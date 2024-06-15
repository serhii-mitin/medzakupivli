<?php

namespace App\Repositories\Api\v1;

use App\Http\RequestsData\Api\v1\VaccinationHistory\NotAvailableDatesRequestData;
use App\Utils\Enums\VaccinationHistory\VaccinationHistoryStatusEnum;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class VaccinationHistoryRepository
{
    public function getNotAvailableDates(NotAvailableDatesRequestData $requestData): Collection
    {
        return DB::table('vaccination_histories as vh')
            ->select(['selected_time'])
            ->where('vh.medical_facility_id', $requestData->medical_facility_id)
            ->where(function (Builder $query) use ($requestData) {
                $query
                    ->where('vh.status', VaccinationHistoryStatusEnum::SELECTED)
                    ->whereBetween('vh.selected_time', [$requestData->start_time, $requestData->end_time]);
            })
            ->get();
    }

    public function checkExistSelectedByUserId(int $userId): bool
    {
        return DB::table('vaccination_histories as vh')
            ->where('user_id', $userId)
            ->where('status', VaccinationHistoryStatusEnum::SELECTED)
            ->exists();
    }

    public function getListByPatientId(int $userId): Collection
    {
        return DB::table('vaccination_histories as vh')
            ->select([
                'vh.id',
                'vh.selected_time',
                'vh.completed_time',
                'vh.status',
                'vd.serial_number',
                'vd.volume',
                'v.name as vaccine_name',
            ])
            ->join('vaccine_doses as vd', 'vh.dose_id', '=', 'vd.id')
            ->join('vaccines as v', 'vd.vaccine_id', '=', 'v.id')
            ->where('vh.user_id', $userId)
            ->orderBy('vh.id', 'desc')
            ->get();
    }
}
