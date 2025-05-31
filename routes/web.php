<?php

use App\Http\Controllers\Admin\AccountController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\UserAuthController;
use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\User\DepositController;
use App\Http\Controllers\User\WithdrawalController;
use App\Http\Controllers\User\TeamController;
use App\Http\Controllers\User\DashboardController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\GameSettingsController;
use App\Http\Controllers\Admin\ReferralController;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\Admin\UserInvestmentsController;
use App\Http\Controllers\Auth\CustomPasswordResetController;
use App\Http\Controllers\ImpersonateController;
use App\Http\Controllers\User\GameController;
use App\Http\Controllers\Payment\NowPaymentcontroller;
use App\Http\Controllers\CoinPaymentsController;
use App\Http\Controllers\Payment\IPNController;
use Illuminate\Support\Facades\Log;


// ==========================
// User Authentication
// ==========================



Route::middleware('guest')->group(function () {
    Route::get('/login', [UserAuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [UserAuthController::class, 'login']);
});

Route::get('/', [UserAuthController::class, 'showRegisterForm'])->name('home');
Route::post('/register', [UserAuthController::class, 'register'])->name('register');
// Route::get('/login', [UserAuthController::class, 'showLoginForm'])->name('login');
// Route::post('/login', [UserAuthController::class, 'login']);


Route::get('/password/reset', [CustomPasswordResetController::class, 'showRequestForm'])->name('password.request');
Route::post('/password/email', [CustomPasswordResetController::class, 'sendResetCode'])->name('password.email');
Route::get('/password/set-new', [CustomPasswordResetController::class, 'showSetNewPasswordForm'])->name('password.set.new');
Route::post('/password/reset', [CustomPasswordResetController::class, 'resetPassword'])->name('password.update');



// ==========================
// Admin Authentication
// ==========================
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AdminAuthController::class, 'login']);
});



// ==========================
// Protected User Routes
// ==========================


Route::middleware(['auth:web'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'home'])->name('dashboard');
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

    Route::get('/withdraw', [WithdrawalController::class, 'withdraw'])->name('withdraw');
    Route::post('/withdraw', [WithdrawalController::class, 'withdrawRequest'])->name('withdraw.request');
    Route::get('/withdraw/setup', [WithdrawalController::class, 'setup'])->name('withdraw.setup');
    Route::post('/withdraw/setup', [WithdrawalController::class, 'storeSetup'])->name('withdraw.setup.store');

    // Team
    Route::get('/team', [TeamController::class, 'team'])->name('team');

    //  BOLT CONTROLLERS

    Route::get('/ai-trading', [GameController::class, 'aitrading'])->name('ai-trading');
    Route::post('/bot/place-trade', [GameController::class, 'placeTrade'])->name('bot.place_trade');
    Route::post('/bot/close-trade', [GameController::class, 'closeTrade'])->name('bot.close_trade');

    Route::get('/bonuses', [TeamController::class, 'bonuses'])->name('bonuses');

    // // User Game Investment
    // Route::get('/game', [GameController::class, 'showInvestmentForm'])->name('user.game.invest_form');
    // Route::post('/game/invest', [GameController::class, 'invest'])->name('user.game.invest');

    // It is important that this route is under 'auth:web' because the user is currently authenticated via 'web' guard
    Route::get('/impersonate/leave', [ImpersonateController::class, 'leave'])->name('impersonate.leave');
    Route::post('/logout', [UserAuthController::class, 'logout'])->name('user.logout');
});



// ==========================
// Protected Admin Routes
// ==========================


Route::prefix('admin')->middleware('auth:admin')->group(function () {

    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/reset-password', [AdminUserController::class, 'passwordResetList'])->name('admin.password');
    Route::get('/traders', [AdminUserController::class, 'traderList'])->name('admin.trader');
    Route::get('/depost', [AdminUserController::class, 'depost'])->name('admin.depost');
    Route::get('/withdraw', [AdminUserController::class, 'withdraw'])->name('admin.withdraw');
    Route::get('/user-team', [AdminUserController::class, 'team'])->name('admin.team');
    Route::get('/trader-details/{id}', [AdminUserController::class, 'traderDetails'])->name('admin.trader-details');
    Route::get('/admin.trader-block/{id}', [AdminUserController::class, 'toggleTraderStatus'])->name('admin.trader-block');
    Route::post('/admin/aprove-depost/{id}', [AdminUserController::class, 'aproveDepost'])->name('admin.aprove-depost');

    Route::get('/settings', [AdminUserController::class, 'settings'])->name('admin.settings');

    Route::post('/add-account', [AccountController::class, 'store'])->name('main-account.store');
    Route::put('/update-account/{id}', [AccountController::class, 'update'])->name('main-account.update');

    //  Managements
    Route::get('/logs', [AdminUserController::class, 'systemLogs'])->name('admin.logs');


    Route::get('/referrals', [ReferralController::class, 'index'])->name('admin.referrals.index');
    Route::post('/referrals', [ReferralController::class, 'store'])->name('admin.referrals.store');
    Route::get('/referrals/status/{key}', [ReferralController::class, 'status'])->name('admin.referrals.status'); // This route will be for toggling global referral status

    Route::post('/transactions/add', [TransactionController::class, 'store'])->name('transactions.add');



    Route::resource('game-settings', GameSettingsController::class)->names('admin.game_settings');
    Route::post('game-settings/{game_setting}/toggle-investment', [GameSettingsController::class, 'toggleInvestmentStatus'])->name('admin.game_settings.toggle_investment');
    Route::post('game-settings/{game_setting}/toggle-payout', [GameSettingsController::class, 'togglePayoutStatus'])->name('admin.game_settings.toggle_payout');


    // User Investments Management (Admin)
    Route::get('/user-investments', [UserInvestmentsController::class, 'index'])->name('admin.user_investments.index');
    Route::post('/user-investments/{user_investment}/payout-profit', [UserInvestmentsController::class, 'payoutProfit'])->name('admin.user_investments.payout_profit');
    Route::post('/user-investments/{user_investment}/return-principal', [UserInvestmentsController::class, 'returnPrincipal'])->name('admin.user_investments.return_principal');
    Route::post('/admin/user-investments/{user_investment}/complete', [UserInvestmentsController::class, 'completeInvestment'])->name('admin.user_investments.complete');
    Route::post('/user-investments/{user_investment}/cancel', [UserInvestmentsController::class, 'cancelInvestment'])->name('admin.user_investments.cancel');

    // Admin-initiated Impersonation
    // This route needs to be protected by the 'auth:admin' middleware
    Route::get('/impersonate/{id}', [ImpersonateController::class, 'loginAsUser'])->name('impersonate.login');

    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');
});


// Route::get('/payment/initiate', [CoinPaymentsController::class, 'showPaymentForm'])->name('coinpayments.form');
// Route::get('/payment/success', [CoinPaymentsController::class, 'paymentSuccess'])->name('payment.success');
// Route::get('/payment/cancel', [CoinPaymentsController::class, 'paymentCancel'])->name('payment.cancel');
// Route::post('/payment/create', [CoinPaymentsController::class, 'createTransaction'])->name('coinpayments.create');
// Route::post('/ipn/coinpayments', [CoinPaymentsController::class, 'handleIpn'])->name('coinpayments.ipn');


Route::get('/nowpayments/form', [NowPaymentController::class, 'paymentForm']);
Route::post('/payments/create', [NowPaymentcontroller::class, 'createPayment'])->name('payments.create');
Route::post('/ipn-callback', [IPNController::class, 'handle'])->name('ipn.callback');
Route::get('/nowpayments/balance', [NowPaymentController::class, 'checkBalance']);
Route::post('/nowpayments/validate-address', [NowPaymentController::class, 'validateAddress']);
