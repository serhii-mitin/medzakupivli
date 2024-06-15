<?php

namespace App\Services\Api\v1\Admin;

use App\Models\MedicalFacility;
use App\Utils\Filters\Admin\AdminMedicalFacilityFilter;
use Illuminate\Pagination\LengthAwarePaginator;

class MedicalFacilityService
{
    public function getList(array $filterParams): LengthAwarePaginator
    {
        $queryFilter = new AdminMedicalFacilityFilter($filterParams);

        return MedicalFacility::filter($queryFilter)
            ->paginate(
                $filterParams['per_page'] ?? config('common.default_per_page'),
                ['*'],
                'page',
                $filterParams['page'] ?? 1
            );
    }
}
