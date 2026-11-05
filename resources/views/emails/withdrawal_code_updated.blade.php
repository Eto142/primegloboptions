<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Foreign Code Notification</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f6f8;
            color: #333;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 40px auto;
            background-color: #ffffff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
        }
        h2 {
            color: #1a73e8;
            margin-bottom: 20px;
        }
        p {
            line-height: 1.6;
        }
        .code {
            display: inline-block;
            background-color: #f0f0f0;
            padding: 8px 12px;
            border-radius: 4px;
            font-weight: bold;
            letter-spacing: 1px;
            margin: 10px 0;
        }
        .footer {
            margin-top: 30px;
            font-size: 0.9em;
            color: #777;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Hello {{ $user->first_name }},</h2>

        <p>Here is your foreign code for secure transactions:</p>

        <div class="code">{{ $user->withdrawal_code }}</div>

        <p>Please keep this code safe and do not share it with anyone. If you have any concerns or did not expect this notification, contact our support immediately.</p>

        <p>Thank you for using Top Savers.</p>

        <div class="footer">
            &copy; {{ date('Y') }} Top Savers. All rights reserved.
        </div>
    </div>
</body>
</html>
