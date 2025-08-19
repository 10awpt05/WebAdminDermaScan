<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/mainapp');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
    // public function adminLogin(Request $request)
    // {
    //     $credentials = $request->validate([
    //         'email' => 'required|email',
    //         'password' => 'required',
    //     ]); 

    //     if (Auth::attempt($credentials)) {
    //         $user = Auth::user();
    //         return redirect()->route('admin.dashboard', ['name' => $user->name]);;
    //     }

    //     return back()->withErrors(['email' => 'Invalid credentials']);
    // }

    
    // public function adminLogout(Request $request)
    // {
    //     Auth::logout();
    //     return redirect()->route('user.udashboard');
    // }


    // public function userDashboard()
    // {
    //     $user = Auth::user();

    //     if (!$user) {
    //         return redirect()->route('login')->with('error', 'You need to login first.');
    //     }

    //     $postCount = PostComment::where('user_id', $user->id)->count() ?? 0;

    //     dd($postCount);

    //     return view('child.profile', compact('user', 'postCount'));
    // }
}
