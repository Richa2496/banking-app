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
        try {
            // Check if the login form view exists
            if (!view()->exists('auth.login')) {
                throw new \Exception('Login form view does not exist.');
            }
    
            // Return the login form view
            return view('auth.login');
        } catch (\Exception $e) {
            // If an unexpected exception occurs, redirect with a generic error message
            return redirect()->back()->with('error', 'An error occurred while loading the login form.');
        }
    }
    
    public function login(Request $request)
    {
        try {
            $credentials = $request->only('email', 'password');
    
            // Find the user by email
            $userData = User::where('email', $credentials['email'])->first();
    
            // Check if user exists and password matches
            if ($userData && Hash::check($credentials['password'], $userData->password)) {
                // Authentication successful
                Session::put('user_id', $userData->id); // Set session
                return redirect()->intended('/home'); // Redirect to dashboard or any desired page
            }
    
            // Authentication failed
            return back()->withErrors(['email' => 'Invalid credentials'])->withInput($request->only('email'));
        } catch (\Exception $e) {
            // If any unexpected exception occurs, redirect with a generic error message
            return back()->withErrors(['email' => 'An error occurred while processing your request. Please try again later.'])->withInput($request->only('email'));
        }
    }
    
    public function logout(Request $request)
    {
        try {
            // Flush all session data
            Session::flush();
    
            // Redirect to the login page
            return redirect('/login');
        } catch (\Exception $e) {
            // If any unexpected exception occurs, redirect with a generic error message
            return redirect('/login')->with('error', 'An error occurred during logout. Please try again later.');
        }
    }
}
