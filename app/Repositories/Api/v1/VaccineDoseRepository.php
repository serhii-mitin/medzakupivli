<?php

namespace App\Repositories\Api\v1;

use App\Http\Requests\Api\v1\VaccinationHistory\StoreVaccinationHistoryRequestData;
use App\Models\VaccineDose;
use App\Utils\Enums\Vaccine\VaccineDoseStatus;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

class VaccineDoseRepository
{
    public function getAvailableByFilter(StoreVaccinationHistoryRequestData $requestData): ?VaccineDose
    {
        return VaccineDose::query()
            ->where('vaccine_id', $requestData->vaccine_id)
            ->where('status', VaccineDoseStatus::NEW)
            ->where('expiration_date', '>', $requestData->selected_time)
            ->joinSub($this->getUniqueByFilterSubQuery($requestData->vaccine_id, $requestData->medical_facility_id), 'sq', 'vaccine_doses.id', '=', 'sq.vd_id')
            ->orderBy('expiration_date')
            ->first();
    }

    private function getUniqueByFilterSubQuery(int $vaccineId, int $medicalFacilityId): Builder
    {
        $subQuery = DB::table('vaccine_doses')
            ->where('vaccine_id', $vaccineId);

        return DB::table('medical_facility_vaccine_dose as mfvd')
            ->select('vaccine_dose_id as vd_id')
            ->joinSub($subQuery, 'vd', 'mfvd.vaccine_dose_id', '=', 'vd.id')
            ->where('mfvd.medical_facility_id', $medicalFacilityId)
            ->distinct('vaccine_dose_id');
    }
}
