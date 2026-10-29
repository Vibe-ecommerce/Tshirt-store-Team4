@extends('layouts.store')

@section('title', 'Checkout — T-Shirt Online')

@section('styles')
<style>
    /* -------------------------------------------------------------
       LUXURY CHECKOUT STYLING
    ------------------------------------------------------------- */
    .checkout-wrap {
        max-width: 1240px;
        margin: 32px auto 80px;
        padding: 0 24px;
    }

    /* Stepper Progress Bar */
    .checkout-stepper {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 16px;
        margin-bottom: 32px;
        flex-wrap: wrap;
    }

    .step-item {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 0.88rem;
        font-weight: 750;
        color: #64748b;
        letter-spacing: 0.2px;
        transition: color 0.2s;
    }

    .step-item.active {
        color: #0f172a;
    }

    .step-number-circle {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: #f1f5f9;
        border: 1.5px solid #cbd5e1;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.85rem;
        font-weight: 850;
        color: #475569;
        transition: all 0.2s;
    }

    .step-item.active .step-number-circle {
        background: #0f172a;
        border-color: #0f172a;
        color: #ffffff;
        box-shadow: 0 4px 12px rgba(15, 23, 42, 0.2);
    }

    .step-divider {
        width: 38px;
        height: 2px;
        background: #e2e8f0;
        border-radius: 2px;
    }

    .page-header-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 28px;
        flex-wrap: wrap;
        gap: 12px;
    }

    .checkout-page-title {
        font-size: 2.1rem;
        font-weight: 900;
        color: #0f172a;
        letter-spacing: -0.7px;
    }

    .checkout-secure-pill {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        background: #eff6ff;
        border: 1px solid #bfdbfe;
        color: #1d4ed8;
        padding: 6px 14px;
        border-radius: 9999px;
        font-size: 0.76rem;
        font-weight: 800;
        letter-spacing: 0.4px;
        text-transform: uppercase;
    }

    /* Main Grid */
    .checkout-grid {
        display: grid;
        grid-template-columns: 1.75fr 1.25fr;
        gap: 32px;
        align-items: start;
    }

    @media (max-width: 980px) {
        .checkout-grid {
            grid-template-columns: 1fr;
        }
    }

    /* Panels */
    .card-panel {
        background: #ffffff;
        border: 1.5px solid #e2e8f0;
        border-radius: 20px;
        padding: 30px;
        margin-bottom: 24px;
        box-shadow: 0 4px 20px -2px rgba(15, 23, 42, 0.04);
        transition: box-shadow 0.2s ease, border-color 0.2s ease;
    }

    .card-panel:hover {
        border-color: #cbd5e1;
    }

    .panel-heading {
        font-size: 1.18rem;
        font-weight: 850;
        margin-bottom: 22px;
        display: flex;
        align-items: center;
        gap: 12px;
        color: #0f172a;
        letter-spacing: -0.3px;
    }

    .step-badge-num {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        background: #0f172a;
        color: #ffffff;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 0.82rem;
        font-weight: 850;
        box-shadow: 0 2px 6px rgba(15, 23, 42, 0.25);
        flex-shrink: 0;
    }

    /* Form Inputs */
    .form-grid-2 {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 16px;
        margin-bottom: 16px;
    }

    @media (max-width: 620px) {
        .form-grid-2 {
            grid-template-columns: 1fr;
        }
    }

    .form-group {
        display: flex;
        flex-direction: column;
        gap: 6px;
        margin-bottom: 16px;
    }

    .form-label {
        font-size: 0.78rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.4px;
        color: #334155;
    }

    .form-control {
        background: #f8fafc !important;
        border: 1.5px solid #cbd5e1 !important;
        color: #0f172a !important;
        padding: 11px 16px;
        border-radius: 12px;
        font-size: 0.92rem;
        font-weight: 600;
        outline: none;
        transition: all 0.2s ease;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.02);
    }

    .form-control::placeholder {
        color: #94a3b8;
        font-weight: 450;
    }

    .form-control:focus {
        border-color: #2563eb !important;
        box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.12) !important;
        background: #ffffff !important;
    }

    /* Preferred Contact Channels */
    .preferred-contact-card {
        background: linear-gradient(135deg, #f8fafc 0%, #f0fdf4 100%);
        border: 1.5px solid #cbd5e1;
        border-radius: 14px;
        padding: 16px 18px;
        margin-top: 18px;
    }

    .channels-selector-row {
        display: flex;
        gap: 12px;
        margin-top: 10px;
        flex-wrap: wrap;
    }

    .channel-checkbox-pill {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 16px;
        border-radius: 9999px;
        border: 1.5px solid #cbd5e1;
        background: #ffffff;
        cursor: pointer;
        font-size: 0.84rem;
        font-weight: 750;
        color: #334155;
        user-select: none;
        transition: all 0.2s;
    }

    .channel-checkbox-pill input[type="checkbox"] {
        accent-color: #2563eb;
        width: 16px;
        height: 16px;
        cursor: pointer;
    }

    .channel-checkbox-pill:hover {
        background: #f1f5f9;
        border-color: #94a3b8;
    }

    /* -------------------------------------------------------------
       DELIVERY OPTIONS WITH ESTIMATED DATES
    ------------------------------------------------------------- */
    .delivery-options-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 14px;
    }

    @media (max-width: 620px) {
        .delivery-options-grid {
            grid-template-columns: 1fr;
        }
    }

    .delivery-card {
        border: 1.5px solid #e2e8f0;
        background: #ffffff;
        border-radius: 14px;
        padding: 18px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        cursor: pointer;
        transition: all 0.22s cubic-bezier(0.16, 1, 0.3, 1);
        position: relative;
        min-height: 110px;
    }

    .delivery-card:hover {
        border-color: #cbd5e1;
        background: #f8fafc;
        transform: translateY(-1px);
    }

    .delivery-card.active {
        border-color: #2563eb;
        background: #eff6ff;
        box-shadow: 0 4px 14px rgba(37, 99, 235, 0.08);
    }

    .delivery-top-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 8px;
    }

    .delivery-card input[type="radio"] {
        accent-color: #2563eb;
        width: 17px;
        height: 17px;
        cursor: pointer;
    }

    .delivery-edd-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        margin-top: 10px;
        font-size: 0.78rem;
        font-weight: 750;
        color: #1e40af;
        background: #dbeafe;
        padding: 4px 10px;
        border-radius: 6px;
    }

    .delivery-edd-badge.express {
        color: #854d0e;
        background: #fef9c3;
    }

    /* -------------------------------------------------------------
       PAYMENT METHOD TILES (REVAMPED LUXURY DESIGN)
    ------------------------------------------------------------- */
    .payment-tiles-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 14px;
        margin-bottom: 22px;
    }

    @media (max-width: 620px) {
        .payment-tiles-grid {
            grid-template-columns: 1fr;
        }
    }

    .payment-tile {
        border: 2px solid #e2e8f0;
        background: #ffffff;
        border-radius: 16px;
        padding: 16px 18px;
        cursor: pointer;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        min-height: 96px;
        position: relative;
        transition: all 0.22s cubic-bezier(0.16, 1, 0.3, 1);
    }

    .payment-tile:hover {
        border-color: #94a3b8;
        background: #f8fafc;
        transform: translateY(-2px);
        box-shadow: 0 6px 18px rgba(0, 0, 0, 0.04);
    }

    .payment-tile.active {
        border-color: #2563eb;
        background: #eff6ff;
        box-shadow: 0 6px 20px rgba(37, 99, 235, 0.12);
    }

    .payment-tile.khqr-tile.active {
        border-color: #e11d48;
        background: #fff1f2;
        box-shadow: 0 6px 20px rgba(225, 29, 72, 0.12);
    }

    .tile-top-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 8px;
    }

    .tile-radio-wrap {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .tile-radio-wrap input[type="radio"] {
        width: 18px;
        height: 18px;
        cursor: pointer;
        accent-color: #2563eb;
    }

    .khqr-tile input[type="radio"] {
        accent-color: #e11d48;
    }

    .tile-title {
        font-size: 0.95rem;
        font-weight: 850;
        color: #0f172a;
        letter-spacing: -0.2px;
    }

    .tile-badge {
        font-size: 0.68rem;
        font-weight: 850;
        padding: 3px 8px;
        border-radius: 6px;
        letter-spacing: 0.4px;
        text-transform: uppercase;
    }

    .tile-badge.khqr {
        background: #e11d48;
        color: #ffffff;
    }

    .tile-badge.popular {
        background: #dbeafe;
        color: #1e40af;
    }

    .tile-badge.cod {
        background: #dcfce7;
        color: #15803d;
    }

    .tile-desc {
        font-size: 0.78rem;
        color: #64748b;
        font-weight: 550;
        line-height: 1.35;
        padding-left: 28px;
    }

    .tile-logos-row {
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .brand-mini-pill {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        height: 22px;
        padding: 0 7px;
        border-radius: 4px;
        font-size: 0.70rem;
        font-weight: 800;
        background: #ffffff;
        border: 1px solid #cbd5e1;
        color: #334155;
    }

    /* -------------------------------------------------------------
       ACTIVE PAYMENT DETAIL CONTAINERS
    ------------------------------------------------------------- */
    .payment-detail-container {
        display: none;
        animation: detailFade 0.28s cubic-bezier(0.16, 1, 0.3, 1);
        margin-top: 18px;
    }

    @keyframes detailFade {
        from { opacity: 0; transform: translateY(8px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* 1. KHQR Ultra-Luxury Container */
    .khqr-luxury-card {
        background: #ffffff;
        border: 1.5px solid #fecdd3;
        border-radius: 18px;
        padding: 24px;
        box-shadow: 0 8px 30px rgba(225, 29, 72, 0.06);
    }

    .khqr-card-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding-bottom: 16px;
        border-bottom: 1.5px solid #ffe4e6;
        margin-bottom: 20px;
        flex-wrap: wrap;
        gap: 12px;
    }

    .khqr-header-left {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .khqr-logo-icon {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        background: linear-gradient(135deg, #e11d48 0%, #be123c 100%);
        color: #ffffff;
        font-weight: 900;
        font-size: 0.95rem;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 14px rgba(225, 29, 72, 0.35);
        letter-spacing: -0.5px;
    }

    .khqr-amount-box {
        text-align: right;
    }

    .khqr-amount-label {
        font-size: 0.72rem;
        color: #64748b;
        text-transform: uppercase;
        font-weight: 800;
        letter-spacing: 0.5px;
    }

    .khqr-amount-val {
        font-size: 1.55rem;
        font-weight: 900;
        color: #e11d48;
        letter-spacing: -0.5px;
    }

    .khqr-body-grid {
        display: grid;
        grid-template-columns: 220px 1fr;
        gap: 26px;
        align-items: start;
    }

    @media (max-width: 720px) {
        .khqr-body-grid {
            grid-template-columns: 1fr;
        }
    }

    .khqr-qr-frame {
        background: #ffffff;
        padding: 14px;
        border-radius: 16px;
        border: 2px solid #e11d48;
        box-shadow: 0 6px 24px rgba(225, 29, 72, 0.12);
        display: inline-block;
        position: relative;
    }

    .khqr-qr-frame img {
        width: 190px;
        height: auto;
        max-height: 220px;
        object-fit: contain;
        display: block;
        border-radius: 8px;
    }

    .khqr-save-btn {
        margin-top: 10px;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 0.78rem;
        font-weight: 750;
        padding: 7px 16px;
        border-radius: 9999px;
        border: 1.5px solid #cbd5e1;
        background: #ffffff;
        color: #0f172a;
        text-decoration: none;
        transition: all 0.2s;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
    }

    .khqr-save-btn:hover {
        background: #f1f5f9;
        border-color: #94a3b8;
        transform: translateY(-1px);
    }

    .bank-info-card {
        background: #f8fafc;
        border: 1.5px solid #e2e8f0;
        border-radius: 14px;
        padding: 16px 18px;
        margin-bottom: 16px;
    }

    .bank-acc-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
    }

    .copy-acc-btn {
        padding: 7px 16px;
        font-size: 0.80rem;
        font-weight: 750;
        background: #ffffff;
        border: 1.5px solid #cbd5e1;
        border-radius: 8px;
        color: #0f172a;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: all 0.2s;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.03);
    }

    .copy-acc-btn:hover {
        background: #f1f5f9;
        border-color: #94a3b8;
    }

    /* Slip Upload Zone */
    .slip-upload-dropzone {
        display: block;
        border: 2px dashed #93c5fd;
        background: #f8fafc;
        border-radius: 14px;
        padding: 18px;
        text-align: center;
        cursor: pointer;
        transition: all 0.22s;
    }

    .slip-upload-dropzone:hover {
        border-color: #2563eb;
        background: #eff6ff;
    }

    .slip-thumb-preview {
        display: none;
        align-items: center;
        gap: 12px;
        background: #ecfdf5;
        border: 1.5px solid #a7f3d0;
        border-radius: 10px;
        padding: 10px 14px;
        margin-top: 10px;
    }

    /* 2. Credit Card Mock Form */
    .card-payment-box {
        background: #f8fafc;
        border: 1.5px solid #e2e8f0;
        border-radius: 18px;
        padding: 22px;
    }

    .card-accepted-strip {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 16px;
        padding-bottom: 12px;
        border-bottom: 1px solid #e2e8f0;
        flex-wrap: wrap;
        gap: 8px;
    }

    /* 3. Cash on Delivery Box */
    .cod-box {
        background: #f0fdf4;
        border: 1.5px solid #bbf7d0;
        border-radius: 16px;
        padding: 20px 22px;
        display: flex;
        align-items: flex-start;
        gap: 14px;
    }

    /* 4. PayPal Box */
    .paypal-box {
        background: #f0f9ff;
        border: 1.5px solid #bae6fd;
        border-radius: 16px;
        padding: 20px 22px;
        display: flex;
        align-items: flex-start;
        gap: 14px;
    }

    /* -------------------------------------------------------------
       STICKY ORDER SUMMARY SIDEBAR
    ------------------------------------------------------------- */
    .order-summary-panel {
        background: #ffffff;
        border: 1.5px solid #e2e8f0;
        border-radius: 20px;
        padding: 28px;
        position: sticky;
        top: 86px;
        box-shadow: 0 6px 25px -4px rgba(15, 23, 42, 0.06);
    }

    .summary-heading-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 18px;
        padding-bottom: 14px;
        border-bottom: 1.5px solid #e2e8f0;
    }

    .item-preview {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 16px;
        padding-bottom: 14px;
        border-bottom: 1px dashed #e2e8f0;
        gap: 12px;
    }

    .item-preview:last-of-type {
        border-bottom: none;
        margin-bottom: 6px;
        padding-bottom: 0;
    }

    .place-order-btn {
        width: 100%;
        background: #0f172a;
        color: #ffffff;
        border: none;
        padding: 16px 24px;
        border-radius: 9999px;
        font-size: 1.05rem;
        font-weight: 850;
        cursor: pointer;
        margin-top: 24px;
        box-shadow: 0 6px 20px rgba(15, 23, 42, 0.25);
        transition: all 0.22s cubic-bezier(0.16, 1, 0.3, 1);
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
    }

    .place-order-btn:hover {
        background: #000000;
        transform: translateY(-2px);
        box-shadow: 0 10px 28px rgba(15, 23, 42, 0.35);
    }

    .place-order-btn:active {
        transform: translateY(0);
    }

    .place-order-btn svg {
        transition: transform 0.2s ease;
    }

    .place-order-btn:hover svg {
        transform: translateX(4px);
    }

    /* Promo Code Field inside Summary */
    .summary-coupon-box {
        margin-top: 14px;
        margin-bottom: 14px;
    }

    .coupon-inline-row {
        display: flex;
        gap: 8px;
    }

    .coupon-inline-input {
        flex: 1;
        height: 40px;
        background: #f8fafc;
        border: 1.5px solid #cbd5e1;
        border-radius: 10px;
        padding: 0 12px;
        font-size: 0.85rem;
        font-weight: 750;
        text-transform: uppercase;
        color: #0f172a;
        outline: none;
        transition: all 0.2s;
    }

    .coupon-inline-input:focus {
        background: #ffffff;
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.12);
    }

    .coupon-inline-btn {
        height: 40px;
        padding: 0 16px;
        background: #0f172a;
        color: #ffffff;
        border: none;
        border-radius: 10px;
        font-size: 0.84rem;
        font-weight: 800;
        cursor: pointer;
        transition: background 0.2s;
    }

    .coupon-inline-btn:hover {
        background: #000000;
    }
</style>
@endsection

@section('content')

    <div class="checkout-wrap">
        <!-- 1. Checkout Stepper -->
        <div class="checkout-stepper">
            <a href="{{ route('cart.index') }}" class="step-item" style="text-decoration:none;">
                <span class="step-number-circle" style="background:#ecfdf5; border-color:#a7f3d0; color:#059669;">✓</span>
                <span style="color:#059669;">1. Shopping Bag</span>
            </a>
            <div class="step-divider" style="background:#0f172a;"></div>
            <div class="step-item active">
                <span class="step-number-circle">2</span>
                <span>2. Checkout & Delivery</span>
            </div>
            <div class="step-divider"></div>
            <div class="step-item">
                <span class="step-number-circle">3</span>
                <span>3. Order Complete</span>
            </div>
        </div>

        <div class="page-header-row">
            <h1 class="checkout-page-title">Checkout</h1>
            <div class="checkout-secure-pill">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                <span>End-to-End SSL Encrypted</span>
            </div>
        </div>

        <!-- Flash Alert if error or success from coupon -->
        @if (session('success'))
            <div style="background:#ecfdf5; border:1px solid #a7f3d0; color:#065f46; padding:12px 18px; border-radius:12px; margin-bottom:20px; font-weight:700; font-size:0.9rem; display:flex; align-items:center; gap:8px;">
                <span>✓</span>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if (session('error'))
            <div style="background:#fef2f2; border:1px solid #fecaca; color:#b91c1c; padding:12px 18px; border-radius:12px; margin-bottom:20px; font-weight:700; font-size:0.9rem; display:flex; align-items:center; gap:8px;">
                <span>✕</span>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        <form action="{{ route('checkout.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="checkout-grid">
                <div>
                    <!-- 1. Customer Information -->
                    <div class="card-panel">
                        @if ($user)
                            <div style="background: #f8fafc; border: 1.5px solid #e2e8f0; border-radius: 12px; padding: 12px 18px; margin-bottom: 22px; display: flex; align-items: center; justify-content: space-between; font-size: 0.88rem; flex-wrap:wrap; gap:10px;">
                                <div style="display:flex; align-items:center; gap:12px;">
                                    <span style="display:inline-flex; align-items:center; justify-content:center; width:36px; height:36px; border-radius:50%; background:linear-gradient(135deg, #2563eb, #1e40af); font-weight:800; color:#ffffff; font-size:0.88rem; box-shadow:0 2px 8px rgba(37,99,235,0.3);">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </span>
                                    <div>
                                        <div style="color:#0f172a; font-weight:750;">
                                            Purchasing as <strong>{{ $user->name }}</strong>
                                        </div>
                                        <div style="font-size:0.78rem; color:#64748b; font-weight:600;">
                                            {{ $user->email }}
                                        </div>
                                    </div>
                                </div>
                                <span style="color:#065f46; font-size:0.76rem; font-weight:800; background:#ecfdf5; padding:4px 12px; border-radius:9999px; border:1px solid #a7f3d0; display:inline-flex; align-items:center; gap:5px;">
                                    ✓ Verified Customer
                                </span>
                            </div>
                        @endif

                        <h3 class="panel-heading">
                            <span class="step-badge-num">1</span>
                            Customer Information
                        </h3>

                        <div class="form-grid-2">
                            <div class="form-group">
                                <label class="form-label">Full Name *</label>
                                <input type="text" name="customer_name" class="form-control" value="{{ old('customer_name', $user->name ?? '') }}" required placeholder="e.g. John Doe">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Email Address *</label>
                                <input type="email" name="customer_email" class="form-control" value="{{ old('customer_email', $user->email ?? '') }}" required placeholder="e.g. john@example.com">
                            </div>
                        </div>

                        <div class="form-group" style="margin-bottom: 0;">
                            <label class="form-label">Phone Number *</label>
                            <input type="tel" name="customer_phone" class="form-control" value="{{ old('customer_phone', $user->phone ?? '') }}" required placeholder="e.g. +855 12 345 678">
                        </div>

                        <!-- Preferred Contact / Notification Channels (NEW FEATURE) -->
                        <div class="preferred-contact-card">
                            <div style="font-size:0.76rem; font-weight:800; text-transform:uppercase; letter-spacing:0.5px; color:#1e293b; display:flex; align-items:center; gap:6px;">
                                <span>📱 Order Confirmation & Delivery Updates Channel</span>
                            </div>
                            <div class="channels-selector-row">
                                <label class="channel-checkbox-pill">
                                    <input type="checkbox" name="notify_telegram" value="1" checked>
                                    <span style="display:inline-flex; align-items:center; gap:6px;">
                                        <svg width="15" height="15" viewBox="0 0 24 24" fill="#0284c7"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm4.64 6.8c-.15 1.58-.8 5.42-1.13 7.19-.14.75-.42 1-.68 1.03-.58.05-1.02-.38-1.58-.75-.88-.58-1.38-.94-2.23-1.5-.99-.65-.35-1.01.22-1.59.15-.15 2.71-2.48 2.76-2.69a.2.2 0 0 0-.05-.18c-.06-.05-.14-.03-.21-.02-.09.02-1.49.95-4.22 2.79-.4.27-.76.41-1.08.4-.36-.01-1.04-.2-1.55-.37-.63-.2-1.12-.31-1.08-.66.02-.18.27-.36.74-.55 2.92-1.27 4.86-2.11 5.83-2.52 2.78-1.16 3.35-1.36 3.73-1.36.08 0 .27.02.39.12.1.08.13.19.14.27-.01.06.01.24 0 .38z"/></svg>
                                        <span>Send via Telegram</span>
                                    </span>
                                </label>
                                <label class="channel-checkbox-pill">
                                    <input type="checkbox" name="notify_whatsapp" value="1" checked>
                                    <span style="display:inline-flex; align-items:center; gap:6px;">
                                        <svg width="15" height="15" viewBox="0 0 24 24" fill="#16a34a"><path d="M12.04 2c-5.46 0-9.91 4.45-9.91 9.91 0 1.75.46 3.45 1.32 4.95L2.05 22l5.25-1.38c1.45.79 3.08 1.21 4.74 1.21 5.46 0 9.91-4.45 9.91-9.91 0-2.65-1.03-5.14-2.9-7.01A9.82 9.82 0 0 0 12.04 2m.01 1.67c2.2 0 4.26.86 5.82 2.42a8.23 8.23 0 0 1 2.41 5.83c0 4.54-3.7 8.24-8.24 8.24-1.48 0-2.93-.4-4.2-1.15l-.3-.18-3.12.82.83-3.04-.2-.31a8.19 8.19 0 0 1-1.26-4.38c0-4.54 3.7-8.24 8.24-8.24m4.52 11.63c-.25-.13-1.47-.72-1.7-.81-.23-.08-.39-.13-.56.13-.17.25-.64.81-.79.97-.14.17-.29.19-.54.06-.25-.13-1.06-.39-2.02-1.25-.75-.67-1.26-1.5-1.41-1.75-.15-.25-.02-.39.11-.51.11-.11.25-.29.38-.44.12-.14.17-.25.25-.42.08-.17.04-.31-.02-.44-.06-.13-.56-1.35-.77-1.85-.2-.49-.41-.42-.56-.43h-.48c-.17 0-.44.06-.67.31-.23.25-.88.86-.88 2.1 0 1.24.9 2.44 1.03 2.61.13.17 1.77 2.7 4.29 3.79.6.26 1.07.41 1.44.53.6.19 1.15.16 1.58.1.48-.07 1.47-.6 1.68-1.18.21-.58.21-1.07.15-1.18-.06-.11-.22-.18-.47-.3z"/></svg>
                                        <span>Send via WhatsApp</span>
                                    </span>
                                </label>
                            </div>
                            <div style="font-size:0.75rem; color:#64748b; margin-top:8px;">
                                We will send instant order tracking, courier dispatch alerts, and payment verification to this number.
                            </div>
                        </div>
                    </div>

                    <!-- 2. Shipping Address -->
                    <div class="card-panel">
                        <h3 class="panel-heading">
                            <span class="step-badge-num">2</span>
                            Shipping Address
                        </h3>

                        <div class="form-group">
                            <label class="form-label">Street Address *</label>
                            <input type="text" name="shipping_address" class="form-control" value="{{ old('shipping_address', $user->address ?? '') }}" required placeholder="Building, street address, apartment or landmark">
                        </div>

                        <div class="form-grid-2" style="margin-bottom: 0;">
                            <div class="form-group" style="margin-bottom: 0;">
                                <label class="form-label">City *</label>
                                <input type="text" name="city" class="form-control" value="{{ old('city', $user->city ?? '') }}" required placeholder="e.g. Phnom Penh">
                            </div>
                            <div class="form-group" style="margin-bottom: 0;">
                                <label class="form-label">Postal / Zip Code (Optional)</label>
                                <input type="text" name="postal_code" class="form-control" value="{{ old('postal_code', $user->postal_code ?? '') }}" placeholder="e.g. 12000">
                            </div>
                        </div>
                    </div>

                    <!-- 3. Delivery Method (WITH ESTIMATED DELIVERY DATES) -->
                    <div class="card-panel">
                        <h3 class="panel-heading">
                            <span class="step-badge-num">3</span>
                            Delivery Method
                        </h3>

                        <div class="delivery-options-grid">
                            <label class="delivery-card active" id="deliveryCardStandard" onclick="selectDeliveryCard('Standard')">
                                <div>
                                    <div class="delivery-top-row">
                                        <div style="display:flex; align-items:center; gap:10px;">
                                            <input type="radio" name="delivery_method" value="Standard" checked id="delivStandard">
                                            <strong style="font-size:0.95rem; color:#0f172a;">Standard Ground</strong>
                                        </div>
                                        <span style="color:#059669; font-weight:850; background:#ecfdf5; border:1px solid #a7f3d0; padding:3px 10px; border-radius:9999px; font-size:0.78rem;">
                                            {{ $subtotal >= 50 ? 'FREE' : '$5.00' }}
                                        </span>
                                    </div>
                                    <div style="font-size:0.80rem; color:#64748b; padding-left:26px;">Safe standard postal dispatch</div>
                                </div>

                                <div class="delivery-edd-badge">
                                    <span>📦 Est. Arrival:</span>
                                    <strong>{{ $estStandardStart }} – {{ $estStandardEnd }}</strong>
                                </div>
                            </label>

                            <label class="delivery-card" id="deliveryCardExpress" onclick="selectDeliveryCard('Express')">
                                <div>
                                    <div class="delivery-top-row">
                                        <div style="display:flex; align-items:center; gap:10px;">
                                            <input type="radio" name="delivery_method" value="Express" id="delivExpress">
                                            <strong style="font-size:0.95rem; color:#0f172a;">Express Air Courier</strong>
                                        </div>
                                        <span style="font-weight:850; font-size:0.88rem; color:#0f172a; background:#f1f5f9; padding:3px 10px; border-radius:9999px; border:1px solid #e2e8f0;">
                                            $9.99
                                        </span>
                                    </div>
                                    <div style="font-size:0.80rem; color:#64748b; padding-left:26px;">Priority courier with VIP tracking</div>
                                </div>

                                <div class="delivery-edd-badge express">
                                    <span>⚡ Est. Arrival:</span>
                                    <strong>Tomorrow, {{ $estExpress }} by 6:00 PM</strong>
                                </div>
                            </label>
                        </div>
                    </div>

                    <!-- 4. Payment Method (REVAMPED LUXURY DESIGN) -->
                    <div class="card-panel" id="paymentSectionPanel">
                        <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:20px; flex-wrap:wrap; gap:10px;">
                            <h3 class="panel-heading" style="margin-bottom:0;">
                                <span class="step-badge-num">4</span>
                                Select Payment Method
                            </h3>
                            <span style="font-size:0.75rem; color:#64748b; font-weight:700;">
                                🛡️ Fast & Verified Processing
                            </span>
                        </div>

                        <!-- Payment Option Tiles Grid -->
                        <div class="payment-tiles-grid">
                            <!-- 1. KHQR / Bank QR Option -->
                            @if (!empty($qrSettings['enabled']))
                                <div class="payment-tile khqr-tile active" id="tileKHQR" onclick="selectPaymentMethod('QR Code')">
                                    <div class="tile-top-row">
                                        <div class="tile-radio-wrap">
                                            <input type="radio" name="payment_method" value="QR Code" id="payMethodQR" checked>
                                            <span class="tile-title">KHQR Scan & Pay</span>
                                        </div>
                                        <span class="tile-badge khqr">Instant • Cambodia</span>
                                    </div>
                                    <div class="tile-desc">ABA Mobile, Bakong, Wing, ACLEDA & all banks</div>
                                    <div class="tile-logos-row" style="margin-top:10px; padding-left:28px;">
                                        <span class="brand-mini-pill" style="color:#e11d48; border-color:#fecdd3; font-weight:900;">KHQR</span>
                                        <span class="brand-mini-pill">ABA</span>
                                        <span class="brand-mini-pill">Bakong</span>
                                        <span class="brand-mini-pill">Wing</span>
                                    </div>
                                </div>
                            @endif

                            <!-- 2. Credit Card Option -->
                            <div class="payment-tile" id="tileCard" onclick="selectPaymentMethod('Credit Card')">
                                <div class="tile-top-row">
                                    <div class="tile-radio-wrap">
                                        <input type="radio" name="payment_method" value="Credit Card" id="payMethodCard" {{ empty($qrSettings['enabled']) ? 'checked' : '' }}>
                                        <span class="tile-title">Credit or Debit Card</span>
                                    </div>
                                    <span class="tile-badge popular">Global</span>
                                </div>
                                <div class="tile-desc">Visa, Mastercard, JCB, Apple Pay</div>
                                <div class="tile-logos-row" style="margin-top:10px; padding-left:28px;">
                                    <span class="brand-mini-pill" style="font-weight:900; color:#1e40af;">VISA</span>
                                    <span class="brand-mini-pill" style="font-weight:900; color:#ea580c;">MC</span>
                                    <span class="brand-mini-pill">Apple Pay</span>
                                </div>
                            </div>

                            <!-- 3. Cash on Delivery (COD) Option -->
                            <div class="payment-tile" id="tileCOD" onclick="selectPaymentMethod('Cash on Delivery')">
                                <div class="tile-top-row">
                                    <div class="tile-radio-wrap">
                                        <input type="radio" name="payment_method" value="Cash on Delivery" id="payMethodCOD">
                                        <span class="tile-title">Cash on Delivery</span>
                                    </div>
                                    <span class="tile-badge cod">COD</span>
                                </div>
                                <div class="tile-desc">Pay cash directly upon parcel delivery</div>
                                <div class="tile-logos-row" style="margin-top:10px; padding-left:28px;">
                                    <span class="brand-mini-pill" style="color:#15803d; border-color:#bbf7d0;">💵 Cash on Arrival</span>
                                </div>
                            </div>

                            <!-- 4. PayPal Option -->
                            <div class="payment-tile" id="tilePayPal" onclick="selectPaymentMethod('PayPal')">
                                <div class="tile-top-row">
                                    <div class="tile-radio-wrap">
                                        <input type="radio" name="payment_method" value="PayPal" id="payMethodPayPal">
                                        <span class="tile-title">PayPal Express</span>
                                    </div>
                                    <span class="tile-badge popular">Fast</span>
                                </div>
                                <div class="tile-desc">Checkout safely via your PayPal account</div>
                                <div class="tile-logos-row" style="margin-top:10px; padding-left:28px;">
                                    <span class="brand-mini-pill" style="color:#0284c7; font-weight:850;">PayPal</span>
                                </div>
                            </div>
                        </div>

                        <!-- ---------------------------------------------------------
                             PAYMENT METHOD DETAILS DYNAMIC PANELS
                        ---------------------------------------------------------- -->

                        <!-- Detail Panel 1: KHQR Bank Scan -->
                        @if (!empty($qrSettings['enabled']))
                            <div class="payment-detail-container" id="detailKHQR" style="display:block;">
                                <div class="khqr-luxury-card">
                                    <div class="khqr-card-header">
                                        <div class="khqr-header-left">
                                            <div class="khqr-logo-icon">KHQR</div>
                                            <div>
                                                <div style="font-weight:850; font-size:1.12rem; color:#0f172a;">{{ $qrSettings['bank_name'] }}</div>
                                                <div style="font-size:0.78rem; color:#64748b; font-weight:600;">Standard Bakong & National Bank of Cambodia</div>
                                            </div>
                                        </div>
                                        <div class="khqr-amount-box">
                                            <div class="khqr-amount-label">Amount to Transfer</div>
                                            <div class="khqr-amount-val">${{ number_format($total, 2) }} USD</div>
                                        </div>
                                    </div>

                                    <div class="khqr-body-grid">
                                        <!-- Left: High-Res QR Visual Card -->
                                        <div style="text-align:center;">
                                            <div class="khqr-qr-frame">
                                                <img src="{{ asset($qrSettings['image']) }}" alt="Scan KHQR to pay">
                                            </div>
                                            <div>
                                                <a href="{{ asset($qrSettings['image']) }}" download="Store_Payment_QR" class="khqr-save-btn">
                                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                                                    <span>Save QR to Gallery</span>
                                                </a>
                                            </div>
                                        </div>

                                        <!-- Right: Account Details & Upload Slip -->
                                        <div>
                                            <div class="bank-info-card">
                                                <div style="font-size:0.72rem; text-transform:uppercase; color:#64748b; font-weight:800; letter-spacing:0.5px;">Account Name</div>
                                                <div style="font-size:1.05rem; font-weight:850; color:#0f172a; margin-bottom:12px;">{{ $qrSettings['account_name'] }}</div>

                                                <div class="bank-acc-row">
                                                    <div>
                                                        <div style="font-size:0.72rem; text-transform:uppercase; color:#64748b; font-weight:800; letter-spacing:0.5px;">Account Number</div>
                                                        <div style="font-size:1.3rem; font-weight:900; color:#059669; letter-spacing:0.8px;" id="qrAccNum">{{ $qrSettings['account_number'] }}</div>
                                                    </div>
                                                    <button type="button" onclick="copyAccountNumber()" class="copy-acc-btn" id="copyBtn">
                                                        <span>📋</span>
                                                        <span>Copy Number</span>
                                                    </button>
                                                </div>
                                            </div>

                                            <div style="font-size:0.84rem; color:#1e40af; line-height:1.5; margin-bottom:16px; background:#eff6ff; border:1px solid #bfdbfe; border-left:4px solid #3b82f6; padding:12px 16px; border-radius:10px; font-weight:600;">
                                                💡 {{ $qrSettings['instructions'] }}
                                            </div>

                                            <!-- Receipt Slip Upload & Ref -->
                                            <div class="form-grid-2" style="margin-bottom:0;">
                                                <div>
                                                    <label class="form-label">Payment Receipt / Slip Screenshot</label>
                                                    <label for="slipFileInput" class="slip-upload-dropzone">
                                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#2563eb" stroke-width="2.2" style="display:block; margin:0 auto 6px;"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="17 8 12 3 7 8"></polyline><line x1="12" y1="3" x2="12" y2="15"></line></svg>
                                                        <span id="slipFileLabel" style="font-size:0.84rem; font-weight:750; color:#2563eb; display:block;">Click to upload receipt</span>
                                                        <span style="font-size:0.72rem; color:#94a3b8; display:block; margin-top:2px;">PNG, JPG up to 6MB</span>
                                                    </label>
                                                    <input type="file" id="slipFileInput" name="payment_slip" accept="image/*" style="display:none;" onchange="handleSlipSelected(this)">

                                                    <div id="slipThumbnailWrap" class="slip-thumb-preview">
                                                        <img id="slipThumbnail" src="" style="width:38px; height:38px; border-radius:6px; object-fit:cover; border:1px solid #6ee7b7;">
                                                        <div style="flex:1; overflow:hidden;">
                                                            <span style="font-size:0.78rem; color:#065f46; font-weight:800; display:block;">✓ Receipt Attached</span>
                                                            <span id="slipFileNameText" style="font-size:0.72rem; color:#1e293b; font-weight:600; white-space:nowrap; text-overflow:ellipsis; overflow:hidden; display:block;"></span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div>
                                                    <label class="form-label">Transaction / Ref # (Optional)</label>
                                                    <input type="text" name="payment_reference" placeholder="e.g. 84920491 or ABA Ref" class="form-control" style="height:44px;">
                                                    <span style="font-size:0.72rem; color:#64748b; margin-top:4px; display:block;">Found in your banking app receipt.</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- Detail Panel 2: Credit Card Mock Form -->
                        <div class="payment-detail-container" id="detailCard">
                            <div class="card-payment-box">
                                <div class="card-accepted-strip">
                                    <div style="font-weight:750; font-size:0.88rem; color:#0f172a;">Card Details</div>
                                    <div style="display:flex; align-items:center; gap:6px;">
                                        <span class="brand-mini-pill" style="font-weight:900; color:#1e40af;">VISA</span>
                                        <span class="brand-mini-pill" style="font-weight:900; color:#ea580c;">MASTERCARD</span>
                                        <span class="brand-mini-pill">AMEX</span>
                                        <span class="brand-mini-pill">JCB</span>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="form-label">Cardholder Name</label>
                                    <input type="text" class="form-control" placeholder="Name as printed on card" value="{{ $user->name ?? '' }}">
                                </div>

                                <div class="form-group">
                                    <label class="form-label">Card Number</label>
                                    <div style="position:relative; display:flex; align-items:center;">
                                        <input type="text" class="form-control" placeholder="4242 •••• •••• 4242" style="width:100%; padding-right:45px;" maxlength="19">
                                        <span style="position:absolute; right:14px; font-size:1.1rem; color:#64748b;">💳</span>
                                    </div>
                                </div>

                                <div class="form-grid-2" style="margin-bottom:0;">
                                    <div class="form-group" style="margin-bottom:0;">
                                        <label class="form-label">Expiration Date</label>
                                        <input type="text" class="form-control" placeholder="MM / YY" maxlength="5">
                                    </div>
                                    <div class="form-group" style="margin-bottom:0;">
                                        <label class="form-label">Security Code (CVC)</label>
                                        <input type="text" class="form-control" placeholder="•••" maxlength="4">
                                    </div>
                                </div>

                                <div style="display:flex; align-items:center; gap:8px; margin-top:14px; font-size:0.78rem; color:#64748b;">
                                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                                    <span>Encrypted with 256-bit AES military-grade payment encryption.</span>
                                </div>
                            </div>
                        </div>

                        <!-- Detail Panel 3: Cash on Delivery (COD) -->
                        <div class="payment-detail-container" id="detailCOD">
                            <div class="cod-box">
                                <span style="font-size:1.8rem; line-height:1;">💵</span>
                                <div>
                                    <div style="font-weight:850; font-size:1rem; color:#065f46; margin-bottom:4px;">Cash on Delivery Selected</div>
                                    <div style="font-size:0.86rem; color:#166534; line-height:1.5;">
                                        You do not need to pay anything online now. Please prepare <strong>${{ number_format($total, 2) }} USD</strong> in cash to hand to the delivery courier when your order arrives.
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Detail Panel 4: PayPal -->
                        <div class="payment-detail-container" id="detailPayPal">
                            <div class="paypal-box">
                                <span style="font-size:1.8rem; line-height:1;">🅿️</span>
                                <div>
                                    <div style="font-weight:850; font-size:1rem; color:#0369a1; margin-bottom:4px;">PayPal Express Checkout</div>
                                    <div style="font-size:0.86rem; color:#075985; line-height:1.5;">
                                        After clicking <strong>Place Order</strong>, you will be redirected to PayPal's secure gateway to finalize your payment via PayPal Balance or linked bank accounts.
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Order Notes -->
                        <div class="form-group" style="margin-top:22px; margin-bottom: 0;">
                            <label class="form-label">Order Notes / Delivery Instructions (Optional)</label>
                            <textarea name="notes" class="form-control" rows="2" placeholder="e.g. Please leave with security guard, or call upon arrival."></textarea>
                        </div>
                    </div>
                </div>

                <!-- 5. Order Summary Sidebar (Sticky) -->
                <div>
                    <div class="order-summary-panel">
                        <div class="summary-heading-row">
                            <h3 style="font-size:1.20rem; font-weight:850; color:#0f172a; letter-spacing:-0.2px;">
                                Items in Order ({{ count($cart) }})
                            </h3>
                            <a href="{{ route('cart.index') }}" style="font-size:0.82rem; font-weight:750; color:#2563eb; text-decoration:none;">
                                Edit Cart
                            </a>
                        </div>

                        @foreach ($cart as $item)
                            <div class="item-preview">
                                <div style="display:flex; align-items:center; gap: 12px;">
                                    <img src="{{ asset($item['image']) }}" alt="{{ $item['name'] }}" style="width:52px; height:52px; border-radius:10px; object-fit:cover; border:1.5px solid #e2e8f0; flex-shrink:0;">
                                    <div>
                                        <div style="font-weight:750; font-size:0.92rem; color:#0f172a !important; line-height:1.35;">{{ $item['name'] }}</div>
                                        <div style="font-size:0.80rem; font-weight:600; color:#64748b; margin-top:2px;">Size: {{ $item['size'] ?? 'L' }} &times; {{ $item['quantity'] }}</div>
                                    </div>
                                </div>
                                <span style="font-weight:850; font-size:0.95rem; color:#0f172a;">${{ number_format($item['price'] * $item['quantity'], 2) }}</span>
                            </div>
                        @endforeach

                        <!-- Promo Code Box on Checkout (NEW FEATURE 1) -->
                        <div class="summary-coupon-box">
                            @if ($discount == 0)
                                <div class="coupon-inline-row">
                                    <input type="text" name="coupon_code" placeholder="Promo code (e.g. WELCOME10)" class="coupon-inline-input">
                                    <button type="submit" formaction="{{ route('cart.coupon') }}" formmethod="POST" class="coupon-inline-btn" title="Apply promo code">
                                        Apply
                                    </button>
                                </div>
                                <div style="font-size:0.72rem; color:#64748b; margin-top:5px; display:flex; justify-content:space-between;">
                                    <span>Have a voucher? Enter code above.</span>
                                </div>
                            @else
                                <div style="display:flex; justify-content:space-between; align-items:center; background:#ecfdf5; border:1.5px solid #a7f3d0; border-radius:10px; padding:8px 12px; font-size:0.84rem;">
                                    <div style="display:flex; align-items:center; gap:6px; color:#065f46; font-weight:750;">
                                        <span>🎟️</span>
                                        <span>Coupon <strong>{{ $coupon['code'] }}</strong> applied!</span>
                                    </div>
                                    <a href="{{ route('cart.coupon.remove') }}" style="color:#b91c1c; font-size:0.74rem; font-weight:800; text-decoration:none; padding:3px 8px; background:#ffffff; border:1px solid #fecaca; border-radius:6px; transition:all 0.15s;">
                                        Remove
                                    </a>
                                </div>
                            @endif
                        </div>

                        <div style="margin-top:14px; padding-top:14px; border-top:1.5px solid #e2e8f0;">
                            <div style="display:flex; justify-content:space-between; margin-bottom:12px; font-size:0.92rem;">
                                <span style="color:#475569; font-weight:600;">Subtotal</span>
                                <span style="color:#0f172a; font-weight:750;">${{ number_format($subtotal, 2) }}</span>
                            </div>

                            @if ($discount > 0)
                                <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:12px; font-size:0.90rem; color:#15803d; background:#ecfdf5; padding:7px 12px; border-radius:8px; border:1px solid #bbf7d0;">
                                    <span style="font-weight:750; display:flex; align-items:center; gap:6px;">
                                        <span>🎟️</span>
                                        <span>Discount ({{ $coupon['code'] }})</span>
                                    </span>
                                    <span style="font-weight:850;">-${{ number_format($discount, 2) }}</span>
                                </div>
                            @endif

                            <div style="display:flex; justify-content:space-between; margin-bottom:12px; font-size:0.92rem;">
                                <span style="color:#475569; font-weight:600;">Shipping</span>
                                <span style="color:#0f172a; font-weight:750;">{{ $shipping == 0 ? 'FREE' : '$' . number_format($shipping, 2) }}</span>
                            </div>

                            <div style="display:flex; justify-content:space-between; align-items:baseline; margin-top:16px; padding-top:16px; border-top:1.5px solid #e2e8f0;">
                                <span style="font-size:1.20rem; font-weight:900; color:#0f172a !important;">Total</span>
                                <span style="font-size:1.60rem; font-weight:900; color:#0f172a !important; letter-spacing:-0.5px;">${{ number_format($total, 2) }}</span>
                            </div>
                        </div>

                        <!-- Place Order Button -->
                        <button type="submit" class="place-order-btn">
                            <span>Place Order (${{ number_format($total, 2) }})</span>
                            <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
                        </button>

                        <div style="background:#f8fafc; border:1px solid #e2e8f0; border-radius:12px; padding:11px 14px; text-align:center; margin-top:18px; font-size:0.78rem; font-weight:600; color:#475569; display:flex; align-items:center; justify-content:center; gap:8px;">
                            <span>🔒</span>
                            <span>256-Bit SSL Encrypted & Secure Checkout</span>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

<script>
    // Delivery Method selection
    function selectDeliveryCard(type) {
        const stdCard = document.getElementById('deliveryCardStandard');
        const expCard = document.getElementById('deliveryCardExpress');
        const stdRadio = document.getElementById('delivStandard');
        const expRadio = document.getElementById('delivExpress');

        if (type === 'Standard') {
            stdRadio.checked = true;
            stdCard.classList.add('active');
            expCard.classList.remove('active');
        } else {
            expRadio.checked = true;
            expCard.classList.add('active');
            stdCard.classList.remove('active');
        }
    }

    // Payment Method selection & dynamic details switching
    function selectPaymentMethod(method) {
        // Uncheck/check radios
        const radioQR = document.getElementById('payMethodQR');
        const radioCard = document.getElementById('payMethodCard');
        const radioCOD = document.getElementById('payMethodCOD');
        const radioPayPal = document.getElementById('payMethodPayPal');

        // Tiles
        const tileQR = document.getElementById('tileKHQR');
        const tileCard = document.getElementById('tileCard');
        const tileCOD = document.getElementById('tileCOD');
        const tilePayPal = document.getElementById('tilePayPal');

        // Details
        const detailQR = document.getElementById('detailKHQR');
        const detailCard = document.getElementById('detailCard');
        const detailCOD = document.getElementById('detailCOD');
        const detailPayPal = document.getElementById('detailPayPal');

        // Clear active classes
        [tileQR, tileCard, tileCOD, tilePayPal].forEach(t => t && t.classList.remove('active'));
        [detailQR, detailCard, detailCOD, detailPayPal].forEach(d => d && (d.style.display = 'none'));

        if (method === 'QR Code' && radioQR) {
            radioQR.checked = true;
            if (tileQR) tileQR.classList.add('active');
            if (detailQR) detailQR.style.display = 'block';
        } else if (method === 'Credit Card') {
            if (radioCard) radioCard.checked = true;
            if (tileCard) tileCard.classList.add('active');
            if (detailCard) detailCard.style.display = 'block';
        } else if (method === 'Cash on Delivery') {
            if (radioCOD) radioCOD.checked = true;
            if (tileCOD) tileCOD.classList.add('active');
            if (detailCOD) detailCOD.style.display = 'block';
        } else if (method === 'PayPal') {
            if (radioPayPal) radioPayPal.checked = true;
            if (tilePayPal) tilePayPal.classList.add('active');
            if (detailPayPal) detailPayPal.style.display = 'block';
        }
    }

    // Copy Account Number
    function copyAccountNumber() {
        const accEl = document.getElementById('qrAccNum');
        if (accEl) {
            const raw = accEl.innerText.replace(/[^0-9]/g, '');
            navigator.clipboard.writeText(raw || accEl.innerText.trim()).then(() => {
                const btn = document.getElementById('copyBtn');
                if (btn) {
                    btn.innerHTML = '<span>✓</span><span>Copied!</span>';
                    btn.style.color = '#059669';
                    btn.style.borderColor = '#059669';
                    btn.style.background = '#ecfdf5';
                    setTimeout(() => {
                        btn.innerHTML = '<span>📋</span><span>Copy Number</span>';
                        btn.style.color = '#0f172a';
                        btn.style.borderColor = '#cbd5e1';
                        btn.style.background = '#ffffff';
                    }, 2000);
                }
            });
        }
    }

    // Receipt Slip upload preview
    function handleSlipSelected(input) {
        if (input.files && input.files[0]) {
            const file = input.files[0];
            const reader = new FileReader();
            reader.onload = function(e) {
                const thumb = document.getElementById('slipThumbnail');
                if (thumb) thumb.src = e.target.result;
                const wrap = document.getElementById('slipThumbnailWrap');
                if (wrap) wrap.style.display = 'flex';
                const label = document.getElementById('slipFileLabel');
                if (label) label.innerText = 'Change Receipt Slip';
                const nameTxt = document.getElementById('slipFileNameText');
                if (nameTxt) nameTxt.innerText = file.name;
            }
            reader.readAsDataURL(file);
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        const checkedRadio = document.querySelector('input[name="payment_method"]:checked');
        if (checkedRadio) {
            selectPaymentMethod(checkedRadio.value);
        }
    });
</script>
@endsection
