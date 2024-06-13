<?php

namespace App\Utils\Enums\Vaccine;

use App\Utils\Enums\Enum;

class VaccineDoseStatus extends Enum
{
    const NEW = 1;

    const OPEN = 2;

    const UTILIZED = 3;
}
