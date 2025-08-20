<?php

namespace App\Services;

use Kreait\Firebase\Factory;
use Kreait\Firebase\Auth;
use Kreait\Firebase\Database;
use Illuminate\Support\Facades\Log;

class FirebaseService
{
     protected $auth;
    protected $database;

    public function __construct()
    {
        // Build service account from env
        $serviceAccount = [
            'type' => 'service_account',
            'project_id' => env('FIREBASE_PROJECT_ID'),
            'private_key_id' => env('FIREBASE_PRIVATE_KEY_ID'), // optional
            'private_key' => str_replace('\\n', "\n", env('FIREBASE_PRIVATE_KEY')),
            'client_email' => env('FIREBASE_CLIENT_EMAIL'),
            'client_id' => env('FIREBASE_CLIENT_ID'), // optional
            'auth_uri' => 'https://accounts.google.com/o/oauth2/auth',
            'token_uri' => 'https://oauth2.googleapis.com/token',
            'auth_provider_x509_cert_url' => 'https://www.googleapis.com/oauth2/v1/certs',
            'client_x509_cert_url' => env('FIREBASE_CLIENT_X509_CERT_URL') // optional
        ];

        $factory = (new Factory)
            ->withServiceAccount($serviceAccount)
            ->withDatabaseUri(env('FIREBASE_DATABASE_URL'));

        $this->auth = $factory->createAuth();
        $this->database = $factory->createDatabase();
    }

    /** ---------------- AUTH ---------------- */
    public function getAuth()
    {
        return $this->auth;
    }

    public function signInWithEmailPassword($email, $password)
    {
        return $this->auth->signInWithEmailAndPassword($email, $password);
    }

    public function createDefaultUser()
    {
        return $this->auth->createUser([
            'email' => 'admin@example.com',
            'emailVerified' => false,
            'password' => '123123',
            'displayName' => 'Admin User',
            'disabled' => false,
        ]);
    }

    /** ---------------- DATABASE ---------------- */
    public function getDatabase()
    {
        return $this->database;
    }

    /** ---------------- USER MANAGEMENT ---------------- */
    public function getUnapprovedUsers()
    {
        $reference = $this->database->getReference('dermaInfo');
        $snapshot = $reference->getValue();

        $unapproved = [];
        if ($snapshot) {
            foreach ($snapshot as $uid => $user) {
                if (isset($user['approved']) && $user['approved'] === false) {
                    $user['uid'] = $uid;
                    $unapproved[] = $user;
                }
            }
        }
        return $unapproved;
    }

    public function approveUser($uid)
    {
        $this->database->getReference("userInfo/$uid")->update([
            'approved' => true
        ]);
    }

    /** ---------------- DAILY TIPS ---------------- */
    public function getDailyTip($key)
    {
        return $this->database->getReference("dailyTips/{$key}")->getValue();
    }

    public function getDailyTips()
    {
        return $this->database->getReference("dailyTips")->getValue();
    }

    public function updateFullTip($key, array $data)
    {
        return $this->database->getReference("dailyTips/{$key}")->set($data);
    }

    public function deleteTip($key)
    {
        return $this->database->getReference("dailyTips/{$key}")->remove();
    }

    public function pushTip(array $data)
    {
        $result = $this->database->getReference("dailyTips")->push($data);
        Log::debug('Firebase push result:', ['result' => $result->getKey()]);
    }
}
