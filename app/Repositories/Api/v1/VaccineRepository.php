<?php

namespace App\Repositories\Api\v1;

use App\Utils\Enums\Vaccine\VaccineDoseStatus;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class VaccineRepository
{
    public function getAvailableList(): Collection
    {
        return DB::table('vaccines as v')
            ->select(['id', 'name'])
            ->joinSub($this->getAvailableDosesSubQuery(), 'd', 'v.id', '=', 'd.vaccine_id')
            ->whereNull('deleted_at')
            ->orderBy('name')
            ->get();
    }

    private function getAvailableDosesSubQuery(): Builder
    {
        return DB::table('vaccine_doses')
            ->select(['vaccine_id'])
            ->distinct('vaccine_id')
            ->where('status', VaccineDoseStatus::NEW);
    }
}
