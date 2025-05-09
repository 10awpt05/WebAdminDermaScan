<?php

namespace App\Http\Controllers;

use Kreait\Firebase\Factory;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class FirebaseController extends Controller
{
    protected $database;

    public function __construct()
    {
        $factory = (new Factory)
            ->withServiceAccount(base_path('dermascanai-2d7a1-firebase-adminsdk-fbsvc-be9d626095.json'))
            ->withDatabaseUri('https://dermascanai-2d7a1-default-rtdb.asia-southeast1.firebasedatabase.app/');

        $this->database = $factory->createDatabase();
        $this->auth = $factory->createAuth();
    }

    public function showUserInfo($id)
    {
        $user = $this->database->getReference("userInfo/{$id}")->getValue();
        return view('users.show', compact('user'));
    }


//     public function listUsers(Request $request)
// {
//     // Fetch the page number from the query parameter, default to 1
//     $page = $request->query('page', 1);

//     // Calculate the starting point (index) based on the current page
//     $startIndex = ($page - 1) * 5;

//     // Fetch users based on the current page, showing 10 users per page
//     $users = $this->database->getReference('userInfo')
//                             ->orderByKey()
//                             ->startAt((string) $startIndex)
//                             ->limitToFirst(5)
//                             ->getValue();

//     $totalUsers = $this->database->getReference('userInfo')->getSnapshot()->numChildren();

//     $totalPages = ceil($totalUsers / 5);

//     return view('userlist', compact('users', 'page', 'totalPages'));
// }


public function listUsers(Request $request)
{
    $currentPage = LengthAwarePaginator::resolveCurrentPage();
    $perPage = 5;

    $allUsers = $this->database->getReference('userInfo')
                ->getValue() ?? [];

    // Convert associative array to indexed array with keys preserved
    $allUsers = collect($allUsers)->map(function ($user, $key) {
        $user['id'] = $key;
        return $user;
    })->values();

    $currentItems = $allUsers->slice(($currentPage - 1) * $perPage, $perPage)->all();

    $paginatedUsers = new LengthAwarePaginator($currentItems, $allUsers->count(), $perPage);
    $paginatedUsers->setPath(route('users.index'));

    return view('userlist', ['users' => $paginatedUsers]);
}

    

        

    public function editUser($id)
    {
        $user = $this->database->getReference("userInfo/{$id}")->getValue();
        return view('users.edit', compact('user', 'id'));
    }

    public function updateUser(Request $request, $id)
    {
        $data = $request->only([
            'name', 'email', 'role', 'birthday', 'gender', 'contact',
            'province', 'city', 'barangay', 'quote', 'bio'
        ]);

        $this->database->getReference("userInfo/{$id}")->update($data);

        return redirect()->route('user.list')->with('success', 'User updated successfully!');
    }

    public function deleteUser($id)
    {
        $this->database->getReference("userInfo/{$id}")->remove();
        return redirect()->route('user.list')->with('success', 'User deleted successfully!');
    }
    public function show($postId)
    {
        $post = $this->database->getReference('blogPosts/' . $postId)->getValue();
    
        $comments = $this->database->getReference('comments')
                                   ->orderByChild('postId')
                                   ->equalTo($postId)
                                   ->getValue();
    
        return view('blog.show', compact('post', 'comments'));
    }

    public function showLogin()
    {
        return view('login');
    }

    public function handleFirebaseLogin(Request $request)
    {
        $idToken = $request->input('idToken');

        try {
            // Verify the ID token sent from the frontend
            $verifiedIdToken = $this->auth->verifyIdToken($idToken);
            $uid = $verifiedIdToken->claims()->get('sub');
            $user = $this->auth->getUser($uid);

            // Store user info in session (this is just an example, adapt it to your needs)
            Session::put('firebase_user', [
                'uid' => $user->uid,
                'email' => $user->email,
                'name' => $user->displayName,
            ]);

            return response()->json(['message' => 'Authenticated']);
        } catch (\Throwable $e) {
            return response()->json(['message' => 'Invalid Firebase token'], 401);
        }
    }

    public function logout()
    {
        // Clear the session
        Session::forget('firebase_user');
        return redirect('/firebase-login');
    }

    // Other methods (e.g., showUserInfo, listUsers, etc.) here...




}
