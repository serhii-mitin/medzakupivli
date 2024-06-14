<?php

namespace App\Utils\Filters\Admin;

use App\Utils\Filters\QueryFilter;
use Illuminate\Database\Eloquent\Builder;

class AdminVaccineFilter extends QueryFilter
{
    protected static array $sortFields = [
        'id' => 'vaccines.id',
        'name' => 'LOWER(vaccines.name)',
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
                            ->whereRaw("LOWER(vaccines.name) like '%$search%'");
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
