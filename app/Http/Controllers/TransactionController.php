<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Transaction;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Models\User;

class TransactionController extends Controller
{
    /**
     * Return home view page
     */

    public function index($id = null){
        try {
            // Retrieve user ID from session
            $userId = session('user_id');
        
            // Check if user ID is set in session
            if ($userId === null) {
                return view('auth.login');
            }
    
            // Retrieve user data
            $userData = User::findOrFail($userId);
    
            // Prepare data to pass to the view
            $data = [
                'userId' => $userId,
                'userData' => $userData,
            ];
    
            // Return the view with user data
            return view('users.home', $data);
        } catch (ModelNotFoundException $e) {
            // If user data is not found, redirect with an error message
            return redirect()->route('auth.login')->with('error', 'User data not found.');
        } catch (\Exception $e) {
            // If any other unexpected exception occurs, redirect with a generic error message
            return redirect()->route('auth.login')->with('error', 'An error occurred. Please try again later.');
        }
    }
    
    /**
     * Deposit form view
     */
    public function showDeposit()
    {
        try {
            // Retrieve user ID from session
            $userId = session('user_id');
    
            // Check if user ID is set in session
            if ($userId === null) {
                // If user is not authenticated, redirect to login page
                return redirect()->route('auth.login')->with('error', 'Please log in to access this page.');
            } else {
                // If user is authenticated, show the deposit form
                return view('transactions.deposit');
            }
        } catch (\Exception $e) {
            // If any unexpected exception occurs, redirect with a generic error message
            return redirect()->route('auth.login')->with('error', 'An error occurred. Please try again later.');
        }
    }
    
    /**
     * Insert deposit amount and calculate current and closing balance
     */
    public function deposit(Request $request){
        try {
            // Retrieve user ID from session
            $userId = session('user_id');
        
            // Check if user ID is set in session
            if ($userId === null) {
                return view('auth.login');
            }
    
            // Find the user by ID
            $user = User::findOrFail($userId);
    
            // Validate the request data
            $request->validate([
                'transaction_amount' => 'required|numeric|min:0',
            ]);
    
            // Perform deposit operation
            $depositAmount = $request->transaction_amount;
            $user->current_balance += $depositAmount;
            $user->save();
    
            // Save transaction
            $transaction = new Transaction();
            $transaction->account_id = $userId;
            $transaction->transaction_amount = $depositAmount;
            $transaction->closing_balance = $user->current_balance;
            $transaction->transaction_type = 'Credit';
            $transaction->save();
    
            return redirect()->route('transactions.deposit')->with('success', 'Amount deposited successfully.');
    
        } catch (ValidationException $e) {
            // If validation fails, return with validation errors
            return redirect()->route('transactions.deposit')->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            // If any other exception occurs, return with a generic error message
            return redirect()->route('transactions.deposit')->with('error', 'An error occurred while processing the deposit. Please try again later.');
        }
    }
    
    /**
     * Withdraw form view
     */
    public function showWithdraw()
    {
        try {
            // Retrieve user ID from session
            $userId = session('user_id');
    
            // Check if user ID is set in session
            if ($userId === null) {
                // If user ID is not set, redirect to the login page
                return redirect()->route('auth.login')->with('error', 'Please log in to access this page.');
            } else {
                // If user ID is set, show the withdraw form
                return view('transactions.withdraw');
            }
        } catch (\Exception $e) {
            // If any unexpected exception occurs, redirect with a generic error message
            return redirect()->route('auth.login')->with('error', 'An error occurred. Please try again later.');
        }
    }
    
    /**
     * Debit amount and calculate current and closing balance
     */

     public function withdraw(Request $request){
         try {
             // Retrieve user ID from session
             $userId = session('user_id');
         
             // Check if user ID is set in session
             if ($userId === null) {
                 return view('auth.login');
             }
     
             // Find the user by ID
             $user = User::findOrFail($userId);
     
             // Validate the request data
             $request->validate([
                 'transaction_amount' => 'required|numeric|min:0',
             ]);
     
             // Check if the user has sufficient balance for withdrawal
             if ($user->current_balance >= $request->transaction_amount) {
                 // Perform withdrawal operation
                 $withdrawAmount = $request->transaction_amount;
                 $user->current_balance -= $withdrawAmount;
                 $user->save();
     
                 // Save transaction
                 $transaction = new Transaction();
                 $transaction->account_id = $userId;
                 $transaction->transaction_amount = $withdrawAmount;
                 $transaction->closing_balance = $user->current_balance;
                 $transaction->transaction_type = 'Debit';
                 $transaction->save(); 
     
                 return redirect()->route('transactions.withdraw')->with('success', 'Amount withdrawn successfully.');
             } else {
                 // If the user has insufficient balance, return with an error message
                 return redirect()->route('transactions.withdraw')->with('error', 'Insufficient balance');
             }
     
         } catch (ValidationException $e) {
             // If validation fails, return with validation errors
             return redirect()->route('transactions.withdraw')->withErrors($e->errors())->withInput();
         } catch (\Exception $e) {
             // If any other exception occurs, return with a generic error message
             return redirect()->route('transactions.withdraw')->with('error', 'An error occurred while processing the withdrawal. Please try again later.');
         }
     }
     
    /**
     * transfer form view
     */
    public function showTransfer()
    {
        try {
            // Retrieve user ID from session
            $userId = session('user_id');
    
            // Check if user ID is set in session
            if ($userId === null) {
                // If user ID is not set, redirect to the login page
                return redirect()->route('auth.login')->with('error', 'Please log in to access this page.');
            } else {
                // If user ID is set, show the transfer form
                return view('transactions.transfer');
            }
        } catch (\Exception $e) {
            // If any unexpected exception occurs, redirect with a generic error message
            return redirect()->route('auth.login')->with('error', 'An error occurred while accessing the transfer page. Please try again later.');
        }
    }
    
    /**
     * Transfer amount from one account to another using email
     */
    public function transfer(Request $request){
        try {
            // Retrieve user ID from session
            $sourceId = session('user_id');
    
            // Check if user ID is set in session
            if ($sourceId === null) {
                return redirect()->route('auth.login')->with('error', 'User not logged in.');
            }
    
            // Get current balance of source account
            $debitor = User::findOrFail($sourceId);
    
            if($debitor->current_balance > $request->transaction_amount){
                $sourceClosingBalance = $debitor->current_balance - $request->transaction_amount;
    
                //Get destination account detail against email
                $creditor = User::where('email', $request->email)->first();
                if ($creditor) {
                    $destination_id = $creditor->id;
                    $creditClosingBalance = $creditor->current_balance + $request->transaction_amount;
    
                    // Start transaction
                    DB::beginTransaction();
    
                    // Insert debited amount in transaction table for source id
                    $debit = new Transaction();
                    $debit->account_id = $sourceId;
                    $debit->transfer_to = $destination_id;
                    $debit->transaction_amount = $request->transaction_amount;
                    $debit->closing_balance = $sourceClosingBalance;
                    $debit->transaction_type = 'Debit';
                    $debit->save();
    
                    // Insertion for credited amount in transaction table for destination id
                    $credit = new Transaction();
                    $credit->account_id = $destination_id;
                    $credit->transfer_from = $sourceId;
                    $credit->transaction_amount = $request->transaction_amount;
                    $credit->closing_balance = $creditClosingBalance;
                    $credit->transaction_type = 'Credit';
                    $credit->save();
    
                    // Update source account current balance in user table
                    $debitor->current_balance = $sourceClosingBalance;
                    $debitor->save();
    
                    // Update destination account current balance in user table
                    $creditor->current_balance = $creditClosingBalance;
                    $creditor->save();
    
                    // Commit transaction
                    DB::commit();
    
                    return redirect()->route('transactions.transfer')->with('success', 'Amount transferred successfully.');
                } else {
                    return redirect()->route('transactions.transfer')->with('error', 'Email address not found.');
                }
            } else {
                return redirect()->route('transactions.transfer')->with('error', 'Insufficient balance');
            }
        } catch (\Exception $e) {
            // Rollback transaction if an exception occurs
            DB::rollBack();
            return redirect()->route('transactions.transfer')->with('error', 'An error occurred. Please try again later.');
        }
    }
    
    /**
     * Show transaction history of the user
     */
    public function statement(Request $request){
        try {
            // Retrieve user ID from session
            $userId = session('user_id');
    
            // Check if user ID is set in session
            if ($userId === null) {
                return view('auth.login');
            }
    
            // Get user's all transaction amount data 
            $accountData = Transaction::select('transactions.id as transaction_id', 
                'transactions.transaction_amount', 'transactions.closing_balance', 
                'transactions.created_at', 'transactions.transaction_type',
                'u2.email as transfer_from_email', 'u3.email as transfer_to_email')
                ->leftJoin('users as u', 'u.id', '=', 'transactions.account_id')
                ->leftJoin('users as u2', 'u2.id', '=', 'transactions.transfer_from')
                ->leftJoin('users as u3', 'u3.id', '=', 'transactions.transfer_to')
                ->where('transactions.account_id', $userId)
                ->orderBy('transactions.created_at', 'asc')
                ->paginate(5);
    
            $data = [
                'accountData' => $accountData,
            ];
    
            // Return the view and pass the retrieved data
            return view('transactions.statement', $data);
    
        } catch (\Exception $e) {
            // Handle the exception and return an error response
            return redirect()->back()->with('error', 'An error occurred while fetching transaction data: ' . $e->getMessage());
        }
    }
    
}
