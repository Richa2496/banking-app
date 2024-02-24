<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Models\User;


class AuthController extends Controller
{
    
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        
        // $userData = new User();
        $userData = User::where('email', $credentials['email'])->first();

        if ($userData && Hash::check($credentials['password'], $userData->password)) {
            // Authentication successful
            Session::put('user_id', $userData->id); // set session
            return redirect()->intended('/home'); // Redirect to dashboard or any desired page
        }

        // Authentication failed
        return back()->withErrors(['email' => 'Invalid credentials'])->withInput($request->only('email'));
    }

    // Logout
    public function logout(Request $request)
    {   
        Session::flush();
        return redirect('/login');
    }
}
