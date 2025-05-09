<?php

namespace App\Services;

use Kreait\Firebase\Factory;

class FirebaseService
{
    protected $database;

    public function __construct()
    {
        $factory = (new Factory)
            ->withServiceAccount(storage_path('app/firebase/dermascanai-2d7a1-firebase-adminsdk-fbsvc-be9d626095.json'))
            ->withDatabaseUri('https://dermascanai-2d7a1-default-rtdb.asia-southeast1.firebasedatabase.app/');

        $this->database = $factory->createDatabase();
    }

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
    public function getDatabase()
    {
        return $this->database;
    }

}
