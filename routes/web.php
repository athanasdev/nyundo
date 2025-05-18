<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\UserAuthController;
use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\User\DepositController;
use App\Http\Controllers\User\WithdrawalController;
use App\Http\Controllers\User\TeamController;
use App\Http\Controllers\User\DashboardController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminUserController;

// ==========================
// User Authentication
// ==========================


Route::get('/', [UserAuthController::class, 'showRegisterForm'])->name('home');
Route::post('/register', [UserAuthController::class, 'register'])->name('register');
Route::get('/login', [UserAuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [UserAuthController::class, 'login']);
Route::post('/logout', [UserAuthController::class, 'logout'])->name('user.logout');
Route::post('/forgot-password', [UserAuthController::class, 'forgotPassword'])->name('user.forgot-password');


// ==========================
// Admin Authentication
// ==========================
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AdminAuthController::class, 'login']);
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');

});



// ==========================
// Protected User Routes
// ==========================


Route::middleware(['auth:web'])->group(function () {
    Route::get('/dashboard', fn () => view('user.dashboard'))->name('dashboard');

    Route::get('/my-account', [DashboardController::class, 'myaccount'])->name('my-account');
    Route::get('/assets', [DashboardController::class, 'assets'])->name('assets');
    Route::get('/order', [DashboardController::class, 'order'])->name('order');
    Route::get('/my-account', [DashboardController::class, 'myaccount'])->name('my-account');
    Route::get('/language', [DashboardController::class, 'language'])->name('language');

    // Deposit
    Route::get('/deposit', [DepositController::class, 'index'])->name('deposit');
    Route::get('/buy-crypto', [DepositController::class, 'buyCrypto'])->name('buy-crypto');
    Route::get('transfer', [DepositController::class, 'transfer'])->name('transfer');
    Route::post('funds-transfer', [DepositController::class, 'fundsTransfer'])->name('funds-transfer');
    Route::get('view-deposit/{id}', [DepositController::class, 'viewDeposit'])->name('view-deposit');
    Route::post('/deposit', [DepositController::class, 'store'])->name('deposit.store');


    // Withdrawal
    Route::get('/payment-method', [WithdrawalController::class, 'index'])->name('payment-method');
    Route::get('/withdraw', [WithdrawalController::class, 'withdraw'])->name('withdraw');
    Route::post('/withdraw', [WithdrawalController::class, 'store'])->name('withdraw.store');

    // Team
    Route::get('/team', [TeamController::class, 'team'])->name('team');
    Route::get('/ai-trading', [TeamController::class, 'aitrading'])->name('ai-trading');
    Route::get('/bonuses', [TeamController::class, 'bonuses'])->name('bonuses');




});



// ==========================
// Protected Admin Routes
// ==========================


Route::prefix('admin')->middleware('auth:admin')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/reset-password', [AdminUserController::class, 'passwordResetList'])->name('admin.password');
    Route::get('/traders', [AdminUserController::class, 'traderList'])->name('admin.trader');
});



