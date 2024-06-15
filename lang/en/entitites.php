<?php

use App\Utils\Enums\VaccinationHistory\VaccinationHistoryStatusEnum;
use App\Utils\Enums\Vaccine\VaccineDoseStatus;

return [
    'vaccine' => [
        'dose' => [
            'statuses' => [
                VaccineDoseStatus::NEW => 'new',
                VaccineDoseStatus::SELECTED => 'selected',
                VaccineDoseStatus::UTILIZED => 'utilized',
                VaccineDoseStatus::USED => 'used',
            ]
        ],
        'vaccination_history' => [
            'statuses' => [
                VaccinationHistoryStatusEnum::SELECTED => 'selected',
                VaccinationHistoryStatusEnum::CANCELLED => 'canceled',
                VaccinationHistoryStatusEnum::COMPLETED => 'completed',
            ]
        ]
    ]
];
