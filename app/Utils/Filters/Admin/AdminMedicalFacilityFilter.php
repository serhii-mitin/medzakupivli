<?php

namespace App\Utils\Filters\Admin;

use App\Utils\Filters\QueryFilter;
use Illuminate\Database\Eloquent\Builder;

class AdminMedicalFacilityFilter extends QueryFilter
{
    protected static array $sortFields = [
        'id' => 'medical_facilities.id',
        'name' => 'LOWER(medical_facilities.name)',
    ];

    protected function initBuilder(Builder $builder): Builder
    {
        return $this->builder = $builder;
    }

    protected function search(string $search)
    {
        $this
            ->builder
            ->when($search, function ($query) use ($search) {
                $query
                    ->where(function ($query) use ($search) {
                        $query
                            ->whereRaw("LOWER(medical_facilities.name) like '%$search%'");
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
