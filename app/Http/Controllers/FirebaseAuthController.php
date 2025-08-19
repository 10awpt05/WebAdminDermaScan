<?php

namespace App\Http\Controllers;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class FirebaseAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.firebase-login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $firebaseApiKey = env('FIREBASE_API_KEY');

        $response = Http::post("https://identitytoolkit.googleapis.com/v1/accounts:signInWithPassword?key=$firebaseApiKey", [
            'email' => $request->email,
            'password' => $request->password,
            'returnSecureToken' => true,
        ]);

        if ($response->successful()) {
            $data = $response->json();

            // Store Firebase token in session (or DB or cookie)
            session([
                'firebase_user' => [
                    'idToken' => $data['idToken'],
                    'refreshToken' => $data['refreshToken'],
                    'uid' => $data['localId'],
                    'email' => $request->email
                ]
            ]);
            return redirect('/mainapp')->with('success', 'Logged in!');
        } else {
            return redirect()->back()->withErrors([
                'email' => 'Login failed. Please check your credentials.'
            ]);
        }
    }
}
