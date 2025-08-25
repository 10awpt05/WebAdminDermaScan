<?php

use Kreait\Firebase\Factory;

return [
    'credentials' => env('FIREBASE_CREDENTIALS', '/etc/secrets/firebase.json'),
    'database_url' => env('FIREBASE_DATABASE_URL'),
];
