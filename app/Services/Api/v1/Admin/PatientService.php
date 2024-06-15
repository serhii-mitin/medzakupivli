<?php

namespace App\Services\Api\v1\Admin;

use App\Models\User;
use App\Utils\Enums\User\UserRoleEnum;
use App\Utils\Filters\Admin\AdminPatientFilter;
use Illuminate\Pagination\LengthAwarePaginator;

class PatientService
{
    public function getList(array $filterParams): LengthAwarePaginator
    {
        $filterParams['filter']['role_name'] = UserRoleEnum::PATIENT;
        $queryFilter = new AdminPatientFilter($filterParams);

        return User::filter($queryFilter)
            ->paginate(
                $filterParams['per_page'] ?? config('common.default_per_page'),
                ['*'],
                'page',
                $filterParams['page'] ?? 1
            );
    }
}
