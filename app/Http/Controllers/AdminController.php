<?php

namespace App\Http\Controllers;

use App\Services\FirebaseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class AdminController extends Controller
{
    protected $database;

    public function __construct(FirebaseService $firebase)
    {
        $this->database = $firebase->getDatabase();
    }

   public function showDermaUsers()
{
    $users = $this->database->getReference('clinicInfo')->getValue();
    $allUsers = [];
    $notVerifiedUsers = [];
    $pendingUsers = [];
    $verifiedUsers = [];

    if ($users) {
        foreach ($users as $uid => $user) {
            $user['uid'] = $uid;

            // Remove large image fields
            // unset($user['logoImage'], $user['businessPermitImage'], $user['birImage'], $user['validIdImage']);

            // Cast array to object so Blade can use $user->uid
            $user = (object) $user;

            $status = $user->status ?? 'not verified';
            $allUsers[] = $user;

            switch ($status) {
                case 'rejected':
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



    //----------------Verify User-----------------

    public function verifyUser($uid)
{
    $this->database->getReference("clinicInfo/{$uid}")->update([
        'status' => 'verified',
    ]);

    // Create a new notification
    $notificationId = $this->database->getReference("notifications/{$uid}")->push()->getKey();
    $notificationData = [
        'notificationId' => $notificationId,
        'fromUserId' => 'admin',
        'toUserId' => $uid,
        'type' => 'registration',
        'message' => 'Your registration has been approved!',
        'timestamp' => round(microtime(true) * 1000),
        'isRead' => false,
        'status' => 'verified'
    ];
    $this->database->getReference("notifications/{$uid}/{$notificationId}")->set($notificationData);

    return redirect()->back()->with('success', 'User verified successfully.');
}


    //----------------Delete User-----------------

    public function deleteUser($uid)
    {
        $this->database->getReference("clinicInfo/{$uid}")->remove();

        return redirect()->back()->with('success', 'User deleted successfully.');
    }

    //----------------Reject User-----------------

    // public function rejectUser($uid)
    // {
    //     $this->database->getReference("clinicInfo/{$uid}")->update([
    //         'status' => 'rejected',
    //     ]);

    //     return redirect()->back()->with('success', 'User rejected successfully.');
    // }

    public function rejectUser(Request $request, $uid)
{
    $request->validate([
        'reason' => 'required|string|max:1000',
    ]);

    $reason = $request->input('reason');
    $user = $this->database->getReference("clinicInfo/{$uid}")->getValue();

    if (!$user || empty($user['email'])) {
        return redirect()->back()->with('error', 'User email not found.');
    }

    // Update status and reason in Firebase
    $this->database->getReference("clinicInfo/{$uid}")->update([
        'status' => 'rejected',
        'rejectionReason' => $reason,
    ]);

    // Create a new notification
    $notificationId = $this->database->getReference("notifications/{$uid}")->push()->getKey();
    $notificationData = [
        'notificationId' => $notificationId,
        'fromUserId' => 'admin',
        'toUserId' => $uid,
        'type' => 'registration',
        'message' => "Your registration was rejected. Reason: {$reason}",
        'timestamp' => round(microtime(true) * 1000),
        'isRead' => false,
        'status' => 'rejected'
    ];
    $this->database->getReference("notifications/{$uid}/{$notificationId}")->set($notificationData);

    // Send rejection email
    Mail::send('emails.rejection', ['user' => $user, 'reason' => $reason], function ($message) use ($user) {
        $message->to($user['email'])
                ->subject('Clinic Registration Rejected');
    });

    return redirect()->back()->with('success', 'User rejected, email and notification sent.');
}



        //----------------Get User Image-----------------

    public function getImage($uid, $type)
{
    $allowedTypes = ['logoImage', 'businessPermitImage', 'birImage', 'validIdImage'];

    if (!in_array($type, $allowedTypes)) {
        abort(404);
    }

    $user = $this->database->getReference("clinicInfo/{$uid}")->getValue();

    if (!$user || !isset($user[$type])) {
        abort(404);
    }

    $base64 = $user[$type];

    // Clean up base64 string if it contains data URI prefix
    if (strpos($base64, 'base64,') !== false) {
        $base64 = substr($base64, strpos($base64, 'base64,') + 7);
    }

    $imageData = base64_decode($base64);

    if ($imageData === false) {
        abort(404);
    }

    return response($imageData, 200)
        ->header('Content-Type', 'image/png')
        ->header('Cache-Control', 'public, max-age=31536000');
}


}

