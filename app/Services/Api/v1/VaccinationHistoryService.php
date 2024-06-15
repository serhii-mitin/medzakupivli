<?php

namespace App\Services\Api\v1;

use App\Http\Requests\Api\v1\VaccinationHistory\StoreVaccinationHistoryRequestData;
use App\Http\RequestsData\Api\v1\VaccinationHistory\MedicalFacilitiesRequestData;
use App\Http\RequestsData\Api\v1\VaccinationHistory\NotAvailableDatesRequestData;
use App\Http\ResponseData\Api\v1\AbstractResponseData;
use App\Models\User;
use App\Models\VaccinationHistory;
use App\Repositories\Api\v1\MedicalFacilityRepository;
use App\Repositories\Api\v1\VaccinationHistoryRepository;
use App\Repositories\Api\v1\VaccineDoseRepository;
use App\Repositories\Api\v1\VaccineRepository;
use App\Utils\Enums\VaccinationHistory\VaccinationHistoryStatusEnum;
use App\Utils\Enums\Vaccine\VaccineDoseStatus;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;

class VaccinationHistoryService
{
    public function __construct(
        public readonly VaccineRepository            $vaccineRepository,
        public readonly MedicalFacilityRepository    $medicalFacilityRepository,
        public readonly VaccinationHistoryRepository $vaccinationHistoryRepository,
        public readonly VaccineDoseRepository        $vaccineDoseRepository,
    )
    {
    }

    public function getAvailableVaccines(): Collection
    {
        return $this->vaccineRepository->getAvailableList();
    }

    public function getMedicalFacilities(MedicalFacilitiesRequestData $requestData): Collection
    {
        return $this->medicalFacilityRepository->getAvailableListByVaccineId($requestData->vaccine_id);
    }

    public function getNotAvailableDates(NotAvailableDatesRequestData $requestData): Collection
    {
        return $this->vaccinationHistoryRepository
            ->getNotAvailableDates($requestData)
            ->pluck('selected_time');
    }

    public function store(User $user, StoreVaccinationHistoryRequestData $requestData): AbstractResponseData
    {
        try {
            $exist = $this->vaccinationHistoryRepository->checkExistSelectedByUserId($user->id);
            if ($exist) {
                return failed_response_data(JsonResponse::HTTP_UNPROCESSABLE_ENTITY, 'You already have an active entry');
            }

            $availableDose = $this->vaccineDoseRepository->getAvailableByFilter($requestData);
            if (is_null($availableDose)) {
                return failed_response_data(JsonResponse::HTTP_UNPROCESSABLE_ENTITY, 'There are no doses available');
            }

            VaccinationHistory::create([
                'user_id' => $user->id,
                'medical_facility_id' => $requestData->medical_facility_id,
                'dose_id' => $availableDose->id,
                'selected_time' => $requestData->selected_time,
                'status' => VaccinationHistoryStatusEnum::SELECTED,
            ]);

            $availableDose->update([
                'status' => VaccineDoseStatus::SELECTED
            ]);

        } catch (\Throwable) {
            return failed_response_data();
        }

        return AbstractResponseData::validateAndCreate([
            'response_status' => JsonResponse::HTTP_CREATED,
            'message' => __('notifications.entry_added'),
        ]);
    }
}
