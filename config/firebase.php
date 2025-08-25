<?php

use Kreait\Firebase\Factory;

return [
    'credentials' => '/etc/secrets/firebase.json',
    'database_url' => env('FIREBASE_DATABASE_URL'),
];
