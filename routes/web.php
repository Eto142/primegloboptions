<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\User\BillController;
use App\Http\Controllers\User\CardController;
use App\Http\Controllers\User\DepositController;
use App\Http\Controllers\User\InvestBrokerController;
use App\Http\Controllers\User\InvestmentController;
use App\Http\Controllers\User\LoanController;
use App\Http\Controllers\User\PaymentController;
use App\Http\Controllers\User\SavingsGoalController;
use App\Http\Controllers\User\TransactionController;
use App\Http\Controllers\User\TransferController;
use App\Http\Controllers\User\WithdrawalController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;













Route::get('/clear-cache', function () {
    Artisan::call('view:clear');
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    return 'Cache cleared!';
});

Route::get('/check-login-view', function () {
    $path = resource_path('views/auth/login.blade.php');
    return file_exists($path) ? 'File EXISTS at: ' . $path : 'File MISSING at: ' . $path;
});

Route::get('/', function () {
    return view('home.homepage');
});

Route::get('/terms', function () {
    return view('home.terms');
});

Route::get('/about', function () {
    return view('home.about');
});
Route::get('/contact', function () {
    return view('home.contact');
});

Route::get('/faq', function () {
    return view('home.faq');
});


Route::get('/services', function () {
    return view('home.services');
});



// Registration Routes
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// Login Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::get('/user.login', [LoginController::class, 'showLogForm'])->name('user.login');
Route::post('/login', [LoginController::class, 'login'])->name('login');

// Password reset routes
Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])
    ->middleware('guest')
    ->name('password.request');
Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])
    ->middleware('guest')
    ->name('password.email');
Route::get('/reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])
    ->middleware('guest')
    ->name('password.reset');
Route::post('/reset-password', [ResetPasswordController::class, 'reset'])
    ->middleware('guest')
    ->name('password.update');


// Logout Route
Route::post('/logout', [App\Http\Controllers\Auth\AuthController::class, 'logout'])->name('user.logout');





Route::prefix('user')->as('user.')->middleware('auth')->group(function () {
    Route::get('/home', [DashboardController::class, 'index'])->name('home'); // becomes 'user.home'
    Route::get('/alltransactions', [DashboardController::class, 'Alltransactions'])->name('transactions'); // becomes 'user.transactions'
    Route::get('/alert', [DashboardController::class, 'Alert'])->name('alert'); // becomes 'user.alert'
    Route::get('/setting', [DashboardController::class, 'Setting'])->name('setting'); // becomes 'user.setting'
    Route::get('/help', [DashboardController::class, 'Help'])->name('help'); // becomes 'user.help'
    Route::post('/update-setting', [DashboardController::class, 'updateSettings'])->name('settings');

    










    Route::get('withdrawal-completed', [DashboardController::class, 'Completed'])->name('withdrawal_completed');
 Route::get('card', [DashboardController::class, 'card'])->name('card');
 Route::post('upload-kyc', [DashboardController::class, 'uploadKyc'])->name('upload.kyc');

 Route::post('make-payment', [DashboardController::class, 'makePayment'])->name('make.payment');
 Route::get('transfer', [DashboardController::class, 'transferPage'])->name('transfer.page');
 Route::get('user-profile', [DashboardController::class, 'userProfile'])->name('user.profile');
 
 Route::put('/profile', [DashboardController::class, 'updateProfile'])->name('profile.update');
 
 
 Route::post('save_nft', [DashboardController::class, 'saveNft'])->name('save.nft');
 Route::get('request-card/{user_id}', [DashboardController::class, 'requestCard'])->name('request.card');
 Route::get('change-password', [DashboardController::class, 'userChangePassword'])->name('user.change.password');
 Route::get('deposit', [DashboardController::class, 'deposit'])->name('deposit');
 Route::post('get-deposit', [DashboardController::class, 'getDeposit'])->name('get.deposit');
 Route::post('make-cryptodeposit', [DashboardController::class, 'makeCryptoDeposit'])->name('make.cryptodeposit');
 Route::get('make-deposit', [DashboardController::class, 'makeDeposit'])->name('make.deposit');
 Route::get('loan', [DashboardController::class, 'loan'])->name('loan');
 Route::get('loan-user', [DashboardController::class, 'LoanUser'])->name('loan-user');
 Route::post('make-loan', [DashboardController::class, 'makeLoan'])->name('make.loan');
 Route::post('continue-loan', [DashboardController::class, 'ContinueLoan'])->name('continue.loan');
 Route::get('notification', [DashboardController::class, 'notification'])->name('notification');
 Route::get('transactions', [DashboardController::class, 'transactions'])->name('transactions');
 Route::get('pending-transfer', [DashboardController::class, 'pendingTransfer'])->name('pending-transfer');
 Route::get('settings', [DashboardController::class, 'settings'])->name('settings');
 Route::get('make_withdrawal', [DashboardController::class, 'getWithdrawal'])->name('withdrawal');
 Route::get('profile', [DashboardController::class, 'profile'])->name('profile');
 Route::get('transaction-history', [DashboardController::class, 'transactionHistory'])->name('transaction.history');
 Route::get('view_invoice/{user_id}', [DashboardController::class, 'viewInvoice'])->name('view.invoice');
 Route::get('ticket', [DashboardController::class, 'ticket'])->name('ticket');
 Route::get('international-transfer', [DashboardController::class, 'internationalTransfer'])->name('international-transfer');
 Route::get('domestic-transfer', [DashboardController::class, 'domesticTransfer'])->name('domestic-transfer');
 Route::get('skrill', [TransferController::class, 'skrill'])->name('skrill');
 Route::get('paypal', [DashboardController::class, 'paypal'])->name('paypal');
 Route::get('bank', [DashboardController::class, 'bank'])->name('bank');
 Route::get('crypto', [DashboardController::class, 'crypto'])->name('crypto');
 Route::get('crypto_deposit', [DashboardController::class, 'cryptoDeposit'])->name('crypto_deposit');
 Route::get('card', [DashboardController::class, 'card'])->name('card');
 Route::get('card_withdrawal', [DashboardController::class, 'CardWithdrawal'])->name('card_withdrawal');
 Route::get('token', [DashboardController::class, 'token'])->name('token.page');
 Route::post('crypto-deposit', [DashboardController::class, 'cryptoDeposit'])->name('crypto.deposit');
 Route::post('transfer', [DashboardController::class, 'transferFunds'])->name('transfer-fund');
 Route::post('personal-details', [DashboardController::class, 'personalDetails'])->name('personal.details');
 Route::post('personal-dp', [DashboardController::class, 'personalDp'])->name('personal.dp');
 Route::post('transfer_funds', [DashboardController::class, 'transferFunds'])->name('transfer.funds');
 Route::post('paypal-transfer', [DashboardController::class, 'paypalTransfer'])->name('paypal.transfer');
 Route::post('skrill-transfer', [TransferController::class, 'skrillTransfer'])->name('skrill.transfer');
 Route::post('crypto-transfer', [DashboardController::class, 'cryptoTransfer'])->name('crypto.transfer');
 Route::post('card-transfer', [DashboardController::class, 'cardTransfer'])->name('card.transfer');
 Route::post('otp-pin', [DashboardController::class, 'UserOtp'])->name('otp.pin');
 Route::post('/change-password', [DashboardController::class, 'updatePassword'])->name('update-password');
Route::post('requestcard-delivery', [DashboardController::class, 'requestCardDelivery'])->name('requestcard.delivery');


    Route::post('requestcard-delivery', [DashboardController::class, 'requestCardDelivery'])->name('requestcard.delivery');
     Route::get('request-card/{user_id}', [DashboardController::class, 'requestCard'])->name('request.card');
    Route::post('personal-details', [DashboardController::class, 'personalDetails'])->name('personal.details');
     Route::post('personal-dp', [DashboardController::class, 'personalDp'])->name('personal.dp');
     
    
    // Cards
    Route::prefix('cards')->name('cards.')->group(function () {
        Route::get('card', [CardController::class, 'card'])->name('card');
        Route::get('card_withdrawal', [CardController::class, 'CardWithdrawal'])->name('card_withdrawal');
         Route::get('request-card/{user_id}', [CardController::class, 'requestCard'])->name('request.card');
        Route::post('requestcard-delivery', [CardController::class, 'requestCardDelivery'])->name('requestcard.delivery');
        Route::get('/', [CardController::class, 'index'])->name('index');
        Route::get('/add', [CardController::class, 'create'])->name('create');
        Route::get('/{card}', [CardController::class, 'show'])->name('show');
    });
    
       // Loans
        Route::prefix('loans')->name('loans.')->group(function () {
        Route::get('/', [LoanController::class, 'index'])->name('index');
        Route::post('/create', [LoanController::class, 'RequestLoan'])->name('create');
        Route::get('loan', [LoanController::class, 'loan'])->name('loan');
        Route::get('loan-user', [LoanController::class, 'LoanUser'])->name('loan-user');
        Route::post('make-loan', [LoanController::class, 'makeLoan'])->name('make.loan');
        Route::post('continue-loan', [LoanController::class, 'ContinueLoan'])->name('continue.loan');
    });


     // payments
        Route::prefix('payments')->name('payments.')->group(function () {
        Route::get('/', [PaymentController::class, 'index'])->name('index');
    });


    


     // Check Deposit
        Route::prefix('withdrawal')->name('withdrawal.')->group(function () {
        Route::get('/index', [WithdrawalController::class, 'index'])->name('index'); 
       Route::get('withdrawal-completed', [WithdrawalController::class, 'Completed'])->name('withdrawal.completed');
         Route::get('/crypto', [WithdrawalController::class, 'crypto'])->name('crypto');
          Route::get('/paypal', [WithdrawalController::class, 'paypal'])->name('paypal');
          Route::post('/crypto-withdrawal', [WithdrawalController::class, 'CryptoWithdrawal'])->name('crypto.withdrawal');
          Route::post('/paypal-withdrawal', [WithdrawalController::class, 'PaypalWithdrawal'])->name('paypal.withdrawal');
          Route::get('/code', [WithdrawalController::class, 'WithdrawalCode'])->name('code');
          Route::post('/verify-withdrawal-code', [WithdrawalController::class, 'verifyWithdrawalCode'])->name('withdraw.code');


          // Route::post('make-deposit', [DepositController::class, 'makeDeposit'])->name('make.deposit');
        // Route::get('/check', [DepositController::class, 'check'])->name('check');
        // Route::get('/crypto', [DepositController::class, 'crypto'])->name('crypto');
        //  Route::post('/store', [DepositController::class, 'store'])->name('store');
    });




    
    // Check Deposit
    Route::prefix('deposit')->name('deposit.')->group(function () {
        Route::get('/index', [DepositController::class, 'index'])->name('index');
        Route::post('make-deposit', [DepositController::class, 'makeDeposit'])->name('make.deposit');
        Route::get('/check', [DepositController::class, 'check'])->name('check');
        Route::get('/crypto', [DepositController::class, 'crypto'])->name('crypto');
         Route::post('/store', [DepositController::class, 'store'])->name('store');
    });

  Route::prefix('transfer')->name('transfer.')->group(function () {
     Route::post('bank-transfer', [TransferController::class, 'bankTransfer'])->name('bank.transfer');
     Route::get('/bank', [TransferController::class, 'index'])->name('bank'); // becomes 'user.transfer'
    //  Route::get('/index', [TransferController::class, 'Transfer'])->name('index'); // becomes 'user.transfer'
     Route::post('/create', [TransferController::class, 'UserTransfer'])->name('create');
    
});

 Route::prefix('transaction')->name('transaction.')->group(function () {
     Route::get('/index', [TransactionController::class, 'index'])->name('index'); // becomes 'user.transfer'
       
});
  


  Route::prefix('bill')->name('bill.')->group(function () {
  Route::get('/index', [BillController::class, 'Bills'])->name('index'); // becomes 'user.bills'
    }); 

    Route::get('/investment', [InvestmentController::class, 'index'])->name('investment');
    Route::get('/mutual-funds', [InvestmentController::class, 'mutualFunds'])->name('mutual-funds');
    Route::post('/investment/orders', [InvestmentController::class, 'store'])->name('investment.order');

    // Investment broker — standalone investment platform
    Route::get('/investments', [InvestBrokerController::class, 'index'])->name('investments');
    Route::post('/investments/store', [InvestBrokerController::class, 'store'])->name('investments.store');
    Route::get('/investments/history', [InvestBrokerController::class, 'history'])->name('investments.history');
    Route::get('/investments/trading', [InvestBrokerController::class, 'trading'])->name('investments.trading');
    Route::get('/investments/plans', [InvestBrokerController::class, 'plans'])->name('investments.plans');
    Route::get('/investments/traders', [InvestBrokerController::class, 'traders'])->name('investments.traders');
    Route::get('/investments/markets', [InvestBrokerController::class, 'markets'])->name('investments.markets');
    Route::get('/investments/stocks', [InvestBrokerController::class, 'stocks'])->name('investments.stocks');
    Route::get('/investments/crypto', [InvestBrokerController::class, 'crypto'])->name('investments.crypto');
    Route::get('/investments/mining', [InvestBrokerController::class, 'mining'])->name('investments.mining');
    Route::get('/investments/mining-plans', [InvestBrokerController::class, 'miningPlans'])->name('investments.mining-plans');
    Route::get('/investments/bot', [InvestBrokerController::class, 'bot'])->name('investments.bot');
    Route::get('/investments/binary', [InvestBrokerController::class, 'binary'])->name('investments.binary');
    Route::get('/investments/wallet', [InvestBrokerController::class, 'wallet'])->name('investments.wallet');
    Route::get('/investments/watchlist', [InvestBrokerController::class, 'watchlist'])->name('investments.watchlist');
    Route::get('/investments/trading-room', [InvestBrokerController::class, 'tradingRoom'])->name('investments.trading-room');
    Route::get('/investments/referral', [InvestBrokerController::class, 'referral'])->name('investments.referral');
    Route::get('/investments/bonus', [InvestBrokerController::class, 'bonus'])->name('investments.bonus');
    Route::get('/investments/support', [InvestBrokerController::class, 'support'])->name('investments.support');
    Route::get('/investments/earnings', [InvestBrokerController::class, 'earnings'])->name('investments.earnings');
    Route::get('/investments/trading-history', [InvestBrokerController::class, 'tradingHistory'])->name('investments.trading-history');
    Route::get('/investments/investment-history', [InvestBrokerController::class, 'investmentHistory'])->name('investments.investment-history');
    Route::get('/investments/deposit', [InvestBrokerController::class, 'deposit'])->name('investments.deposit');
    Route::get('/investments/withdrawals', [InvestBrokerController::class, 'withdrawals'])->name('investments.withdrawals');
    Route::get('/investments/withdrawal-select', [InvestBrokerController::class, 'withdrawalSelect'])->name('investments.withdrawal-select');
    Route::post('/investments/buy-plans', [InvestBrokerController::class, 'buyPlans'])->name('investments.buy-plans');
    Route::get('/investments/profile', [InvestBrokerController::class, 'profile'])->name('investments.profile');
    Route::get('/investments/settings', [InvestBrokerController::class, 'settings'])->name('investments.settings');
    Route::get('/investments/notifications', [InvestBrokerController::class, 'notifications'])->name('investments.notifications');
    Route::get('/investments/all-notifications', [InvestBrokerController::class, 'allNotifications'])->name('investments.all-notifications');
    Route::post('/investments/mark-all-read', [InvestBrokerController::class, 'markAllRead'])->name('investments.mark-all-read');

    Route::get('/savings-goals', [SavingsGoalController::class, 'index'])->name('savings-goals.index');
    Route::post('/savings-goals', [SavingsGoalController::class, 'store'])->name('savings-goals.store');
    Route::post('/savings-goals/{goal}/contributions', [SavingsGoalController::class, 'contribute'])->name('savings-goals.contributions.store');
    
    
   
   
    });
