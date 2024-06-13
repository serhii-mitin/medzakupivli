<?php

use App\Utils\Enums\Vaccine\VaccineDoseStatus;

return [
    'vaccine' => [
        'dose' => [
            'statuses' => [
                VaccineDoseStatus::NEW => 'New',
                VaccineDoseStatus::OPEN => 'Open',
                VaccineDoseStatus::UTILIZED => 'Utilized',
            ]
        ]
    ]
];
