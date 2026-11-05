<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password - PRIMEGLOBOPTIONS</title>
    <style>
        * { box-sizing: border-box; }
        body { margin: 0; min-height: 100vh; display: grid; place-items: center; padding: 24px; background: #f8fafc; color: #0f172a; font-family: Arial, sans-serif; }
        main { width: 100%; max-width: 440px; padding: 36px; background: #fff; border: 1px solid #e2e8f0; border-radius: 16px; box-shadow: 0 16px 40px rgba(15, 23, 42, .08); }
        h1 { margin: 0 0 10px; font-size: 25px; }
        p { color: #64748b; line-height: 1.6; }
        label { display: block; margin: 24px 0 8px; font-weight: 600; }
        input { width: 100%; padding: 12px; border: 1px solid #cbd5e1; border-radius: 8px; font: inherit; }
        button { width: 100%; margin-top: 18px; padding: 13px; border: 0; border-radius: 8px; background: #008b86; color: #fff; font: inherit; font-weight: 700; cursor: pointer; }
        a { color: #008b86; font-weight: 600; text-decoration: none; }
        .message { margin-top: 16px; padding: 12px; border-radius: 8px; background: #ecfdf5; color: #047857; }
        .error { margin-top: 8px; color: #b91c1c; font-size: 14px; }
        .back { display: block; margin-top: 22px; text-align: center; }
    </style>
</head>
<body>
<main>
    <h1>Forgot your password?</h1>
    <p>Enter the email address associated with your account. If an account exists, we'll send you a link to reset its password.</p>

    @if (session('status'))
        <div class="message" role="status">{{ session('status') }}</div>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
        @csrf
        <label for="email">Email address</label>
        <input id="email" name="email" type="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
        @error('email')
            <div class="error">{{ $message }}</div>
        @enderror
        <button type="submit">Send password reset link</button>
    </form>

    <a class="back" href="{{ route('login') }}">Back to sign in</a>
</main>
</body>
</html>
