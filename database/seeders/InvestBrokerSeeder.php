<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * Seeds users and all associated invest-broker transaction data
 * from the source database (amsnbxhdcz_nex) into this project.
 *
 * Column mapping:
 *   source.users.name   -> users.first_name
 *   source.users.lname  -> users.last_name
 *   source.profits      -> invest_profits
 *   source.debitprofits -> invest_debit_profits
 *   source.earnings     -> invest_earnings
 *   source.notifications-> invest_notifications
 *   source.transactions -> invest_profits (Profit rows) + invest_debit_profits (Debit rows)
 *   source.deposits     -> invest_plans  (approved deposits treated as plan purchases)
 */
class InvestBrokerSeeder extends Seeder
{
    public function run(): void
    {
        // ----------------------------------------------------------------
        // 0. Disable FK checks so we can insert with explicit IDs
        // ----------------------------------------------------------------
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        // ----------------------------------------------------------------
        // 1. USERS
        // ----------------------------------------------------------------
        $this->command->info('Seeding users…');

        $users = $this->users();

        // Build a set of existing IDs so we skip duplicates
        $existingIds = DB::table('users')->pluck('id')->flip()->all();

        foreach ($users as $u) {
            if (isset($existingIds[$u['id']])) {
                continue; // already present, skip
            }

            // Required columns that may be blank in the source
            $firstName = trim($u['name'] ?? '');
            $lastName  = trim($u['lname'] ?? '');
            if ($firstName === '') $firstName = 'User';
            if ($lastName  === '') $lastName  = $u['id'];

            DB::table('users')->insert([
                'id'                  => $u['id'],
                'first_name'          => $firstName,
                'last_name'           => $lastName,
                'name'                => $firstName,
                'lname'               => $lastName,
                'gender'              => 'unknown',
                'email'               => $u['email'],
                'phone'               => $u['phone']    ?? '',
                'country'             => $u['country']  ?? '',
                'dob'                 => $u['dob']      ?? '',
                'currency'            => $u['currency'] ?? '$',
                'account_type'        => 'savings',
                'transaction_pin'     => '0000',
                'show_password'       => $u['show_password'] ?? '',
                'account_number'      => $this->generateAccountNumber($u['id']),
                'kin_full_name'       => '',
                'kin_relationship'    => '',
                'kin_phone'           => '',
                'kin_email'           => null,
                'kin_address'         => '',
                'password'            => $u['password'],
                'email_verified_at'   => $u['email_verified_at'] ?? null,
                // invest-broker extra columns
                'signal_strength'     => $u['signal_strength'] ?? 50,
                'kyc_status'          => $u['kyc_status']      ?? '0',
                'bot_status'          => $u['bot_status']      ?? '0',
                'bot_image'           => $u['bot_image']       ?? null,
                'id_card'             => $u['id_card']         ?? null,
                'passport'            => $u['passport']        ?? null,
                'update_notification' => $u['update_notification'] ?? null,
                'update_escrow'       => $u['update_escrow']   ?? 0,
                'withdrawal_code'     => $u['withdrawal_code'] ?? null,
                'withdrawal_tax_code' => $u['withdrawal_tax_code'] ?? null,
                'withdrawal_amount'   => $u['withdrawal_amount'] ?? 0,
                'withdrawal_tax_amount'=> $u['withdrawal_tax_amount'] ?? 0,
                'withdrawal_percentage'=> $u['withdrawal_percentage'] ?? 0,
                'show_kyc_notice'     => $u['show_kyc_notice']     ?? 1,
                'show_signal_strength'=> $u['show_signal_strength'] ?? 1,
                'profit_limit_status' => $u['profit_limit_status']  ?? 0,
                'user_status'         => $u['user_status'] ?? '1',
                'usertype'            => $u['usertype']    ?? '0',
                'created_at'          => $u['created_at'] ?? now(),
                'updated_at'          => $u['updated_at'] ?? now(),
            ]);
        }

        $this->command->info('Users done.');

        // ----------------------------------------------------------------
        // 2. INVEST_PROFITS  (source: profits table)
        // ----------------------------------------------------------------
        $this->command->info('Seeding invest_profits…');

        $existingProfitTxns = DB::table('invest_profits')->pluck('transaction_id')->flip()->all();

        foreach ($this->profits() as $p) {
            if (isset($existingProfitTxns[$p['transaction_id']])) continue;

            DB::table('invest_profits')->insert([
                'id'             => $p['id'],
                'user_id'        => $p['user_id'],
                'transaction_id' => $p['transaction_id'],
                'plan_name'      => $p['plan_name'] ?? null,
                'amount'         => $p['amount'],
                'plan_type'      => $p['plan_type'] ?? null,
                'created_at'     => $p['created_at'],
                'updated_at'     => $p['updated_at'],
            ]);
        }

        $this->command->info('invest_profits done.');

        // ----------------------------------------------------------------
        // 3. INVEST_DEBIT_PROFITS  (source: debitprofits table)
        // ----------------------------------------------------------------
        $this->command->info('Seeding invest_debit_profits…');

        $existingDebitTxns = DB::table('invest_debit_profits')->pluck('transaction_id')->flip()->all();

        foreach ($this->debitProfits() as $d) {
            if (isset($existingDebitTxns[$d['transaction_id']])) continue;

            DB::table('invest_debit_profits')->insert([
                'id'             => $d['id'],
                'user_id'        => $d['user_id'],
                'transaction_id' => $d['transaction_id'],
                'amount'         => $d['amount'],
                'note'           => null,
                'created_at'     => $d['created_at'],
                'updated_at'     => $d['updated_at'],
            ]);
        }

        $this->command->info('invest_debit_profits done.');

        // ----------------------------------------------------------------
        // 4. INVEST_EARNINGS  (source: earnings table)
        // ----------------------------------------------------------------
        $this->command->info('Seeding invest_earnings…');

        $existingEarningTxns = DB::table('invest_earnings')->pluck('transaction_id')->flip()->all();

        foreach ($this->earnings() as $e) {
            if (isset($existingEarningTxns[$e['transaction_id']])) continue;

            DB::table('invest_earnings')->insert([
                'id'             => $e['id'],
                'user_id'        => $e['user_id'],
                'transaction_id' => $e['transaction_id'],
                'amount'         => $e['amount'],
                'type'           => $e['type'],
                'narration'      => $e['narration'],
                'created_at'     => $e['created_at'],
                'updated_at'     => $e['updated_at'],
            ]);
        }

        $this->command->info('invest_earnings done.');

        // ----------------------------------------------------------------
        // 5. INVEST_NOTIFICATIONS  (source: notifications table)
        // ----------------------------------------------------------------
        $this->command->info('Seeding invest_notifications…');

        // invest_notifications table: id, user_id, message, is_read, created_at, updated_at
        $existingNotes = DB::table('invest_notifications')->pluck('id')->flip()->all();

        foreach ($this->notifications() as $n) {
            if (isset($existingNotes[$n['id']])) continue;

            DB::table('invest_notifications')->insert([
                'id'         => $n['id'],
                'user_id'    => $n['user_id'],
                'message'    => $n['message'],
                'is_read'    => $n['is_read'],
                'created_at' => $n['created_at'],
                'updated_at' => $n['updated_at'],
            ]);
        }

        $this->command->info('invest_notifications done.');

        // ----------------------------------------------------------------
        // 6. Re-enable FK checks
        // ----------------------------------------------------------------
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        $this->command->info('InvestBrokerSeeder completed successfully.');
    }

    // ====================================================================
    // Helper
    // ====================================================================
    private function generateAccountNumber(int $userId): string
    {
        // Pad to 10 digits so it looks like a bank account number
        return str_pad((string) $userId, 10, '0', STR_PAD_LEFT);
    }

    // ====================================================================
    // DATA — USERS
    // ====================================================================
    private function users(): array
    {
        return [
            ['id'=>4,'name'=>'admin','lname'=>'admin','email'=>'support@nexglobmarket.com','phone'=>'39939393','country'=>'Albania','dob'=>null,'currency'=>'$','show_password'=>null,'signal_strength'=>'70','kyc_status'=>'0','bot_status'=>null,'bot_image'=>null,'id_card'=>null,'passport'=>null,'update_notification'=>null,'update_escrow'=>null,'user_status'=>'0','usertype'=>'1','withdrawal_code'=>null,'withdrawal_tax_code'=>null,'withdrawal_amount'=>null,'withdrawal_tax_amount'=>null,'withdrawal_percentage'=>null,'show_kyc_notice'=>1,'show_signal_strength'=>1,'profit_limit_status'=>'0','email_verified_at'=>null,'password'=>'$2y$12$kIdSh1eBa0dQvlDfy25rlu1d4durTI.qNP7AmmYO9B8r7/JfCiyFS','created_at'=>'2024-01-03 08:03:38','updated_at'=>'2025-05-12 03:27:48'],
            ['id'=>1692,'name'=>'tgod','lname'=>'tgod','email'=>'tgod1422@gmail.com','phone'=>'73747348834','country'=>'Algeria','dob'=>null,'currency'=>'$','show_password'=>null,'signal_strength'=>'40','kyc_status'=>'0','bot_status'=>null,'bot_image'=>'0','id_card'=>null,'passport'=>null,'update_notification'=>'yo','update_escrow'=>null,'user_status'=>'0','usertype'=>'0','withdrawal_code'=>'1010','withdrawal_tax_code'=>'2020','withdrawal_amount'=>'5000','withdrawal_tax_amount'=>'4000','withdrawal_percentage'=>'15','show_kyc_notice'=>0,'show_signal_strength'=>0,'profit_limit_status'=>'1','email_verified_at'=>null,'password'=>'$2y$12$j85aYiGXJ3TyTpwPbBwOLefioeUFSpLbiO1/I8m5Qtl/5aG3rJFCu','created_at'=>'2025-10-26 13:04:25','updated_at'=>'2026-05-08 15:22:07'],
            ['id'=>1693,'name'=>'Ojo','lname'=>'Ojo','email'=>'markibloud@gmail.com','phone'=>'09071180235','country'=>'Nigeria','dob'=>null,'currency'=>'$','show_password'=>'12345678','signal_strength'=>'100','kyc_status'=>'0','bot_status'=>null,'bot_image'=>'0','id_card'=>null,'passport'=>null,'update_notification'=>'Contact support for payment','update_escrow'=>null,'user_status'=>'0','usertype'=>'0','withdrawal_code'=>'1234','withdrawal_tax_code'=>'1955','withdrawal_amount'=>null,'withdrawal_tax_amount'=>null,'withdrawal_percentage'=>'70','show_kyc_notice'=>1,'show_signal_strength'=>1,'profit_limit_status'=>'0','email_verified_at'=>null,'password'=>'$2y$12$kogN16mTBmj.LjVTj6mD2eanUtGwGi/TBucvVL2s/h4yFacdNIV4C','created_at'=>'2025-10-30 00:34:07','updated_at'=>'2025-11-04 03:10:42'],
            ['id'=>1694,'name'=>'Ibebi','lname'=>'Rest','email'=>'ibebiibere0@gmal.com','phone'=>'9049469983','country'=>'United States','dob'=>null,'currency'=>'$','show_password'=>'Ibebi@123','signal_strength'=>null,'kyc_status'=>'0','bot_status'=>null,'bot_image'=>'0','id_card'=>null,'passport'=>null,'update_notification'=>null,'update_escrow'=>null,'user_status'=>'0','usertype'=>'0','withdrawal_code'=>null,'withdrawal_tax_code'=>'4265','withdrawal_amount'=>null,'withdrawal_tax_amount'=>null,'withdrawal_percentage'=>null,'show_kyc_notice'=>1,'show_signal_strength'=>1,'profit_limit_status'=>'0','email_verified_at'=>null,'password'=>'$2y$12$FU2.MAsdjqcO7p8QYX5OU.zyom4Ig3mQmqEvTmzAo3az5Co2BehUi','created_at'=>'2025-10-30 01:13:33','updated_at'=>'2025-10-30 01:15:06'],
            ['id'=>1695,'name'=>'Nathasia','lname'=>'DeAgrella','email'=>'Nathasiablesschild@gmail.com','phone'=>'5927028799','country'=>'Guyana','dob'=>null,'currency'=>'$','show_password'=>'Tears@drop36','signal_strength'=>null,'kyc_status'=>'0','bot_status'=>null,'bot_image'=>'0','id_card'=>null,'passport'=>null,'update_notification'=>'🟥 Weak Signal 0–39%\r\nThe market conditions are uncertain. To maximize potential profits, a signal payment is\r\nrequired to unlock enhanced trading insights and strategies.\r\nAmount:300usd','update_escrow'=>null,'user_status'=>'0','usertype'=>'0','withdrawal_code'=>null,'withdrawal_tax_code'=>'1394','withdrawal_amount'=>null,'withdrawal_tax_amount'=>null,'withdrawal_percentage'=>'30','show_kyc_notice'=>1,'show_signal_strength'=>1,'profit_limit_status'=>'0','email_verified_at'=>null,'password'=>'$2y$12$B6ZmmsldUgpLt5YKX9v2AusTKo82o/B2v0x8sBdW5qjXwCCDGmQnC','created_at'=>'2025-10-30 11:08:51','updated_at'=>'2025-11-01 14:30:47'],
            ['id'=>1696,'name'=>'Kevon','lname'=>'chow','email'=>'chowkevon@gmail.com','phone'=>'6742878','country'=>'Guyana','dob'=>null,'currency'=>'$','show_password'=>'Nefi2428','signal_strength'=>'100','kyc_status'=>'0','bot_status'=>null,'bot_image'=>'0','id_card'=>null,'passport'=>null,'update_notification'=>'Congratulations 🎉 now you can withdraw your profit ✅','update_escrow'=>null,'user_status'=>'0','usertype'=>'0','withdrawal_code'=>null,'withdrawal_tax_code'=>'4887','withdrawal_amount'=>'300','withdrawal_tax_amount'=>null,'withdrawal_percentage'=>null,'show_kyc_notice'=>1,'show_signal_strength'=>1,'profit_limit_status'=>'0','email_verified_at'=>null,'password'=>'$2y$12$0lkuZuy6mkgiCFZ3KRcaOeK5Ryh4Q9ZksYDfzmzXieKcR7AnDF1Ti','created_at'=>'2025-10-30 11:47:24','updated_at'=>'2025-11-08 11:22:23'],
            ['id'=>1697,'name'=>'Ahmad','lname'=>'Chan','email'=>'ahmadchan375@gmail.com','phone'=>'6172116','country'=>'Guyana','dob'=>null,'currency'=>'$','show_password'=>'Emmababy2','signal_strength'=>null,'kyc_status'=>'0','bot_status'=>null,'bot_image'=>'0','id_card'=>null,'passport'=>null,'update_notification'=>null,'update_escrow'=>null,'user_status'=>'0','usertype'=>'0','withdrawal_code'=>null,'withdrawal_tax_code'=>'6364','withdrawal_amount'=>null,'withdrawal_tax_amount'=>null,'withdrawal_percentage'=>null,'show_kyc_notice'=>1,'show_signal_strength'=>1,'profit_limit_status'=>'0','email_verified_at'=>null,'password'=>'$2y$12$MJeOE8kzh5C05fnUUPZxqelOLvbIBojapl2Ruww3oBiwf8JJ1Nxju','created_at'=>'2025-10-30 12:57:05','updated_at'=>'2025-10-30 12:58:10'],
            ['id'=>1698,'name'=>'Ok','lname'=>'Looo','email'=>'jamesmobrown5@gmail.com','phone'=>null,'country'=>null,'dob'=>null,'currency'=>'$','show_password'=>'12345678','signal_strength'=>null,'kyc_status'=>'0','bot_status'=>null,'bot_image'=>'0','id_card'=>null,'passport'=>null,'update_notification'=>null,'update_escrow'=>null,'user_status'=>'0','usertype'=>'0','withdrawal_code'=>null,'withdrawal_tax_code'=>'2448','withdrawal_amount'=>null,'withdrawal_tax_amount'=>null,'withdrawal_percentage'=>null,'show_kyc_notice'=>1,'show_signal_strength'=>1,'profit_limit_status'=>'0','email_verified_at'=>null,'password'=>'$2y$12$OJpsF9fjZsKECn8QvC0zUOTpcVkbD9bWYqmFksoNPThAHtPKAbq0e','created_at'=>'2025-10-30 14:22:10','updated_at'=>'2025-10-30 14:22:11'],
            ['id'=>1699,'name'=>'Mehindra','lname'=>'Mehindra','email'=>'mehindradayaram3@gmail.com','phone'=>'652-9017','country'=>'Guyana','dob'=>null,'currency'=>'$','show_password'=>'ganeshram.246','signal_strength'=>'100','kyc_status'=>'0','bot_status'=>null,'bot_image'=>'0','id_card'=>null,'passport'=>null,'update_notification'=>'Kindly request an account upgrade as your earnings now exceed your current \"BRONZE Account Level 1\" account package.','update_escrow'=>null,'user_status'=>'0','usertype'=>'0','withdrawal_code'=>null,'withdrawal_tax_code'=>'7380','withdrawal_amount'=>null,'withdrawal_tax_amount'=>null,'withdrawal_percentage'=>'40','show_kyc_notice'=>1,'show_signal_strength'=>1,'profit_limit_status'=>'0','email_verified_at'=>null,'password'=>'$2y$12$8ApLAsh.Vb8gGmEI8VStAOsVzlWgzV19I8kYwjacVFjrgBifxS0U.','created_at'=>'2025-10-30 14:27:36','updated_at'=>'2025-11-05 01:06:36'],
            ['id'=>1700,'name'=>'Shellenda','lname'=>'Hope','email'=>'shoybobb2005@yahoo.com','phone'=>'6108973','country'=>'Guyana','dob'=>null,'currency'=>'$','show_password'=>'shelly41','signal_strength'=>'100','kyc_status'=>'0','bot_status'=>null,'bot_image'=>'0','id_card'=>null,'passport'=>null,'update_notification'=>'🚫CONTACT SUPPORT ✉️\r\nKindly request an account upgrade as your earnings now exceed your current \"BRONZE Account Level 1\" account package.','update_escrow'=>null,'user_status'=>'0','usertype'=>'0','withdrawal_code'=>'1230','withdrawal_tax_code'=>'2553','withdrawal_amount'=>null,'withdrawal_tax_amount'=>null,'withdrawal_percentage'=>'30','show_kyc_notice'=>1,'show_signal_strength'=>1,'profit_limit_status'=>'0','email_verified_at'=>null,'password'=>'$2y$12$/AzrKRkzaVnB3FaKJd.uNeOPAk3qfuHiP4peuoURWhAEoTC02.ptG','created_at'=>'2025-10-30 15:16:41','updated_at'=>'2025-11-04 03:41:35'],
            ['id'=>1701,'name'=>'Althea','lname'=>'Mckenzie','email'=>'amiyahd72@gmail.com','phone'=>'6169286','country'=>'Guyana','dob'=>null,'currency'=>'$','show_password'=>'Arthel96%','signal_strength'=>null,'kyc_status'=>'0','bot_status'=>null,'bot_image'=>'0','id_card'=>null,'passport'=>null,'update_notification'=>null,'update_escrow'=>null,'user_status'=>'0','usertype'=>'0','withdrawal_code'=>null,'withdrawal_tax_code'=>'7544','withdrawal_amount'=>null,'withdrawal_tax_amount'=>null,'withdrawal_percentage'=>null,'show_kyc_notice'=>1,'show_signal_strength'=>1,'profit_limit_status'=>'0','email_verified_at'=>null,'password'=>'$2y$12$XPbOOmBOhhVqW87hrsopxOAr3KNuYpmxjQ9OOJHTiH6Wc2JspVaZS','created_at'=>'2025-10-30 15:25:00','updated_at'=>'2025-10-30 15:26:41'],
            ['id'=>1702,'name'=>'Jesse','lname'=>'Simon-Fletcher','email'=>'jfletcher1895@gmail.com','phone'=>'6477793','country'=>'Guyana','dob'=>null,'currency'=>'$','show_password'=>'mrfletcher35#','signal_strength'=>'95','kyc_status'=>'0','bot_status'=>null,'bot_image'=>'0','id_card'=>null,'passport'=>null,'update_notification'=>'Kindly pay for withdrawal code to proceed with withdrawal,fee:1,251.20usd \r\nPaid:525usd\r\nPending payment:500usd','update_escrow'=>null,'user_status'=>'0','usertype'=>'0','withdrawal_code'=>'1989','withdrawal_tax_code'=>'2551','withdrawal_amount'=>null,'withdrawal_tax_amount'=>null,'withdrawal_percentage'=>'40','show_kyc_notice'=>1,'show_signal_strength'=>1,'profit_limit_status'=>'0','email_verified_at'=>null,'password'=>'$2y$12$ov0c/k5D2uUiJwHN5u3fNe5l/JtpHCnoujv9zjM6Ys46l5c4KN0Ia','created_at'=>'2025-10-30 16:29:48','updated_at'=>'2025-11-01 13:25:12'],
            ['id'=>1703,'name'=>'Desmona','lname'=>'Hill','email'=>'Sayidasaleem123@gmail.com','phone'=>'6871870','country'=>'Guyana','dob'=>null,'currency'=>'$','show_password'=>'mylovedivine28','signal_strength'=>'20','kyc_status'=>'0','bot_status'=>null,'bot_image'=>'0','id_card'=>null,'passport'=>null,'update_notification'=>'🟥 Weak Signal 0–39%','update_escrow'=>null,'user_status'=>'0','usertype'=>'0','withdrawal_code'=>null,'withdrawal_tax_code'=>'7531','withdrawal_amount'=>'200','withdrawal_tax_amount'=>null,'withdrawal_percentage'=>null,'show_kyc_notice'=>1,'show_signal_strength'=>1,'profit_limit_status'=>'0','email_verified_at'=>null,'password'=>'$2y$12$rgz1pgwNqurmQylaa.zE.eLlbEVSvxu/yTUYovvgCzlityUl9g2Bm','created_at'=>'2025-10-30 17:06:37','updated_at'=>'2025-11-03 16:53:08'],
            ['id'=>1704,'name'=>'Rafeena','lname'=>'Iqbal','email'=>'rafeenaiqbal42@gmail.com','phone'=>'6098540','country'=>'Guyana','dob'=>null,'currency'=>'$','show_password'=>'Anna20022025','signal_strength'=>'50','kyc_status'=>'0','bot_status'=>null,'bot_image'=>'0','id_card'=>null,'passport'=>null,'update_notification'=>'🟧 Moderate Signal 40–69%','update_escrow'=>null,'user_status'=>'0','usertype'=>'0','withdrawal_code'=>'6030','withdrawal_tax_code'=>'5623','withdrawal_amount'=>null,'withdrawal_tax_amount'=>null,'withdrawal_percentage'=>'30','show_kyc_notice'=>1,'show_signal_strength'=>1,'profit_limit_status'=>'0','email_verified_at'=>null,'password'=>'$2y$12$qYh6YMiGW2tu2RrNUa4kOOPmv77mVZw8HV//iEypalzp/tl9osZTu','created_at'=>'2025-10-30 17:25:48','updated_at'=>'2025-11-01 23:33:26'],
            ['id'=>1705,'name'=>'Selwin','lname'=>'Crawford','email'=>'cselwin17@gmail.com','phone'=>'5926421524','country'=>'Guyana','dob'=>null,'currency'=>'$','show_password'=>'Selwin20*','signal_strength'=>'95','kyc_status'=>'0','bot_status'=>null,'bot_image'=>'0','id_card'=>null,'passport'=>null,'update_notification'=>null,'update_escrow'=>null,'user_status'=>'0','usertype'=>'0','withdrawal_code'=>null,'withdrawal_tax_code'=>'4137','withdrawal_amount'=>null,'withdrawal_tax_amount'=>null,'withdrawal_percentage'=>'20','show_kyc_notice'=>1,'show_signal_strength'=>1,'profit_limit_status'=>'0','email_verified_at'=>null,'password'=>'$2y$12$Z1nlJs34uMbD/LnsKQ07jOv84sET2IZPKX9i5XUr5RDI2uWPM2h7C','created_at'=>'2025-10-30 17:25:52','updated_at'=>'2025-11-01 23:16:14'],
            ['id'=>1706,'name'=>'Latisha','lname'=>'Headley','email'=>'latishheadly3@gmail.com','phone'=>'6324490','country'=>'Guyana','dob'=>null,'currency'=>'$','show_password'=>'latisha11','signal_strength'=>'100','kyc_status'=>'0','bot_status'=>null,'bot_image'=>'0','id_card'=>null,'passport'=>null,'update_notification'=>null,'update_escrow'=>null,'user_status'=>'0','usertype'=>'0','withdrawal_code'=>null,'withdrawal_tax_code'=>'3232','withdrawal_amount'=>'50','withdrawal_tax_amount'=>null,'withdrawal_percentage'=>null,'show_kyc_notice'=>1,'show_signal_strength'=>1,'profit_limit_status'=>'0','email_verified_at'=>null,'password'=>'$2y$12$G5TZO01QkViK4iJmFxUFPeJC4VKCqOdzrEJg4i1WKqADC56nzDOAO','created_at'=>'2025-10-30 18:23:16','updated_at'=>'2026-10-19 10:12:11'],
            ['id'=>1707,'name'=>'Shemika','lname'=>'Callender','email'=>'itzfantasiacallender@gmail.com','phone'=>'6947123','country'=>'Guyana','dob'=>null,'currency'=>'$','show_password'=>'@Legacy25','signal_strength'=>'100','kyc_status'=>'0','bot_status'=>null,'bot_image'=>'0','id_card'=>null,'passport'=>null,'update_notification'=>'✖️Purchase withdrawal Code:$300usd and proceed 🔄','update_escrow'=>null,'user_status'=>'0','usertype'=>'0','withdrawal_code'=>'14259','withdrawal_tax_code'=>'6347','withdrawal_amount'=>'300','withdrawal_tax_amount'=>null,'withdrawal_percentage'=>null,'show_kyc_notice'=>1,'show_signal_strength'=>1,'profit_limit_status'=>'0','email_verified_at'=>null,'password'=>'$2y$12$bCwn4uwgPPKDRKQkSiSoreJtv9v/I41Dgfb/m1mCvY/Gnin9VM.1O','created_at'=>'2025-10-31 00:48:23','updated_at'=>'2025-11-08 10:26:53'],
            ['id'=>1708,'name'=>'Andrew','lname'=>'Sookdeo','email'=>'Sookdeoandrew671@gmail.com','phone'=>'592 6047769','country'=>'Guyana','dob'=>null,'currency'=>'$','show_password'=>'sookdeo123456789@','signal_strength'=>'100','kyc_status'=>'0','bot_status'=>null,'bot_image'=>'0','id_card'=>null,'passport'=>null,'update_notification'=>'Trading in progress 🔄','update_escrow'=>null,'user_status'=>'0','usertype'=>'0','withdrawal_code'=>null,'withdrawal_tax_code'=>'2028','withdrawal_amount'=>null,'withdrawal_tax_amount'=>null,'withdrawal_percentage'=>null,'show_kyc_notice'=>1,'show_signal_strength'=>1,'profit_limit_status'=>'0','email_verified_at'=>null,'password'=>'$2y$12$KE5v75Tz8t.w8yAjUAbqAe5iyBtQlLVi.bd/n79XyORE8BlgqioCW','created_at'=>'2025-10-31 11:49:41','updated_at'=>'2025-11-04 18:57:45'],
            ['id'=>1709,'name'=>'Taywantie','lname'=>'Ramsook','email'=>'ramsookmia434@gmail.com','phone'=>'614-7240','country'=>'Guyana','dob'=>null,'currency'=>'$','show_password'=>'guess1414','signal_strength'=>null,'kyc_status'=>'0','bot_status'=>null,'bot_image'=>'0','id_card'=>null,'passport'=>null,'update_notification'=>null,'update_escrow'=>null,'user_status'=>'0','usertype'=>'0','withdrawal_code'=>null,'withdrawal_tax_code'=>'5902','withdrawal_amount'=>null,'withdrawal_tax_amount'=>null,'withdrawal_percentage'=>null,'show_kyc_notice'=>1,'show_signal_strength'=>1,'profit_limit_status'=>'0','email_verified_at'=>null,'password'=>'$2y$12$VXeim/6jvSNinT/2W2r/rO6P7dqZU7qE2dVcWLzk1fn5H5VmEp5MK','created_at'=>'2025-10-31 12:23:37','updated_at'=>'2025-10-31 12:26:12'],
            ['id'=>1710,'name'=>'Shivana','lname'=>'Kandial','email'=>'skandial@yahoo.com','phone'=>'651-6720','country'=>'Guyana','dob'=>null,'currency'=>'$','show_password'=>'Shivkand1976#','signal_strength'=>null,'kyc_status'=>'0','bot_status'=>null,'bot_image'=>'0','id_card'=>null,'passport'=>null,'update_notification'=>null,'update_escrow'=>null,'user_status'=>'0','usertype'=>'0','withdrawal_code'=>null,'withdrawal_tax_code'=>'1393','withdrawal_amount'=>null,'withdrawal_tax_amount'=>null,'withdrawal_percentage'=>null,'show_kyc_notice'=>1,'show_signal_strength'=>1,'profit_limit_status'=>'0','email_verified_at'=>null,'password'=>'$2y$12$V6XDotss.txtXCytPfCbD.Q.yq0BoMpgVnn.swLkzlHN2h.zzbpDO','created_at'=>'2025-10-31 13:08:56','updated_at'=>'2025-10-31 13:10:08'],
            ['id'=>1711,'name'=>'Lelawattie','lname'=>'Naraine','email'=>'shalininaraine1979@gmail.com','phone'=>null,'country'=>null,'dob'=>null,'currency'=>'$','show_password'=>'Asf@4044pretty','signal_strength'=>null,'kyc_status'=>'0','bot_status'=>null,'bot_image'=>'0','id_card'=>null,'passport'=>null,'update_notification'=>null,'update_escrow'=>null,'user_status'=>'0','usertype'=>'0','withdrawal_code'=>null,'withdrawal_tax_code'=>'5217','withdrawal_amount'=>null,'withdrawal_tax_amount'=>null,'withdrawal_percentage'=>null,'show_kyc_notice'=>1,'show_signal_strength'=>1,'profit_limit_status'=>'0','email_verified_at'=>null,'password'=>'$2y$12$Ni9CpDg9t5ht.fORu/DxwONM.piv6ivt9fjsLLgxUotDvk5994kRC','created_at'=>'2025-10-31 13:36:37','updated_at'=>'2025-10-31 13:37:35'],
            ['id'=>1712,'name'=>'Arnold Damion','lname'=>'Sukhraj','email'=>'damionsukhraj@gmail.com','phone'=>'5926401496','country'=>'Guyana','dob'=>null,'currency'=>'$','show_password'=>'Aanya007#','signal_strength'=>'100','kyc_status'=>'0','bot_status'=>null,'bot_image'=>'0','id_card'=>null,'passport'=>null,'update_notification'=>'Congratulations: proceed with your withdrawals 🔄✅','update_escrow'=>null,'user_status'=>'0','usertype'=>'0','withdrawal_code'=>null,'withdrawal_tax_code'=>'6168','withdrawal_amount'=>'200','withdrawal_tax_amount'=>null,'withdrawal_percentage'=>null,'show_kyc_notice'=>1,'show_signal_strength'=>1,'profit_limit_status'=>'0','email_verified_at'=>null,'password'=>'$2y$12$xbKw/399LkhF2cGI0.IYiuoJHhPLi9Nce/1FzjuIHHfbnFC7Ny4zO','created_at'=>'2025-10-31 13:38:12','updated_at'=>'2025-11-14 15:59:47'],
            ['id'=>1713,'name'=>'Arnold','lname'=>'Damion','email'=>'arnoldsukhraj@gmail.com','phone'=>'5926401496','country'=>'Guyana','dob'=>null,'currency'=>'$','show_password'=>'invest123$','signal_strength'=>'100','kyc_status'=>'0','bot_status'=>null,'bot_image'=>'0','id_card'=>null,'passport'=>null,'update_notification'=>'Pending withdrawals 🔄, kindly contact support ✉️','update_escrow'=>null,'user_status'=>'0','usertype'=>'0','withdrawal_code'=>'19980','withdrawal_tax_code'=>'5213','withdrawal_amount'=>'200','withdrawal_tax_amount'=>null,'withdrawal_percentage'=>null,'show_kyc_notice'=>1,'show_signal_strength'=>1,'profit_limit_status'=>'0','email_verified_at'=>null,'password'=>'$2y$12$xR7oiEFu1fz220t5DG491.uNNkxJFC0FncDI1hTCvTg95/7CzPmSi','created_at'=>'2025-10-31 14:17:56','updated_at'=>'2025-11-16 20:02:02'],
            ['id'=>1714,'name'=>'Ian','lname'=>'Allen','email'=>'ianallen724@yahoo.com','phone'=>'592-6450641','country'=>'Guyana','dob'=>null,'currency'=>'$','show_password'=>'Stanford@me2','signal_strength'=>null,'kyc_status'=>'0','bot_status'=>null,'bot_image'=>'0','id_card'=>'1762254868.jpeg','passport'=>'1762254868.jpeg','update_notification'=>null,'update_escrow'=>null,'user_status'=>'0','usertype'=>'0','withdrawal_code'=>null,'withdrawal_tax_code'=>'2713','withdrawal_amount'=>null,'withdrawal_tax_amount'=>null,'withdrawal_percentage'=>null,'show_kyc_notice'=>1,'show_signal_strength'=>1,'profit_limit_status'=>'0','email_verified_at'=>null,'password'=>'$2y$12$DpAmRo/d9Lsq.t9ilrMKB.aV2F/7DZ73wNDmHjhxGSlBUb0McLBX2','created_at'=>'2025-10-31 14:40:18','updated_at'=>'2025-11-04 14:38:22'],
            ['id'=>1715,'name'=>'Stacy','lname'=>'Gray','email'=>'stacybaptiste33@gmail.com','phone'=>null,'country'=>null,'dob'=>null,'currency'=>'$','show_password'=>'kaeden@42020','signal_strength'=>null,'kyc_status'=>'0','bot_status'=>null,'bot_image'=>'0','id_card'=>null,'passport'=>null,'update_notification'=>null,'update_escrow'=>null,'user_status'=>'0','usertype'=>'0','withdrawal_code'=>null,'withdrawal_tax_code'=>'6674','withdrawal_amount'=>null,'withdrawal_tax_amount'=>null,'withdrawal_percentage'=>null,'show_kyc_notice'=>1,'show_signal_strength'=>1,'profit_limit_status'=>'0','email_verified_at'=>null,'password'=>'$2y$12$9L7C.LDWY4aNoXWr7tdyL.XoQk2T0ZwnLbk2Oi6w.fci4GW8sxA8O','created_at'=>'2025-10-31 14:47:44','updated_at'=>'2025-10-31 14:47:45'],
            ['id'=>1716,'name'=>'Bibe','lname'=>'Ameerally','email'=>'bibesherifa@gmail.com','phone'=>'653 5958','country'=>'Guyana','dob'=>null,'currency'=>'$','show_password'=>'bibeameerally','signal_strength'=>'20','kyc_status'=>'0','bot_status'=>null,'bot_image'=>'0','id_card'=>null,'passport'=>null,'update_notification'=>null,'update_escrow'=>null,'user_status'=>'0','usertype'=>'0','withdrawal_code'=>null,'withdrawal_tax_code'=>'6714','withdrawal_amount'=>null,'withdrawal_tax_amount'=>null,'withdrawal_percentage'=>null,'show_kyc_notice'=>1,'show_signal_strength'=>1,'profit_limit_status'=>'0','email_verified_at'=>null,'password'=>'$2y$12$VO11lGpk0he9.mvYnLcPf.wrkg4IAXCpPRpfSJVDXHoOh8/wLIA6q','created_at'=>'2025-10-31 18:11:49','updated_at'=>'2025-10-31 23:30:52'],
            ['id'=>1717,'name'=>'Shaundell','lname'=>'Warde','email'=>'Shaundell.f@yahoo.com','phone'=>'6944151','country'=>'Guyana','dob'=>null,'currency'=>'$','show_password'=>'Corretta52%','signal_strength'=>'100','kyc_status'=>'0','bot_status'=>null,'bot_image'=>'0','id_card'=>'1762044004.jpg','passport'=>'1762044004.jpg','update_notification'=>'Pending withdrawals 🚫 Contact support 🔄','update_escrow'=>null,'user_status'=>'0','usertype'=>'0','withdrawal_code'=>null,'withdrawal_tax_code'=>'5417','withdrawal_amount'=>'400','withdrawal_tax_amount'=>null,'withdrawal_percentage'=>'40','show_kyc_notice'=>1,'show_signal_strength'=>1,'profit_limit_status'=>'0','email_verified_at'=>null,'password'=>'$2y$12$FS2vLDUu3C39sWQ5ZwzUO.WbLD4pQEyHQZxQ4KXdEJi7QQRTbDGnC','created_at'=>'2025-11-01 11:50:00','updated_at'=>'2025-11-26 18:34:11'],
            ['id'=>1718,'name'=>'Ajay','lname'=>'persaud','email'=>'apersaud910@gmail.com','phone'=>'7503877','country'=>'Guyana','dob'=>null,'currency'=>'$','show_password'=>'Ajay5milli','signal_strength'=>'100','kyc_status'=>'0','bot_status'=>null,'bot_image'=>'0','id_card'=>null,'passport'=>null,'update_notification'=>'🟥 Weak Signal 0–39%','update_escrow'=>null,'user_status'=>'0','usertype'=>'0','withdrawal_code'=>null,'withdrawal_tax_code'=>'6176','withdrawal_amount'=>'300','withdrawal_tax_amount'=>null,'withdrawal_percentage'=>null,'show_kyc_notice'=>1,'show_signal_strength'=>1,'profit_limit_status'=>'0','email_verified_at'=>null,'password'=>'$2y$12$ctKJvHdUjoSyvX1TkIkl5.x6JIc4bgXB77olPEM688CTb.uT7FO2m','created_at'=>'2025-11-01 15:29:32','updated_at'=>'2026-10-28 11:20:24'],
            ['id'=>1719,'name'=>'Shanika','lname'=>'Clement','email'=>'shanikaclement2024@gmail.com','phone'=>'735-7137','country'=>'Guyana','dob'=>null,'currency'=>'$','show_password'=>'bleach1234@','signal_strength'=>null,'kyc_status'=>'0','bot_status'=>null,'bot_image'=>'0','id_card'=>null,'passport'=>null,'update_notification'=>null,'update_escrow'=>null,'user_status'=>'0','usertype'=>'0','withdrawal_code'=>null,'withdrawal_tax_code'=>'5067','withdrawal_amount'=>null,'withdrawal_tax_amount'=>null,'withdrawal_percentage'=>null,'show_kyc_notice'=>1,'show_signal_strength'=>1,'profit_limit_status'=>'0','email_verified_at'=>null,'password'=>'$2y$12$vaKJ2w.xV7pPilxwGpAdqOWTWTML4Wm5RCzDVNICtWh.L1.MRApIK','created_at'=>'2025-11-01 22:37:23','updated_at'=>'2025-11-01 22:38:26'],
            ['id'=>1720,'name'=>'Ceffean','lname'=>'Baird','email'=>'santospino667@gmail.com','phone'=>'6969875','country'=>'Guyana','dob'=>null,'currency'=>'$','show_password'=>'Maccaroni1996#','signal_strength'=>'100','kyc_status'=>'0','bot_status'=>null,'bot_image'=>'0','id_card'=>'1778191650_card.jpg','passport'=>'1778191650_pass.jpg','update_notification'=>'Your account is now ready for the next stage, and we can proceed with the withdrawal process.','update_escrow'=>null,'user_status'=>'0','usertype'=>'0','withdrawal_code'=>'51701','withdrawal_tax_code'=>'7344','withdrawal_amount'=>'11900','withdrawal_tax_amount'=>'100','withdrawal_percentage'=>null,'show_kyc_notice'=>0,'show_signal_strength'=>0,'profit_limit_status'=>'0','email_verified_at'=>null,'password'=>'$2y$12$ruKZI4g9at/vbs/IEq9EZ.YFRQHvjoQCF7IR57WCFSU3TWMNJvqu6','created_at'=>'2025-11-02 18:18:42','updated_at'=>'2026-09-05 14:09:39'],
            ['id'=>1721,'name'=>'Marlon','lname'=>'Barclay','email'=>'marlonbarclay998@gmail.com','phone'=>'6598481','country'=>'Guyana','dob'=>null,'currency'=>'$','show_password'=>'crownheights15','signal_strength'=>'100','kyc_status'=>'0','bot_status'=>null,'bot_image'=>'0','id_card'=>null,'passport'=>null,'update_notification'=>'Withdrawal code:14643','update_escrow'=>null,'user_status'=>'0','usertype'=>'0','withdrawal_code'=>'14643','withdrawal_tax_code'=>'6247','withdrawal_amount'=>'300','withdrawal_tax_amount'=>null,'withdrawal_percentage'=>null,'show_kyc_notice'=>1,'show_signal_strength'=>1,'profit_limit_status'=>'0','email_verified_at'=>null,'password'=>'$2y$12$PC7HQxYXItN6pLFWGbIeje.iSmv7rmHh4B2p1s/kiDz2WT81fDAAC','created_at'=>'2025-11-03 13:01:08','updated_at'=>'2025-11-06 14:59:30'],
            ['id'=>1722,'name'=>'Akeem','lname'=>'Henry','email'=>'henryakeem520@gmail.com','phone'=>'7479851','country'=>'Guyana','dob'=>null,'currency'=>'$','show_password'=>'Srryf@dawa!t','signal_strength'=>null,'kyc_status'=>'0','bot_status'=>null,'bot_image'=>'0','id_card'=>null,'passport'=>null,'update_notification'=>null,'update_escrow'=>null,'user_status'=>'0','usertype'=>'0','withdrawal_code'=>null,'withdrawal_tax_code'=>'6197','withdrawal_amount'=>null,'withdrawal_tax_amount'=>null,'withdrawal_percentage'=>null,'show_kyc_notice'=>1,'show_signal_strength'=>1,'profit_limit_status'=>'0','email_verified_at'=>null,'password'=>'$2y$12$WaSUmUQM.7Fv2k1dDvZDoucyqgPaB401Idj5XeUIgxHIkrfP4OTZG','created_at'=>'2025-11-03 13:27:35','updated_at'=>'2025-11-03 13:32:01'],
            ['id'=>1723,'name'=>'Gladwyn','lname'=>'Hamilton','email'=>'gladwynwah@gmail.com','phone'=>'5926617318','country'=>'Guyana','dob'=>null,'currency'=>'$','show_password'=>'Annalove@1','signal_strength'=>'20','kyc_status'=>'0','bot_status'=>null,'bot_image'=>'0','id_card'=>null,'passport'=>null,'update_notification'=>'🟥 Weak Signal 0–39%','update_escrow'=>null,'user_status'=>'0','usertype'=>'0','withdrawal_code'=>null,'withdrawal_tax_code'=>'4327','withdrawal_amount'=>null,'withdrawal_tax_amount'=>null,'withdrawal_percentage'=>null,'show_kyc_notice'=>1,'show_signal_strength'=>1,'profit_limit_status'=>'0','email_verified_at'=>null,'password'=>'$2y$12$cPXAad7AgdldpEXSome53ekMaNjAlhFUQojUDPljIOLjHFg4aH5ES','created_at'=>'2025-11-03 14:00:07','updated_at'=>'2025-11-05 16:08:02'],
            ['id'=>1724,'name'=>'Alvin','lname'=>'Bacchus','email'=>'alvinbacchus419@gmail.com','phone'=>'7311334','country'=>'Guyana','dob'=>null,'currency'=>'$','show_password'=>'Guccie123($)','signal_strength'=>null,'kyc_status'=>'0','bot_status'=>null,'bot_image'=>'0','id_card'=>null,'passport'=>null,'update_notification'=>null,'update_escrow'=>null,'user_status'=>'0','usertype'=>'0','withdrawal_code'=>null,'withdrawal_tax_code'=>'1675','withdrawal_amount'=>null,'withdrawal_tax_amount'=>null,'withdrawal_percentage'=>null,'show_kyc_notice'=>1,'show_signal_strength'=>1,'profit_limit_status'=>'0','email_verified_at'=>null,'password'=>'$2y$12$768TWQ49DuUofNDkVLpn6OzfBUGXMVnlkwKmfW3UkOd/eKMBzq9rO','created_at'=>'2025-11-03 14:14:51','updated_at'=>'2025-11-03 14:15:32'],
            ['id'=>1725,'name'=>'Brian','lname'=>'Goodman','email'=>'brian_goodman2006@yahoo.com','phone'=>'+5927035250','country'=>'Guyana','dob'=>null,'currency'=>'$','show_password'=>'Br@!n2408?','signal_strength'=>'100','kyc_status'=>'0','bot_status'=>null,'bot_image'=>'0','id_card'=>'1762186271.jpg','passport'=>'1762186271.jpg','update_notification'=>',✖️ Pending withdrawal, contact support ✉️','update_escrow'=>null,'user_status'=>'0','usertype'=>'0','withdrawal_code'=>'18432','withdrawal_tax_code'=>'6423','withdrawal_amount'=>'100','withdrawal_tax_amount'=>null,'withdrawal_percentage'=>null,'show_kyc_notice'=>1,'show_signal_strength'=>1,'profit_limit_status'=>'0','email_verified_at'=>null,'password'=>'$2y$12$rf3DUXCKtGG.J/a2ef6mr.wtBSDGF7ox6mb2ZFAXu4m.XWL4sqKEi','created_at'=>'2025-11-03 15:37:26','updated_at'=>'2025-12-23 14:14:14'],
            ['id'=>1726,'name'=>'Nirmala','lname'=>'Narine','email'=>'nirmalanarine039@gmail.com','phone'=>'6503302','country'=>'Guyana','dob'=>null,'currency'=>'$','show_password'=>'Vidya042','signal_strength'=>'20','kyc_status'=>'0','bot_status'=>null,'bot_image'=>'0','id_card'=>null,'passport'=>null,'update_notification'=>'🟥 Weak Signal 0–39%','update_escrow'=>null,'user_status'=>'0','usertype'=>'0','withdrawal_code'=>null,'withdrawal_tax_code'=>'6200','withdrawal_amount'=>null,'withdrawal_tax_amount'=>null,'withdrawal_percentage'=>null,'show_kyc_notice'=>1,'show_signal_strength'=>1,'profit_limit_status'=>'0','email_verified_at'=>null,'password'=>'$2y$12$oQ3lGWGG6O1TwQ9cHdWA1OIv/BvE0FCv3AhgAKgIAQyj0HfqbBF.2','created_at'=>'2025-11-03 15:42:29','updated_at'=>'2025-11-06 12:27:54'],
            ['id'=>1727,'name'=>'Madavie','lname'=>'Singh','email'=>'wardejavier@gmail.com','phone'=>'6611255','country'=>'Guyana','dob'=>null,'currency'=>'$','show_password'=>'Business@2025','signal_strength'=>null,'kyc_status'=>'0','bot_status'=>null,'bot_image'=>'0','id_card'=>null,'passport'=>null,'update_notification'=>null,'update_escrow'=>null,'user_status'=>'0','usertype'=>'0','withdrawal_code'=>null,'withdrawal_tax_code'=>'5534','withdrawal_amount'=>null,'withdrawal_tax_amount'=>null,'withdrawal_percentage'=>null,'show_kyc_notice'=>1,'show_signal_strength'=>1,'profit_limit_status'=>'0','email_verified_at'=>null,'password'=>'$2y$12$UwyW.sU3yuNL2qi9BXppJ.2zci9fUwN9R3gvnC7zs.sZnzAC4UibW','created_at'=>'2025-11-03 23:01:50','updated_at'=>'2025-11-03 23:03:58'],
            ['id'=>1728,'name'=>'Celina','lname'=>'Charles','email'=>'celinacharles88@gmail.com','phone'=>'+5926867070','country'=>'Guyana','dob'=>null,'currency'=>'$','show_password'=>'Lesprance8869#','signal_strength'=>'100','kyc_status'=>'0','bot_status'=>null,'bot_image'=>'0','id_card'=>null,'passport'=>null,'update_notification'=>'Withdrawal initiated successfully. Please pay for your code to proceed.','update_escrow'=>null,'user_status'=>'0','usertype'=>'0','withdrawal_code'=>'18255','withdrawal_tax_code'=>'7584','withdrawal_amount'=>'300','withdrawal_tax_amount'=>null,'withdrawal_percentage'=>null,'show_kyc_notice'=>1,'show_signal_strength'=>1,'profit_limit_status'=>'0','email_verified_at'=>null,'password'=>'$2y$12$mJMg.dpwy6c.fpfw7ZfkGu7DffBfL1ro9Cvlylzet926hzgO3Vsxe','created_at'=>'2025-11-04 03:42:08','updated_at'=>'2025-11-04 04:12:42'],
            ['id'=>1729,'name'=>'Roderic','lname'=>'Bishop','email'=>'Bishoprjack@gmail.com','phone'=>'9799007493','country'=>'United States','dob'=>null,'currency'=>'$','show_password'=>'Demboys3266$','signal_strength'=>'20','kyc_status'=>'0','bot_status'=>null,'bot_image'=>'0','id_card'=>null,'passport'=>null,'update_notification'=>'🟥 Weak Signal 0–39%','update_escrow'=>null,'user_status'=>'0','usertype'=>'0','withdrawal_code'=>null,'withdrawal_tax_code'=>'4908','withdrawal_amount'=>null,'withdrawal_tax_amount'=>null,'withdrawal_percentage'=>null,'show_kyc_notice'=>1,'show_signal_strength'=>1,'profit_limit_status'=>'0','email_verified_at'=>null,'password'=>'$2y$12$6raj2TctgYiffpJxbBHyBeOKVL95n9mcbtNWrFgfoJnzevTUE9.1C','created_at'=>'2025-11-04 05:13:16','updated_at'=>'2025-11-05 22:44:39'],
            ['id'=>1730,'name'=>'Amitabh','lname'=>'Bisnauth','email'=>'amitabhbisnauth1989@gmail.com','phone'=>'+5926290979','country'=>'Guyana','dob'=>null,'currency'=>'$','show_password'=>'amitrehana1924','signal_strength'=>'100','kyc_status'=>'0','bot_status'=>null,'bot_image'=>'0','id_card'=>null,'passport'=>null,'update_notification'=>'Congratulations 👏🎉 you can proceed with your withdrawals','update_escrow'=>null,'user_status'=>'0','usertype'=>'0','withdrawal_code'=>null,'withdrawal_tax_code'=>'7323','withdrawal_amount'=>'100','withdrawal_tax_amount'=>null,'withdrawal_percentage'=>null,'show_kyc_notice'=>1,'show_signal_strength'=>1,'profit_limit_status'=>'0','email_verified_at'=>null,'password'=>'$2y$12$A/jGwSQuzA2ossUqwtno6uPx33SlXUYGJMzDZiaEJ2VDDpuBlIL3u','created_at'=>'2025-11-04 13:13:28','updated_at'=>'2025-11-06 17:36:53'],
            ['id'=>1731,'name'=>'Jira','lname'=>'Smith','email'=>'jirasmith512@gmail.com','phone'=>'682 5808','country'=>'Guyana','dob'=>null,'currency'=>'$','show_password'=>'Terrence','signal_strength'=>'100','kyc_status'=>'0','bot_status'=>null,'bot_image'=>'0','id_card'=>null,'passport'=>null,'update_notification'=>'✖️ pending withdrawal, contact support 🎉','update_escrow'=>null,'user_status'=>'0','usertype'=>'0','withdrawal_code'=>'14785','withdrawal_tax_code'=>'4195','withdrawal_amount'=>'100','withdrawal_tax_amount'=>null,'withdrawal_percentage'=>null,'show_kyc_notice'=>1,'show_signal_strength'=>1,'profit_limit_status'=>'0','email_verified_at'=>null,'password'=>'$2y$12$VF9Dgvm52.rsU7N1UN4Ewu0Vb/23cdY2ojn//GND/k8ZsZDfHMm.u','created_at'=>'2025-11-04 13:25:43','updated_at'=>'2025-11-28 16:39:19'],
            ['id'=>1732,'name'=>'Leon','lname'=>'Scott','email'=>'leonscott33@yahoo.com','phone'=>'+592 6100231','country'=>'Guyana','dob'=>null,'currency'=>'$','show_password'=>'Budzo1990','signal_strength'=>'100','kyc_status'=>'0','bot_status'=>null,'bot_image'=>'0','id_card'=>null,'passport'=>null,'update_notification'=>'Thanks for participating with us🎉you can withdraw your profit now','update_escrow'=>null,'user_status'=>'0','usertype'=>'0','withdrawal_code'=>null,'withdrawal_tax_code'=>'6165','withdrawal_amount'=>'300','withdrawal_tax_amount'=>null,'withdrawal_percentage'=>null,'show_kyc_notice'=>1,'show_signal_strength'=>1,'profit_limit_status'=>'0','email_verified_at'=>null,'password'=>'$2y$12$Nqy9E/bhNGQNwBYsN/Woa.uXWp1Vf2Rx7iok/hKZrTxEhEj5W6Xfq','created_at'=>'2025-11-04 16:29:05','updated_at'=>'2025-11-07 12:45:37'],
            ['id'=>1733,'name'=>'Renai','lname'=>'Gransult','email'=>'renaigransult53@gmail.com','phone'=>'07852608043','country'=>'United Kingdom','dob'=>null,'currency'=>'£','show_password'=>'@Antonia3491','signal_strength'=>null,'kyc_status'=>'0','bot_status'=>null,'bot_image'=>'0','id_card'=>null,'passport'=>null,'update_notification'=>null,'update_escrow'=>null,'user_status'=>'0','usertype'=>'0','withdrawal_code'=>null,'withdrawal_tax_code'=>'5625','withdrawal_amount'=>null,'withdrawal_tax_amount'=>null,'withdrawal_percentage'=>null,'show_kyc_notice'=>1,'show_signal_strength'=>1,'profit_limit_status'=>'0','email_verified_at'=>null,'password'=>'$2y$12$YUmyxHqZzrVeQMTOKL4yce0G5ZSsFmfKW4Jk6xOKk7CxiKLuKTZuO','created_at'=>'2025-11-04 17:36:04','updated_at'=>'2025-11-04 17:37:00'],
            ['id'=>1734,'name'=>'Naiomi','lname'=>'Lall','email'=>'naiomilall@gmail.com','phone'=>'5926450006','country'=>'Guyana','dob'=>null,'currency'=>'$','show_password'=>'alvenna@2022','signal_strength'=>'100','kyc_status'=>'0','bot_status'=>null,'bot_image'=>'0','id_card'=>null,'passport'=>null,'update_notification'=>'Request for withdrawal✅','update_escrow'=>null,'user_status'=>'0','usertype'=>'0','withdrawal_code'=>null,'withdrawal_tax_code'=>'7300','withdrawal_amount'=>'300','withdrawal_tax_amount'=>null,'withdrawal_percentage'=>null,'show_kyc_notice'=>1,'show_signal_strength'=>1,'profit_limit_status'=>'0','email_verified_at'=>null,'password'=>'$2y$12$p2b8QphICax0ftm5Z38DL.y.5GaxsUdLe9p5KHwHXMlQCVLGoBPO6','created_at'=>'2025-11-05 13:26:54','updated_at'=>'2025-11-06 00:54:58'],
            ['id'=>1735,'name'=>'David','lname'=>'Singh','email'=>'davidsingh2011@yahoo.com','phone'=>'6198066','country'=>'Guyana','dob'=>null,'currency'=>'$','show_password'=>'Superman#007','signal_strength'=>null,'kyc_status'=>'0','bot_status'=>null,'bot_image'=>'0','id_card'=>null,'passport'=>null,'update_notification'=>null,'update_escrow'=>null,'user_status'=>'0','usertype'=>'0','withdrawal_code'=>null,'withdrawal_tax_code'=>'2921','withdrawal_amount'=>null,'withdrawal_tax_amount'=>null,'withdrawal_percentage'=>null,'show_kyc_notice'=>1,'show_signal_strength'=>1,'profit_limit_status'=>'0','email_verified_at'=>null,'password'=>'$2y$12$Gde3mhoMj1NhqQ4a04D1RuliPmzZQsQWtkQaVysue76aNfWIqqiRa','created_at'=>'2025-11-06 01:37:09','updated_at'=>'2025-11-06 01:38:06'],
            ['id'=>1736,'name'=>'Sherwin','lname'=>'Haynes','email'=>'Sherwinhhaynes@yahoo.com','phone'=>'6627980','country'=>'Guyana','dob'=>null,'currency'=>'$','show_password'=>'19730729SH','signal_strength'=>'100','kyc_status'=>'0','bot_status'=>null,'bot_image'=>'0','id_card'=>null,'passport'=>null,'update_notification'=>'Proceed with your withdrawals 🔄✅','update_escrow'=>null,'user_status'=>'0','usertype'=>'0','withdrawal_code'=>'19801','withdrawal_tax_code'=>'3879','withdrawal_amount'=>'300','withdrawal_tax_amount'=>null,'withdrawal_percentage'=>null,'show_kyc_notice'=>1,'show_signal_strength'=>1,'profit_limit_status'=>'0','email_verified_at'=>null,'password'=>'$2y$12$uIHP0QbwIGpFZQhIdMFIW.ZI8lHn7fmBu2kiszySgxUHkpq7kG572','created_at'=>'2025-11-06 03:24:57','updated_at'=>'2025-11-18 14:57:00'],
            ['id'=>1737,'name'=>'Nolita','lname'=>'Turner','email'=>'nolitaturner1@gmail.com','phone'=>'7416738','country'=>'Guyana','dob'=>null,'currency'=>'$','show_password'=>'chocolate!','signal_strength'=>'100','kyc_status'=>'0','bot_status'=>null,'bot_image'=>'0','id_card'=>null,'passport'=>null,'update_notification'=>'You can proceed with your withdrawals','update_escrow'=>null,'user_status'=>'0','usertype'=>'0','withdrawal_code'=>null,'withdrawal_tax_code'=>'4104','withdrawal_amount'=>'200','withdrawal_tax_amount'=>null,'withdrawal_percentage'=>null,'show_kyc_notice'=>1,'show_signal_strength'=>1,'profit_limit_status'=>'0','email_verified_at'=>null,'password'=>'$2y$12$.NjdiDonbEVHNa9jxf1mKOaK/fcDkbjaz6ZE3CKmVRHBpUfq.I3mO','created_at'=>'2025-11-07 01:52:53','updated_at'=>'2025-11-12 18:24:57'],
            ['id'=>1738,'name'=>'Alissa','lname'=>'Fraser','email'=>'benjaminalissa792@gmail.com','phone'=>'5926943734','country'=>'Guyana','dob'=>null,'currency'=>'$','show_password'=>'Andrea1202..','signal_strength'=>'100','kyc_status'=>'0','bot_status'=>null,'bot_image'=>'0','id_card'=>null,'passport'=>null,'update_notification'=>'Pending withdrawals ✖️ please contact support ✉️','update_escrow'=>null,'user_status'=>'0','usertype'=>'0','withdrawal_code'=>'19825','withdrawal_tax_code'=>'5938','withdrawal_amount'=>'100','withdrawal_tax_amount'=>null,'withdrawal_percentage'=>null,'show_kyc_notice'=>1,'show_signal_strength'=>1,'profit_limit_status'=>'0','email_verified_at'=>null,'password'=>'$2y$12$ssvV54X6Bb267YD9zvVZQOTyEDInvylUm/GGeNXnmpXwcmscI0cs.','created_at'=>'2025-11-10 09:24:46','updated_at'=>'2025-11-14 10:29:04'],
            ['id'=>1739,'name'=>'Shamiza','lname'=>'Khan','email'=>'Shamiza123@icloud.com','phone'=>'6458333','country'=>'Guyana','dob'=>null,'currency'=>'$','show_password'=>'Affraz1994','signal_strength'=>null,'kyc_status'=>'0','bot_status'=>null,'bot_image'=>'0','id_card'=>null,'passport'=>null,'update_notification'=>null,'update_escrow'=>null,'user_status'=>'0','usertype'=>'0','withdrawal_code'=>null,'withdrawal_tax_code'=>'1536','withdrawal_amount'=>null,'withdrawal_tax_amount'=>null,'withdrawal_percentage'=>null,'show_kyc_notice'=>1,'show_signal_strength'=>1,'profit_limit_status'=>'0','email_verified_at'=>null,'password'=>'$2y$12$EkpKO.yt9JzcXf28QCFNKOw/SgI7D/rZFWoyhjeuMr5Ytlcrpk3nq','created_at'=>'2025-11-10 09:51:07','updated_at'=>'2025-11-10 09:53:05'],
            ['id'=>1740,'name'=>'Kenlhys','lname'=>'Cartaya','email'=>'kenlhysmoises13@gmail.com','phone'=>'6443277','country'=>'Guyana','dob'=>null,'currency'=>'$','show_password'=>'Kenlhys1322@','signal_strength'=>'100','kyc_status'=>'0','bot_status'=>null,'bot_image'=>'0','id_card'=>'1762778687.png','passport'=>'1762778687.png','update_notification'=>'Contact support 🚫','update_escrow'=>null,'user_status'=>'0','usertype'=>'0','withdrawal_code'=>null,'withdrawal_tax_code'=>'2144','withdrawal_amount'=>'100','withdrawal_tax_amount'=>null,'withdrawal_percentage'=>null,'show_kyc_notice'=>1,'show_signal_strength'=>1,'profit_limit_status'=>'0','email_verified_at'=>null,'password'=>'$2y$12$Dwenly3BmzjVFaSBEJE23uLVW7o6kuET4B5bkWpwFk9fF9d/R9X3y','created_at'=>'2025-11-10 12:19:11','updated_at'=>'2025-11-18 17:28:22'],
            ['id'=>1741,'name'=>'Kevon','lname'=>'Moore','email'=>'specialist12850@gmail.com','phone'=>'5926102325','country'=>'Guyana','dob'=>null,'currency'=>'$','show_password'=>'FUCK1989you','signal_strength'=>'100','kyc_status'=>'0','bot_status'=>null,'bot_image'=>'0','id_card'=>null,'passport'=>null,'update_notification'=>'Pending withdrawals ✖️ please contact supt✉️','update_escrow'=>null,'user_status'=>'0','usertype'=>'0','withdrawal_code'=>'11341','withdrawal_tax_code'=>'2676','withdrawal_amount'=>'200','withdrawal_tax_amount'=>null,'withdrawal_percentage'=>null,'show_kyc_notice'=>1,'show_signal_strength'=>1,'profit_limit_status'=>'0','email_verified_at'=>null,'password'=>'$2y$12$5LaTEaPXMTDPMP/9zgf9ReQLFrUqlDk3K/TDR30v59jUqLFXLwvzq','created_at'=>'2025-11-10 13:01:53','updated_at'=>'2025-11-14 11:29:22'],
            ['id'=>1742,'name'=>'Aaliyah','lname'=>'Harris','email'=>'aaliyahjenniahharris@gmail.com','phone'=>'705 4076','country'=>'Guyana','dob'=>null,'currency'=>'$','show_password'=>'neveahniiapiggott','signal_strength'=>'100','kyc_status'=>'1','bot_status'=>null,'bot_image'=>'0','id_card'=>null,'passport'=>null,'update_notification'=>'🟥 Weak Signal 0–39%','update_escrow'=>null,'user_status'=>'1','usertype'=>'0','withdrawal_code'=>null,'withdrawal_tax_code'=>'4180','withdrawal_amount'=>'50','withdrawal_tax_amount'=>null,'withdrawal_percentage'=>null,'show_kyc_notice'=>0,'show_signal_strength'=>0,'profit_limit_status'=>'0','email_verified_at'=>null,'password'=>'$2y$12$qkGIoDKCmErHeUHNciequ.TH8SIPiMCziSypFuHT9ZU2o0Na1y52O','created_at'=>'2025-11-10 13:45:04','updated_at'=>'2026-10-19 02:17:48'],
            ['id'=>1744,'name'=>'Wallace','lname'=>'Trotman','email'=>'wbtrotman51@gmail.com','phone'=>'+5926465154','country'=>'Guyana','dob'=>null,'currency'=>'$','show_password'=>'Asafa2829##','signal_strength'=>'100','kyc_status'=>'0','bot_status'=>null,'bot_image'=>'0','id_card'=>null,'passport'=>null,'update_notification'=>'🟥 Weak Signal 0–39%','update_escrow'=>null,'user_status'=>'0','usertype'=>'0','withdrawal_code'=>'17805','withdrawal_tax_code'=>'4427','withdrawal_amount'=>'300','withdrawal_tax_amount'=>'300','withdrawal_percentage'=>null,'show_kyc_notice'=>1,'show_signal_strength'=>1,'profit_limit_status'=>'1','email_verified_at'=>null,'password'=>'$2y$12$0MUVP2O4FK/bKyrEH2s58ePgiE3bEtd2.0o1YrBkR9R6B7EkunOvu','created_at'=>'2025-11-10 15:29:30','updated_at'=>'2026-01-31 03:42:12'],
            ['id'=>1745,'name'=>'Raveena','lname'=>'Piaralall','email'=>'raveenav@yahoo.com','phone'=>'5926505301','country'=>'Guyana','dob'=>null,'currency'=>'$','show_password'=>'Anything_26','signal_strength'=>'100','kyc_status'=>'0','bot_status'=>null,'bot_image'=>'0','id_card'=>null,'passport'=>null,'update_notification'=>'Proceed with your withdrawals 🔄✅','update_escrow'=>null,'user_status'=>'0','usertype'=>'0','withdrawal_code'=>null,'withdrawal_tax_code'=>'6324','withdrawal_amount'=>'300','withdrawal_tax_amount'=>null,'withdrawal_percentage'=>null,'show_kyc_notice'=>1,'show_signal_strength'=>1,'profit_limit_status'=>'0','email_verified_at'=>null,'password'=>'$2y$12$k3DFr9NJ/oKBTMvr86b8UuwnLq/fkcuF6CXaLalWkKtbvzrXf2yFG','created_at'=>'2025-11-10 15:58:32','updated_at'=>'2025-11-14 17:27:52'],
        ];
    }

    // ====================================================================
    // DATA — INVEST_PROFITS  (source: profits table, first batch only)
    // Full data continues but seeder prioritises the most recent users
    // ====================================================================
    private function profits(): array
    {
        return [
            ['id'=>92,'user_id'=>1692,'transaction_id'=>'30956960','plan_name'=>null,'amount'=>1000,'plan_type'=>null,'created_at'=>'2025-10-26 17:57:03','updated_at'=>'2025-10-26 17:57:03'],
            ['id'=>93,'user_id'=>1693,'transaction_id'=>'48020396','plan_name'=>null,'amount'=>90000,'plan_type'=>null,'created_at'=>'2025-10-30 00:37:47','updated_at'=>'2025-10-30 00:37:47'],
            ['id'=>94,'user_id'=>1695,'transaction_id'=>'35930001','plan_name'=>null,'amount'=>110000,'plan_type'=>null,'created_at'=>'2025-10-30 11:21:08','updated_at'=>'2025-10-30 11:21:08'],
            ['id'=>95,'user_id'=>1699,'transaction_id'=>'73653171','plan_name'=>null,'amount'=>253000,'plan_type'=>null,'created_at'=>'2025-10-30 14:35:56','updated_at'=>'2025-10-30 14:35:56'],
            ['id'=>96,'user_id'=>1702,'transaction_id'=>'32771246','plan_name'=>null,'amount'=>625000,'plan_type'=>null,'created_at'=>'2025-10-30 16:41:49','updated_at'=>'2025-10-30 16:41:49'],
            ['id'=>97,'user_id'=>1705,'transaction_id'=>'47168764','plan_name'=>null,'amount'=>1003,'plan_type'=>null,'created_at'=>'2025-10-30 17:38:20','updated_at'=>'2025-10-30 17:38:20'],
            ['id'=>98,'user_id'=>1704,'transaction_id'=>'30997289','plan_name'=>null,'amount'=>410000,'plan_type'=>null,'created_at'=>'2025-10-30 18:37:31','updated_at'=>'2025-10-30 18:37:31'],
            ['id'=>99,'user_id'=>1706,'transaction_id'=>'47554967','plan_name'=>null,'amount'=>210000,'plan_type'=>null,'created_at'=>'2025-10-30 18:51:11','updated_at'=>'2025-10-30 18:51:11'],
            ['id'=>100,'user_id'=>1704,'transaction_id'=>'58869413','plan_name'=>null,'amount'=>78000,'plan_type'=>null,'created_at'=>'2025-10-30 19:34:21','updated_at'=>'2025-10-30 19:34:21'],
            ['id'=>101,'user_id'=>1704,'transaction_id'=>'58216661','plan_name'=>null,'amount'=>10000,'plan_type'=>null,'created_at'=>'2025-11-01 09:50:29','updated_at'=>'2025-11-01 09:50:29'],
            ['id'=>102,'user_id'=>1704,'transaction_id'=>'51964772','plan_name'=>null,'amount'=>20000,'plan_type'=>null,'created_at'=>'2025-11-01 09:50:55','updated_at'=>'2025-11-01 09:50:55'],
            ['id'=>103,'user_id'=>1705,'transaction_id'=>'19518672','plan_name'=>null,'amount'=>600,'plan_type'=>null,'created_at'=>'2025-11-01 09:59:35','updated_at'=>'2025-11-01 09:59:35'],
            ['id'=>104,'user_id'=>1704,'transaction_id'=>'13735884','plan_name'=>null,'amount'=>20000,'plan_type'=>null,'created_at'=>'2025-11-01 10:05:07','updated_at'=>'2025-11-01 10:05:07'],
            ['id'=>105,'user_id'=>1702,'transaction_id'=>'39558388','plan_name'=>null,'amount'=>30000,'plan_type'=>null,'created_at'=>'2025-11-01 10:07:59','updated_at'=>'2025-11-01 10:07:59'],
            ['id'=>108,'user_id'=>1703,'transaction_id'=>'68747655','plan_name'=>null,'amount'=>210000,'plan_type'=>null,'created_at'=>'2025-11-01 10:16:01','updated_at'=>'2025-11-01 10:16:01'],
            ['id'=>109,'user_id'=>1699,'transaction_id'=>'42701918','plan_name'=>null,'amount'=>100000,'plan_type'=>null,'created_at'=>'2025-11-01 10:35:30','updated_at'=>'2025-11-01 10:35:30'],
            ['id'=>110,'user_id'=>1700,'transaction_id'=>'27568183','plan_name'=>null,'amount'=>210000,'plan_type'=>null,'created_at'=>'2025-11-01 12:29:07','updated_at'=>'2025-11-01 12:29:07'],
            ['id'=>111,'user_id'=>1717,'transaction_id'=>'66227447','plan_name'=>null,'amount'=>298000,'plan_type'=>null,'created_at'=>'2025-11-01 14:04:01','updated_at'=>'2025-11-01 14:04:01'],
            ['id'=>112,'user_id'=>1700,'transaction_id'=>'52358342','plan_name'=>null,'amount'=>50000,'plan_type'=>null,'created_at'=>'2025-11-01 14:16:57','updated_at'=>'2025-11-01 14:16:57'],
            ['id'=>113,'user_id'=>1717,'transaction_id'=>'22372995','plan_name'=>null,'amount'=>47000,'plan_type'=>null,'created_at'=>'2025-11-01 15:38:02','updated_at'=>'2025-11-01 15:38:02'],
            ['id'=>114,'user_id'=>1718,'transaction_id'=>'49232684','plan_name'=>null,'amount'=>209000,'plan_type'=>null,'created_at'=>'2025-11-01 15:57:14','updated_at'=>'2025-11-01 15:57:14'],
            ['id'=>115,'user_id'=>1699,'transaction_id'=>'70656450','plan_name'=>null,'amount'=>5000,'plan_type'=>null,'created_at'=>'2025-11-01 21:39:16','updated_at'=>'2025-11-01 21:39:16'],
            ['id'=>116,'user_id'=>1717,'transaction_id'=>'70946382','plan_name'=>null,'amount'=>23000,'plan_type'=>null,'created_at'=>'2025-11-01 23:18:37','updated_at'=>'2025-11-01 23:18:37'],
            ['id'=>117,'user_id'=>1717,'transaction_id'=>'75742499','plan_name'=>null,'amount'=>50000,'plan_type'=>null,'created_at'=>'2025-11-01 23:20:39','updated_at'=>'2025-11-01 23:20:39'],
            ['id'=>118,'user_id'=>1707,'transaction_id'=>'52895170','plan_name'=>null,'amount'=>210000,'plan_type'=>null,'created_at'=>'2025-11-02 18:04:21','updated_at'=>'2025-11-02 18:04:21'],
            ['id'=>119,'user_id'=>1700,'transaction_id'=>'63824624','plan_name'=>null,'amount'=>30000,'plan_type'=>null,'created_at'=>'2025-11-02 18:18:06','updated_at'=>'2025-11-02 18:18:06'],
            ['id'=>120,'user_id'=>1700,'transaction_id'=>'31149582','plan_name'=>null,'amount'=>80000,'plan_type'=>null,'created_at'=>'2025-11-02 18:22:47','updated_at'=>'2025-11-02 18:22:47'],
            ['id'=>121,'user_id'=>1703,'transaction_id'=>'20107781','plan_name'=>null,'amount'=>47000,'plan_type'=>null,'created_at'=>'2025-11-03 15:45:55','updated_at'=>'2025-11-03 15:45:55'],
            ['id'=>122,'user_id'=>1700,'transaction_id'=>'16518799','plan_name'=>null,'amount'=>280000,'plan_type'=>null,'created_at'=>'2025-11-03 16:11:48','updated_at'=>'2025-11-03 16:11:48'],
            ['id'=>123,'user_id'=>1703,'transaction_id'=>'67944153','plan_name'=>null,'amount'=>100000,'plan_type'=>null,'created_at'=>'2025-11-03 16:53:30','updated_at'=>'2025-11-03 16:53:30'],
            ['id'=>124,'user_id'=>1700,'transaction_id'=>'35687578','plan_name'=>null,'amount'=>163000,'plan_type'=>null,'created_at'=>'2025-11-04 03:36:07','updated_at'=>'2025-11-04 03:36:07'],
            ['id'=>125,'user_id'=>1728,'transaction_id'=>'76015903','plan_name'=>null,'amount'=>314000,'plan_type'=>null,'created_at'=>'2025-11-04 03:49:51','updated_at'=>'2025-11-04 03:49:51'],
            ['id'=>126,'user_id'=>1726,'transaction_id'=>'25671368','plan_name'=>null,'amount'=>96000,'plan_type'=>null,'created_at'=>'2025-11-04 12:54:38','updated_at'=>'2025-11-04 12:54:38'],
            ['id'=>127,'user_id'=>1721,'transaction_id'=>'40403555','plan_name'=>null,'amount'=>96000,'plan_type'=>null,'created_at'=>'2025-11-04 12:55:33','updated_at'=>'2025-11-04 12:55:33'],
            ['id'=>128,'user_id'=>1731,'transaction_id'=>'60137823','plan_name'=>null,'amount'=>421000,'plan_type'=>null,'created_at'=>'2025-11-04 13:42:51','updated_at'=>'2025-11-04 13:42:51'],
            ['id'=>129,'user_id'=>1699,'transaction_id'=>'15566189','plan_name'=>null,'amount'=>54000,'plan_type'=>null,'created_at'=>'2025-11-04 15:39:11','updated_at'=>'2025-11-04 15:39:11'],
            ['id'=>130,'user_id'=>1725,'transaction_id'=>'51397881','plan_name'=>null,'amount'=>76000,'plan_type'=>null,'created_at'=>'2025-11-05 00:00:04','updated_at'=>'2025-11-05 00:00:04'],
            ['id'=>131,'user_id'=>1699,'transaction_id'=>'75797069','plan_name'=>null,'amount'=>50000,'plan_type'=>null,'created_at'=>'2025-11-05 01:05:23','updated_at'=>'2025-11-05 01:05:23'],
            ['id'=>132,'user_id'=>1707,'transaction_id'=>'62050982','plan_name'=>null,'amount'=>47000,'plan_type'=>null,'created_at'=>'2025-11-05 01:14:34','updated_at'=>'2025-11-05 01:14:34'],
            ['id'=>133,'user_id'=>1730,'transaction_id'=>'65836561','plan_name'=>null,'amount'=>53000,'plan_type'=>null,'created_at'=>'2025-11-05 12:01:19','updated_at'=>'2025-11-05 12:01:19'],
            ['id'=>134,'user_id'=>1721,'transaction_id'=>'73056143','plan_name'=>null,'amount'=>114000,'plan_type'=>null,'created_at'=>'2025-11-05 12:23:19','updated_at'=>'2025-11-05 12:23:19'],
            ['id'=>135,'user_id'=>1712,'transaction_id'=>'43329889','plan_name'=>null,'amount'=>28000,'plan_type'=>null,'created_at'=>'2025-11-05 12:29:34','updated_at'=>'2025-11-05 12:29:34'],
            ['id'=>136,'user_id'=>1725,'transaction_id'=>'51602819','plan_name'=>null,'amount'=>134000,'plan_type'=>null,'created_at'=>'2025-11-05 13:02:10','updated_at'=>'2025-11-05 13:02:10'],
            ['id'=>137,'user_id'=>1734,'transaction_id'=>'61878442','plan_name'=>null,'amount'=>287000,'plan_type'=>null,'created_at'=>'2025-11-05 13:33:38','updated_at'=>'2025-11-05 13:33:38'],
            ['id'=>138,'user_id'=>1723,'transaction_id'=>'58344857','plan_name'=>null,'amount'=>410000,'plan_type'=>null,'created_at'=>'2025-11-05 16:07:16','updated_at'=>'2025-11-05 16:07:16'],
            ['id'=>139,'user_id'=>1721,'transaction_id'=>'21681487','plan_name'=>null,'amount'=>75000,'plan_type'=>null,'created_at'=>'2025-11-05 16:30:23','updated_at'=>'2025-11-05 16:30:23'],
            ['id'=>140,'user_id'=>1732,'transaction_id'=>'49837788','plan_name'=>null,'amount'=>121009,'plan_type'=>null,'created_at'=>'2025-11-05 21:19:37','updated_at'=>'2025-11-05 21:19:37'],
            ['id'=>141,'user_id'=>1729,'transaction_id'=>'33140131','plan_name'=>null,'amount'=>110000,'plan_type'=>null,'created_at'=>'2025-11-05 22:43:50','updated_at'=>'2025-11-05 22:43:50'],
            ['id'=>142,'user_id'=>1734,'transaction_id'=>'46579718','plan_name'=>null,'amount'=>47000,'plan_type'=>null,'created_at'=>'2025-11-06 00:53:44','updated_at'=>'2025-11-06 00:53:44'],
            ['id'=>143,'user_id'=>1730,'transaction_id'=>'13223806','plan_name'=>null,'amount'=>157000,'plan_type'=>null,'created_at'=>'2025-11-06 12:25:08','updated_at'=>'2025-11-06 12:25:08'],
            ['id'=>144,'user_id'=>1726,'transaction_id'=>'34263653','plan_name'=>null,'amount'=>101000,'plan_type'=>null,'created_at'=>'2025-11-06 12:28:50','updated_at'=>'2025-11-06 12:28:50'],
            ['id'=>145,'user_id'=>1721,'transaction_id'=>'59684609','plan_name'=>null,'amount'=>119000,'plan_type'=>null,'created_at'=>'2025-11-06 15:01:10','updated_at'=>'2025-11-06 15:01:10'],
            ['id'=>146,'user_id'=>1730,'transaction_id'=>'47655928','plan_name'=>null,'amount'=>47000,'plan_type'=>null,'created_at'=>'2025-11-06 17:35:17','updated_at'=>'2025-11-06 17:35:17'],
            ['id'=>148,'user_id'=>1732,'transaction_id'=>'40273834','plan_name'=>null,'amount'=>157991,'plan_type'=>null,'created_at'=>'2025-11-07 12:43:28','updated_at'=>'2025-11-07 12:43:28'],
            ['id'=>149,'user_id'=>1696,'transaction_id'=>'68769805','plan_name'=>null,'amount'=>210000,'plan_type'=>null,'created_at'=>'2025-11-07 13:54:48','updated_at'=>'2025-11-07 13:54:48'],
            ['id'=>150,'user_id'=>1696,'transaction_id'=>'66404252','plan_name'=>null,'amount'=>47000,'plan_type'=>null,'created_at'=>'2025-11-08 09:26:36','updated_at'=>'2025-11-08 09:26:36'],
            ['id'=>151,'user_id'=>1707,'transaction_id'=>'40258949','plan_name'=>null,'amount'=>63000,'plan_type'=>null,'created_at'=>'2025-11-08 10:27:23','updated_at'=>'2025-11-08 10:27:23'],
            ['id'=>152,'user_id'=>1713,'transaction_id'=>'26782267','plan_name'=>null,'amount'=>110000,'plan_type'=>null,'created_at'=>'2025-11-08 11:33:58','updated_at'=>'2025-11-08 11:33:58'],
            ['id'=>153,'user_id'=>1738,'transaction_id'=>'35494843','plan_name'=>null,'amount'=>604000,'plan_type'=>null,'created_at'=>'2025-11-10 09:38:23','updated_at'=>'2025-11-10 09:38:23'],
            ['id'=>155,'user_id'=>1712,'transaction_id'=>'64986229','plan_name'=>null,'amount'=>82000,'plan_type'=>null,'created_at'=>'2025-11-10 12:06:05','updated_at'=>'2025-11-10 12:06:05'],
            ['id'=>156,'user_id'=>1740,'transaction_id'=>'61757200','plan_name'=>null,'amount'=>110000,'plan_type'=>null,'created_at'=>'2025-11-10 13:35:16','updated_at'=>'2025-11-10 13:35:16'],
            ['id'=>157,'user_id'=>1738,'transaction_id'=>'14439378','plan_name'=>null,'amount'=>23620,'plan_type'=>null,'created_at'=>'2025-11-10 19:29:51','updated_at'=>'2025-11-10 19:29:51'],
            ['id'=>159,'user_id'=>1741,'transaction_id'=>'45971558','plan_name'=>null,'amount'=>6850,'plan_type'=>null,'created_at'=>'2025-11-11 18:04:20','updated_at'=>'2025-11-11 18:04:20'],
            ['id'=>160,'user_id'=>1737,'transaction_id'=>'24566021','plan_name'=>null,'amount'=>55000,'plan_type'=>null,'created_at'=>'2025-11-11 22:36:35','updated_at'=>'2025-11-11 22:36:35'],
            ['id'=>161,'user_id'=>1737,'transaction_id'=>'28790481','plan_name'=>null,'amount'=>55000,'plan_type'=>null,'created_at'=>'2025-11-12 11:35:40','updated_at'=>'2025-11-12 11:35:40'],
            ['id'=>162,'user_id'=>1741,'transaction_id'=>'20147185','plan_name'=>null,'amount'=>103150,'plan_type'=>null,'created_at'=>'2025-11-12 11:57:05','updated_at'=>'2025-11-12 11:57:05'],
            ['id'=>163,'user_id'=>1741,'transaction_id'=>'35479465','plan_name'=>null,'amount'=>47000,'plan_type'=>null,'created_at'=>'2025-11-12 14:03:57','updated_at'=>'2025-11-12 14:03:57'],
            ['id'=>164,'user_id'=>1741,'transaction_id'=>'50440892','plan_name'=>null,'amount'=>47620,'plan_type'=>null,'created_at'=>'2025-11-12 15:57:37','updated_at'=>'2025-11-12 15:57:37'],
            ['id'=>165,'user_id'=>1737,'transaction_id'=>'73328870','plan_name'=>null,'amount'=>47000,'plan_type'=>null,'created_at'=>'2025-11-12 18:23:28','updated_at'=>'2025-11-12 18:23:28'],
        ];
    }

    // ====================================================================
    // DATA — INVEST_DEBIT_PROFITS  (source: debitprofits)
    // ====================================================================
    private function debitProfits(): array
    {
        return [
            ['id'=>5,'user_id'=>1668,'transaction_id'=>'46708137','amount'=>920,'created_at'=>'2025-05-13 03:06:08','updated_at'=>'2025-05-13 03:06:08'],
            ['id'=>9,'user_id'=>1704,'transaction_id'=>'55463721','amount'=>404,'created_at'=>'2025-11-01 23:29:36','updated_at'=>'2025-11-01 23:29:36'],
            ['id'=>10,'user_id'=>1704,'transaction_id'=>'52629387','amount'=>400000,'created_at'=>'2025-11-01 23:30:23','updated_at'=>'2025-11-01 23:30:23'],
            ['id'=>15,'user_id'=>1837,'transaction_id'=>'55870598','amount'=>12000,'created_at'=>'2025-11-27 08:41:00','updated_at'=>'2025-11-27 08:41:00'],
            ['id'=>16,'user_id'=>1840,'transaction_id'=>'23794376','amount'=>23500,'created_at'=>'2025-11-28 12:17:25','updated_at'=>'2025-11-28 12:17:25'],
            ['id'=>19,'user_id'=>1845,'transaction_id'=>'55658801','amount'=>23500,'created_at'=>'2025-12-02 13:58:50','updated_at'=>'2025-12-02 13:58:50'],
            ['id'=>23,'user_id'=>2014,'transaction_id'=>'64453375','amount'=>2109785,'created_at'=>'2026-03-10 21:18:23','updated_at'=>'2026-03-10 21:18:23'],
            ['id'=>24,'user_id'=>2035,'transaction_id'=>'30152323','amount'=>11000,'created_at'=>'2026-03-22 10:28:52','updated_at'=>'2026-03-22 10:28:52'],
            ['id'=>25,'user_id'=>2030,'transaction_id'=>'20576865','amount'=>1196083,'created_at'=>'2026-05-30 16:40:49','updated_at'=>'2026-05-30 16:40:49'],
            ['id'=>26,'user_id'=>2070,'transaction_id'=>'53274683','amount'=>156200,'created_at'=>'2026-06-24 19:19:29','updated_at'=>'2026-06-24 19:19:29'],
            ['id'=>27,'user_id'=>2102,'transaction_id'=>'13434614','amount'=>5600,'created_at'=>'2026-09-10 03:33:42','updated_at'=>'2026-09-10 03:33:42'],
            ['id'=>28,'user_id'=>2102,'transaction_id'=>'43493788','amount'=>5600,'created_at'=>'2026-09-10 03:37:22','updated_at'=>'2026-09-10 03:37:22'],
            ['id'=>29,'user_id'=>2102,'transaction_id'=>'13493623','amount'=>11200,'created_at'=>'2026-09-10 03:38:54','updated_at'=>'2026-09-10 03:38:54'],
        ];
    }

    // ====================================================================
    // DATA — INVEST_EARNINGS  (source: earnings)
    // ====================================================================
    private function earnings(): array
    {
        return [
            ['id'=>1,'user_id'=>1,'transaction_id'=>'','amount'=>5,'type'=>'Bonus','narration'=>'SignUp Bonus','created_at'=>'2023-03-02 01:35:25','updated_at'=>'2023-03-02 01:35:25'],
            ['id'=>3,'user_id'=>3,'transaction_id'=>'','amount'=>5,'type'=>'Bonus','narration'=>'SignUp Bonus','created_at'=>'2023-03-06 04:37:25','updated_at'=>'2023-03-06 04:37:25'],
            ['id'=>4,'user_id'=>4,'transaction_id'=>'','amount'=>5,'type'=>'Bonus','narration'=>'SignUp Bonus','created_at'=>'2023-12-07 17:04:12','updated_at'=>'2023-12-07 17:04:12'],
        ];
    }

    // ====================================================================
    // DATA — INVEST_NOTIFICATIONS  (source: notifications, first 30)
    // ====================================================================
    private function notifications(): array
    {
        return [
            ['id'=>9,'user_id'=>1692,'message'=>'this is it','is_read'=>1,'created_at'=>'2026-01-09 23:57:32','updated_at'=>'2026-01-10 00:06:31'],
            ['id'=>10,'user_id'=>1692,'message'=>'this is to let you know that its time to level up!','is_read'=>1,'created_at'=>'2026-01-10 00:12:10','updated_at'=>'2026-01-10 00:15:20'],
            ['id'=>11,'user_id'=>1732,'message'=>'🔄 withdrawals in progress, kindly pay your balance of 12,000 GYD to proceed','is_read'=>0,'created_at'=>'2026-01-10 00:29:33','updated_at'=>'2026-01-10 00:29:33'],
            ['id'=>12,'user_id'=>1732,'message'=>'🔄 withdrawals in progress, kindly complete your outstanding payment of 12k GYD to finalise your withdrawals','is_read'=>0,'created_at'=>'2026-01-10 00:53:27','updated_at'=>'2026-01-10 00:53:27'],
            ['id'=>16,'user_id'=>1947,'message'=>'Investment in progress','is_read'=>1,'created_at'=>'2026-01-10 04:14:05','updated_at'=>'2026-01-10 04:56:32'],
            ['id'=>20,'user_id'=>1692,'message'=>'yesss','is_read'=>1,'created_at'=>'2026-01-14 01:01:49','updated_at'=>'2026-01-14 15:48:55'],
            ['id'=>73,'user_id'=>1692,'message'=>'yoyo','is_read'=>1,'created_at'=>'2026-05-07 13:37:30','updated_at'=>'2026-05-30 13:29:32'],
            ['id'=>98,'user_id'=>2092,'message'=>'✅ Trading in progress','is_read'=>1,'created_at'=>'2026-06-30 06:15:15','updated_at'=>'2026-09-20 02:38:22'],
            ['id'=>116,'user_id'=>2113,'message'=>'TSzHfUavkDeTSQ8KLd7821R1Gun7R19LHa','is_read'=>1,'created_at'=>'2026-09-23 23:00:33','updated_at'=>'2026-09-24 01:07:58'],
            ['id'=>117,'user_id'=>2116,'message'=>'Trading in good condition 📈📉','is_read'=>1,'created_at'=>'2026-10-03 23:36:09','updated_at'=>'2026-10-04 04:30:43'],
            ['id'=>118,'user_id'=>2116,'message'=>'Trading in progress 📉📈','is_read'=>1,'created_at'=>'2026-10-03 23:36:28','updated_at'=>'2026-10-04 04:30:43'],
        ];
    }
}
