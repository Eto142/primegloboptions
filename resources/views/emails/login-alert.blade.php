<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login Alert - TopSavers Bank</title>
    <style>
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            background-color: #f4f6f8;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 30px auto;
            background: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
            overflow: hidden;
        }
        .header {
            background-color: #0052cc;
            padding: 20px;
            text-align: center;
        }
        .header img {
            width: 100px;
        }
        .content {
            padding: 30px;
            color: #333;
        }
        .content h2 {
            color: #0052cc;
            margin-bottom: 10px;
        }
        .footer {
            background: #f9fafb;
            text-align: center;
            padding: 15px;
            font-size: 13px;
            color: #666;
        }
        .details {
            background: #f2f6ff;
            padding: 10px 15px;
            border-radius: 6px;
            margin-top: 15px;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <img src="{{ asset('logo.png') }}" alt="TopSavers Logo">
        </div>
        <div class="content">
            <h2>Login Alert</h2>
            <p>Dear <strong>{{ $user->first_name }}</strong>,</p>
            <p>Your account just logged in successfully to <strong>TopSavers Bank</strong>.</p>

            <div class="details">
                <p><strong>Time:</strong> {{ $time }}</p>
                <p><strong>IP Address:</strong> {{ $ip }}</p>
            </div>

            <p>If this was <strong>not you</strong>, please secure your account immediately by changing your password or contacting our support team.</p>
            <p>Thank you for banking with us.<br><strong>TopSavers Bank Security Team</strong></p>
        </div>
        <div class="footer">
            © {{ date('Y') }} TopSavers Bank. All rights reserved.
        </div>
    </div>
</body>
</html>
