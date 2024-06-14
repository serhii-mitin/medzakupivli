<?php

return [
    'super_admin' => [
        'email' => env('SUPER_ADMIN_EMAIL', 'super_admin@medzakupivli.com'),
        'password' => env('SUPER_ADMIN_PASSWORD', '!Qwerty123'),
    ],
    'patient' => [
        'email' => env('PATIENT_EMAIL', 'patient@medzakupivli.com'),
        'password' => env('PATIENT_PASSWORD', '!Qwerty123'),
    ],

    'default_per_page' => 10
];
