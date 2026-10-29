<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sign In — T-Shirt Online</title>

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
            --radius-input: 11px;
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
            padding: 16px 24px;
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
            width: 36px;
            height: 36px;
            border-radius: 10px;
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
            padding: 7px 16px;
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
            padding: 10px 20px;
            min-height: 0;
        }

        .auth-card-panel {
            max-width: 440px;
            width: 100%;
            background: var(--bg-card);
            border: 1.5px solid var(--border-card);
            border-radius: var(--radius-card);
            padding: 28px 32px;
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
            font-size: 0.7rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.7px;
            margin-bottom: 10px;
        }

        .security-badge svg {
            color: #2563eb;
        }

        .auth-title {
            font-size: 1.85rem;
            font-weight: 850;
            color: var(--text-heading);
            letter-spacing: -0.7px;
            line-height: 1.18;
            margin-bottom: 4px;
        }

        .auth-subtitle {
            color: var(--text-body);
            font-size: 0.88rem;
            line-height: 1.45;
            margin-bottom: 18px;
        }

        .auth-alert {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 9px 12px;
            border-radius: 10px;
            font-size: 0.84rem;
            margin-bottom: 14px;
            line-height: 1.4;
        }

        .auth-alert.info {
            background: #eff6ff;
            border: 1px solid #bfdbfe;
            color: #1e40af;
        }

        .auth-alert.cart {
            background: #ecfdf5;
            border: 1px solid #a7f3d0;
            color: #065f46;
        }

        .auth-alert.error {
            background: #fef2f2;
            border: 1px solid #fecaca;
            color: #b91c1c;
        }

        .auth-form {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        .label-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .form-label {
            font-size: 0.74rem;
            font-weight: 750;
            color: var(--text-label);
            letter-spacing: 0.3px;
            text-transform: uppercase;
        }

        .forgot-link {
            font-size: 0.78rem;
            font-weight: 700;
            color: var(--accent-blue);
            text-decoration: none;
            transition: all 0.15s ease;
            cursor: pointer;
            padding: 2px 4px;
            border-radius: 6px;
        }

        .forgot-link:hover {
            color: #1d4ed8;
            background: #eff6ff;
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
            height: 42px;
            background: var(--input-bg);
            border: 1.5px solid var(--border-input);
            border-radius: var(--radius-input);
            padding: 0 42px 0 42px;
            font-size: 0.9rem;
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

        .remember-wrap {
            display: flex;
            align-items: center;
            margin-top: 2px;
        }

        .checkbox-container {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            font-size: 0.82rem;
            font-weight: 600;
            color: var(--text-body);
            user-select: none;
        }

        .checkbox-container input[type="checkbox"] {
            width: 16px;
            height: 16px;
            accent-color: #2563eb;
            cursor: pointer;
        }

        .submit-btn {
            width: 100%;
            height: 44px;
            background: var(--primary);
            color: #ffffff;
            border: none;
            border-radius: var(--radius-full);
            font-size: 0.94rem;
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
            margin: 14px 0;
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
            height: 42px;
            background: #ffffff;
            color: #1e293b;
            border: 1.5px solid #cbd5e1;
            border-radius: var(--radius-full);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            font-size: 0.9rem;
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
            width: 18px;
            height: 18px;
            flex-shrink: 0;
        }

        .card-footer {
            text-align: center;
            margin-top: 14px;
            padding-top: 12px;
            border-top: 1px solid #f1f5f9;
            font-size: 0.84rem;
            color: var(--text-body);
        }

        .card-footer a {
            color: var(--text-heading);
            font-weight: 800;
            text-decoration: none;
            margin-left: 5px;
            transition: color 0.15s;
        }

        .card-footer a:hover {
            color: var(--accent-blue);
            text-decoration: underline;
        }

        /* -------------------------------------------------------------
           FORGOT PASSWORD MODAL STYLING
        ------------------------------------------------------------- */
        .modal-backdrop {
            position: fixed;
            inset: 0;
            width: 100vw;
            height: 100vh;
            background: rgba(15, 23, 42, 0.55);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            z-index: 9999;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            animation: modalFadeIn 0.25s cubic-bezier(0.16, 1, 0.3, 1);
        }

        @keyframes modalFadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .modal-dialog {
            position: relative;
            max-width: 440px;
            width: 100%;
            background: #ffffff;
            border: 1.5px solid #e2e8f0;
            border-radius: 22px;
            padding: 34px 30px;
            box-shadow: 0 25px 65px -12px rgba(15, 23, 42, 0.25), 0 4px 16px rgba(0, 0, 0, 0.04);
            text-align: center;
            animation: modalScaleUp 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        }

        @keyframes modalScaleUp {
            from { opacity: 0; transform: scale(0.94) translateY(12px); }
            to { opacity: 1; transform: scale(1) translateY(0); }
        }

        .modal-close-btn {
            position: absolute;
            top: 16px;
            right: 16px;
            width: 32px;
            height: 32px;
            border-radius: 50%;
            border: none;
            background: #f1f5f9;
            color: #64748b;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s;
        }

        .modal-close-btn:hover {
            background: #e2e8f0;
            color: #0f172a;
            transform: rotate(90deg);
        }

        .modal-icon-badge {
            width: 52px;
            height: 52px;
            border-radius: 16px;
            background: #eff6ff;
            border: 1px solid #dbeafe;
            color: #2563eb;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 16px;
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.12);
        }

        .modal-icon-badge.success {
            background: #ecfdf5;
            border-color: #a7f3d0;
            color: #059669;
            box-shadow: 0 4px 12px rgba(5, 150, 105, 0.15);
        }

        .modal-title {
            font-size: 1.45rem;
            font-weight: 850;
            color: #0f172a;
            letter-spacing: -0.5px;
            line-height: 1.25;
            margin-bottom: 6px;
        }

        .modal-desc {
            font-size: 0.88rem;
            color: #64748b;
            line-height: 1.5;
            margin-bottom: 18px;
        }

        .modal-support-box {
            margin-top: 20px;
            padding-top: 16px;
            border-top: 1px solid #f1f5f9;
            font-size: 0.76rem;
            color: #64748b;
        }

        .support-title {
            display: block;
            font-weight: 600;
            margin-bottom: 6px;
            color: #475569;
        }

        .support-links-row {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            flex-wrap: wrap;
            font-size: 0.78rem;
        }

        .support-item-link {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            color: #2563eb;
            text-decoration: none;
            font-weight: 700;
            transition: color 0.15s;
        }

        .support-item-link:hover {
            color: #1d4ed8;
            text-decoration: underline;
        }

        /* -------------------------------------------------------------
           PAGE FOOTER (Compact)
        ------------------------------------------------------------- */
        .page-footer {
            position: relative;
            z-index: 10;
            text-align: center;
            padding: 12px 20px;
            font-size: 0.76rem;
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
                    <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                    <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                </svg>
                <span>Secure Authentication</span>
            </div>

            <h1 class="auth-title">Welcome Back</h1>
            <p class="auth-subtitle">Sign in to complete your checkout and manage orders.</p>

            <!-- Notifications -->
            @if (session('info'))
                <div class="auth-alert info">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg>
                    <span>{{ session('info') }}</span>
                </div>
            @elseif (count(session('cart', [])) > 0)
                <div class="auth-alert cart">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path><line x1="3" y1="6" x2="21" y2="6"></line><path d="M16 10a4 4 0 0 1-8 0"></path></svg>
                    <span><strong>Your Bag is Saved:</strong> Sign in to proceed straight to Checkout!</span>
                </div>
            @endif

            @if ($errors->any())
                <div class="auth-alert error">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>
                    <span>{{ $errors->first() }}</span>
                </div>
            @endif

            <!-- Form -->
            <form action="{{ route('login') }}" method="POST" id="loginForm" class="auth-form">
                @csrf

                <div class="form-group">
                    <label for="email" class="form-label">Email Address</label>
                    <div class="input-wrapper">
                        <span class="input-icon">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
                        </span>
                        <input type="email" name="email" id="email" class="form-input" value="{{ old('email') }}" placeholder="name@example.com" required autofocus>
                    </div>
                </div>

                <div class="form-group">
                    <div class="label-row">
                        <label for="password" class="form-label">Password</label>
                        <a href="javascript:void(0)" onclick="openForgotPasswordModal()" class="forgot-link">Forgot password?</a>
                    </div>
                    <div class="input-wrapper">
                        <span class="input-icon">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                        </span>
                        <input type="password" name="password" id="password" class="form-input" placeholder="••••••••" required>
                        <button type="button" class="password-toggle" onclick="togglePasswordVisibility()" title="Toggle visibility">
                            <svg id="eyeIcon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                        </button>
                    </div>
                </div>

                <div class="remember-wrap">
                    <label class="checkbox-container">
                        <input type="checkbox" name="remember" id="remember" checked>
                        <span>Remember me for 30 days</span>
                    </label>
                </div>

                <button type="submit" class="submit-btn">
                    <span>Sign In to Continue</span>
                    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
                </button>
            </form>

            <div class="auth-divider">
                <span>or continue with</span>
            </div>

            <!-- Google Sign-In -->
            <a href="{{ route('auth.google') }}" class="google-btn" id="googleSignInBtn" title="Continue with Google">
                <svg class="google-icon" viewBox="0 0 24 24">
                    <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                    <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                    <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.06H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.94l2.85-2.22.81-.63z"/>
                    <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.06l3.66 2.84c.87-2.6 3.3-4.52 6.16-4.52z"/>
                </svg>
                <span>Continue with Google</span>
            </a>

            <div class="card-footer">
                <span>Don't have an account yet?</span>
                <a href="{{ route('register') }}">Create Account →</a>
            </div>
        </div>
    </main>

    <!-- Page Footer (Compact) -->
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

    <!-- Forgot Password Modal -->
    <div id="forgotPasswordModal" class="modal-backdrop" style="display: none;" onclick="handleBackdropClick(event)">
        <div class="modal-dialog">
            <button type="button" class="modal-close-btn" onclick="closeForgotPasswordModal()" title="Close">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="18" y1="6" x2="6" y2="18"></line>
                    <line x1="6" y1="6" x2="18" y2="18"></line>
                </svg>
            </button>

            <div id="forgotModalFormState">
                <div class="modal-icon-badge">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                        <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                        <circle cx="12" cy="16" r="1"></circle>
                    </svg>
                </div>

                <h2 class="modal-title">Reset Your Password</h2>
                <p class="modal-desc">Enter your registered email address and we'll send you instructions to recover your account.</p>

                <form id="forgotPasswordForm" onsubmit="handleForgotPasswordSubmit(event)">
                    <div class="form-group" style="text-align: left; margin-bottom: 16px;">
                        <label for="resetEmail" class="form-label">Email Address</label>
                        <div class="input-wrapper">
                            <span class="input-icon">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
                            </span>
                            <input type="email" id="resetEmail" class="form-input" placeholder="name@example.com" required>
                        </div>
                    </div>

                    <button type="submit" class="submit-btn" id="sendResetBtn" style="margin-top: 0;">
                        <span>Send Reset Instructions</span>
                        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
                    </button>
                </form>

                <div class="modal-support-box">
                    <span class="support-title">Need direct customer support?</span>
                    <div class="support-links-row">
                        <a href="mailto:support@tshirtonline.store" class="support-item-link">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
                            <span>support@tshirtonline.store</span>
                        </a>
                        <span>&bull;</span>
                        <a href="tel:+85512345678" class="support-item-link">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
                            <span>+855 (0) 12 345 678</span>
                        </a>
                    </div>
                </div>
            </div>

            <div id="forgotModalSuccessState" style="display: none;">
                <div class="modal-icon-badge success">
                    <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="20 6 9 17 4 12"></polyline>
                    </svg>
                </div>

                <h2 class="modal-title">Instructions Sent!</h2>
                <p class="modal-desc">
                    If an account exists for <strong id="successTargetEmail" style="color:#0f172a;"></strong>, you will receive an email with instructions to reset your password shortly.
                </p>

                <div class="auth-alert info" style="text-align: left; margin: 16px 0; font-size: 0.82rem;">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg>
                    <span>Please be sure to check your <strong>Spam</strong> or <strong>Junk</strong> folder if you do not see it in your Inbox.</span>
                </div>

                <button type="button" class="submit-btn" onclick="closeForgotPasswordModal()">
                    <span>Back to Sign In</span>
                </button>
            </div>
        </div>
    </div>

    <script>
        function togglePasswordVisibility() {
            const pwdInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eyeIcon');
            if (pwdInput.type === 'password') {
                pwdInput.type = 'text';
                eyeIcon.innerHTML = '<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path><line x1="1" y1="1" x2="23" y2="23"></line>';
            } else {
                pwdInput.type = 'password';
                eyeIcon.innerHTML = '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle>';
            }
        }

        function openForgotPasswordModal() {
            const modal = document.getElementById('forgotPasswordModal');
            const resetEmailInput = document.getElementById('resetEmail');
            const currentLoginEmail = document.getElementById('email').value.trim();

            document.getElementById('forgotModalFormState').style.display = 'block';
            document.getElementById('forgotModalSuccessState').style.display = 'none';

            if (currentLoginEmail) {
                resetEmailInput.value = currentLoginEmail;
            }

            modal.style.display = 'flex';
            document.body.style.overflow = 'hidden';

            setTimeout(() => {
                resetEmailInput.focus();
            }, 100);
        }

        function closeForgotPasswordModal() {
            const modal = document.getElementById('forgotPasswordModal');
            modal.style.display = 'none';
        }

        function handleBackdropClick(event) {
            if (event.target === document.getElementById('forgotPasswordModal')) {
                closeForgotPasswordModal();
            }
        }

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeForgotPasswordModal();
            }
        });

        function handleForgotPasswordSubmit(e) {
            e.preventDefault();
            const email = document.getElementById('resetEmail').value.trim();
            const btn = document.getElementById('sendResetBtn');

            if (!email) return;

            btn.disabled = true;
            btn.innerHTML = '<span>Sending instructions...</span>';

            setTimeout(() => {
                btn.disabled = false;
                btn.innerHTML = '<span>Send Reset Instructions</span><svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>';

                document.getElementById('successTargetEmail').textContent = email;
                document.getElementById('forgotModalFormState').style.display = 'none';
                document.getElementById('forgotModalSuccessState').style.display = 'block';
            }, 500);
        }
    </script>
</body>
</html>