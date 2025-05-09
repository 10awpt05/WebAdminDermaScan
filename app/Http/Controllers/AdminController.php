<?php

namespace App\Http\Controllers;

use App\Services\FirebaseService;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    protected $database;

    public function __construct(FirebaseService $firebase)
    {
        $this->database = $firebase->getDatabase();
    }

    public function showDermaUsers()
    {
        $users = $this->database->getReference('dermaInfo')->getValue();
        $allUsers = [];
        $notVerifiedUsers = [];
        $pendingUsers = [];
        $verifiedUsers = [];

        if ($users) {
            foreach ($users as $uid => $user) {
                $user['uid'] = $uid;
                $status = $user['status'] ?? 'not verified';

                // Add to allUsers first
                $allUsers[] = $user;

                // Categorize
                switch ($status) {
                    case 'not verified':
                        $notVerifiedUsers[] = $user;
                        break;
                    case 'pending':
                        $pendingUsers[] = $user;
                        break;
                    case 'verified':
                        $verifiedUsers[] = $user;
                        break;
                }
            }
        }


        return view('admin.derma-users', compact('allUsers', 'notVerifiedUsers', 'pendingUsers', 'verifiedUsers'));
    }

    public function verifyUser($uid)
    {
        $this->database->getReference("dermaInfo/{$uid}")->update([
            'status' => 'verified',
        ]);

        return redirect()->back()->with('success', 'User verified successfully.');
    }

    public function deleteUser($uid)
    {
        $this->database->getReference("dermaInfo/{$uid}")->remove();

        return redirect()->back()->with('success', 'User deleted successfully.');
    }
    public function rejectUser($uid)
{
    $this->database->getReference("dermaInfo/{$uid}")->update([
        'status' => 'not verified',
    ]);

    return redirect()->back()->with('success', 'User rejected successfully.');
}

}

