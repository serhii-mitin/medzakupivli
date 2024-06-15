<?php

namespace App\Http\RequestsData\Api\v1\VaccinationHistory;

use Spatie\LaravelData\Data;

class NotAvailableDatesRequestData extends Data
{
    public function __construct(
        public int    $vaccine_id,
        public int    $medical_facility_id,
        public string $start_time,
        public string $end_time,
    )
    {
    }
}
