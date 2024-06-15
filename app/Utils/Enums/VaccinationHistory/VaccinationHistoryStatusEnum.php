<?php

namespace App\Utils\Enums\VaccinationHistory;

use App\Utils\Enums\Enum;

class VaccinationHistoryStatusEnum extends Enum
{
    const SELECTED = 1;

    const CANCELLED = 2;

    const COMPLETED = 3;

    static function getNotAvailable()
    {
        return [
            static::SELECTED,
            static::COMPLETED,
        ];
    }
}
