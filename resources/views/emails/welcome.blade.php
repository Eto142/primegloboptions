<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Welcome to PRIMEGLOBOPTIONS</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background: linear-gradient(to right, #0a5c5c, #0d7a7a);
            color: white;
            padding: 30px;
            text-align: center;
            border-radius: 10px 10px 0 0;
        }
        .content {
            background: #f8f9fa;
            padding: 30px;
            border-radius: 0 0 10px 10px;
        }
        .account-details {
            background: white;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
            border-left: 4px solid #0a5c5c;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
            color: #666;
            font-size: 14px;
        }
        .highlight {
            background: #0a5c5c;
            color: white;
            padding: 10px 15px;
            border-radius: 5px;
            font-weight: bold;
            text-align: center;
            margin: 15px 0;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Welcome to PRIMEGLOBOPTIONS</h1>
        <p>Your trusted financial partner</p>
    </div>
    
    <div class="content">
        <h2>Dear {{ $user->first_name }},</h2>
        
        <p>Welcome to PRIMEGLOBOPTIONS! We're excited to have you as our valued customer.</p>
        
        <div class="account-details">
            <h3>Your Account Details:</h3>
            <p><strong>Account Number:</strong> {{ $user->account_number }}</p>
            <p><strong>Account Type:</strong> {{ ucfirst($user->account_type) }} Account</p>
            <p><strong>Currency:</strong> {{ $user->currency }}</p>
            <p><strong>Registration Date:</strong> {{ $user->created_at->format('F d, Y') }}</p>
        </div>

        <div class="highlight">
            Your account has been successfully created and is ready for use.
        </div>

        <h3>What's Next?</h3>
        <ul>
            <li>Log in to your online banking account</li>
            <li>Set up your security preferences</li>
            <li>Explore our banking features</li>
            <li>Make your first deposit</li>
        </ul>

        <h3>Security Reminder:</h3>
        <p>Never share your login credentials, password, or transaction PIN with anyone. 
        PRIMEGLOBOPTIONS will never ask for this information via email or phone.</p>

        <p>If you have any questions, please don't hesitate to contact our customer support team.</p>

        <p>Best regards,<br>
        <strong>The PRIMEGLOBOPTIONS Team</strong></p>
    </div>

    <div class="footer">
        <p>&copy; {{ date('Y') }} PRIMEGLOBOPTIONS. All rights reserved.</p>
        <p>Member FDIC | Equal Housing Lender</p>
        <p>This is an automated message. Please do not reply to this email.</p>
    </div>
</body>
</html>