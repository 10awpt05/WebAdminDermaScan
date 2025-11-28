<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Session;
use App\Services\FirebaseService;

class FirebaseController extends Controller
{
    protected $database;
    protected $auth;

    public function __construct(FirebaseService $firebase)
    {
        $this->database = $firebase->getDatabase();
        $this->auth = $firebase->getAuth();
    }

    public function showUserInfo($id)
    {
        $user = $this->database->getReference("userInfo/{$id}")->getValue();
        return view('users.show', compact('user'));
    }

    public function listUsers(Request $request)
    {
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $perPage = 5;

        $allUsers = $this->database->getReference('userInfo')->getValue() ?? [];

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
        return redirect()->route('users.index')->with('success', 'User deleted successfully!');

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

            // Store user info in session
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
}
