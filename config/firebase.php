<?php

use Kreait\Firebase\Factory;

return [

    /*
    |--------------------------------------------------------------------------
    | Firebase Admin SDK Credentials
    |--------------------------------------------------------------------------
    |
    | Instead of referencing a file, we store the service account JSON in
    | an environment variable and decode it here. This way no secrets
    | are committed to git or baked into the Docker image.
    |
    */

    'credentials' => json_decode(env('FIREBASE_CREDENTIALS_JSON'), true),

    'database_url' => env('FIREBASE_DATABASE_URL'),

];
