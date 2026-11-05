<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - PRIMEGLOBOPTIONS</title>
    <style>
        * { box-sizing: border-box; }
        body { margin: 0; min-height: 100vh; display: grid; place-items: center; padding: 24px; background: #f8fafc; color: #0f172a; font-family: Arial, sans-serif; }
        main { width: 100%; max-width: 440px; padding: 36px; background: #fff; border: 1px solid #e2e8f0; border-radius: 16px; box-shadow: 0 16px 40px rgba(15, 23, 42, .08); }
        h1 { margin: 0 0 10px; font-size: 25px; }
        p { color: #64748b; line-height: 1.6; }
        label { display: block; margin: 20px 0 8px; font-weight: 600; }
        input { width: 100%; padding: 12px; border: 1px solid #cbd5e1; border-radius: 8px; font: inherit; }
        button { width: 100%; margin-top: 22px; padding: 13px; border: 0; border-radius: 8px; background: #008b86; color: #fff; font: inherit; font-weight: 700; cursor: pointer; }
        a { color: #008b86; font-weight: 600; text-decoration: none; }
        .error { margin-top: 8px; color: #b91c1c; font-size: 14px; }
        .back { display: block; margin-top: 22px; text-align: center; }
    </style>
</head>
<body>
<main>
    <h1>Choose a new password</h1>
    <p>Use a password with at least 8 characters.</p>

    <form method="POST" action="{{ route('password.update') }}">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">

        <label for="email">Email address</label>
        <input id="email" name="email" type="email" value="{{ old('email', $email) }}" required autocomplete="email">
        @error('email')
            <div class="error">{{ $message }}</div>
        @enderror

        <label for="password">New password</label>
        <input id="password" name="password" type="password" required autocomplete="new-password">
        @error('password')
            <div class="error">{{ $message }}</div>
        @enderror

        <label for="password_confirmation">Confirm new password</label>
        <input id="password_confirmation" name="password_confirmation" type="password" required autocomplete="new-password">

        <button type="submit">Reset password</button>
    </form>

    <a class="back" href="{{ route('login') }}">Back to sign in</a>
</main>
</body>
</html>
