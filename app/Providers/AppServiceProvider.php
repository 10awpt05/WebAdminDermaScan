<?php

namespace App\Services;

use Kreait\Firebase\Factory;
use Kreait\Firebase\Auth;
use Kreait\Firebase\Database;

class FirebaseService
{
    protected $firebase;

    public function __construct()
    {
        // Replace escaped newlines with real newlines
        $firebaseKey = str_replace('\\n', "\n", env('FIREBASE_PRIVATE_KEY'));

        // Initialize Firebase
        $this->firebase = (new Factory())
            ->withServiceAccount([
                'type' => 'service_account',
                'project_id' => env('FIREBASE_PROJECT_ID'),
                'private_key' => $firebaseKey,
                'client_email' => env('FIREBASE_CLIENT_EMAIL'),
            ])
            ->withDatabaseUri(env('FIREBASE_DATABASE_URL'))
            ->create();
    }

    public function auth(): Auth
    {
        return $this->firebase->getAuth();
    }

    public function database(): Database
    {
        return $this->firebase->getDatabase();
    }
}
