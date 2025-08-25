<?php

use Kreait\Firebase\Factory;

<?php

return [

    'default' => env('FIREBASE_PROJECT_ID'),

    'projects' => [
        env('FIREBASE_PROJECT_ID') => [
            'credentials' => [
                'type'                        => 'service_account',
                'project_id'                  => env('FIREBASE_PROJECT_ID'),
                'private_key_id'              => env('FIREBASE_PRIVATE_KEY_ID'),
                'private_key'                 => str_replace("\\n", "\n", env('FIREBASE_PRIVATE_KEY')), // 🔑 fix line breaks
                'client_email'                => env('FIREBASE_CLIENT_EMAIL'),
                'client_id'                   => env('FIREBASE_CLIENT_ID'),
                'auth_uri'                    => 'https://accounts.google.com/o/oauth2/auth',
                'token_uri'                   => 'https://oauth2.googleapis.com/token',
                'auth_provider_x509_cert_url' => 'https://www.googleapis.com/oauth2/v1/certs',
                'client_x509_cert_url'        => env('FIREBASE_CLIENT_CERT_URL'),
            ],
            'database' => [
                'url' => env('FIREBASE_DATABASE_URL'),
            ],
        ],
    ],

];

