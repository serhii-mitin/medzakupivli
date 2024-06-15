<?php

namespace App\Repositories\Api\v1;

use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class MedicalFacilityRepository
{
    public function getAvailableListByVaccineId(int $vaccineId): Collection
    {
        return DB::table('medical_facilities as mf')
            ->select(['mf.id', 'mf.name'])
            ->joinSub($this->getUniqueByVaccineIdSubQuery($vaccineId), 'sq', 'mf.id', '=', 'sq.mf_id')
            ->whereNull('deleted_at')
            ->orderBy('name')
            ->get();
    }

    public function getUniqueByVaccineIdSubQuery(int $vaccineId): Builder
    {
        $subQuery = DB::table('vaccine_doses')
            ->where('vaccine_id', $vaccineId);

        return DB::table('medical_facility_vaccine_dose as mfvd')
            ->select('medical_facility_id as mf_id')
            ->joinSub($subQuery, 'vd', 'mfvd.vaccine_dose_id', '=', 'vd.id')
            ->distinct('medical_facility_id');
    }
}
