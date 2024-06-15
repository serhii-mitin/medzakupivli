<?php

namespace App\Http\RequestsData\Api\v1\VaccinationHistory;

use Spatie\LaravelData\Data;

class MedicalFacilitiesRequestData extends Data
{
    public function __construct(
        public int $vaccine_id
    )
    {
    }
}
