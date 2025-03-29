<?php

return [
    'App\Models\User' => [  // Full namespace path
        'fields' => ['first_name', 'last_name'],
        'ar_suffix' => '_ar'
    ],

    // Add other models as needed:
    'App\Models\Place' => [
        'fields' => ['name', 'address', 'type', 'description'],
        'ar_suffix' => '_ar'
    ]
];
