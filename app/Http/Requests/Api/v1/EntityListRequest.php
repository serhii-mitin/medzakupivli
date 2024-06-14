<?php

namespace App\Http\Requests\Api\v1;

use Illuminate\Foundation\Http\FormRequest;

abstract class EntityListRequest extends FormRequest
{
    protected array $filterFields;

    //Need to set rules for filters
    abstract protected function setFilters();

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'page' => 'nullable|integer',
            'per_page' => 'nullable|integer',
            'sort_field' => 'nullable|string',
            'sort_direction' => 'nullable|in:asc,desc',
            'search' => 'nullable|string'
        ];
    }

    protected function filters()
    {
        $this->setFilters();

        $filterRules['filter'] = 'nullable|array';

        foreach ($this->filterFields as $key => $field) {
            $filterRules["filter.{$key}"] = $field;
        }

        return $filterRules;
    }
}
