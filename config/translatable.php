<?php

return [
    'App\Models\User' => [
        'fields' => ['first_name', 'last_name'],
        'ar_suffix' => '_ar'
    ],

    'App\Models\Place' => [
        'fields' => ['name', 'address', 'type', 'description'],
        'ar_suffix' => '_ar'
    ],

    'App\Models\Category' => [
        'fields' => ['name'],
        'ar_suffix' => '_ar'
    ],

    'App\Models\Res_type' => [
        'fields' => ['name'],
        'ar_suffix' => '_ar'
    ],
];
