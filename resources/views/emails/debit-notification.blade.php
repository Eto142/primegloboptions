<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Account Debited - TopSavers</title>
    <style>
        body {
            font-family: 'Segoe UI', Roboto, Arial, sans-serif;
            background-color: #f3f5f8;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 650px;
            margin: 40px auto;
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08);
            overflow: hidden;
        }
        .header {
            background-color: #b30000; /* Red for debit alert */
            padding: 25px;
            text-align: center;
        }
        .header img {
            width: 130px;
        }
        .content {
            padding: 35px 30px;
            color: #2e2e2e;
        }
        .content h2 {
            color: #b30000;
            font-size: 24px;
            margin-bottom: 15px;
        }
        .content p {
            font-size: 16px;
            line-height: 1.6;
            margin: 10px 0;
        }
        .details {
            background: #ffeaea;
            border-left: 5px solid #b30000;
            padding: 20px;
            border-radius: 8px;
            margin: 25px 0;
            font-size: 15px;
        }
        .details p {
            margin: 8px 0;
        }
        .highlight {
            color: #b30000;
            font-weight: bold;
        }
        .amount {
            font-size: 22px;
            color: #b30000;
            font-weight: bold;
        }
        .button {
            display: inline-block;
            background-color: #b30000;
            color: #ffffff;
            text-decoration: none;
            padding: 12px 25px;
            border-radius: 6px;
            margin-top: 25px;
            font-weight: 500;
            transition: background 0.3s ease;
        }
        .button:hover {
            background-color: #800000;
        }
        .footer {
            background: #f7f8fa;
            text-align: center;
            padding: 18px;
            font-size: 13px;
            color: #7a7a7a;
        }
        .footer a {
            color: #b30000;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <img src="{{ asset('logo.png') }}" alt="TopSavers Logo">
        </div>

        <!-- Content -->
        <div class="content">
            <h2>Account Debited Successfully!</h2>
            <p>Dear <strong>{{ $user['full_name'] }}</strong>,</p>
            <p>This is to inform you that your <strong>TopSavers</strong> account has been debited as per your recent transaction.</p>

            <!-- Transaction Details -->
            <div class="details">
                <p><strong>Transaction Reference:</strong> <span class="highlight">{{ $user['ref'] }}</span></p>
                <p><strong>Amount Debited:</strong> <span class="amount">{{ $user['currency'] }}{{ number_format($user['amount'], 2) }}</span></p>
                <p><strong>New Balance:</strong> {{ $user['currency'] }}{{ number_format($user['balance'], 2) }}</p>
                <p><strong>Description:</strong> {{ $user['description'] }}</p>
                <p><strong>Date:</strong> {{ \Carbon\Carbon::parse($user['date'])->format('d M Y, h:i A') }}</p>
                <p><strong>Account Number:</strong> {{ $user['account_number'] }}</p>
            </div>

            <p style="margin-top: 25px;">
                For your security, please review your account regularly.  
                If you did not authorize this transaction, contact our support team immediately.
            </p>

            <a href="{{ route('user.home') }}" class="button">View Account</a>
        </div>

        <!-- Footer -->
        <div class="footer">
            © {{ date('Y') }} <strong>TopSavers</strong>. All rights reserved.  
            <br>
            Need help? <a href="{{ route('user.home') }}">Contact Support</a>
        </div>
    </div>
</body>
</html>
