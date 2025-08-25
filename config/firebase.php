<?php

use Kreait\Firebase\Factory;

return [

    'credentials' => env('FIREBASE_CREDENTIALS', base_path('firebase.json')),

    'database_url' => env('FIREBASE_DATABASE_URL'),
];

