<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\User;

class TransactionController extends Controller
{
    public function index($id = null){

        // Retrieve user ID from session
        $userId = session('user_id');
    
        // Check if user ID is set in session
        if ($userId === null) {
            return view('auth.login');
        }

        $userData = new Transaction();
        $userData= User::where('id', $userId)->first();
        $data = [
            'userId' => $userId,
            'userData' => $userData,
        ];
        return view('users.home', $data);
    }

    public function showDeposit()
    {
        // Retrieve user ID from session
        $userId = session('user_id');

        // Check if user ID is set in session
        if ($userId === null) {
            return view('auth.login');
        }else{
            return view('transactions.deposit');
        }
    }
    public function deposit(Request $request){
        // Retrieve user ID from session
        $userId = session('user_id');
    
        // Check if user ID is set in session
        if ($userId === null) {
            return view('auth.login');
        }

        $deposit = new User();
        $deposit = User::findOrFail($userId);
        $deposit->current_balance = $deposit->current_balance + $request->transaction_amount;
        $deposit->save();

        $user = new Transaction();
        $user->account_id = $userId;
        $user->transaction_amount = $request->transaction_amount;
        $user->closing_balance = $deposit->current_balance ;
        $user->transaction_type = 'Credit';
        $user->save();

        $data = [
            'userId' => $userId,
            'userData' => $deposit,
        ];

        return redirect()->route('transactions.deposit')->with('success', 'Amount deposited successfully.');
    }

    public function showWithdraw()
    {
        // Retrieve user ID from session
        $userId = session('user_id');

        // Check if user ID is set in session
        if ($userId === null) {
            return view('auth.login');
        }else{
            return view('transactions.withdraw');
        }
    }

    public function withdraw(Request $request){
        // Retrieve user ID from session
        $userId = session('user_id');
    
        // Check if user ID is set in session
        if ($userId === null) {
            return view('auth.login');
        }

        $withdraw = new User();
        $withdraw = User::findOrFail($userId);

        if ($withdraw->current_balance>=$request->transaction_amount){
            $withdraw->current_balance = $withdraw->current_balance - $request->transaction_amount;
            $withdraw->save();

            $user = new Transaction();
            $user->account_id = $userId;
            $user->transaction_amount = $request->transaction_amount;
            $user->closing_balance = $withdraw->current_balance ;
            $user->transaction_type = 'Debit';
            $user->save(); 
            
            $data = [
                'userId' => $userId,
                'userData' => $withdraw,
            ];
            //return view('users.home', $data);

            return redirect()->route('transactions.withdraw')->with('success', 'Amount withdrawn successfully.');

        }else{
            return redirect()->route('transactions.withdraw')->with('error', 'Insufficient balance');

        }
    }

    public function showTransfer()
    {
        // Retrieve user ID from session
        $userId = session('user_id');

        // Check if user ID is set in session
        if ($userId === null) {
            return view('auth.login');
        }else{
            return view('transactions.transfer');
        }
    }


    public function transfer(Request $request){
        // Retrieve user ID from session
        $sourceId = session('user_id');

        // Check if user ID is set in session
        if ($sourceId === null) {
            return view('auth.login');
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

            // Update source account current balanlne in user table
            $updateDebitorBalance = User::where('id', $sourceId)->update([
                'current_balance' => $sourceClosingBalance,
            ]);

            // Update source id current balanlne in user table
            $updateCreditorBalance = User::where('email', $request->email)->update([
                'current_balance' => $creditClosingBalance,
            ]);    

            $data = [
                'userId' => $sourceId,
                'userData' => $debitor,
            ];

            return redirect()->route('transactions.transfer')->with('success', 'Amount transfered successfully.');

            }else{
                return redirect()->route('transactions.transfer')->with('error', 'Email address not found.');

            }
            
        }else{
            return redirect()->route('transactions.transfer')->with('error', 'Insufficient balance');

        }
    }

    public function statement(Request $request){
        // Retrieve user ID from session
        $userId = session('user_id');

        // Check if user ID is set in session
        if ($userId === null) {
            return view('auth.login');
        }

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

        $data=[
            'accountData' => $accountData,
        ];
        //dd($accountData);
        // Return the view and pass the retrieved data
        return view('transactions.statement', $data);

    }
}
