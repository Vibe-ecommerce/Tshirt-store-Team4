@extends('layouts.admin')

@section('title', 'Admin Account & Security')
@section('page-title', 'Admin Account & Security')

@section('styles')
<style>
    /* ==========================================================================
       HERO BANNER - Bento Identity Card
       ========================================================================== */
    .admin-hero-card {
        background: linear-gradient(135deg, #1e1b4b 0%, #0f172a 60%, #0b1329 100%);
        border: 1.5px solid rgba(255, 255, 255, 0.12);
        border-radius: var(--radius-lg);
        padding: 30px 32px;
        margin-bottom: 28px;
        position: relative;
        overflow: hidden;
        box-shadow: 0 10px 25px -5px rgba(15, 23, 42, 0.3), 0 0 25px rgba(79, 70, 229, 0.12);
    }

    .admin-hero-card::before {
        content: '';
        position: absolute;
        top: -100px;
        right: -80px;
        width: 320px;
        height: 320px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(99, 102, 241, 0.25) 0%, rgba(168, 85, 247, 0.1) 50%, transparent 70%);
        pointer-events: none;
    }

    .hero-flex-wrap {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 24px;
        flex-wrap: wrap;
        position: relative;
        z-index: 1;
    }

    .hero-identity-left {
        display: flex;
        align-items: center;
        gap: 22px;
    }

    .hero-avatar-box {
        position: relative;
        width: 86px;
        height: 86px;
        border-radius: 22px;
        padding: 3px;
        background: linear-gradient(135deg, #6366f1 0%, #a855f7 50%, #ec4899 100%);
        box-shadow: 0 8px 24px rgba(99, 102, 241, 0.4);
        flex-shrink: 0;
    }

    .hero-avatar-inner {
        width: 100%;
        height: 100%;
        border-radius: 19px;
        background: #0f172a;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .hero-avatar-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .hero-avatar-initials {
        font-size: 2.2rem;
        font-weight: 900;
        color: #ffffff;
        background: linear-gradient(135deg, #818cf8 0%, #c084fc 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .hero-name {
        font-size: 1.75rem;
        font-weight: 850;
        color: #ffffff;
        letter-spacing: -0.4px;
        display: flex;
        align-items: center;
        gap: 10px;
        line-height: 1.2;
    }

    .hero-role-pill {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: #7e22ce;
        border: 1px solid #a855f7;
        color: #ffffff;
        font-size: 0.76rem;
        font-weight: 800;
        padding: 4px 12px;
        border-radius: var(--radius-full);
        text-transform: uppercase;
        letter-spacing: 0.6px;
        box-shadow: 0 2px 6px rgba(126, 34, 206, 0.35);
    }

    .hero-meta-row {
        display: flex;
        align-items: center;
        gap: 16px;
        margin-top: 8px;
        flex-wrap: wrap;
        font-size: 0.88rem;
    }

    .hero-meta-item {
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .hero-metrics-right {
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
    }

    .stat-mini-pill {
        background: rgba(255, 255, 255, 0.08);
        border: 1px solid rgba(255, 255, 255, 0.15);
        border-radius: 14px;
        padding: 12px 18px;
        display: flex;
        flex-direction: column;
        gap: 3px;
        min-width: 140px;
        backdrop-filter: blur(8px);
    }

    .stat-mini-label {
        font-size: 0.72rem;
        font-weight: 800;
        color: #94a3b8;
        text-transform: uppercase;
        letter-spacing: 0.6px;
    }

    .stat-mini-value {
        font-size: 0.98rem;
        font-weight: 850;
        color: #ffffff;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    /* ==========================================================================
       TWO-COLUMN DASHBOARD GRID
       ========================================================================== */
    .admin-forms-grid {
        display: grid;
        grid-template-columns: 1.2fr 1.15fr;
        gap: 24px;
        align-items: start;
        margin-bottom: 28px;
    }

    @media (max-width: 1024px) {
        .admin-forms-grid {
            grid-template-columns: 1fr;
        }
    }

    .form-panel-card {
        background: #ffffff;
        border: 1.5px solid #e2e8f0;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04), 0 6px 18px rgba(0, 0, 0, 0.02);
    }

    .panel-card-header {
        padding: 18px 24px;
        border-bottom: 1.5px solid #e2e8f0;
        background: #f8fafc;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .panel-header-title {
        font-size: 1.12rem;
        font-weight: 850;
        color: #0f172a;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .panel-header-sub {
        font-size: 0.84rem;
        color: #475569;
        font-weight: 500;
        margin-top: 3px;
    }

    .panel-card-body {
        padding: 24px 26px;
    }

    /* Avatar Upload Preview Box */
    .avatar-upload-zone {
        display: flex;
        align-items: center;
        gap: 20px;
        background: #f8fafc;
        border: 1.5px dashed #cbd5e1;
        border-radius: var(--radius-md);
        padding: 18px;
        margin-bottom: 22px;
        transition: all 0.2s ease;
    }

    .avatar-upload-zone:hover {
        border-color: #4f46e5;
        background: #f1f5f9;
    }

    .avatar-preview-circle {
        width: 68px;
        height: 68px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid #cbd5e1;
        background: #ffffff;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    }

    /* Form Inputs */
    .input-field-group {
        margin-bottom: 18px;
    }

    .input-label {
        display: block;
        font-size: 0.8rem;
        font-weight: 800;
        color: #334155;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 7px;
    }

    .input-with-icon {
        position: relative;
        display: flex;
        align-items: center;
    }

    .field-icon {
        position: absolute;
        left: 14px;
        color: #64748b;
        pointer-events: none;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .admin-input {
        width: 100%;
        background: #ffffff;
        border: 1.5px solid #cbd5e1;
        color: #0f172a;
        font-weight: 650;
        padding: 12px 14px 12px 42px;
        border-radius: 10px;
        font-size: 0.92rem;
        outline: none;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.04);
        transition: all 0.2s ease;
    }

    .admin-input:focus {
        border-color: #4f46e5;
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.15);
        background: #ffffff;
    }

    .password-toggle-btn {
        position: absolute;
        right: 12px;
        background: none;
        border: none;
        color: #64748b;
        cursor: pointer;
        padding: 4px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: color 0.2s;
    }

    .password-toggle-btn:hover {
        color: #0f172a;
    }

    /* Password Strength Meter */
    .strength-meter-wrap {
        margin-top: 8px;
    }

    .strength-bars-track {
        display: flex;
        gap: 5px;
        height: 6px;
        margin-bottom: 6px;
    }

    .strength-bar-seg {
        flex: 1;
        height: 100%;
        border-radius: 3px;
        background: #e2e8f0;
        transition: background 0.25s ease;
    }

    .strength-text {
        font-size: 0.78rem;
        font-weight: 700;
        color: #475569;
        display: flex;
        justify-content: space-between;
    }

    /* Buttons */
    .btn-executive-save {
        width: 100%;
        background: var(--accent-gradient);
        color: #ffffff;
        border: none;
        padding: 13px 22px;
        border-radius: 10px;
        font-size: 0.92rem;
        font-weight: 800;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        box-shadow: 0 4px 14px rgba(79, 70, 229, 0.35);
        transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
    }

    .btn-executive-save:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(79, 70, 229, 0.5);
    }

    .btn-executive-pwd {
        width: 100%;
        background: linear-gradient(135deg, #0284c7 0%, #2563eb 100%);
        color: #ffffff;
        border: none;
        padding: 13px 22px;
        border-radius: 10px;
        font-size: 0.92rem;
        font-weight: 800;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        box-shadow: 0 4px 14px rgba(2, 132, 199, 0.35);
        transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
    }

    .btn-executive-pwd:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(2, 132, 199, 0.5);
    }

    /* Security Notice Box */
    .security-notice-callout {
        background: #f0f9ff;
        border: 1.5px solid #bae6fd;
        border-radius: var(--radius-md);
        padding: 14px 16px;
        font-size: 0.85rem;
        color: #0369a1;
        line-height: 1.5;
        margin-bottom: 20px;
        display: flex;
        align-items: flex-start;
        gap: 10px;
    }

    /* ==========================================================================
       BOTTOM TELEMETRY CARDS (Security Specs)
       ========================================================================== */
    .telemetry-cards-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 20px;
    }

    @media (max-width: 900px) {
        .telemetry-cards-grid {
            grid-template-columns: 1fr;
        }
    }

    .telemetry-card {
        background: #ffffff;
        border: 1.5px solid #e2e8f0;
        border-radius: 14px;
        padding: 20px 22px;
        display: flex;
        flex-direction: column;
        gap: 8px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04), 0 4px 12px rgba(0, 0, 0, 0.02);
    }

    .telemetry-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        font-size: 0.8rem;
        font-weight: 800;
        text-transform: uppercase;
        color: #334155;
        letter-spacing: 0.5px;
    }

    .telemetry-main {
        font-size: 1.15rem;
        font-weight: 850;
        color: #0f172a;
    }

    .telemetry-desc {
        font-size: 0.82rem;
        color: #475569;
        font-weight: 500;
        line-height: 1.5;
    }
</style>
@endsection

@section('content')

    <!-- 1. HERO IDENTITY BENTO BANNER -->
    <div class="admin-hero-card">
        <div class="hero-flex-wrap">
            <div class="hero-identity-left">
                <div class="hero-avatar-box">
                    <div class="hero-avatar-inner">
                        @if ($admin->avatar)
                            <img src="{{ asset($admin->avatar) }}" alt="{{ $admin->name }}" class="hero-avatar-img" id="heroAvatarDisplay">
                        @else
                            <span class="hero-avatar-initials" id="heroAvatarDisplay">{{ strtoupper(substr($admin->name, 0, 1)) }}</span>
                        @endif
                    </div>
                </div>

                <div>
                    <div class="hero-name">
                        <span>{{ $admin->name }}</span>
                        <span class="hero-role-pill">👑 Super Admin</span>
                    </div>

                    <div class="hero-meta-row">
                        <div class="hero-meta-item">
                            <span>✉️</span>
                            <span style="font-family:ui-monospace,SFMono-Regular,Consolas,monospace; font-weight:700; color:#e2e8f0;">{{ $admin->email }}</span>
                        </div>
                        <div class="hero-meta-item">
                            <span style="color:#4ade80;">●</span>
                            <span style="color:#4ade80; font-weight:750;">Active Authenticated Session</span>
                        </div>
                        <div class="hero-meta-item">
                            <span>📅</span>
                            <span style="color:#cbd5e1; font-weight:600;">Admin Member since {{ $admin->created_at ? $admin->created_at->format('M Y') : 'Oct 2026' }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="hero-metrics-right">
                <div class="stat-mini-pill">
                    <span class="stat-mini-label">Security Health</span>
                    <span class="stat-mini-value" style="color:#4ade80;">
                        <span>🛡️ 98%</span>
                        <span style="font-size:0.75rem; color:#cbd5e1; font-weight:600;">(Protected)</span>
                    </span>
                </div>

                <div class="stat-mini-pill">
                    <span class="stat-mini-label">Master Access</span>
                    <span class="stat-mini-value" style="color:#c084fc;">
                        <span>⚡ Tier-1</span>
                        <span style="font-size:0.75rem; color:#cbd5e1; font-weight:600;">(Root)</span>
                    </span>
                </div>

                <div class="stat-mini-pill">
                    <span class="stat-mini-label">Cryptographic Salt</span>
                    <span class="stat-mini-value" style="color:#38bdf8;">
                        <span>🔒 Bcrypt-12</span>
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- 2. TWO-COLUMN INTERACTIVE FORMS GRID -->
    <div class="admin-forms-grid">

        <!-- COLUMN 1: Profile & Identity Management -->
        <div class="form-panel-card">
            <div class="panel-card-header">
                <div>
                    <div class="panel-header-title">
                        <span>👤</span>
                        <span>Administrator Profile Identity</span>
                    </div>
                    <div class="panel-header-sub">Manage administrator name, contact email, avatar, and credentials</div>
                </div>
                <span class="badge-status" style="background:#e0e7ff; color:#4338ca; border:1.5px solid #c7d2fe; font-weight:850; font-size:0.75rem; padding:4px 12px; border-radius:9999px;">
                    Verified Master
                </span>
            </div>

            <div class="panel-card-body">
                <form action="{{ route('admin.account.profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <!-- Avatar Upload Zone -->
                    <div class="avatar-upload-zone">
                        <img id="profileAvatarPreview" 
                             src="{{ $admin->avatar ? asset($admin->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($admin->name) . '&background=4f46e5&color=fff&size=128' }}" 
                             alt="Avatar" 
                             class="avatar-preview-circle">

                        <div style="flex:1;">
                            <label style="font-size:0.82rem; font-weight:800; color:#0f172a; text-transform:uppercase; letter-spacing:0.4px; display:block; margin-bottom:4px;">
                                Profile Avatar Photo
                            </label>
                            <div style="font-size:0.78rem; color:#64748b; font-weight:500; margin-bottom:10px;">
                                Recommended: Square JPG, PNG, or WEBP (Max 5MB).
                            </div>

                            <div style="display:flex; align-items:center; gap:10px; flex-wrap:wrap;">
                                <label for="avatarFileInput" class="btn-outline" style="cursor:pointer; padding:7px 14px; font-size:0.82rem; font-weight:750; color:#1e293b; background:#ffffff; border:1.5px solid #cbd5e1; border-radius:8px; display:inline-flex; align-items:center; gap:6px;">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="17 8 12 3 7 8"></polyline><line x1="12" y1="3" x2="12" y2="15"></line></svg>
                                    <span>Upload New Photo</span>
                                </label>
                                <input type="file" id="avatarFileInput" name="avatar" accept="image/*" style="display:none;" onchange="previewAdminAvatar(this)">

                                @if ($admin->avatar)
                                    <label style="font-size:0.8rem; font-weight:700; color:#dc2626; display:inline-flex; align-items:center; gap:5px; cursor:pointer;">
                                        <input type="checkbox" name="remove_avatar" value="1" style="accent-color:#ef4444;">
                                        <span>Remove avatar</span>
                                    </label>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Administrator Full Name -->
                    <div class="input-field-group">
                        <label class="input-label">Administrator Display Name (ឈ្មោះអ្នកគ្រប់គ្រង)</label>
                        <div class="input-with-icon">
                            <span class="field-icon">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                            </span>
                            <input type="text" name="name" class="admin-input" value="{{ old('name', $admin->name) }}" required placeholder="Enter administrator name">
                        </div>
                    </div>

                    <!-- Administrator Email Address -->
                    <div class="input-field-group">
                        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:7px;">
                            <label class="input-label" style="margin-bottom:0;">Official Admin Email (អ៊ីមែល Admin)</label>
                            <span style="font-size:0.75rem; color:#15803d; font-weight:800; background:#dcfce7; border:1px solid #86efac; padding:2px 8px; border-radius:9999px;">✓ Primary Login Identifier</span>
                        </div>
                        <div class="input-with-icon">
                            <span class="field-icon">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
                            </span>
                            <input type="email" name="email" class="admin-input" value="{{ old('email', $admin->email) }}" required placeholder="admin@tshirtstore.com">
                        </div>
                    </div>

                    <!-- Administrator Contact Phone -->
                    <div class="input-field-group">
                        <label class="input-label">Direct Contact Phone (លេខទូរស័ព្ទ)</label>
                        <div class="input-with-icon">
                            <span class="field-icon">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
                            </span>
                            <input type="text" name="phone" class="admin-input" value="{{ old('phone', $admin->phone ?? '+1 (800) 555-TEES') }}" placeholder="+855 (0) 12 345 678">
                        </div>
                    </div>

                    <!-- Department & Privilege Notice -->
                    <div style="background:#f8fafc; border:1.5px solid #e2e8f0; border-radius:10px; padding:12px 16px; margin-bottom:24px; font-size:0.82rem; color:#334155; display:flex; justify-content:space-between; align-items:center;">
                        <span>System Authority: <strong style="color:#0f172a;">Store Management & Finance Control</strong></span>
                        <span style="background:#f3e8ff; color:#7e22ce; border:1px solid #d8b4fe; font-weight:800; font-size:0.75rem; padding:3px 10px; border-radius:9999px;">Full Access</span>
                    </div>

                    <button type="submit" class="btn-executive-save">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path><polyline points="17 21 17 13 7 13 7 21"></polyline><polyline points="7 3 7 8 15 8"></polyline></svg>
                        <span>Save Profile Identity (រក្សាទុកព័ត៌មាន)</span>
                    </button>
                </form>
            </div>
        </div>

        <!-- COLUMN 2: Master Security & Password -->
        <div class="form-panel-card">
            <div class="panel-card-header">
                <div>
                    <div class="panel-header-title">
                        <span>🔐</span>
                        <span>Master Security & Password</span>
                    </div>
                    <div class="panel-header-sub">Manage master password and account protection credentials</div>
                </div>
                <span class="badge-status" style="background:#e0f2fe; color:#0369a1; border:1.5px solid #bae6fd; font-weight:850; font-size:0.75rem; padding:4px 12px; border-radius:9999px;">
                    Bcrypt 12
                </span>
            </div>

            <div class="panel-card-body">
                <form action="{{ route('admin.account.password') }}" method="POST" id="passwordChangeForm">
                    @csrf

                    <!-- Security Callout Notice -->
                    <div class="security-notice-callout">
                        <span style="font-size:1.2rem; flex-shrink:0;">🛡️</span>
                        <div>
                            <strong style="color:#0c4a6e; font-weight:800;">Strong Password Requirement:</strong> Minimum 8 characters. We recommend combining uppercase letters, numbers, and symbols for maximum security.
                        </div>
                    </div>

                    <!-- Current Password -->
                    <div class="input-field-group">
                        <label class="input-label">Current Master Password (ពាក្យសម្ងាត់បច្ចុប្បន្ន)</label>
                        <div class="input-with-icon">
                            <span class="field-icon">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                            </span>
                            <input type="password" id="current_password" name="current_password" class="admin-input" required placeholder="Enter current admin password">
                            <button type="button" class="password-toggle-btn" onclick="togglePasswordVisibility('current_password', this)">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                            </button>
                        </div>
                    </div>

                    <!-- New Password -->
                    <div class="input-field-group">
                        <label class="input-label">New Master Password (ពាក្យសម្ងាត់ថ្មី)</label>
                        <div class="input-with-icon">
                            <span class="field-icon">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 9.9-1"></path></svg>
                            </span>
                            <input type="password" id="new_password" name="new_password" class="admin-input" required placeholder="Minimum 8 characters" oninput="checkPasswordStrength(this.value)">
                            <button type="button" class="password-toggle-btn" onclick="togglePasswordVisibility('new_password', this)">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                            </button>
                        </div>

                        <!-- Live Strength Meter -->
                        <div class="strength-meter-wrap">
                            <div class="strength-bars-track">
                                <div class="strength-bar-seg" id="seg1"></div>
                                <div class="strength-bar-seg" id="seg2"></div>
                                <div class="strength-bar-seg" id="seg3"></div>
                                <div class="strength-bar-seg" id="seg4"></div>
                            </div>
                            <div class="strength-text">
                                <span id="strengthLabel" style="font-weight:700;">Enter new password</span>
                                <span id="strengthScore" style="font-weight:800;">0 / 4</span>
                            </div>
                        </div>
                    </div>

                    <!-- Confirm New Password -->
                    <div class="input-field-group">
                        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:7px;">
                            <label class="input-label" style="margin-bottom:0;">Confirm New Password (បញ្ជាក់ពាក្យសម្ងាត់ថ្មី)</label>
                            <span id="matchIndicator" style="font-size:0.75rem; font-weight:800;"></span>
                        </div>
                        <div class="input-with-icon">
                            <span class="field-icon">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                            </span>
                            <input type="password" id="new_password_confirmation" name="new_password_confirmation" class="admin-input" required placeholder="Repeat new password" oninput="verifyPasswordMatch()">
                            <button type="button" class="password-toggle-btn" onclick="togglePasswordVisibility('new_password_confirmation', this)">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                            </button>
                        </div>
                    </div>

                    <div style="margin-top:24px;">
                        <button type="submit" class="btn-executive-pwd">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>
                            <span>Update Master Password (ប្តូរពាក្យសម្ងាត់)</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>

    <!-- 3. SYSTEM SECURITY TELEMETRY OVERVIEW -->
    <div class="telemetry-cards-grid">
        <div class="telemetry-card">
            <div class="telemetry-header">
                <span>🖥️ Active Workstation</span>
                <span style="background:#dcfce7; color:#15803d; border:1px solid #86efac; font-weight:800; font-size:0.72rem; padding:2px 8px; border-radius:9999px;">● Connected</span>
            </div>
            <div class="telemetry-main">Chrome / Windows</div>
            <div class="telemetry-desc">
                Current active administrator session connected via local IP (127.0.0.1). High-integrity session cookie with HTTPOnly and SameSite encryption.
            </div>
        </div>

        <div class="telemetry-card">
            <div class="telemetry-header">
                <span>🛡️ Hashing Standard</span>
                <span style="background:#e0f2fe; color:#0369a1; border:1px solid #bae6fd; font-weight:800; font-size:0.72rem; padding:2px 8px; border-radius:9999px;">Bcrypt + Salt</span>
            </div>
            <div class="telemetry-main">256-Bit Protection</div>
            <div class="telemetry-desc">
                All administrator authentication credentials are encrypted using PHP native Bcrypt algorithms with 12 iterative salt hashing cycles.
            </div>
        </div>

        <div class="telemetry-card">
            <div class="telemetry-header">
                <span>⚡ Authorization Scope</span>
                <span style="background:#f3e8ff; color:#7e22ce; border:1px solid #d8b4fe; font-weight:800; font-size:0.72rem; padding:2px 8px; border-radius:9999px;">Root Authority</span>
            </div>
            <div class="telemetry-main">Full Master Permissions</div>
            <div class="telemetry-desc">
                Unrestricted capability to manage catalog, order fulfillment, financial VAT tax settings, QR bank payments, customer reports, and invoices.
            </div>
        </div>
    </div>

@endsection

@section('scripts')
<script>
    // Live Avatar Preview Handler
    function previewAdminAvatar(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('profileAvatarPreview').src = e.target.result;
                const heroAvatar = document.getElementById('heroAvatarDisplay');
                if (heroAvatar) {
                    if (heroAvatar.tagName.toLowerCase() === 'img') {
                        heroAvatar.src = e.target.result;
                    } else {
                        heroAvatar.outerHTML = `<img src="${e.target.result}" alt="Avatar" class="hero-avatar-img" id="heroAvatarDisplay">`;
                    }
                }
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    // Toggle Password Visibility
    function togglePasswordVisibility(fieldId, btn) {
        const input = document.getElementById(fieldId);
        if (!input) return;

        if (input.type === 'password') {
            input.type = 'text';
            btn.innerHTML = `<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path><line x1="1" y1="1" x2="23" y2="23"></line></svg>`;
            btn.style.color = '#0284c7';
        } else {
            input.type = 'password';
            btn.innerHTML = `<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>`;
            btn.style.color = '#64748b';
        }
    }

    // Real-Time Password Strength Evaluator
    function checkPasswordStrength(password) {
        let score = 0;
        if (!password) {
            updateStrengthUI(0, 'Enter new password', '#64748b');
            return;
        }

        if (password.length >= 8) score++;
        if (/[A-Z]/.test(password) && /[a-z]/.test(password)) score++;
        if (/[0-9]/.test(password)) score++;
        if (/[^A-Za-z0-9]/.test(password)) score++;

        let label = 'Weak';
        let color = '#dc2626'; // Red

        if (score === 2) {
            label = 'Fair';
            color = '#d97706'; // Amber
        } else if (score === 3) {
            label = 'Good';
            color = '#0284c7'; // Blue
        } else if (score >= 4) {
            label = 'Strong & Secure';
            color = '#15803d'; // Green
        }

        updateStrengthUI(score, label, color);
        verifyPasswordMatch();
    }

    function updateStrengthUI(score, label, color) {
        for (let i = 1; i <= 4; i++) {
            const seg = document.getElementById('seg' + i);
            if (i <= score) {
                seg.style.background = color;
            } else {
                seg.style.background = '#e2e8f0';
            }
        }
        const labelEl = document.getElementById('strengthLabel');
        const scoreEl = document.getElementById('strengthScore');
        if (labelEl) {
            labelEl.textContent = label;
            labelEl.style.color = color;
        }
        if (scoreEl) {
            scoreEl.textContent = score + ' / 4';
            scoreEl.style.color = color;
        }
    }

    // Live Password Match Verifier
    function verifyPasswordMatch() {
        const pwd = document.getElementById('new_password').value;
        const confirm = document.getElementById('new_password_confirmation').value;
        const indicator = document.getElementById('matchIndicator');

        if (!confirm) {
            indicator.textContent = '';
            return;
        }

        if (pwd === confirm) {
            indicator.textContent = '✓ Passwords Match';
            indicator.style.color = '#15803d';
        } else {
            indicator.textContent = '✕ Passwords do not match';
            indicator.style.color = '#dc2626';
        }
    }
</script>
@endsection
