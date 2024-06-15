<?php

namespace App\Http\Requests\Api\v1\VaccinationHistory;

use Illuminate\Foundation\Http\FormRequest;

class GetMedicalFacilitiesRequest extends FormRequest
{
    public function rules()
    {
        return [
            'vaccine_id' => 'required|integer|exists:vaccines,id',
        ];
    }
}
