<?php

namespace App\Services\Api\v1\Admin;

use App\Models\Vaccine;
use App\Utils\Filters\Admin\AdminVaccineFilter;
use Illuminate\Pagination\LengthAwarePaginator;

class VaccineService
{
    public function getList(array $filterParams): LengthAwarePaginator
    {
        $queryFilter = new AdminVaccineFilter($filterParams);

        return Vaccine::filter($queryFilter)
            ->paginate(
                $filterParams['per_page'] ?? config('common.default_per_page'),
                ['*'],
                'page',
                $filterParams['page'] ?? 1
            );
    }
}
