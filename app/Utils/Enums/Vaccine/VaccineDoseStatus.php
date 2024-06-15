<?php

namespace App\Utils\Enums\Vaccine;

use App\Utils\Enums\Enum;

class VaccineDoseStatus extends Enum
{
    const NEW = 1;

    const SELECTED = 2;

    const UTILIZED = 3;

    const USED = 4;
}
