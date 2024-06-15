<?php

namespace App\Utils\Filters\Admin;

use App\Utils\Filters\QueryFilter;
use Illuminate\Database\Eloquent\Builder;

class AdminPatientFilter extends QueryFilter
{
    protected static array $sortFields = [
        'id' => 'users.id',
        'name' => 'LOWER(users.name)',
    ];

    protected function initBuilder(Builder $builder): Builder
    {
        return $this->builder = $builder->with(['roles']);
    }

    protected function roleName(string $roleName)
    {
        $this->builder->whereHas('roles', function ($query) use ($roleName) {
            $query->where('name', $roleName);
        });
    }

    protected function search(string $search)
    {
        $this
            ->builder
            ->when($search, function ($query) use ($search) {
                $query
                    ->where(function ($query) use ($search) {
                        $query
                            ->whereRaw("LOWER(users.name) like '%$search%'");
                    });
            });
    }

    public function sortField(string $sortField = '')
    {
        $field = $this->getSortField($sortField, self::$sortFields['id']);
        $direction = $this->getSortDirection('sort_direction');
        $this->builder->orderByRaw("$field $direction");
    }
}
