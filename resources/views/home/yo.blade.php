<!DOCTYPE html>
<html lang="en">
<head>
    
    
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>PRIMEGLOBOPTIONS - Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #0a5c5c;
            --primary-light: #0d7a7a;
            --primary-dark: #063e3e;
            --accent-color: #ff6b35;
            --light-color: #ffffff;
            --dark-color: #333333;
            --gray-light: #f5f7fa;
            --gray-medium: #e0e6ed;
            --gray-dark: #6b7280;
            --error-color: #ef4444;
            --border-radius: 12px;
            --box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
            --transition: all 0.3s ease;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #e4e8eb 100%);
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            color: var(--dark-color);
            line-height: 1.6;
        }
        
        .bank-header {
            background-color: var(--light-color);
            color: var(--primary-color);
            padding: 1rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.05);
            border-bottom: 1px solid var(--gray-medium);
        }
        
        .bank-logo {
            font-size: 1.2rem;
            font-weight: bold;
            display: flex;
            align-items: center;
        }
        
        .bank-logo i {
            font-size: 1.5rem;
            margin-right: 8px;
            color: var(--primary-color);
        }
        
        .register-link {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 600;
            padding: 0.5rem 1rem;
            border-radius: 50px;
            transition: var(--transition);
            display: flex;
            align-items: center;
            border: 2px solid var(--primary-color);
            font-size: 0.85rem;
        }
        
        .register-link:hover {
            background-color: var(--primary-color);
            color: white;
        }
        
        .register-link i {
            margin-right: 6px;
        }
        
        .main-container {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-grow: 1;
            padding: 1rem;
        }
        
        .login-container {
            background-color: white;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            width: 100%;
            max-width: 450px;
            padding: 2rem;
            animation: fadeInUp 0.5s ease;
        }
        
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .login-header {
            margin-bottom: 1.5rem;
            text-align: center;
        }
        
        .login-header h2 {
            color: var(--primary-color);
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }
        
        .login-header p {
            color: var(--gray-dark);
            font-size: 0.9rem;
        }
        
        .form-group {
            margin-bottom: 1.5rem;
            position: relative;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
            color: var(--primary-dark);
            font-size: 0.9rem;
        }
        
        .form-group input {
            width: 100%;
            padding: 0.85rem 1rem;
            border: 1px solid var(--gray-medium);
            border-radius: 8px;
            font-size: 1rem;
            transition: var(--transition);
            box-sizing: border-box;
            background-color: var(--light-color);
        }
        
        .form-group input:focus {
            border-color: var(--primary-color);
            outline: none;
            box-shadow: 0 0 0 3px rgba(10, 92, 92, 0.1);
        }
        
        .password-container {
            position: relative;
        }
        
        .toggle-password {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: var(--gray-dark);
            transition: var(--transition);
            background: none;
            border: none;
            font-size: 1rem;
        }
        
        .toggle-password:hover {
            color: var(--primary-color);
        }
        
        .error-message {
            color: var(--error-color);
            font-size: 0.8rem;
            margin-top: 0.5rem;
            min-height: 1rem;
            font-weight: 500;
        }
        
        .remember-forgot {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }
        
        .remember-me {
            display: flex;
            align-items: center;
        }
        
        .remember-me input {
            width: auto;
            margin-right: 0.5rem;
            accent-color: var(--primary-color);
        }
        
        .remember-me label {
            font-size: 0.85rem;
            color: var(--gray-dark);
            cursor: pointer;
        }
        
        .forgot-password {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 600;
            font-size: 0.85rem;
            transition: var(--transition);
        }
        
        .forgot-password:hover {
            text-decoration: underline;
        }
        
        .btn {
            padding: 0.85rem 1.5rem;
            font-size: 1rem;
            font-weight: 600;
            border-radius: 8px;
            cursor: pointer;
            transition: var(--transition);
            border: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 100%;
        }
        
        .btn-primary {
            background: linear-gradient(to right, var(--primary-color), var(--primary-light));
            color: white;
            box-shadow: 0 4px 12px rgba(10, 92, 92, 0.2);
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 18px rgba(10, 92, 92, 0.3);
        }
        
        .btn i {
            margin-right: 8px;
        }
        
        .security-notice {
            margin-top: 1.5rem;
            padding: 1rem;
            background-color: var(--gray-light);
            border-radius: var(--border-radius);
            font-size: 0.8rem;
            border-left: 4px solid var(--accent-color);
        }
        
        .security-notice h3 {
            margin-top: 0;
            color: var(--primary-color);
            font-size: 0.9rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
        }
        
        .security-notice h3 i {
            margin-right: 6px;
            color: var(--accent-color);
        }
        
        .security-notice ul {
            padding-left: 1.2rem;
            margin-bottom: 0;
        }
        
        .security-notice li {
            margin-bottom: 0.3rem;
        }
        
        .login-footer {
            display: flex;
            justify-content: center;
            margin-top: 1.5rem;
            gap: 1rem;
        }
        
        .login-footer img {
            height: 25px;
            filter: grayscale(100%) brightness(0.5);
        }
        
        footer {
            background-color: var(--primary-dark);
            color: white;
            text-align: center;
            padding: 1rem;
            font-size: 0.8rem;
        }
        
        /* Loading spinner */
        .spinner {
            display: none;
            width: 18px;
            height: 18px;
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            border-top-color: white;
            animation: spin 1s ease-in-out infinite;
            margin-right: 8px;
        }
        
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
        
        /* Desktop styles */
        @media (min-width: 768px) {
            .bank-header {
                padding: 1rem 2rem;
            }
            
            .bank-logo {
                font-size: 1.5rem;
            }
            
            .bank-logo i {
                font-size: 2rem;
                margin-right: 10px;
            }
            
            .register-link {
                padding: 0.75rem 1.5rem;
                font-size: 0.9rem;
            }
            
            .main-container {
                padding: 2rem;
            }
            
            .login-container {
                padding: 2.5rem;
            }
            
            .login-header h2 {
                font-size: 1.8rem;
            }
        }
    </style>
</head>

<!-- Smartsupp Live Chat script -->
<script type="text/javascript">
var _smartsupp = _smartsupp || {};
_smartsupp.key = '400579ce64e0abc3d4c0be6882ce7b545d338a5c';
window.smartsupp||(function(d) {
  var s,c,o=smartsupp=function(){ o._.push(arguments)};o._=[];
  s=d.getElementsByTagName('script')[0];c=d.createElement('script');
  c.type='text/javascript';c.charset='utf-8';c.async=true;
  c.src='https://www.smartsuppchat.com/loader.js?';s.parentNode.insertBefore(c,s);
})(document);
</script>
<noscript> Powered by <a href=“https://www.smartsupp.com” target=“_blank”>Smartsupp</a></noscript>
<body>
    <header class="bank-header">
        <div class="bank-logo">
            <i class="fas fa-university"></i>
            <a class="navbar-brand" href="/">
                            <img class="logo-light" src="home/asset/img/logo.png" alt="logo" width="160">
                        </a>
        </div>
        <a href="{{ route('register') }}" class="register-link">
            <i class="fas fa-user-plus"></i> Enroll
        </a>
    </header>
    
    <div class="main-container">
        <div class="login-container">
            <div class="login-header">
                <h2>Secure Login</h2>
                <p>Access your accounts</p>
            </div>
            
            <div id="alert-area"></div>
            
            <form id="loginForm">
                @csrf

                <div class="form-group">
                    <label for="email">Online ID (Email/Phone Number)</label>
                    <input type="text" name="email" required id="email" placeholder="Enter your email/phone number" autocomplete="username">
                    <div class="error-message" id="error-email"></div>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <div class="password-container">
                        <input type="password" name="password" required id="password" placeholder="Enter your password" autocomplete="current-password">
                        <button type="button" class="toggle-password" data-target="password">
                            <i class="far fa-eye"></i>
                        </button>
                    </div>
                    <div class="error-message" id="error-password"></div>
                </div>
                
                <div class="remember-forgot">
                    <div class="remember-me">
                        <input type="checkbox" id="remember" name="remember">
                        <label for="remember">Remember me</label>
                    </div>
                    <a href="/forgot-password" class="forgot-password">
                        Forgot password?
                    </a>
                </div>

                <button type="submit" class="btn btn-primary" id="loginButton">
                    <span class="spinner" id="spinner"></span>
                    <i class="fas fa-lock"></i> Sign In
                </button>

                <a href="{{ route('register') }}" class="forgot-password">
                        Not Registered Yet?
                    </a>
                
                <div class="security-notice">
                    <h3><i class="fas fa-shield-alt"></i> Security Tips</h3>
                    <ul>
                        <li>Never share your credentials</li>
                        <li>Log out after each session</li>
                    </ul>
                </div>
                
            
            </form>
        </div>
    </div>

    <footer>
        <p>Copyright &copy; 2025 PRIMEGLOBOPTIONS. All rights reserved.</p>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('loginForm');
            const alertArea = document.getElementById('alert-area');
            const loginButton = document.getElementById('loginButton');
            const spinner = document.getElementById('spinner');
            
            // Toggle password visibility
            document.querySelector('.toggle-password').addEventListener('click', function() {
                const passwordInput = document.getElementById('password');
                const icon = this.querySelector('i');
                
                if (passwordInput.type === 'password') {
                    passwordInput.type = 'text';
                    icon.classList.remove('fa-eye');
                    icon.classList.add('fa-eye-slash');
                } else {
                    passwordInput.type = 'password';
                    icon.classList.remove('fa-eye-slash');
                    icon.classList.add('fa-eye');
                }
            });
            
            // Check if there's a saved email in localStorage
            if (localStorage.getItem('rememberedEmail')) {
                document.getElementById('email').value = localStorage.getItem('rememberedEmail');
                document.getElementById('remember').checked = true;
            }
            
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                const formData = new FormData(form);
                const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
                
                // Show loading spinner
                loginButton.disabled = true;
                spinner.style.display = 'inline-block';
                
                // Clear previous errors
                document.getElementById('error-email').textContent = '';
                document.getElementById('error-password').textContent = '';
                alertArea.innerHTML = '';
                
                fetch("{{ route('login') }}", {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json',
                    },
                    body: formData
                })
                .then(response => {
                    if (!response.ok) {
                        throw response;
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        // Handle "Remember me" functionality
                        if (document.getElementById('remember').checked) {
                            localStorage.setItem('rememberedEmail', document.getElementById('email').value);
                        } else {
                            localStorage.removeItem('rememberedEmail');
                        }
                        
                        // Show success message
                        alertArea.innerHTML = `
                            <div style="padding: 0.75rem; border-radius: 8px; background-color: #d1fae5; color: #065f46; border: 1px solid #a7f3d0; font-size: 0.9rem; display: flex; align-items: center;">
                                <i class="fas fa-check-circle" style="margin-right: 8px;"></i>
                                ${data.message}
                            </div>
                        `;
                        
                        // Redirect after short delay
                        setTimeout(() => {
                            window.location.href = data.redirect;
                        }, 1000);
                    } else {
                        // Show error message
                        alertArea.innerHTML = `
                            <div style="padding: 0.75rem; border-radius: 8px; background-color: #fee2e2; color: #991b1b; border: 1px solid #fecaca; font-size: 0.9rem; display: flex; align-items: center;">
                                <i class="fas fa-exclamation-circle" style="margin-right: 8px;"></i>
                                ${data.message}
                            </div>
                        `;
                        
                        // Handle field errors
                        if (data.errors) {
                            if (data.errors.email) {
                                document.getElementById('error-email').textContent = data.errors.email[0];
                            }
                            if (data.errors.password) {
                                document.getElementById('error-password').textContent = data.errors.password[0];
                            }
                        }
                    }
                })
                .catch(async (error) => {
                    let errorMessage = 'An unexpected error occurred. Please try again.';
                    
                    try {
                        const errorData = await error.json();
                        if (errorData.message) {
                            errorMessage = errorData.message;
                        }
                    } catch (e) {
                        console.error('Error parsing error response:', e);
                    }
                    
                    alertArea.innerHTML = `
                        <div style="padding: 0.75rem; border-radius: 8px; background-color: #fee2e2; color: #991b1b; border: 1px solid #fecaca; font-size: 0.9rem; display: flex; align-items: center;">
                            <i class="fas fa-exclamation-circle" style="margin-right: 8px;"></i>
                            ${errorMessage}
                        </div>
                    `;
                })
                .finally(() => {
                    // Hide loading spinner
                    loginButton.disabled = false;
                    spinner.style.display = 'none';
                });
            });
            
            // Auto-focus email field on page load
            document.getElementById('email').focus();
        });
    </script>
</body>
</html>