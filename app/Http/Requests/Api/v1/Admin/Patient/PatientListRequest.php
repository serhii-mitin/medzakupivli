<?php

namespace App\Http\Requests\Api\v1\Admin\Patient;

use App\Http\Requests\Api\v1\EntityListRequest;
use App\Utils\Filters\Admin\AdminPatientFilter;

class PatientListRequest extends EntityListRequest
{
    public function rules()
    {
        $rules = parent::rules();

        $rules['sort_field'] = 'nullable|in:' . $this->sortFields();

        return array_merge($rules, $this->filters());
    }

    private function sortFields(): string
    {
        return AdminPatientFilter::getSortFieldsString();
    }

    protected function setFilters()
    {
        $this->filterFields = [
            'search' => 'nullable|string|max:100',
        ];
    }
}
