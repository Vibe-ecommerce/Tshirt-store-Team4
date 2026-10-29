<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Create Account — T-Shirt Online</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,400&display=swap" rel="stylesheet">

    <style>
        :root {
            --bg-page: #f8fafc;
            --bg-card: #ffffff;
            --text-heading: #0f172a;
            --text-body: #475569;
            --text-label: #334155;
            --text-muted: #64748b;
            --border-card: #e2e8f0;
            --border-input: #cbd5e1;
            --border-input-focus: #2563eb;
            --input-bg: #f8fafc;
            --input-bg-focus: #ffffff;
            --primary: #0f172a;
            --primary-hover: #000000;
            --accent-blue: #2563eb;
            --shadow-card: 0 16px 40px -12px rgba(15, 23, 42, 0.08), 0 2px 10px rgba(0, 0, 0, 0.03);
            --shadow-btn: 0 8px 20px rgba(15, 23, 42, 0.14);
            --radius-input: 10px;
            --radius-card: 20px;
            --radius-full: 9999px;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, sans-serif;
            -webkit-font-smoothing: antialiased;
        }

        html, body {
            height: 100vh;
            max-height: 100vh;
            margin: 0;
            padding: 0;
            overflow: hidden;
            background-color: var(--bg-page);
            color: var(--text-heading);
        }

        body {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            position: relative;
        }

        .ambient-glow-top {
            position: absolute;
            top: -120px;
            left: 50%;
            transform: translateX(-50%);
            width: 650px;
            height: 320px;
            background: radial-gradient(ellipse at center, rgba(37, 99, 235, 0.07) 0%, rgba(241, 245, 249, 0) 70%);
            filter: blur(50px);
            pointer-events: none;
            z-index: 0;
        }

        /* -------------------------------------------------------------
           TOP NAVIGATION BAR (Compact)
        ------------------------------------------------------------- */
        .auth-nav-bar {
            position: relative;
            z-index: 10;
            max-width: 1200px;
            width: 100%;
            margin: 0 auto;
            padding: 14px 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .auth-brand-logo {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
            color: var(--text-heading);
            font-weight: 850;
            font-size: 1.25rem;
            letter-spacing: -0.5px;
            transition: opacity 0.2s;
        }

        .auth-brand-logo:hover {
            opacity: 0.88;
        }

        .brand-icon-box {
            width: 34px;
            height: 34px;
            border-radius: 9px;
            background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #ffffff;
            box-shadow: 0 4px 10px rgba(37, 99, 235, 0.28);
        }

        .brand-dot {
            color: var(--accent-blue);
        }

        .back-to-store-link {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            color: var(--text-body);
            text-decoration: none;
            font-size: 0.84rem;
            font-weight: 700;
            padding: 7px 15px;
            border-radius: var(--radius-full);
            border: 1.5px solid var(--border-card);
            background: #ffffff;
            box-shadow: 0 1px 4px rgba(0, 0, 0, 0.03);
            transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .back-to-store-link:hover {
            color: var(--text-heading);
            background: #f1f5f9;
            border-color: #cbd5e1;
            transform: translateX(-2px);
        }

        /* -------------------------------------------------------------
           CENTER AUTHENTICATION WORKSPACE (Zero-Scroll Precision)
        ------------------------------------------------------------- */
        .auth-main-container {
            position: relative;
            z-index: 10;
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 6px 20px;
            min-height: 0;
        }

        .auth-card-panel {
            max-width: 440px;
            width: 100%;
            background: var(--bg-card);
            border: 1.5px solid var(--border-card);
            border-radius: var(--radius-card);
            padding: 24px 30px;
            box-shadow: var(--shadow-card);
            animation: cardFadeUp 0.35s cubic-bezier(0.16, 1, 0.3, 1);
        }

        @keyframes cardFadeUp {
            from { opacity: 0; transform: translateY(12px) scale(0.98); }
            to { opacity: 1; transform: translateY(0) scale(1); }
        }

        .security-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 4px 11px;
            border-radius: var(--radius-full);
            background: #eff6ff;
            border: 1px solid #bfdbfe;
            color: #1e40af;
            font-size: 0.68rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.7px;
            margin-bottom: 8px;
        }

        .auth-title {
            font-size: 1.65rem;
            font-weight: 850;
            color: var(--text-heading);
            letter-spacing: -0.6px;
            line-height: 1.15;
            margin-bottom: 3px;
        }

        .auth-subtitle {
            color: var(--text-body);
            font-size: 0.85rem;
            line-height: 1.45;
            margin-bottom: 14px;
        }

        .auth-alert {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 8px 12px;
            border-radius: 9px;
            font-size: 0.82rem;
            margin-bottom: 12px;
            line-height: 1.35;
        }

        .auth-alert.error {
            background: #fef2f2;
            border: 1px solid #fecaca;
            color: #b91c1c;
        }

        .auth-form {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .form-label {
            font-size: 0.72rem;
            font-weight: 750;
            color: var(--text-label);
            letter-spacing: 0.3px;
            text-transform: uppercase;
        }

        .input-wrapper {
            position: relative;
            display: flex;
            align-items: center;
        }

        .input-icon {
            position: absolute;
            left: 14px;
            color: var(--text-muted);
            display: flex;
            align-items: center;
            pointer-events: none;
            transition: color 0.2s;
        }

        .form-input {
            width: 100%;
            height: 40px;
            background: var(--input-bg);
            border: 1.5px solid var(--border-input);
            border-radius: var(--radius-input);
            padding: 0 40px 0 40px;
            font-size: 0.88rem;
            color: var(--text-heading);
            font-weight: 550;
            outline: none;
            transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .form-input::placeholder {
            color: #94a3b8;
            font-weight: 400;
        }

        .form-input:focus {
            background: var(--input-bg-focus);
            border-color: var(--border-input-focus);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.12);
        }

        .input-wrapper:focus-within .input-icon {
            color: var(--accent-blue);
        }

        .password-toggle {
            position: absolute;
            right: 10px;
            background: none;
            border: none;
            color: #94a3b8;
            cursor: pointer;
            padding: 5px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 6px;
            transition: color 0.2s;
        }

        .password-toggle:hover {
            color: var(--text-heading);
        }

        .submit-btn {
            width: 100%;
            height: 44px;
            background: var(--primary);
            color: #ffffff;
            border: none;
            border-radius: var(--radius-full);
            font-size: 0.92rem;
            font-weight: 800;
            letter-spacing: 0.2px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            margin-top: 4px;
            box-shadow: var(--shadow-btn);
            transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .submit-btn:hover {
            background: var(--primary-hover);
            transform: translateY(-1px);
            box-shadow: 0 10px 24px rgba(15, 23, 42, 0.2);
        }

        .submit-btn:active {
            transform: translateY(0);
        }

        .auth-divider {
            display: flex;
            align-items: center;
            margin: 11px 0;
            color: #94a3b8;
            font-size: 0.68rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .auth-divider::before,
        .auth-divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: #e2e8f0;
        }

        .auth-divider span {
            padding: 0 10px;
        }

        .google-btn {
            width: 100%;
            height: 40px;
            background: #ffffff;
            color: #1e293b;
            border: 1.5px solid #cbd5e1;
            border-radius: var(--radius-full);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            font-size: 0.88rem;
            font-weight: 750;
            text-decoration: none;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.03);
            transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .google-btn:hover {
            background: #f8fafc;
            border-color: #94a3b8;
            transform: translateY(-1px);
        }

        .google-icon {
            width: 17px;
            height: 17px;
            flex-shrink: 0;
        }

        .card-footer {
            text-align: center;
            margin-top: 10px;
            padding-top: 9px;
            border-top: 1px solid #f1f5f9;
            font-size: 0.82rem;
            color: var(--text-body);
        }

        .card-footer a {
            color: var(--text-heading);
            font-weight: 800;
            text-decoration: none;
            margin-left: 4px;
            transition: color 0.15s;
        }

        .card-footer a:hover {
            color: var(--accent-blue);
            text-decoration: underline;
        }

        /* -------------------------------------------------------------
           PAGE FOOTER (Compact)
        ------------------------------------------------------------- */
        .page-footer {
            position: relative;
            z-index: 10;
            text-align: center;
            padding: 10px 20px;
            font-size: 0.74rem;
            color: var(--text-muted);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 14px;
            flex-wrap: wrap;
        }

        .footer-item {
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        /* Responsive safeguard only for extreme tiny screens */
        @media (max-height: 640px) {
            html, body {
                height: auto;
                min-height: 100vh;
                overflow-y: auto;
            }
        }
    </style>
</head>
<body>

    <div class="ambient-glow-top"></div>

    <header class="auth-nav-bar">
        <a href="{{ route('home') }}" class="auth-brand-logo">
            <span class="brand-icon-box">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M20.38 3.46L16 2a4 4 0 0 1-8 0L3.62 3.46a2 2 0 0 0-1.34 2.23l.58 3.47a1 1 0 0 0 .99.84H6v10a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V10h2.15a1 1 0 0 0 .99-.84l.58-3.47a2 2 0 0 0-1.34-2.23z"/>
                </svg>
            </span>
            <span>T-Shirt Online<span class="brand-dot">•</span></span>
        </a>

        <a href="{{ route('shop.index') }}" class="back-to-store-link">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2">
                <line x1="19" y1="12" x2="5" y2="12"></line>
                <polyline points="12 19 5 12 12 5"></polyline>
            </svg>
            <span>Back to Store</span>
        </a>
    </header>

    <main class="auth-main-container">
        <div class="auth-card-panel">
            <div class="security-badge">
                <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                    <circle cx="8.5" cy="7" r="4"></circle>
                    <line x1="20" y1="8" x2="20" y2="14"></line>
                    <line x1="23" y1="11" x2="17" y2="11"></line>
                </svg>
                <span>Member Registration</span>
            </div>

            <h1 class="auth-title">Create Account</h1>
            <p class="auth-subtitle">Enter your details to register your member profile.</p>

            @if ($errors->any())
                <div class="auth-alert error">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>
                    <span>{{ $errors->first() }}</span>
                </div>
            @endif

            <form action="{{ route('register') }}" method="POST" id="registerForm" class="auth-form">
                @csrf

                <div class="form-group">
                    <label for="name" class="form-label">Full Name</label>
                    <div class="input-wrapper">
                        <span class="input-icon">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                        </span>
                        <input type="text" name="name" id="name" class="form-input" value="{{ old('name') }}" placeholder="Alex Mercer" required autofocus>
                    </div>
                </div>

                <div class="form-group">
                    <label for="email" class="form-label">Email Address</label>
                    <div class="input-wrapper">
                        <span class="input-icon">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
                        </span>
                        <input type="email" name="email" id="email" class="form-input" value="{{ old('email') }}" placeholder="name@example.com" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="password" class="form-label">Password</label>
                    <div class="input-wrapper">
                        <span class="input-icon">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                        </span>
                        <input type="password" name="password" id="password" class="form-input" placeholder="At least 8 characters" required>
                        <button type="button" class="password-toggle" onclick="togglePasswordVisibility('password', 'eyeIcon1')" title="Toggle visibility">
                            <svg id="eyeIcon1" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                        </button>
                    </div>
                </div>

                <div class="form-group">
                    <label for="password_confirmation" class="form-label">Confirm Password</label>
                    <div class="input-wrapper">
                        <span class="input-icon">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                        </span>
                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-input" placeholder="Repeat your password" required>
                        <button type="button" class="password-toggle" onclick="togglePasswordVisibility('password_confirmation', 'eyeIcon2')" title="Toggle visibility">
                            <svg id="eyeIcon2" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                        </button>
                    </div>
                </div>

                <button type="submit" class="submit-btn">
                    <span>Create Member Profile</span>
                    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
                </button>
            </form>

            <div class="auth-divider">
                <span>or register with</span>
            </div>

            <a href="{{ route('auth.google') }}" class="google-btn" id="googleSignInBtn" title="Register with Google">
                <svg class="google-icon" viewBox="0 0 24 24">
                    <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                    <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                    <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.06H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.94l2.85-2.22.81-.63z"/>
                    <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.06l3.66 2.84c.87-2.6 3.3-4.52 6.16-4.52z"/>
                </svg>
                <span>Continue with Google</span>
            </a>

            <div class="card-footer">
                <span>Already have an account?</span>
                <a href="{{ route('login') }}">Sign In →</a>
            </div>
        </div>
    </main>

    <footer class="page-footer">
        <div class="footer-item">
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
            <span>256-Bit SSL Encrypted Checkout</span>
        </div>
        <span>&bull;</span>
        <div class="footer-item">
            <span>© {{ date('Y') }} T-Shirt Online</span>
        </div>
    </footer>

    <script>
        function togglePasswordVisibility(fieldId, iconId) {
            const pwdInput = document.getElementById(fieldId);
            const eyeIcon = document.getElementById(iconId);
            if (pwdInput.type === 'password') {
                pwdInput.type = 'text';
                eyeIcon.innerHTML = '<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path><line x1="1" y1="1" x2="23" y2="23"></line>';
            } else {
                pwdInput.type = 'password';
                eyeIcon.innerHTML = '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle>';
            }
        }
    </script>
</body>
</html>