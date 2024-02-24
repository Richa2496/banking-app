<?php

namespace App\Http\Controllers;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    
    /**
     * Registration form view
     */
    public function create()
    {
        try {
            // Retrieve user ID from session
            $userId = session('user_id');
    
            // Check if user ID is set in session
            if ($userId !== null) {
                // If user is already authenticated, redirect to the home page
                return redirect()->route('users.home');
            } else {
                // If user is not authenticated, show the create user form
                return view('users.create');
            }
        } catch (\Exception $e) {
            // If any unexpected exception occurs, redirect with a generic error message
            return redirect()->route('auth.login')->with('error', 'An error occurred while accessing the create user page. Please try again later.');
        }
    }

    /**
     * Store data of new registered user
     */

     // New user registration
     public function store(Request $request)
     { 
         try {
             // Validate request data
             $request->validate([
                 'name' => 'required|string',
                 'email' => 'required|email|unique:users',
                 'password' => 'required|min:6',
                 'amount' => 'numeric',
                 'is_active' => 'boolean',
                 'agree_terms' => 'required',
             ], [
                 'agree_terms.required' => 'Please agree to the terms.',
             ]);
 
             // Create user if validation passes
             $user = new User();
             $user->name = $request->name;
             $user->email = $request->email;
             $user->password = bcrypt($request->password);
             $user->current_balance = $request->amount ?? 0;
             $user->is_active = $request->is_active ?? true;
             $user->save();
 
             $userId = $user->id;
             $userData = User::where('id', $userId)->first();
 
             $data = [
                 'userId' => $userId,
                 'userData' => $userData,
             ];
             // Set user id in session when new user is registerted
             Session::put('user_id', $userId);
 
             // Return view with new user data.
             return view('users.home', $data);
 
         } catch (ValidationException $e) {
             return redirect()->route('users.create')->withErrors($e->errors())->withInput();
         }
     }     
    /**
     * Home page after user registration
     */

    public function index()
    {
        try {
            // Retrieve user ID from session
            $userId = session('user_id');
    
            // Check if user ID is set in session
            if ($userId === null) {
                // If user ID is not set, redirect to the login page
                return redirect()->route('auth.login')->with('error', 'Please log in to access this page.');
            }
    
            // Retrieve user data based on user ID
            $userData = User::findOrFail($userId); // Assuming user must exist
    
            // Prepare data to be passed to the view
            $data = [
                'userId' => $userId,
                'userData' => $userData,
            ];
    
            // Return the view with the prepared data
            return view('users.home', $data);
        } catch (\Exception $e) {
            // If any unexpected exception occurs, redirect with a generic error message
            return redirect()->route('auth.login')->with('error', 'An error occurred while accessing the home page. Please try again later.');
        }
    }
        
}
