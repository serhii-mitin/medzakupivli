<?php

namespace App\Http\Requests\Api\v1\VaccinationHistory;


class GetNotAvailableDatesRequest extends GetMedicalFacilitiesRequest
{
    public function rules()
    {
        return array_merge(parent::rules(),
            [
                'medical_facility_id' => 'required|integer|exists:medical_facilities,id',
                'start_time' => 'required|date|date_format:Y-m-d H:i:s|after_or_equal:' . now()->addMinutes(20),
                'end_time' => 'required|date|date_format:Y-m-d H:i:s|after_or_equal:today',
            ]
        );
    }
}
