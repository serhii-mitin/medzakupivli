<?php

namespace App\Http\Requests\Api\v1\VaccinationHistory;

use Spatie\LaravelData\Data;

class StoreVaccinationHistoryRequestData extends Data
{
    public function __construct(
        public int    $vaccine_id,
        public int    $medical_facility_id,
        public string $selected_time,
    )
    {
    }
}
