<?php

namespace App\Http\Controllers;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    
    public function create()
    {
        // Retrieve user ID from session
        $userId = session('user_id');

        // Check if user ID is set in session
        if ($userId !== null) {
            return redirect()->route('users.home');
        }else{
            return view('users.create');
        }
    }
 

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

            Session::put('user_id', $userId);
            return view('users.home', $data);

        } catch (ValidationException $e) {
            return redirect()->route('users.create')->withErrors($e->errors())->withInput();
        }
    } 

    
    public function index(){
        // Retrieve user ID from session
        $userId = session('user_id');
    
        // Check if user ID is set in session
        if ($userId === null) {
            return view('auth.login');
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
    }
    
}
