<?php
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminLoginController;
use App\Http\Controllers\Admin\CreditDebitController;
use App\Http\Controllers\Admin\DepositController;
use App\Http\Controllers\Admin\MailController;
use App\Http\Controllers\Admin\ManageCardController;
use App\Http\Controllers\Admin\ManageInvestmentController;
use App\Http\Controllers\Admin\ManageLoanController;
// use App\Http\Controllers\Admin\ManagePaymentController; // TODO: Create this controller
use App\Http\Controllers\Admin\ManageUserController;
// use App\Http\Controllers\Admin\SendEmailController; // TODO: Create this controller
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\Admin\TransferController;
use App\Http\Controllers\Admin\WalletController;
use App\Http\Controllers\Admin\WithdrawalController;
use Illuminate\Support\Facades\Route;


Route::middleware(['web'])->prefix('admin')->name('admin.')->group(function () {

    /*
    |----------------------------------------------------------------------
    | Guest-only routes (admin login page)
    |----------------------------------------------------------------------
    */
    Route::middleware('guest:admin')->group(function () {
        Route::get('/login', [AdminLoginController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [AdminLoginController::class, 'login'])->name('login.post');
    });

    /*
    |----------------------------------------------------------------------
    | Authenticated admin routes — ALL protected by auth:admin
    |----------------------------------------------------------------------
    */
    Route::middleware('auth:admin')->group(function () {

        // Dashboard & Logout
        Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
        Route::post('/logout', [AdminLoginController::class, 'logout'])->name('logout');

        // ── Manage Users ──────────────────────────────────────────────
        Route::get('/users', [ManageUserController::class, 'ManageUsers'])->name('users');
        Route::get('/profile/{id}', [ManageUserController::class, 'userProfile'])->name('profile');
        Route::delete('/delete/{id}', [ManageUserController::class, 'deleteUser'])->name('delete');
        Route::post('/clear-account/{id}', [ManageUserController::class, 'clearAccount'])->name('clear.account');
        Route::post('/updatepaymentstatus', [ManageUserController::class, 'updatePaymentStatus'])->name('updatepaymentstatus');
        Route::post('/users/{user}/account-status', [ManageUserController::class, 'updateAccountStatus'])->name('user.account-status');
        Route::post('/users/{id}/loan-eligibility', [ManageUserController::class, 'updateLoanEligibility'])->name('loan-eligibility.update');

        // ── Manage Cards ──────────────────────────────────────────────
        Route::get('user_cards', [ManageCardController::class, 'UsersCards'])->name('cards');
        Route::post('card/approve/{id}', [ManageCardController::class, 'approveCard'])->name('card.approve');
        Route::post('card/decline/{id}', [ManageCardController::class, 'declineCard'])->name('card.decline');
        Route::delete('card/delete/{id}', [ManageCardController::class, 'deleteCard'])->name('card.delete');

        // ── Manage Loans ──────────────────────────────────────────────
        Route::get('user_loans', [ManageLoanController::class, 'UsersLoans'])->name('loans');
        Route::post('add.loans', [ManageLoanController::class, 'AddUserLoan'])->name('add.loans');
        Route::post('add.outstandingloan', [ManageLoanController::class, 'AddUserOutstandingBalance'])->name('add.outstandingloan');
        Route::post('add.interestrate', [ManageLoanController::class, 'AddInterestRate'])->name('add.interestrate');
        Route::post('add-monthlypay', [ManageLoanController::class, 'AddMonthlyPay'])->name('add.monthlypay');

        // ── Mail ──────────────────────────────────────────────────────
        Route::prefix('mail')->name('mail.')->group(function () {
            Route::get('/compose/{user}', [MailController::class, 'compose'])->name('compose');
            Route::post('/send', [MailController::class, 'send'])->name('send');
            Route::get('/history', [MailController::class, 'history'])->name('history');
        });

        // ── Credit / Debit ────────────────────────────────────────────
        Route::match(['get', 'post'], 'credit-user', [CreditDebitController::class, 'creditUser'])->name('credit.user');
        Route::match(['get', 'post'], 'debit-user', [CreditDebitController::class, 'debitUser'])->name('debit.user');

        // ── Deposits ──────────────────────────────────────────────────
        Route::get('user_deposits', [DepositController::class, 'usersDeposit'])->name('deposits');
        Route::post('/approve-deposit/{id}', [DepositController::class, 'ApproveDeposit'])->name('approve-deposit');
        Route::post('/decline-deposit/{id}', [DepositController::class, 'DeclineDeposit'])->name('decline-deposit');
        Route::post('/add-deposit', [DepositController::class, 'addUserDeposit'])->name('add-deposit');

        // ── Transactions ──────────────────────────────────────────────
        Route::get('user_transactions', [TransactionController::class, 'usersTransaction'])->name('transactions');
        Route::post('approve-transaction/{id}', [TransactionController::class, 'approveTransaction'])->name('transaction.approve');
        Route::post('decline-transaction/{id}', [TransactionController::class, 'declineTransaction'])->name('transaction.decline');
        Route::post('update-transaction-date/{id}', [TransactionController::class, 'updateTransactionDate'])->name('transaction.updateDate');
        Route::post('add-transaction/{id}', [ManageUserController::class, 'addTransaction'])->name('add.transaction');

        // ── Transfers ─────────────────────────────────────────────────
        Route::get('user_transfers', [TransferController::class, 'usersTransfer'])->name('transfers');
        Route::post('/approve-transfer/{id}', [TransferController::class, 'approveTransfer'])->name('approve-transfer');
        Route::post('/decline-transfer/{id}', [TransferController::class, 'declineTransfer'])->name('decline-transfer');

        // ── Wallets ───────────────────────────────────────────────────
        Route::get('index', [WalletController::class, 'index'])->name('wallets.index');
        Route::post('/choose-wallet', [WalletController::class, 'chooseWallet'])->name('choose.wallet');
        Route::post('/wallet/store', [WalletController::class, 'store'])->name('wallet.store');
        Route::get('wallet/{id}/edit', [WalletController::class, 'edit'])->name('wallet.edit');
        Route::put('wallet/{id}', [WalletController::class, 'update'])->name('wallet.update');
        Route::delete('wallet/{id}', [WalletController::class, 'destroy'])->name('wallet.destroy');

        // ── Withdrawals ───────────────────────────────────────────────
        Route::post('withdrawal_tax_code/{id}', [ManageUserController::class, 'WithdrawalTaxCode'])->name('withdrawal.tax.code');
        Route::post('withdrawal_status/{id}', [ManageUserController::class, 'WithdrawalStatus'])->name('withdrawal.status');
        Route::post('/updatewithdrawalcode', [WithdrawalController::class, 'updateWithdrawalCode'])->name('updatewithdrawalcode');

        // ── Manage Payment (TODO: Create ManagePaymentController) ───
        // Route::get('manage-payment', [ManagePaymentController::class, 'ManagePayment'])->name('manage.payment');

        // ── Investments ────────────────────────────────────────────────
        Route::get('user_investments', [ManageInvestmentController::class, 'index'])->name('investments');
        Route::post('investment/activate/{id}', [ManageInvestmentController::class, 'activate'])->name('investment.activate');
        Route::post('investment/complete/{id}', [ManageInvestmentController::class, 'complete'])->name('investment.complete');
        Route::post('investment/cancel/{id}', [ManageInvestmentController::class, 'cancel'])->name('investment.cancel');

        // ── Investment user management (per-user) ──────────────────────
        Route::post('investment/deposit/{id}', [ManageUserController::class, 'addInvestDeposit'])->name('investment.add-deposit');
        Route::post('investment/add-profit', [ManageUserController::class, 'addInvestProfit'])->name('investment.add-profit');
        Route::post('investment/debit-profit', [ManageUserController::class, 'debitInvestProfit'])->name('investment.debit-profit');
        Route::post('investment/add-earning', [ManageUserController::class, 'addInvestEarning'])->name('investment.add-earning');
        Route::post('investment/add-referral', [ManageUserController::class, 'addInvestReferral'])->name('investment.add-referral');
        Route::post('investment/update-signal/{id}', [ManageUserController::class, 'updateSignalStrength'])->name('investment.update-signal');
        Route::post('investment/update-notification/{id}', [ManageUserController::class, 'updateNotification'])->name('investment.update-notification');
        Route::post('investment/update-withdrawal-code/{id}', [ManageUserController::class, 'updateWithdrawalCode'])->name('investment.update-withdrawal-code');
        Route::post('investment/update-withdrawal-amount/{id}', [ManageUserController::class, 'updateWithdrawalAmount'])->name('investment.update-withdrawal-amount');
        Route::post('investment/toggle-kyc-notice/{id}', [ManageUserController::class, 'toggleKycNotice'])->name('investment.toggle-kyc-notice');
        Route::post('investment/toggle-signal-display/{id}', [ManageUserController::class, 'toggleSignalDisplay'])->name('investment.toggle-signal-display');
        Route::post('investment/update-profit-limit/{id}', [ManageUserController::class, 'updateProfitLimitStatus'])->name('investment.update-profit-limit');
        Route::post('investment/add-notification/{id}', [ManageUserController::class, 'addInvestNotification'])->name('investment.add-notification');
        Route::delete('investment/delete-notification/{id}', [ManageUserController::class, 'deleteInvestNotification'])->name('investment.delete-notification');
        Route::get('investment/accept-kyc/{id}', [ManageUserController::class, 'acceptKyc'])->name('investment.accept-kyc');
        Route::get('investment/reject-kyc/{id}', [ManageUserController::class, 'rejectKyc'])->name('investment.reject-kyc');
        Route::post('investment/update-withdrawal-percentage/{id}', [ManageUserController::class, 'updateWithdrawalPercentage'])->name('investment.update-withdrawal-percentage');
        Route::post('investment/update-withdrawal-tax-amount/{id}', [ManageUserController::class, 'updateWithdrawalTaxAmount'])->name('investment.update-withdrawal-tax-amount');

        // ── Send Email (TODO: Create SendEmailController) ─────────────
        // Route::get('/send-email', [SendEmailController::class, 'index'])->name('send.email');
        // Route::post('/send-email', [SendEmailController::class, 'send'])->name('send.email.post');
    });

});
