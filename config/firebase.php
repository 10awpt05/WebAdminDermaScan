<?php

use Kreait\Firebase\Factory;

return [

    'credentials' => storage_path('app/firebase.json'), // if you upload manually into storage
    // OR if using Render Secret Files:
    'credentials' => '/etc/secrets/firebase.json',

    'database_url' => env('FIREBASE_DATABASE_URL'),
];
