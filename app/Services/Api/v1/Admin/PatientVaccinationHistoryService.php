<?php

namespace App\Services\Api\v1\Admin;

use App\Http\ResponseData\Api\v1\AbstractResponseData;
use App\Models\User;
use App\Models\VaccinationHistory;
use App\Repositories\Api\v1\VaccinationHistoryRepository;
use App\Utils\Enums\Vaccine\VaccineDoseStatus;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;

class PatientVaccinationHistoryService
{
    public function __construct(
        protected readonly VaccinationHistoryRepository $vaccinationHistoryRepository
    )
    {
    }

    public function getList(User $patient): Collection
    {
        return $this->vaccinationHistoryRepository->getListByPatientId($patient->id);
    }

    public function delete(VaccinationHistory $history): AbstractResponseData
    {
        $history->vaccineDose->update([
            'status' => VaccineDoseStatus::NEW
        ]);

        $history->delete();

        return AbstractResponseData::validateAndCreate([
            'response_status' => JsonResponse::HTTP_OK,
            'message' => 'The record was cancelled',
        ]);
    }
}
