<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sign In — THREADCRAFT</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <style>
        :root {
            --bg-primary: #0b0f19;
            --bg-card: #ffffff;
            --text-main: #0f172a;
            --text-muted: #64748b;
            --text-sub: #475569;
            --border-subtle: #e2e8f0;
            --radius-sm: 10px;
            --radius-md: 14px;
            --radius-lg: 24px;
            --radius-full: 9999px;
            --primary: #0f172a;
            --accent-blue: #2563eb;
            --accent-indigo: #4f46e5;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, sans-serif;
        }

        html, body {
            min-height: 100vh;
            background-color: #f8fafc;
            color: var(--text-main);
            overflow-x: hidden;
        }

        /* -------------------------------------------------------------
           SPLIT SCREEN ARCHITECTURE
        ------------------------------------------------------------- */
        .auth-split-layout {
            display: flex;
            min-height: 100vh;
            width: 100vw;
        }

        /* LEFT COLUMN: High-Fashion Visual & Brand Prestige */
        .auth-visual-pane {
            flex: 1.1;
            position: relative;
            background-color: #0b0f19;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 48px;
            color: #ffffff;
        }

        .visual-bg-media {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
            opacity: 0.65;
            transform: scale(1.03);
            transition: transform 8s ease-out;
        }

        .auth-visual-pane:hover .visual-bg-media {
            transform: scale(1.08);
        }

        .visual-scrim-gradient {
            position: absolute;
            inset: 0;
            background: linear-gradient(
                180deg,
                rgba(11, 15, 25, 0.75) 0%,
                rgba(11, 15, 25, 0.4) 40%,
                rgba(11, 15, 25, 0.95) 100%
            );
            pointer-events: none;
        }

        .visual-ambient-blur {
            position: absolute;
            top: 20%;
            left: 20%;
            width: 380px;
            height: 380px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(99, 102, 241, 0.3) 0%, transparent 70%);
            filter: blur(60px);
            pointer-events: none;
        }

        /* Top Brand Link on Image */
        .visual-top-bar {
            position: relative;
            z-index: 2;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .visual-brand {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
            color: #ffffff;
        }

        .visual-brand-icon {
            width: 42px;
            height: 42px;
            border-radius: 12px;
            background: linear-gradient(135deg, #2563eb 0%, #4f46e5 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 16px rgba(37, 99, 235, 0.4);
        }

        .visual-brand-title {
            font-size: 1.35rem;
            font-weight: 850;
            letter-spacing: -0.5px;
            color: #ffffff;
        }

        .visual-brand-title span {
            color: #60a5fa;
        }

        .visual-edition-chip {
            background: rgba(255, 255, 255, 0.12);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: #e2e8f0;
            padding: 6px 14px;
            border-radius: var(--radius-full);
            font-size: 0.72rem;
            font-weight: 800;
            letter-spacing: 0.8px;
            text-transform: uppercase;
        }

        /* Bottom Luxury Card / Testimonial Over Image */
        .visual-content-card {
            position: relative;
            z-index: 2;
            background: rgba(15, 23, 42, 0.85);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            border: 1px solid rgba(255, 255, 255, 0.16);
            border-radius: var(--radius-lg);
            padding: 32px;
            box-shadow: 0 25px 60px rgba(0, 0, 0, 0.4);
            max-width: 580px;
        }

        .spotlight-top-pill {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            background: rgba(37, 99, 235, 0.25);
            border: 1px solid rgba(96, 165, 250, 0.4);
            color: #93c5fd;
            padding: 4px 12px;
            border-radius: var(--radius-full);
            font-size: 0.72rem;
            font-weight: 800;
            letter-spacing: 0.8px;
            text-transform: uppercase;
            margin-bottom: 14px;
        }

        .spotlight-dot-pulse {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background: #38bdf8;
            box-shadow: 0 0 10px #38bdf8;
            animation: pulseDot 2s infinite;
        }

        @keyframes pulseDot {
            0%, 100% { opacity: 1; transform: scale(1); }
            50% { opacity: 0.4; transform: scale(0.85); }
        }

        .spotlight-headline {
            font-size: 1.85rem;
            font-weight: 850;
            line-height: 1.25;
            letter-spacing: -0.5px;
            margin-bottom: 12px;
            color: #ffffff;
        }

        .spotlight-desc {
            color: #cbd5e1;
            font-size: 0.95rem;
            line-height: 1.6;
            margin-bottom: 22px;
        }

        .spotlight-testimonial-box {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 14px;
            padding: 16px 18px;
            margin-bottom: 20px;
        }

        .testimonial-quote {
            font-size: 0.88rem;
            color: #e2e8f0;
            font-style: italic;
            line-height: 1.5;
            margin-bottom: 12px;
        }

        .testimonial-user-row {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .avatar-group-wrap {
            display: flex;
            align-items: center;
        }

        .avatar-img-circle {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            border: 2px solid #0f172a;
            object-fit: cover;
            margin-left: -8px;
        }

        .avatar-img-circle:first-child {
            margin-left: 0;
        }

        .testimonial-meta {
            font-size: 0.78rem;
            color: #94a3b8;
        }

        .testimonial-meta strong {
            color: #ffffff;
        }

        .spotlight-trust-strip {
            display: flex;
            align-items: center;
            gap: 14px;
            font-size: 0.78rem;
            color: #94a3b8;
            font-weight: 600;
            flex-wrap: wrap;
        }

        .spotlight-trust-strip span {
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }

        /* RIGHT COLUMN: The Luxury Authentication Workspace */
        .auth-form-pane {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 32px 48px;
            background: #ffffff;
            position: relative;
        }

        .form-pane-nav {
            display: flex;
            align-items: center;
            justify-content: space-between;
            width: 100%;
        }

        .form-mobile-logo {
            display: none;
            align-items: center;
            gap: 10px;
            text-decoration: none;
            color: #0f172a;
        }

        .back-to-store-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: #475569;
            text-decoration: none;
            font-size: 0.86rem;
            font-weight: 700;
            padding: 8px 16px;
            border-radius: var(--radius-full);
            border: 1px solid #e2e8f0;
            background: #ffffff;
            transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
            margin-left: auto;
        }

        .back-to-store-btn:hover {
            color: #0f172a;
            background: #f8fafc;
            border-color: #cbd5e1;
            transform: translateX(-2px);
        }

        /* Centered Form Wrapper */
        .form-center-wrapper {
            max-width: 440px;
            width: 100%;
            margin: auto;
            padding: 24px 0;
            animation: formFadeUp 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        }

        @keyframes formFadeUp {
            from { opacity: 0; transform: translateY(16px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .form-badge-pill {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 4px 12px;
            border-radius: var(--radius-full);
            background: #f1f5f9;
            border: 1px solid #e2e8f0;
            color: #334155;
            font-size: 0.72rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            margin-bottom: 12px;
        }

        .auth-heading {
            font-size: 2rem;
            font-weight: 850;
            color: #0f172a;
            letter-spacing: -0.8px;
            line-height: 1.2;
            margin-bottom: 6px;
        }

        .auth-subheading {
            color: #64748b;
            font-size: 0.9rem;
            line-height: 1.5;
            margin-bottom: 20px;
        }

        /* Alerts & Info Banners */
        .auth-notice-card {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 14px;
            border-radius: 12px;
            font-size: 0.82rem;
            margin-bottom: 16px;
            line-height: 1.4;
        }

        .auth-notice-card.info {
            background: #eff6ff;
            border: 1px solid #bfdbfe;
            color: #1e40af;
        }

        .auth-notice-card.cart {
            background: #ecfdf5;
            border: 1px solid #a7f3d0;
            color: #065f46;
        }

        .auth-notice-card.error {
            background: #fef2f2;
            border: 1px solid #fecaca;
            color: #b91c1c;
        }


        /* Form Inputs */
        .auth-form {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .input-group {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .input-label-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .input-label {
            font-size: 0.82rem;
            font-weight: 700;
            color: #334155;
            letter-spacing: 0.2px;
        }

        .forgot-pass-link {
            font-size: 0.78rem;
            font-weight: 600;
            color: #2563eb;
            text-decoration: none;
        }

        .forgot-pass-link:hover {
            text-decoration: underline;
        }

        .input-shell {
            position: relative;
            display: flex;
            align-items: center;
        }

        .input-lead-icon {
            position: absolute;
            left: 14px;
            color: #94a3b8;
            display: flex;
            align-items: center;
            pointer-events: none;
            transition: color 0.2s;
        }

        .text-input-field {
            width: 100%;
            height: 46px;
            background: #ffffff;
            border: 1.5px solid #e2e8f0;
            border-radius: var(--radius-sm);
            padding: 0 42px 0 42px;
            font-size: 0.92rem;
            color: #0f172a;
            font-weight: 500;
            outline: none;
            transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .text-input-field:focus {
            border-color: #0f172a;
            box-shadow: 0 0 0 3px rgba(15, 23, 42, 0.1);
        }

        .input-shell:focus-within .input-lead-icon {
            color: #0f172a;
        }

        .password-toggle-btn {
            position: absolute;
            right: 12px;
            background: none;
            border: none;
            color: #94a3b8;
            cursor: pointer;
            padding: 4px;
            display: flex;
            align-items: center;
            transition: color 0.2s;
        }

        .password-toggle-btn:hover {
            color: #0f172a;
        }

        /* Checkbox */
        .remember-row {
            display: flex;
            align-items: center;
            margin-top: -4px;
        }

        .checkbox-label {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            font-size: 0.82rem;
            font-weight: 600;
            color: #475569;
            user-select: none;
        }

        .checkbox-label input {
            accent-color: #0f172a;
            width: 16px;
            height: 16px;
            cursor: pointer;
        }

        /* Main Submit Button */
        .submit-auth-btn {
            width: 100%;
            height: 48px;
            background: #0f172a;
            color: #ffffff;
            border: none;
            border-radius: var(--radius-full);
            font-size: 0.96rem;
            font-weight: 750;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            margin-top: 6px;
            box-shadow: 0 4px 18px rgba(15, 23, 42, 0.2);
            transition: all 0.22s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .submit-auth-btn:hover {
            background: #000000;
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(15, 23, 42, 0.3);
        }

        .submit-auth-btn:active {
            transform: translateY(0);
        }

        /* Divider */
        .auth-divider-line {
            display: flex;
            align-items: center;
            margin: 20px 0;
            color: #94a3b8;
            font-size: 0.74rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.8px;
        }

        .auth-divider-line::before,
        .auth-divider-line::after {
            content: '';
            flex: 1;
            height: 1px;
            background: #e2e8f0;
        }

        .auth-divider-line span {
            padding: 0 12px;
        }

        /* Google Continue Button */
        .google-continue-btn {
            width: 100%;
            height: 46px;
            background: #ffffff;
            color: #1f2937;
            border: 1.5px solid #cbd5e1;
            border-radius: var(--radius-full);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            font-size: 0.92rem;
            font-weight: 700;
            text-decoration: none;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .google-continue-btn:hover {
            background: #f8fafc;
            border-color: #94a3b8;
            box-shadow: 0 4px 14px rgba(0, 0, 0, 0.08);
            transform: translateY(-1px);
        }

        .google-continue-btn:active {
            transform: translateY(0);
        }

        .google-g-icon {
            width: 20px;
            height: 20px;
            flex-shrink: 0;
        }

        /* Footer Link */
        .auth-card-footer-note {
            text-align: center;
            margin-top: 24px;
            padding-top: 18px;
            border-top: 1px solid #f1f5f9;
            font-size: 0.86rem;
            color: #64748b;
        }

        .auth-card-footer-note a {
            color: #0f172a;
            font-weight: 750;
            text-decoration: none;
            margin-left: 4px;
            transition: color 0.15s;
        }

        .auth-card-footer-note a:hover {
            color: #2563eb;
            text-decoration: underline;
        }

        /* Bottom Security Bar */
        .form-pane-bottom {
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-size: 0.74rem;
            color: #94a3b8;
            padding-top: 16px;
        }

        /* -------------------------------------------------------------
           RESPONSIVE BREAKPOINTS
        ------------------------------------------------------------- */
        @media (max-width: 1024px) {
            .auth-visual-pane {
                display: none;
            }
            .auth-form-pane {
                padding: 24px;
            }
            .form-mobile-logo {
                display: inline-flex;
            }
        }
    </style>
</head>
<body>

    <div class="auth-split-layout">
        <!-- 1. LEFT PANE: High-End Fashion Visual Showcase -->
        <aside class="auth-visual-pane">
            <img src="{{ asset('/images/hero-editorial.jpg') }}" alt="THREADCRAFT Luxury Streetwear" class="visual-bg-media">
            <div class="visual-scrim-gradient"></div>
            <div class="visual-ambient-blur"></div>

            <!-- Top Brand -->
            <div class="visual-top-bar">
                <a href="{{ route('home') }}" class="visual-brand">
                    <span class="visual-brand-icon">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M20.38 3.46L16 2a4 4 0 0 1-8 0L3.62 3.46a2 2 0 0 0-1.34 2.23l.58 3.47a1 1 0 0 0 .99.84H6v10a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V10h2.15a1 1 0 0 0 .99-.84l.58-3.47a2 2 0 0 0-1.34-2.23z" fill="rgba(255,255,255,0.2)"/>
                        </svg>
                    </span>
                    <span class="visual-brand-title">THREADCRAFT<span>•</span></span>
                </a>
                <span class="visual-edition-chip">ARCHIVAL STREETWEAR • 2026</span>
            </div>

            <!-- Bottom Spotlight Glass Card -->
            <div class="visual-content-card">
                <div class="spotlight-top-pill">
                    <span class="spotlight-dot-pulse"></span>
                    <span>SPRING / SUMMER ARCHIVE</span>
                </div>
                <h2 class="spotlight-headline">Architectural Streetwear.<br>Engineered for Life.</h2>
                <p class="spotlight-subtext">240 GSM organic combed cotton, relaxed tailored cuts, and archival screen prints designed for everyday modern luxury.</p>

                <div class="spotlight-testimonial-box">
                    <p class="testimonial-quote">"The collar stays crisp and the fabric has that substantial 240 GSM weight without feeling hot. Best tee in my rotation."</p>
                    <div class="testimonial-user-row">
                        <div class="avatar-group-wrap">
                            <img src="{{ asset('/images/products/tee-cyberpunk.jpg') }}" alt="User" class="avatar-img-circle">
                            <img src="{{ asset('/images/products/tee-cream.jpg') }}" alt="User" class="avatar-img-circle">
                            <img src="{{ asset('/images/products/tee-sage.jpg') }}" alt="User" class="avatar-img-circle">
                        </div>
                        <div class="testimonial-meta">
                            <strong>Marcus K.</strong> &bull; Verified Buyer &bull; ★★★★★ 5.0
                        </div>
                    </div>
                </div>

                <div class="spotlight-trust-strip">
                    <span>⚡ Ships in 24h</span>
                    <span>&bull;</span>
                    <span>🌿 100% Organic GOTS</span>
                    <span>&bull;</span>
                    <span>🔁 30-Day Free Returns</span>
                </div>
            </div>
        </aside>

        <!-- 2. RIGHT PANE: Modern Luxury Auth Workspace -->
        <main class="auth-form-pane">
            <!-- Header bar -->
            <div class="form-pane-nav">
                <a href="{{ route('home') }}" class="form-mobile-logo">
                    <span style="font-size:1.25rem; font-weight:850; color:#0f172a;">THREADCRAFT<span style="color:#2563eb;">•</span></span>
                </a>
                <a href="{{ route('shop.index') }}" class="back-to-store-btn">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                    <span>Back to Store</span>
                </a>
            </div>

            <!-- Centered Card -->
            <div class="form-center-wrapper">
                <div class="form-badge-pill">
                    <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M12 15v2m-6 4h12a2 2 0 0 0 2-2v-6a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2zm10-10V7a4 4 0 0 0-8 0v4h8z"/></svg>
                    <span>Secure Authentication</span>
                </div>

                <h1 class="auth-heading">Welcome Back</h1>
                <p class="auth-subheading">Sign in to complete your checkout and manage orders.</p>

                <!-- Notifications -->
                @if (session('info'))
                    <div class="auth-notice-card info">
                        <span style="font-size:1.1rem;">🔒</span>
                        <span>{{ session('info') }}</span>
                    </div>
                @elseif (count(session('cart', [])) > 0)
                    <div class="auth-notice-card cart">
                        <span style="font-size:1.1rem;">🛍️</span>
                        <span><strong>Your Bag is Saved:</strong> Sign in to proceed straight to Checkout!</span>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="auth-notice-card error">
                        <span style="font-size:1rem;">✕</span>
                        <span>{{ $errors->first() }}</span>
                    </div>
                @endif


                <!-- Form -->
                <form action="{{ route('login') }}" method="POST" id="loginForm" class="auth-form">
                    @csrf

                    <div class="input-group">
                        <label for="email" class="input-label">Email Address</label>
                        <div class="input-shell">
                            <span class="input-lead-icon">
                                <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
                            </span>
                            <input type="email" name="email" id="email" class="text-input-field" value="{{ old('email') }}" placeholder="name@example.com" required autofocus>
                        </div>
                    </div>

                    <div class="input-group">
                        <div class="input-label-row">
                            <label for="password" class="input-label">Password</label>
                            <a href="javascript:void(0)" onclick="alert('Please contact support to reset your password.')" class="forgot-pass-link">Forgot password?</a>
                        </div>
                        <div class="input-shell">
                            <span class="input-lead-icon">
                                <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                            </span>
                            <input type="password" name="password" id="password" class="text-input-field" placeholder="••••••••" required>
                            <button type="button" class="password-toggle-btn" onclick="togglePasswordVisibility()" title="Toggle visibility">
                                <svg id="eyeIcon" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                            </button>
                        </div>
                    </div>

                    <div class="remember-row">
                        <label class="checkbox-label">
                            <input type="checkbox" name="remember" id="remember" checked>
                            <span>Remember me for 30 days</span>
                        </label>
                    </div>

                    <button type="submit" class="submit-auth-btn">
                        <span>Sign In to Continue</span>
                        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
                    </button>
                </form>

                <div class="auth-divider-line">
                    <span>or continue with</span>
                </div>

                <!-- Google Sign-In -->
                <a href="{{ route('auth.google') }}" class="google-continue-btn" id="googleSignInBtn" title="Continue with Google">
                    <svg class="google-g-icon" viewBox="0 0 24 24">
                        <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                        <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                        <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.06H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.94l2.85-2.22.81-.63z"/>
                        <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.06l3.66 2.84c.87-2.6 3.3-4.52 6.16-4.52z"/>
                    </svg>
                    <span>Continue with Google</span>
                </a>

                <div class="auth-card-footer-note">
                    <span>Don't have an account yet?</span>
                    <a href="{{ route('register') }}">Create Account →</a>
                </div>
            </div>

            <!-- Bottom trust line -->
            <div class="form-pane-bottom">
                <span>🔒 256-Bit SSL Encrypted Checkout</span>
                <span>© 2026 THREADCRAFT</span>
            </div>
        </main>
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

    </script>
</body>
</html>