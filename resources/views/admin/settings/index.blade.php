@extends('layouts.admin')

@section('title', 'System & Store Settings')
@section('page-title', 'System & Store Settings')

@section('styles')
<style>
    /* ==========================================================================
       SETTINGS HERO BANNER & BENTO OVERVIEW
       ========================================================================== */
    /* ==========================================================================
       SETTINGS HERO BANNER & BENTO OVERVIEW
       ========================================================================== */
    .settings-hero-banner {
        background: linear-gradient(135deg, #1e1b4b 0%, #312e81 40%, #4338ca 100%);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: var(--radius-lg);
        padding: 28px 32px;
        margin-bottom: 26px;
        position: relative;
        overflow: hidden;
        box-shadow: 0 8px 30px rgba(49, 46, 129, 0.2);
    }

    .settings-hero-banner::before {
        content: '';
        position: absolute;
        top: -90px;
        right: -60px;
        width: 280px;
        height: 280px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(165, 180, 252, 0.25) 0%, rgba(192, 132, 252, 0.1) 50%, transparent 70%);
        pointer-events: none;
    }

    .settings-hero-flex {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 20px;
        flex-wrap: wrap;
        position: relative;
        z-index: 1;
    }

    .settings-hero-title {
        font-size: 1.65rem;
        font-weight: 850;
        color: #ffffff !important;
        letter-spacing: -0.4px;
        margin-bottom: 6px;
    }

    .settings-hero-sub {
        font-size: 0.94rem;
        color: #e0e7ff !important;
        line-height: 1.55;
        font-weight: 500;
        max-width: 580px;
    }

    .settings-metrics-pills {
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
    }

    .metric-pill-item {
        background: rgba(255, 255, 255, 0.15);
        border: 1px solid rgba(255, 255, 255, 0.28);
        backdrop-filter: blur(10px);
        border-radius: 12px;
        padding: 10px 18px;
        display: flex;
        flex-direction: column;
        gap: 3px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .metric-pill-label {
        font-size: 0.72rem;
        font-weight: 800;
        text-transform: uppercase;
        color: #c7d2fe !important;
        letter-spacing: 0.6px;
    }

    .metric-pill-val {
        font-size: 0.95rem;
        font-weight: 800;
        color: #ffffff !important;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    /* ==========================================================================
       SEGMENTED NAVIGATION TABS
       ========================================================================== */
    .settings-nav-bar {
        display: flex;
        gap: 10px;
        overflow-x: auto;
        padding-bottom: 8px;
        margin-bottom: 26px;
        border-bottom: 1px solid #e2e8f0;
    }

    .nav-tab-item {
        padding: 11px 20px;
        border-radius: var(--radius-full);
        font-weight: 700;
        font-size: 0.88rem;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
        text-decoration: none;
        white-space: nowrap;
    }

    .nav-tab-item.active {
        background: linear-gradient(135deg, #4f46e5 0%, #6366f1 100%);
        color: #ffffff !important;
        box-shadow: 0 4px 14px rgba(79, 70, 229, 0.4);
        border: 1.5px solid transparent;
    }

    .nav-tab-item:not(.active) {
        background: #ffffff;
        color: #334155;
        border: 1.5px solid #cbd5e1;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.04);
    }

    .nav-tab-item:not(.active):hover {
        background: #f8fafc;
        color: #0f172a;
        border-color: #94a3b8;
        transform: translateY(-1px);
    }

    /* ==========================================================================
       CARDS & BENTO PANELS
       ========================================================================== */
    .settings-content-wrap {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: var(--radius-lg);
        padding: 34px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05), 0 6px 16px rgba(0, 0, 0, 0.03);
    }

    .bento-split-grid {
        display: grid;
        grid-template-columns: 1.25fr 1fr;
        gap: 26px;
        align-items: start;
        margin-bottom: 28px;
    }

    @media (max-width: 1024px) {
        .bento-split-grid {
            grid-template-columns: 1fr;
        }
    }

    .section-headline {
        margin-bottom: 24px;
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 16px;
        flex-wrap: wrap;
    }

    .section-title {
        font-size: 1.35rem;
        font-weight: 850;
        color: #0f172a !important;
        letter-spacing: -0.3px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .section-desc {
        font-size: 0.9rem;
        color: #475569 !important;
        margin-top: 4px;
        line-height: 1.55;
    }

    /* Form Fields */
    .form-group-block {
        margin-bottom: 20px;
    }

    .form-group-label {
        display: block;
        font-size: 0.85rem;
        font-weight: 750;
        color: #0f172a;
        letter-spacing: 0.2px;
        margin-bottom: 8px;
        line-height: 1.5;
    }

    .form-group-label .kh-text {
        color: #4f46e5;
        font-weight: 600;
        font-size: 0.88rem;
        margin-left: 4px;
    }

    .field-input-box {
        position: relative;
        display: flex;
        align-items: center;
    }

    .field-left-icon {
        position: absolute;
        left: 14px;
        color: #4f46e5;
        pointer-events: none;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .settings-input-control {
        width: 100%;
        background: #ffffff;
        border: 1.5px solid #cbd5e1;
        color: #0f172a !important;
        font-weight: 600;
        padding: 12px 14px 12px 44px;
        border-radius: var(--radius-md);
        font-size: 0.94rem;
        outline: none;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.04);
        transition: all 0.2s ease;
    }

    .settings-input-control:focus {
        border-color: #4f46e5;
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.15);
        background: #ffffff;
    }

    .settings-select-control {
        width: 100%;
        background: #ffffff;
        border: 1.5px solid #cbd5e1;
        color: #0f172a !important;
        font-weight: 600;
        padding: 12px 14px 12px 44px;
        border-radius: var(--radius-md);
        font-size: 0.94rem;
        outline: none;
        cursor: pointer;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.04);
        transition: all 0.2s ease;
    }

    .settings-select-control:focus {
        border-color: #4f46e5;
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.15);
    }

    /* Live Store Preview Card */
    .live-preview-card {
        background: #f8fafc;
        border: 1.5px solid #e2e8f0;
        border-radius: var(--radius-lg);
        padding: 22px;
        position: relative;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
    }

    .preview-card-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 16px;
        padding-bottom: 12px;
        border-bottom: 1px solid #e2e8f0;
    }

    .preview-brand-badge {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 14px;
    }

    .preview-logo-box {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        background: linear-gradient(135deg, #4f46e5, #7c3aed);
        color: #ffffff;
        font-weight: 900;
        font-size: 1.15rem;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 14px rgba(79, 70, 229, 0.35);
    }

    /* Toggle Option Cards */
    .toggle-option-card {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 18px 20px;
        background: #f8fafc;
        border: 1.5px solid #e2e8f0;
        border-radius: var(--radius-md);
        margin-bottom: 14px;
        transition: all 0.2s ease;
    }

    .toggle-option-card:hover {
        background: #ffffff;
        border-color: #cbd5e1;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
    }

    .toggle-info-title {
        font-weight: 800;
        font-size: 0.95rem;
        color: #0f172a !important;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .toggle-info-desc {
        font-size: 0.85rem;
        color: #64748b;
        margin-top: 3px;
        line-height: 1.45;
    }

    .status-select-pill {
        background-color: #ffffff !important;
        border: 1.5px solid #cbd5e1 !important;
        color: #0f172a !important;
        padding: 8px 32px 8px 14px;
        border-radius: var(--radius-md);
        font-weight: 750;
        font-size: 0.88rem;
        cursor: pointer;
        outline: none;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.04);
        transition: all 0.2s ease;
        appearance: auto;
        -webkit-appearance: auto;
    }

    .status-select-pill:focus {
        border-color: #4f46e5 !important;
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.15);
    }

    .status-select-pill option {
        background: #ffffff;
        color: #0f172a;
        font-weight: 600;
        padding: 6px;
    }

    /* Floating Save Bar */
    .save-actions-bar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-top: 24px;
        border-top: 1px solid var(--border-subtle);
        margin-top: 28px;
        flex-wrap: wrap;
        gap: 16px;
    }

    .btn-executive-save-settings {
        background: linear-gradient(135deg, #4f46e5 0%, #6366f1 100%);
        color: #ffffff;
        border: none;
        padding: 13px 28px;
        border-radius: var(--radius-md);
        font-size: 0.95rem;
        font-weight: 800;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        box-shadow: 0 4px 18px rgba(79, 70, 229, 0.45);
        transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
    }

    .btn-executive-save-settings:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 28px rgba(79, 70, 229, 0.65);
        background: linear-gradient(135deg, #4338ca 0%, #4f46e5 100%);
    }
</style>
@endsection

@section('content')
<div style="max-width:1080px; margin:0 auto;">

    <!-- 1. HERO BANNER OVERVIEW -->
    <div class="settings-hero-banner">
        <div class="settings-hero-flex">
            <div>
                <h2 class="settings-hero-title">System & Store Configuration</h2>
                <p class="settings-hero-sub">
                    Manage global store parameters, KHQR payment gateways, automated fulfillment, and administrative policies.
                </p>
            </div>

            <div class="settings-metrics-pills">
                <div class="metric-pill-item">
                    <span class="metric-pill-label">Storefront</span>
                    <span class="metric-pill-val" style="color:#34d399;">
                        <span>● Online</span>
                        <a href="{{ route('home') }}" target="_blank" style="color:#38bdf8; font-size:0.75rem; text-decoration:none;">↗</a>
                    </span>
                </div>

                <div class="metric-pill-item">
                    <span class="metric-pill-label">Currency</span>
                    <span class="metric-pill-val" style="color:#fbbf24;">
                        <span>{{ $settings['currency'] ?? 'USD' }}</span>
                    </span>
                </div>

                <div class="metric-pill-item">
                    <span class="metric-pill-label">VAT Tax</span>
                    <span class="metric-pill-val" style="color:#a855f7;">
                        <span>{{ number_format(floatval($settings['tax_rate'] ?? 10), 1) }}%</span>
                    </span>
                </div>

                <div class="metric-pill-item">
                    <span class="metric-pill-label">QR Pay</span>
                    <span class="metric-pill-val" style="color:#38bdf8;">
                        <span>{{ ($settings['enable_qr'] ?? '1') == '1' ? 'Active' : 'Off' }}</span>
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- 2. SEGMENTED NAVIGATION TABS -->
    <div class="settings-nav-bar">
        <a href="{{ route('admin.settings.index', ['group' => 'website']) }}" 
           class="nav-tab-item {{ $group === 'website' ? 'active' : '' }}">
            <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="2" y1="12" x2="22" y2="12"></line><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path></svg>
            <span>Website & Branding</span>
        </a>

        <a href="{{ route('admin.settings.index', ['group' => 'payment']) }}" 
           class="nav-tab-item {{ $group === 'payment' ? 'active' : '' }}">
            <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="5" width="20" height="14" rx="2"></rect><line x1="2" y1="10" x2="22" y2="10"></line></svg>
            <span>Payment & QR Gateways</span>
        </a>

        <a href="{{ route('admin.settings.index', ['group' => 'shipping']) }}" 
           class="nav-tab-item {{ $group === 'shipping' ? 'active' : '' }}">
            <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="1" y="3" width="15" height="13"></rect><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon><circle cx="5.5" cy="18.5" r="2.5"></circle><circle cx="18.5" cy="18.5" r="2.5"></circle></svg>
            <span>Shipping & Delivery</span>
        </a>

        <a href="{{ route('admin.settings.index', ['group' => 'notification']) }}" 
           class="nav-tab-item {{ $group === 'notification' ? 'active' : '' }}">
            <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg>
            <span>Alerts & Notifications</span>
        </a>

        <a href="{{ route('admin.settings.index', ['group' => 'security']) }}" 
           class="nav-tab-item {{ $group === 'security' ? 'active' : '' }}">
            <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
            <span>Security & Governance</span>
        </a>
    </div>

    <!-- 3. MAIN SETTINGS FORM CONTAINER -->
    <div class="settings-content-wrap">
        <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="group" value="{{ $group }}">

            {{-- ============================================================
                 1. WEBSITE & BRAND IDENTITY (Clean Bento Layout)
                 ============================================================ --}}
            @if ($group === 'website')
                <div class="section-headline">
                    <div>
                        <div class="section-title">
                            <span>🌐</span>
                            <span>Website & Brand Identity (ម៉ាកសញ្ញាហាង)</span>
                        </div>
                        <div class="section-desc">
                            Configure the public branding, store name, default currency, and legal contact details used across the storefront and invoices.
                        </div>
                    </div>
                    <a href="{{ route('home') }}" target="_blank" class="btn-outline" style="font-size:0.82rem; padding:8px 14px; display:inline-flex; align-items:center; gap:6px; color:#38bdf8; border-color:rgba(56,189,248,0.4);">
                        <span>Live Storefront</span>
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="7" y1="17" x2="17" y2="7"></line><polyline points="7 7 17 7 17 17"></polyline></svg>
                    </a>
                </div>

                <div class="bento-split-grid">
                    <!-- Left Column: Core Brand & Currency -->
                    <div>
                        <!-- Store Name -->
                        <div class="form-group-block">
                            <label class="form-group-label">Store Brand Name <span class="kh-text">(ឈ្មោះហាង)</span></label>
                            <div class="field-input-box">
                                <span class="field-left-icon">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                                </span>
                                <input type="text" name="store_name" id="storeNameInput" class="settings-input-control" value="{{ old('store_name', $settings['store_name']) }}" required placeholder="e.g. T-Shirt Online" oninput="updateLivePreview()">
                            </div>
                        </div>

                        <!-- Store Tagline -->
                        <div class="form-group-block">
                            <label class="form-group-label">Brand Tagline / Slogan <span class="kh-text">(ពាក្យស្លោកហាង)</span></label>
                            <div class="field-input-box">
                                <span class="field-left-icon">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="4" y1="9" x2="20" y2="9"></line><line x1="4" y1="15" x2="20" y2="15"></line><line x1="10" y1="3" x2="8" y2="21"></line><line x1="16" y1="3" x2="14" y2="21"></line></svg>
                                </span>
                                <input type="text" name="store_tagline" id="storeTaglineInput" class="settings-input-control" value="{{ old('store_tagline', $settings['store_tagline']) }}" placeholder="e.g. Premium Streetwear & Graphic T-Shirts" oninput="updateLivePreview()">
                            </div>
                        </div>

                        <!-- Store Currency -->
                        <div class="form-group-block">
                            <label class="form-group-label">Default Store Currency <span class="kh-text">(រូបិយប័ណ្ណលក់)</span></label>
                            <div class="field-input-box">
                                <span class="field-left-icon">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="1" x2="12" y2="23"></line><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path></svg>
                                </span>
                                <select name="currency" id="storeCurrencySelect" class="settings-select-control" onchange="updateLivePreview()">
                                    <option value="USD" {{ $settings['currency'] == 'USD' ? 'selected' : '' }}>💵 USD ($ - United States Dollar)</option>
                                    <option value="KHR" {{ $settings['currency'] == 'KHR' ? 'selected' : '' }}>🇰🇭 KHR (៛ - Cambodian Riel)</option>
                                    <option value="EUR" {{ $settings['currency'] == 'EUR' ? 'selected' : '' }}>💶 EUR (€ - Euro)</option>
                                    <option value="GBP" {{ $settings['currency'] == 'GBP' ? 'selected' : '' }}>💷 GBP (£ - British Pound)</option>
                                    <option value="CAD" {{ $settings['currency'] == 'CAD' ? 'selected' : '' }}>🍁 CAD ($ - Canadian Dollar)</option>
                                </select>
                            </div>
                        </div>

                        <!-- Physical Studio / Store Address -->
                        <div class="form-group-block">
                            <label class="form-group-label">Store Location & Legal Address <span class="kh-text">(អាសយដ្ឋានផ្លូវការ)</span></label>
                            <div class="field-input-box">
                                <span class="field-left-icon">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                                </span>
                                <input type="text" name="address" class="settings-input-control" value="{{ old('address', $settings['address'] ?? 'Studio 4A, Street 123, Sangkat Boeung Keng Kang 1, Phnom Penh, Cambodia') }}" placeholder="Street address for invoices and receipts">
                            </div>
                        </div>

                        <!-- Official Tax ID (VAT TIN) -->
                        <div class="form-group-block">
                            <label class="form-group-label">Tax Identification Number <span class="kh-text">(VAT TIN / លេខអត្តសញ្ញាណកម្មពន្ធ)</span></label>
                            <div class="field-input-box">
                                <span class="field-left-icon">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="12 2 2 7 12 12 22 7 12 2"></polygon><polyline points="2 17 12 22 22 17"></polyline><polyline points="2 12 12 17 22 12"></polyline></svg>
                                </span>
                                <input type="text" name="tax_id" class="settings-input-control" value="{{ old('tax_id', $settings['tax_id'] ?? 'VAT-K008-902188442') }}" placeholder="e.g. VAT-K008-902188442 (Printed on Tax Invoices)">
                            </div>
                        </div>
                    </div>

                    <!-- Right Column: Contact Details & Live Preview -->
                    <div>
                        <!-- Public Support Email -->
                        <div class="form-group-block">
                            <label class="form-group-label">Public Customer Support Email <span class="kh-text">(អ៊ីមែលទំនាក់ទំនង)</span></label>
                            <div class="field-input-box">
                                <span class="field-left-icon">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
                                </span>
                                <input type="email" name="support_email" id="supportEmailInput" class="settings-input-control" value="{{ old('support_email', $settings['support_email']) }}" required placeholder="support@tshirtstore.com" oninput="updateLivePreview()">
                            </div>
                        </div>

                        <!-- Customer Helpline Phone -->
                        <div class="form-group-block">
                            <label class="form-group-label">Customer Helpline Phone <span class="kh-text">(លេខទូរស័ព្ទ)</span></label>
                            <div class="field-input-box">
                                <span class="field-left-icon">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
                                </span>
                                <input type="text" name="phone" class="settings-input-control" value="{{ old('phone', $settings['phone']) }}" placeholder="+1 (800) 555-TEES">
                            </div>
                        </div>

                        <!-- Live Brand Card Preview -->
                        <div class="live-preview-card">
                            <div class="preview-card-header">
                                <span style="font-size:0.75rem; font-weight:800; color:#38bdf8; text-transform:uppercase; letter-spacing:0.8px;">
                                    👁️ Live Brand Mockup Preview
                                </span>
                                <span style="font-size:0.72rem; color:var(--text-muted);">Real-Time</span>
                            </div>

                            <div class="preview-brand-badge">
                                <div class="preview-logo-box" id="previewLogoBox">TC</div>
                                <div>
                                    <div style="font-size:1.15rem; font-weight:850; color:#0f172a;" id="previewStoreName">
                                        {{ $settings['store_name'] ?? 'T-Shirt Online' }}
                                    </div>
                                    <div style="font-size:0.82rem; color:#4f46e5; font-weight:600;" id="previewStoreTagline">
                                        {{ $settings['store_tagline'] ?? 'Premium Streetwear & Graphic T-Shirts' }}
                                    </div>
                                </div>
                            </div>

                            <div style="background:#ffffff; border:1px solid #cbd5e1; border-radius:var(--radius-sm); padding:10px 14px; font-size:0.82rem; color:#334155; display:flex; justify-content:space-between; align-items:center; box-shadow:0 1px 2px rgba(0,0,0,0.03);">
                                <span>Active Currency: <strong style="color:#d97706; font-weight:800;" id="previewCurrency">{{ $settings['currency'] ?? 'USD' }}</strong></span>
                                <span id="previewSupportEmail" style="font-family:'JetBrains Mono', monospace; color:#0f172a; font-weight:700;">{{ $settings['support_email'] ?? 'admin@tshirtstore.com' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            {{-- ============================================================
                 2. PAYMENT & QR GATEWAYS (Featured KHQR)
                 ============================================================ --}}
            @if ($group === 'payment')
                <div class="section-headline">
                    <div>
                        <div class="section-title">
                            <span>💳</span>
                            <span>Payment Gateways & QR Configuration</span>
                        </div>
                        <div class="section-desc">
                            Configure customer checkout payment methods, upload admin bank QR codes (KHQR / Bakong / ABA), and set VAT sales tax rates.
                        </div>
                    </div>
                    <a href="{{ route('checkout.index') }}" target="_blank" style="font-size:0.85rem; padding:8px 18px; display:inline-flex; align-items:center; gap:8px; color:#4f46e5; background:#ffffff; border:1.5px solid #c7d2fe; border-radius:var(--radius-full); font-weight:750; box-shadow:0 1px 2px rgba(0,0,0,0.04); text-decoration:none; transition:all 0.2s ease;">
                        <span>Test Checkout ↗</span>
                    </a>
                </div>

                <!-- FEATURED KHQR / BANK QR SCAN CARD -->
                <div style="background:linear-gradient(145deg, #ffffff 0%, #fff5f7 100%); border:1.5px solid #fecdd3; border-radius:var(--radius-lg); padding:26px; margin-bottom:28px; box-shadow:0 4px 16px rgba(225,29,72,0.05);">
                    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:22px; flex-wrap:wrap; gap:16px;">
                        <div style="display:flex; align-items:center; gap:14px;">
                            <div style="width:44px; height:44px; border-radius:12px; background:linear-gradient(135deg, #e11d48, #be123c); display:flex; align-items:center; justify-content:center; color:#fff; font-size:1.35rem; box-shadow:0 4px 14px rgba(225,29,72,0.35); flex-shrink:0;">
                                📱
                            </div>
                            <div>
                                <h4 style="font-size:1.15rem; font-weight:850; color:#0f172a; margin:0; letter-spacing:-0.2px;">
                                    KHQR / Bank QR Scan & Pay (Admin QR Code)
                                </h4>
                                <span style="font-size:0.86rem; color:#475569; font-weight:500; margin-top:3px; display:block;">
                                    Allow customers to pay instantly by scanning your store's QR code (ABA Mobile, Bakong, Wing, ACLEDA, etc.).
                                </span>
                            </div>
                        </div>

                        <div style="display:flex; align-items:center; gap:10px;">
                            <label style="font-size:0.82rem; font-weight:800; color:#334155; text-transform:uppercase; letter-spacing:0.5px;">Gateway Status:</label>
                            <select name="enable_qr" class="status-select-pill" style="min-width:130px;">
                                <option value="1" {{ ($settings['enable_qr'] ?? '1') == '1' ? 'selected' : '' }}>Enabled</option>
                                <option value="0" {{ ($settings['enable_qr'] ?? '1') == '0' ? 'selected' : '' }}>Disabled</option>
                            </select>
                        </div>
                    </div>

                    <div style="display:grid; grid-template-columns:1fr 1.35fr; gap:26px; align-items:start;">
                        <!-- QR Code Upload & Live Preview -->
                        <div style="background:#ffffff; border:1.5px dashed #cbd5e1; border-radius:var(--radius-md); padding:24px; text-align:center; box-shadow:0 1px 3px rgba(0,0,0,0.03);">
                            <div style="font-size:0.82rem; font-weight:850; color:#1e293b; text-transform:uppercase; letter-spacing:0.6px; margin-bottom:14px; display:flex; align-items:center; justify-content:center; gap:6px;">
                                <span>📷 Active QR Code Image</span>
                            </div>
                            
                            <div style="position:relative; display:inline-block; margin-bottom:16px; background:#ffffff; padding:12px; border:1.5px solid #e2e8f0; border-radius:14px; box-shadow:0 4px 14px rgba(0,0,0,0.06);">
                                <img id="adminQrPreview" 
                                     src="{{ asset($settings['qr_code_image'] ?: '/images/payments/default_khqr.svg') }}" 
                                     alt="Admin QR Code" 
                                     style="width:200px; height:auto; max-height:250px; border-radius:8px; object-fit:contain; display:block;">
                            </div>

                            <div>
                                <label for="qrCodeInput" style="cursor:pointer; display:inline-flex; align-items:center; gap:8px; font-size:0.88rem; font-weight:750; color:#1e293b; background:#f8fafc; border:1.5px solid #cbd5e1; padding:9px 20px; border-radius:var(--radius-full); transition:all 0.2s ease; box-shadow:0 1px 2px rgba(0,0,0,0.04);">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="17 8 12 3 7 8"></polyline><line x1="12" y1="3" x2="12" y2="15"></line></svg>
                                    <span>Upload New QR Image</span>
                                </label>
                                <input type="file" id="qrCodeInput" name="qr_code_image_file" accept="image/*" style="display:none;" onchange="previewAdminQR(this)">
                                <div style="font-size:0.78rem; font-weight:600; color:#64748b; margin-top:8px;">Supported: JPG, PNG, WEBP, SVG (Max 5MB)</div>
                            </div>

                            @if (!empty($settings['qr_code_image']) && $settings['qr_code_image'] !== '/images/payments/default_khqr.svg')
                                <div style="margin-top:14px;">
                                    <label style="display:inline-flex; align-items:center; gap:6px; font-size:0.82rem; font-weight:700; color:#dc2626; cursor:pointer;">
                                        <input type="checkbox" name="remove_qr_code" value="1" style="accent-color:#ef4444; width:16px; height:16px;">
                                        <span>Reset to Default KHQR Template</span>
                                    </label>
                                </div>
                            @endif
                        </div>

                        <!-- Bank & Account Information -->
                        <div>
                            <div class="form-group-block">
                                <label class="form-group-label" style="font-size:0.88rem; font-weight:800; color:#0f172a;">Bank / Provider Name <span class="kh-text" style="color:#4f46e5; font-weight:700;">(ឈ្មោះធនាគារ)</span> *</label>
                                <input type="text" name="qr_bank_name" class="settings-input-control" style="padding-left:14px; font-weight:700;" value="{{ old('qr_bank_name', $settings['qr_bank_name'] ?? 'ABA Bank / KHQR') }}" placeholder="e.g. ABA Bank, Bakong, ACLEDA" required>
                            </div>

                            <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px; margin-bottom:18px;">
                                <div>
                                    <label class="form-group-label" style="font-size:0.88rem; font-weight:800; color:#0f172a;">Account Holder Name *</label>
                                    <input type="text" name="qr_account_name" class="settings-input-control" style="padding-left:14px; font-weight:700;" value="{{ old('qr_account_name', $settings['qr_account_name'] ?? 'T-SHIRT ONLINE CO., LTD') }}" placeholder="e.g. T-SHIRT ONLINE" required>
                                </div>
                                <div>
                                    <label class="form-group-label" style="font-size:0.88rem; font-weight:800; color:#0f172a;">Account Number *</label>
                                    <input type="text" name="qr_account_number" class="settings-input-control" style="padding-left:14px; font-weight:700;" value="{{ old('qr_account_number', $settings['qr_account_number'] ?? '001 888 999 (USD)') }}" placeholder="e.g. 001 888 999" required>
                                </div>
                            </div>

                            <div class="form-group-block">
                                <label class="form-group-label" style="font-size:0.88rem; font-weight:800; color:#0f172a;">Customer Payment Instructions</label>
                                <textarea name="qr_instructions" rows="3" class="settings-input-control" style="padding-left:14px; resize:vertical; font-weight:600; line-height:1.55;" placeholder="Instructions displayed to customers when scanning QR...">{{ old('qr_instructions', $settings['qr_instructions'] ?? 'Scan this QR code using any banking app (ABA Mobile, Bakong, ACLEDA, Wing) to complete payment. Upload your payment slip / receipt screenshot below for prompt verification.') }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- OTHER GATEWAYS -->
                <div style="margin-bottom:26px;">
                    <h4 style="font-size:1.05rem; font-weight:850; color:#0f172a; margin-bottom:14px; display:flex; align-items:center; gap:8px;">
                        <span>⚡</span>
                        <span>Additional Payment Methods</span>
                    </h4>

                    <div class="toggle-option-card">
                        <div>
                            <div class="toggle-info-title">💳 Stripe Credit & Debit Card Checkout</div>
                            <div class="toggle-info-desc">Accept Visa, MasterCard, and American Express with instant validation.</div>
                        </div>
                        <select name="enable_stripe" class="status-select-pill" style="min-width:120px;">
                            <option value="1" {{ $settings['enable_stripe'] == '1' ? 'selected' : '' }}>Enabled</option>
                            <option value="0" {{ $settings['enable_stripe'] == '0' ? 'selected' : '' }}>Disabled</option>
                        </select>
                    </div>

                    <div class="toggle-option-card">
                        <div>
                            <div class="toggle-info-title">🅿️ PayPal Express Checkout</div>
                            <div class="toggle-info-desc">Allow customers to pay through their PayPal balance or linked cards.</div>
                        </div>
                        <select name="enable_paypal" class="status-select-pill" style="min-width:120px;">
                            <option value="1" {{ $settings['enable_paypal'] == '1' ? 'selected' : '' }}>Enabled</option>
                            <option value="0" {{ $settings['enable_paypal'] == '0' ? 'selected' : '' }}>Disabled</option>
                        </select>
                    </div>

                    <div class="toggle-option-card">
                        <div>
                            <div class="toggle-info-title">💵 Cash on Delivery (COD)</div>
                            <div class="toggle-info-desc">Permit buyers to settle balance upon postal receipt.</div>
                        </div>
                        <select name="enable_cod" class="status-select-pill" style="min-width:120px;">
                            <option value="1" {{ $settings['enable_cod'] == '1' ? 'selected' : '' }}>Enabled</option>
                            <option value="0" {{ $settings['enable_cod'] == '0' ? 'selected' : '' }}>Disabled</option>
                        </select>
                    </div>
                </div>

                <!-- SALES TAX / VAT RATE -->
                <div style="background:linear-gradient(135deg, #f8fafc 0%, #eef2ff 100%); border:1.5px solid #cbd5e1; border-radius:var(--radius-md); padding:20px 24px; display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:16px; box-shadow:0 1px 3px rgba(0,0,0,0.03);">
                    <div>
                        <div style="font-weight:850; font-size:1.05rem; color:#0f172a; display:flex; align-items:center; gap:8px;">
                            <span>🏛️ Standard Sales Tax / VAT Rate (%)</span>
                        </div>
                        <div style="font-size:0.86rem; color:#475569; margin-top:4px; font-weight:500;">
                            Official Value Added Tax (VAT) applied on customer tax invoices. Standard Cambodia rate is <strong style="color:#0f172a;">10.00%</strong>.
                        </div>
                    </div>
                    <div style="display:flex; align-items:center; gap:10px;">
                        <input type="number" step="0.01" name="tax_rate" value="{{ old('tax_rate', $settings['tax_rate']) }}" style="width:120px; text-align:right; font-weight:800; font-size:1.05rem; color:#0f172a !important; background:#ffffff; border:1.5px solid #cbd5e1; border-radius:var(--radius-sm); padding:10px 14px;" class="settings-input-control">
                        <span style="font-weight:850; font-size:1.15rem; color:#4f46e5;">%</span>
                    </div>
                </div>
            @endif

            {{-- ============================================================
                 3. SHIPPING & FULFILLMENT THRESHOLDS
                 ============================================================ --}}
            @if ($group === 'shipping')
                <div class="section-headline">
                    <div>
                        <div class="section-title">
                            <span>🚚</span>
                            <span>Shipping & Fulfillment Thresholds</span>
                        </div>
                        <div class="section-desc">
                            Set standard flat delivery rates, express courier options, and free shipping qualification.
                        </div>
                    </div>
                </div>

                <div style="display:grid; grid-template-columns:1fr 1fr; gap:20px; margin-bottom:24px;">
                    <div class="form-group-block">
                        <label class="form-group-label">Free Shipping Qualification Threshold ($)</label>
                        <div class="field-input-box">
                            <span class="field-left-icon">🎁</span>
                            <input type="number" step="0.01" name="free_shipping_threshold" value="{{ old('free_shipping_threshold', $settings['free_shipping_threshold']) }}" class="settings-input-control" required>
                        </div>
                        <span style="font-size:0.75rem; color:var(--text-muted); margin-top:5px; display:block;">Orders above this cart subtotal receive free standard shipping.</span>
                    </div>

                    <div class="form-group-block">
                        <label class="form-group-label">Standard Delivery Flat Rate ($)</label>
                        <div class="field-input-box">
                            <span class="field-left-icon">📦</span>
                            <input type="number" step="0.01" name="standard_shipping_rate" value="{{ old('standard_shipping_rate', $settings['standard_shipping_rate']) }}" class="settings-input-control" required>
                        </div>
                        <span style="font-size:0.75rem; color:var(--text-muted); margin-top:5px; display:block;">Applied when cart is below free threshold.</span>
                    </div>
                </div>

                <div style="display:grid; grid-template-columns:1fr 1fr; gap:20px;">
                    <div class="form-group-block">
                        <label class="form-group-label">Express Courier Upgrade ($)</label>
                        <div class="field-input-box">
                            <span class="field-left-icon">⚡</span>
                            <input type="number" step="0.01" name="express_shipping_rate" value="{{ old('express_shipping_rate', $settings['express_shipping_rate']) }}" class="settings-input-control" required>
                        </div>
                    </div>

                    <div class="form-group-block">
                        <label class="form-group-label">Primary Dispatch / Fulfillment Origin</label>
                        <div class="field-input-box">
                            <span class="field-left-icon">📍</span>
                            <input type="text" name="shipping_origin" value="{{ old('shipping_origin', $settings['shipping_origin']) }}" class="settings-input-control" placeholder="Phnom Penh Distribution Hub">
                        </div>
                    </div>
                </div>
            @endif

            {{-- ============================================================
                 4. NOTIFICATION & ALERT SETTINGS
                 ============================================================ --}}
            @if ($group === 'notification')
                <div class="section-headline">
                    <div>
                        <div class="section-title">
                            <span>🔔</span>
                            <span>Automated Alerts & Dispatch Notifications</span>
                        </div>
                        <div class="section-desc">
                            Configure administrative order alerts, customer notification triggers, and low stock warnings.
                        </div>
                    </div>
                </div>

                <div class="form-group-block" style="margin-bottom:24px;">
                    <label class="form-group-label">Manager Notification Alert Email</label>
                    <div class="field-input-box">
                        <span class="field-left-icon">✉️</span>
                        <input type="email" name="admin_notify_email" value="{{ old('admin_notify_email', $settings['admin_notify_email']) }}" class="settings-input-control" required>
                    </div>
                </div>

                <div class="toggle-option-card">
                    <div>
                        <div class="toggle-info-title">📩 Instant New Order Email Ping</div>
                        <div class="toggle-info-desc">Send immediate notification to store managers whenever a new customer checkout occurs.</div>
                    </div>
                    <select name="notify_on_order" class="status-select-pill">
                        <option value="1" {{ $settings['notify_on_order'] == '1' ? 'selected' : '' }}>Enabled</option>
                        <option value="0" {{ $settings['notify_on_order'] == '0' ? 'selected' : '' }}>Disabled</option>
                    </select>
                </div>

                <div class="toggle-option-card">
                    <div>
                        <div class="toggle-info-title">⚠️ Low Stock Inventory Alert</div>
                        <div class="toggle-info-desc">Trigger dashboard and email warnings when any shirt SKU stock drops below 10 units.</div>
                    </div>
                    <select name="notify_on_low_stock" class="status-select-pill">
                        <option value="1" {{ $settings['notify_on_low_stock'] == '1' ? 'selected' : '' }}>Enabled</option>
                        <option value="0" {{ $settings['notify_on_low_stock'] == '0' ? 'selected' : '' }}>Disabled</option>
                    </select>
                </div>

                <!-- Telegram Order Bot Automated Notifications -->
                <div style="margin-top:28px; background:linear-gradient(135deg, #f0fdf4 0%, #eff6ff 100%); border:1.5px solid #bfdbfe; border-radius:var(--radius-md); padding:24px; box-shadow:0 4px 16px rgba(37,99,235,0.06);">
                    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:18px; flex-wrap:wrap; gap:12px;">
                        <div style="display:flex; align-items:center; gap:12px;">
                            <div style="width:40px; height:40px; border-radius:10px; background:#0284c7; color:#ffffff; display:flex; align-items:center; justify-content:center; box-shadow:0 3px 10px rgba(2,132,199,0.3);">
                                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M21.198 2.433a2.242 2.242 0 0 0-1.022.215l-16.5 6.75a2.25 2.25 0 0 0 .126 4.16l4.026 1.487 1.488 4.027a2.25 2.25 0 0 0 4.16.126l6.75-16.5a2.242 2.242 0 0 0-.215-1.022 2.25 2.25 0 0 0-1.813-1.243z"></path></svg>
                            </div>
                            <div>
                                <div style="font-size:1.1rem; font-weight:850; color:#0f172a;">Instant Telegram Order Notifications</div>
                                <div style="font-size:0.84rem; color:#475569; font-weight:500;">Receive automatic alerts + payment receipt slips directly in your Telegram group or private chat.</div>
                            </div>
                        </div>

                        <select name="enable_telegram_notifications" class="status-select-pill" style="min-width:120px;">
                            <option value="1" {{ ($settings['enable_telegram_notifications'] ?? '1') == '1' ? 'selected' : '' }}>Enabled</option>
                            <option value="0" {{ ($settings['enable_telegram_notifications'] ?? '1') == '0' ? 'selected' : '' }}>Disabled</option>
                        </select>
                    </div>

                    <div style="display:grid; grid-template-columns:1fr 1fr; gap:18px; margin-bottom:14px;">
                        <div>
                            <label class="form-group-label" style="font-size:0.86rem; font-weight:800; color:#0f172a;">Telegram Bot Token</label>
                            <div class="field-input-box">
                                <span class="field-left-icon">🤖</span>
                                <input type="text" name="telegram_bot_token" value="{{ old('telegram_bot_token', $settings['telegram_bot_token'] ?? '') }}" class="settings-input-control" placeholder="e.g. 123456789:ABCdefGhIJKlmNoPQRsTUVwxyZ">
                            </div>
                            <span style="font-size:0.75rem; color:#64748b; margin-top:4px; display:block;">Obtained from <a href="https://t.me/BotFather" target="_blank" style="color:#2563eb; font-weight:700;">@BotFather</a> on Telegram.</span>
                        </div>

                        <div>
                            <div style="display:flex; justify-content:space-between; align-items:center;">
                                <label class="form-group-label" style="font-size:0.86rem; font-weight:800; color:#0f172a;">Telegram Chat / Group ID</label>
                                <button type="submit" formaction="{{ route('admin.settings.telegram.detect') }}" formmethod="POST" style="background:#eff6ff; border:1px solid #bfdbfe; color:#1d4ed8; font-size:0.75rem; font-weight:750; padding:2px 8px; border-radius:6px; cursor:pointer;" title="Click to auto-fetch your ID from /start">
                                    🔍 Auto-Detect ID
                                </button>
                            </div>
                            <div class="field-input-box">
                                <span class="field-left-icon">💬</span>
                                <input type="text" name="telegram_chat_id" value="{{ old('telegram_chat_id', $settings['telegram_chat_id'] ?? '') }}" class="settings-input-control" placeholder="e.g. 1660281294 or -1001234567890">
                            </div>
                            <span style="font-size:0.75rem; color:#64748b; margin-top:4px; display:block;">Chat ID must be numeric (e.g. <code>1660281294</code>), <strong>not</strong> your bot's username.</span>
                        </div>
                    </div>

                    <!-- Connection Action Controls -->
                    <div style="display:flex; align-items:center; justify-content:space-between; margin-top:14px; padding-top:14px; border-top:1px dashed #bfdbfe; flex-wrap:wrap; gap:10px;">
                        <div style="font-size:0.82rem; color:#0369a1; display:flex; align-items:center; gap:6px;">
                            <span>💡</span>
                            <span>Open your Telegram bot and tap <strong>/start</strong>, then click <strong>Auto-Detect ID</strong> or <strong>Send Test Notification</strong>.</span>
                        </div>
                        <button type="submit" formaction="{{ route('admin.settings.telegram.test') }}" formmethod="POST" style="background:linear-gradient(135deg, #0284c7, #0369a1); color:#ffffff; border:none; padding:8px 18px; border-radius:8px; font-size:0.82rem; font-weight:750; cursor:pointer; display:inline-flex; align-items:center; gap:6px; box-shadow:0 2px 8px rgba(2,132,199,0.35);">
                            <span>⚡</span>
                            <span>Send Test Notification (សាកល្បងផ្ញើសារ)</span>
                        </button>
                    </div>
                </div>
            @endif

            {{-- ============================================================
                 5. SECURITY & ACCESS CONTROL
                 ============================================================ --}}
            @if ($group === 'security')
                <div class="section-headline">
                    <div>
                        <div class="section-title">
                            <span>🔒</span>
                            <span>Security Protocols & Access Governance</span>
                        </div>
                        <div class="section-desc">
                            Enforce session lifespans, brute-force rate-limiting, and two-factor authentication for administrators.
                        </div>
                    </div>
                </div>

                <div class="toggle-option-card">
                    <div>
                        <div class="toggle-info-title">🛡️ Two-Factor Authentication (2FA) for Admins</div>
                        <div class="toggle-info-desc">Require OTP authenticator confirmation upon accessing the admin control center.</div>
                    </div>
                    <select name="two_factor_auth" class="status-select-pill">
                        <option value="0" {{ $settings['two_factor_auth'] == '0' ? 'selected' : '' }}>Disabled (Standard)</option>
                        <option value="1" {{ $settings['two_factor_auth'] == '1' ? 'selected' : '' }}>Enforced (Strict)</option>
                    </select>
                </div>

                <div style="display:grid; grid-template-columns:1fr 1fr; gap:20px;">
                    <div class="form-group-block">
                        <label class="form-group-label">Admin Session Idle Timeout (Minutes)</label>
                        <div class="field-input-box">
                            <span class="field-left-icon">⏱️</span>
                            <input type="number" name="session_timeout" value="{{ old('session_timeout', $settings['session_timeout']) }}" class="settings-input-control" required>
                        </div>
                    </div>

                    <div class="form-group-block">
                        <label class="form-group-label">Max Failed Login Rate Limit</label>
                        <div class="field-input-box">
                            <span class="field-left-icon">🚫</span>
                            <input type="number" name="login_attempt_limit" value="{{ old('login_attempt_limit', $settings['login_attempt_limit']) }}" class="settings-input-control" required>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Save Action Button -->
            <div class="save-actions-bar">
                <div style="font-size:0.82rem; color:var(--text-muted); display:flex; align-items:center; gap:6px;">
                    <span>💾</span>
                    <span>Modifications apply globally across customer storefront and admin suites.</span>
                </div>

                <button type="submit" class="btn-executive-save-settings">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path><polyline points="17 21 17 13 7 13 7 21"></polyline><polyline points="7 3 7 8 15 8"></polyline></svg>
                    <span>Save {{ ucfirst($group) }} Settings (រក្សាទុក)</span>
                </button>
            </div>
        </form>
    </div>

</div>
@endsection

@section('scripts')
<script>
    // Live Brand Preview Sync
    function updateLivePreview() {
        const nameInput = document.getElementById('storeNameInput');
        const taglineInput = document.getElementById('storeTaglineInput');
        const currencySelect = document.getElementById('storeCurrencySelect');
        const emailInput = document.getElementById('supportEmailInput');

        if (nameInput) {
            document.getElementById('previewStoreName').textContent = nameInput.value || 'T-Shirt Online';
            const initials = nameInput.value.trim().split(' ').map(w => w[0]).join('').substring(0, 2).toUpperCase() || 'TO';
            document.getElementById('previewLogoBox').textContent = initials;
        }

        if (taglineInput) {
            document.getElementById('previewStoreTagline').textContent = taglineInput.value || 'Premium Streetwear & Graphic T-Shirts';
        }

        if (currencySelect) {
            document.getElementById('previewCurrency').textContent = currencySelect.value;
        }

        if (emailInput) {
            document.getElementById('previewSupportEmail').textContent = emailInput.value || 'admin@tshirtstore.com';
        }
    }

    // QR Preview
    function previewAdminQR(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('adminQrPreview').src = e.target.result;
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection
