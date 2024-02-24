<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;
use App\Models\Transaction;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


// Login routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

// Logout route
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

//Registration route
Route::get('/registration', [UserController::class, 'create'])->name('users.create');
Route::post('/users', [UserController::class, 'store'])->name('users.store');

//Homepage route
Route::get('/', [UserController:: class, 'index']);
Route::get('/home', [UserController:: class, 'index'])->name('users.home');

//Deposit route
Route::get('/deposit', [TransactionController::class, 'showDeposit'])->name('transactions.deposit');
Route::post('/deposit', [TransactionController::class, 'deposit'])->name('transactions.deposit');

//Withdraw route
Route::get('/withdraw', [TransactionController::class, 'showWithdraw'])->name('transactions.withdraw');
Route::post('/withdraw', [TransactionController::class, 'withdraw'])->name('transactions.withdraw');

//Amount transfer route
Route::get('/transfer', [TransactionController::class, 'showTransfer'])->name('transactions.transfer');
Route::post('/transfer', [TransactionController::class, 'transfer'])->name('transactions.transfer');

//Account statement route
Route::get('/statement', [TransactionController::class, 'statement'])->name('transactions.statement');

