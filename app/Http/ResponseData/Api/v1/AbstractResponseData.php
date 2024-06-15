<?php

namespace App\Http\ResponseData\Api\v1;

use Spatie\LaravelData\Data;

class AbstractResponseData extends Data
{
    public function __construct(
        public int     $response_status,
        public ?string $message,
        public ?Data   $data,
    )
    {
    }
}
