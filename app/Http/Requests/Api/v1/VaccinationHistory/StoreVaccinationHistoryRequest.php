<?php

namespace App\Http\Requests\Api\v1\VaccinationHistory;

use Illuminate\Foundation\Http\FormRequest;

class StoreVaccinationHistoryRequest extends FormRequest
{
    public function rules()
    {
        return [
            'vaccine_id' => 'required|integer|exists:vaccines,id',
            'medical_facility_id' => 'required|integer|exists:medical_facilities,id',
            'selected_time' => 'required|date|date_format:Y-m-d H:i:s|after_or_equal:' . now()->addMinutes(20),
        ];
    }
}
