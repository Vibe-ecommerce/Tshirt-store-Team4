@extends('layouts.store')

@section('title', 'Checkout — THREADCRAFT')

@section('styles')
<style>
    .checkout-wrap {
        max-width: 1240px;
        margin: 36px auto 90px;
        padding: 0 24px;
    }

    /* Checkout Stepper Progress */
    .checkout-stepper {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 16px;
        margin-bottom: 34px;
        flex-wrap: wrap;
    }

    .step-item {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 0.90rem;
        font-weight: 750;
        color: #64748b;
        letter-spacing: 0.2px;
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
    }

    .step-item.active .step-number-circle {
        background: #0f172a;
        border-color: #0f172a;
        color: #ffffff;
        box-shadow: 0 4px 12px rgba(15, 23, 42, 0.2);
    }

    .step-divider {
        width: 36px;
        height: 2px;
        background: #cbd5e1;
    }

    /* Main Grid */
    .checkout-grid {
        display: grid;
        grid-template-columns: 1.75fr 1.25fr;
        gap: 36px;
        align-items: start;
    }

    @media (max-width: 960px) {
        .checkout-grid {
            grid-template-columns: 1fr;
        }
    }

    /* Panels */
    .card-panel {
        background: #ffffff;
        border: 1.5px solid #e2e8f0;
        border-radius: 18px;
        padding: 28px;
        margin-bottom: 24px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04);
        transition: box-shadow 0.2s ease;
    }

    .panel-heading {
        font-size: 1.20rem;
        font-weight: 850;
        margin-bottom: 22px;
        display: flex;
        align-items: center;
        gap: 12px;
        color: #0f172a;
        letter-spacing: -0.2px;
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
        font-size: 0.85rem;
        font-weight: 850;
        box-shadow: 0 2px 6px rgba(15, 23, 42, 0.25);
        flex-shrink: 0;
    }

    .form-grid-2 {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 16px;
        margin-bottom: 16px;
    }

    @media (max-width: 600px) {
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
        font-size: 0.80rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #1e293b;
        margin-bottom: 2px;
    }

    .form-control {
        background: #ffffff !important;
        border: 1.5px solid #cbd5e1 !important;
        color: #0f172a !important;
        padding: 12px 15px;
        border-radius: 10px;
        font-size: 0.92rem;
        font-weight: 600;
        outline: none;
        transition: all 0.2s ease;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.03);
    }

    .form-control::placeholder {
        color: #94a3b8;
        font-weight: 500;
    }

    .form-control:focus {
        border-color: #4f46e5 !important;
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.15) !important;
        background: #ffffff !important;
    }

    /* Option Radios */
    .option-list {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .radio-card {
        border: 1.5px solid #e2e8f0;
        background: #ffffff;
        border-radius: 12px;
        padding: 16px 20px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        cursor: pointer;
        transition: all 0.2s ease;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.02);
    }

    .radio-card:hover {
        border-color: #cbd5e1;
        background: #f8fafc;
    }

    .radio-card:has(input:checked) {
        border-color: #4f46e5;
        background: #f8fafc;
        box-shadow: 0 2px 10px rgba(79, 70, 229, 0.08);
    }

    .radio-card input[type="radio"] {
        margin-right: 12px;
        accent-color: #4f46e5;
        width: 18px;
        height: 18px;
        cursor: pointer;
    }

    .radio-title {
        font-size: 0.95rem;
        font-weight: 800;
        color: #0f172a;
    }

    .radio-sub {
        display: block;
        font-size: 0.82rem;
        color: #64748b;
        font-weight: 500;
        margin-left: 30px;
        margin-top: 3px;
    }

    /* Order Summary Sticky Panel */
    .order-summary-panel {
        background: #ffffff;
        border: 1.5px solid #e2e8f0;
        border-radius: 18px;
        padding: 28px;
        height: fit-content;
        position: sticky;
        top: 90px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
    }

    .item-preview {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 18px;
        padding-bottom: 14px;
        border-bottom: 1px dashed #e2e8f0;
        gap: 12px;
    }

    .item-preview:last-of-type {
        border-bottom: none;
        margin-bottom: 8px;
        padding-bottom: 0;
    }

    .place-order-btn {
        width: 100%;
        background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 100%);
        color: #ffffff;
        border: none;
        padding: 16px 20px;
        border-radius: 12px;
        font-size: 1.05rem;
        font-weight: 850;
        cursor: pointer;
        margin-top: 24px;
        box-shadow: 0 4px 20px rgba(15, 23, 42, 0.25);
        transition: all 0.2s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }

    .place-order-btn:hover {
        background: #000000;
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(15, 23, 42, 0.35);
    }

    .btn-qr-download:hover {
        background: #f1f5f9 !important;
        border-color: #94a3b8 !important;
    }

    .copy-btn:hover {
        background: #f1f5f9 !important;
        border-color: #94a3b8 !important;
    }
</style>
@endsection

@section('content')

    <div class="checkout-wrap">
        <!-- Breadcrumb / Stepper -->
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

        <h1 style="font-size: 2.1rem; font-weight: 900; color:#0f172a; margin-bottom: 28px; letter-spacing:-0.5px;">Checkout</h1>

        <form action="{{ route('checkout.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="checkout-grid">
                <div>
                    <!-- 1. Customer Information -->
                    <div class="card-panel">
                        @if ($user)
                            <div style="background: #f8fafc; border: 1.5px solid #e2e8f0; border-radius: 12px; padding: 12px 18px; margin-bottom: 22px; display: flex; align-items: center; justify-content: space-between; font-size: 0.88rem; flex-wrap:wrap; gap:10px;">
                                <div style="display:flex; align-items:center; gap:12px;">
                                    <span style="display:inline-flex; align-items:center; justify-content:center; width:34px; height:34px; border-radius:50%; background:linear-gradient(135deg, #4f46e5, #6366f1); font-weight:800; color:#ffffff; font-size:0.85rem; box-shadow:0 2px 6px rgba(79,70,229,0.3);">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </span>
                                    <div>
                                        <div style="color:#1e293b; font-weight:750;">
                                            Purchasing as <strong>{{ $user->name }}</strong>
                                        </div>
                                        <div style="font-size:0.78rem; color:#64748b; font-weight:600;">
                                            {{ $user->email }}
                                        </div>
                                    </div>
                                </div>
                                <span style="color:#065f46; font-size:0.78rem; font-weight:800; background:#ecfdf5; padding:4px 12px; border-radius:9999px; border:1px solid #a7f3d0; display:inline-flex; align-items:center; gap:5px;">
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
                            <input type="tel" name="customer_phone" class="form-control" value="{{ old('customer_phone', $user->phone ?? '') }}" required placeholder="e.g. +1 (555) 019-2834">
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
                            <input type="text" name="shipping_address" class="form-control" value="{{ old('shipping_address', $user->address ?? '') }}" required placeholder="Apartment, suite, unit, street address">
                        </div>

                        <div class="form-grid-2" style="margin-bottom: 0;">
                            <div class="form-group" style="margin-bottom: 0;">
                                <label class="form-label">City *</label>
                                <input type="text" name="city" class="form-control" value="{{ old('city', $user->city ?? '') }}" required placeholder="e.g. Los Angeles">
                            </div>
                            <div class="form-group" style="margin-bottom: 0;">
                                <label class="form-label">Postal / Zip Code</label>
                                <input type="text" name="postal_code" class="form-control" value="{{ old('postal_code', $user->postal_code ?? '') }}" placeholder="e.g. 90014">
                            </div>
                        </div>
                    </div>

                    <!-- 3. Delivery Method -->
                    <div class="card-panel">
                        <h3 class="panel-heading">
                            <span class="step-badge-num">3</span>
                            Delivery Method
                        </h3>

                        <div class="option-list">
                            <label class="radio-card">
                                <div>
                                    <input type="radio" name="delivery_method" value="Standard" checked>
                                    <strong class="radio-title">Standard Ground Delivery</strong>
                                    <span class="radio-sub">Estimated 3-5 business days</span>
                                </div>
                                <span style="color:#059669; font-weight:850; background:#ecfdf5; border:1px solid #a7f3d0; padding:4px 12px; border-radius:9999px; font-size:0.82rem;">
                                    {{ $subtotal >= 50 ? 'FREE' : '$5.00' }}
                                </span>
                            </label>

                            <label class="radio-card">
                                <div>
                                    <input type="radio" name="delivery_method" value="Express">
                                    <strong class="radio-title">Express Air Courier</strong>
                                    <span class="radio-sub">Priority 24-48 hours tracking</span>
                                </div>
                                <span style="font-weight:850; font-size:0.95rem; color:#0f172a;">$9.99</span>
                            </label>
                        </div>
                    </div>

                    <!-- 4. Payment Method -->
                    <div class="card-panel">
                        <h3 class="panel-heading">
                            <span class="step-badge-num">4</span>
                            Payment Method
                        </h3>

                        <div class="option-list">
                            <!-- Option A: KHQR / Bank QR Scan -->
                            @if (!empty($qrSettings['enabled']))
                                <label class="radio-card" id="qrOptionCard" style="border: 2px solid #e11d48; background: #fff1f2; cursor:pointer;">
                                    <div style="display:flex; align-items:center;">
                                        <input type="radio" name="payment_method" value="QR Code" id="payMethodQR" checked onchange="togglePaymentDetails()">
                                        <div style="margin-left:8px;">
                                            <div style="display:flex; align-items:center; gap:8px; flex-wrap:wrap;">
                                                <strong style="color:#0f172a; font-weight:850; font-size:0.98rem;">KHQR / Bank QR Scan & Pay</strong>
                                                <span style="font-size:0.72rem; font-weight:850; background:#e11d48; color:#ffffff; padding:2px 8px; border-radius:6px; letter-spacing:0.4px;">Instant • Cambodia</span>
                                            </div>
                                            <span style="display:block; font-size:0.82rem; color:#475569; font-weight:500; margin-top:3px;">
                                                Pay with ABA Mobile, Bakong, Wing, ACLEDA or any Bank App
                                            </span>
                                        </div>
                                    </div>
                                    <span style="font-size:1.4rem;">📱</span>
                                </label>

                                <!-- QR Payment Detail Box -->
                                <div id="qrPaymentDetailBox" style="margin-top:14px; background:#ffffff; border:1.5px solid #cbd5e1; border-radius:16px; padding:24px; box-shadow:0 4px 20px rgba(0,0,0,0.05);">
                                    <!-- QR Box Header -->
                                    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:18px; border-bottom:1.5px solid #e2e8f0; padding-bottom:14px; flex-wrap:wrap; gap:10px;">
                                        <div style="display:flex; align-items:center; gap:12px;">
                                            <div style="width:38px; height:38px; border-radius:8px; background:#e11d48; display:flex; align-items:center; justify-content:center; color:#ffffff; font-weight:900; font-size:0.85rem; box-shadow:0 4px 12px rgba(225,29,72,0.3);">
                                                KHQR
                                            </div>
                                            <div>
                                                <div style="font-weight:850; color:#0f172a; font-size:1.10rem;">{{ $qrSettings['bank_name'] }}</div>
                                                <div style="font-size:0.78rem; color:#64748b; font-weight:600;">Bakong & National Bank of Cambodia Standard</div>
                                            </div>
                                        </div>
                                        <div style="text-align:right;">
                                            <div style="font-size:0.72rem; color:#64748b; text-transform:uppercase; font-weight:800;">Exact Amount to Transfer</div>
                                            <div style="font-size:1.45rem; font-weight:900; color:#e11d48;">${{ number_format($total, 2) }} USD</div>
                                        </div>
                                    </div>

                                    <div style="display:grid; grid-template-columns: 210px 1fr; gap:24px; align-items:start;" class="qr-info-grid">
                                        <!-- QR Code Visual Preview -->
                                        <div style="text-align:center;">
                                            <div style="background:#ffffff; padding:12px; border-radius:14px; display:inline-block; box-shadow:0 4px 18px rgba(225,29,72,0.12); border:2px solid #e11d48;">
                                                <img src="{{ asset($qrSettings['image']) }}" alt="Scan to pay" style="width:175px; height:auto; max-height:220px; object-fit:contain; border-radius:6px; display:block;">
                                            </div>
                                            <div style="margin-top:10px;">
                                                <a href="{{ asset($qrSettings['image']) }}" download="Store_Payment_QR" class="btn-qr-download" style="font-size:0.78rem; font-weight:750; padding:6px 14px; display:inline-flex; align-items:center; gap:6px; background:#ffffff; border:1.5px solid #cbd5e1; border-radius:8px; color:#0f172a; text-decoration:none; box-shadow:0 1px 2px rgba(0,0,0,0.04); transition:all 0.2s;">
                                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                                                    <span>Save QR Image</span>
                                                </a>
                                            </div>
                                        </div>

                                        <!-- Bank Account Information -->
                                        <div>
                                            <div style="background:#f8fafc; border:1.5px solid #e2e8f0; border-radius:12px; padding:16px 18px; margin-bottom:14px;">
                                                <div style="font-size:0.72rem; text-transform:uppercase; color:#64748b; font-weight:800; letter-spacing:0.5px;">Account Name</div>
                                                <div style="font-size:1.05rem; font-weight:850; color:#0f172a; margin-bottom:12px;">{{ $qrSettings['account_name'] }}</div>

                                                <div style="display:flex; justify-content:space-between; align-items:center; gap:10px; flex-wrap:wrap;">
                                                    <div>
                                                        <div style="font-size:0.72rem; text-transform:uppercase; color:#64748b; font-weight:800; letter-spacing:0.5px;">Account Number</div>
                                                        <div style="font-size:1.28rem; font-weight:900; color:#059669; letter-spacing:0.8px;" id="qrAccNum">{{ $qrSettings['account_number'] }}</div>
                                                    </div>
                                                    <button type="button" onclick="copyAccountNumber()" class="copy-btn" style="padding:7px 16px; font-size:0.80rem; font-weight:750; background:#ffffff; border:1.5px solid #cbd5e1; border-radius:8px; color:#0f172a; cursor:pointer; box-shadow:0 1px 2px rgba(0,0,0,0.04); transition:all 0.2s;" id="copyBtn">
                                                        📋 Copy Number
                                                    </button>
                                                </div>
                                            </div>

                                            <div style="font-size:0.84rem; color:#1e40af; line-height:1.5; margin-bottom:16px; background:#eff6ff; border:1.5px solid #bfdbfe; border-left:4px solid #3b82f6; padding:12px 16px; border-radius:10px; font-weight:600;">
                                                💡 {{ $qrSettings['instructions'] }}
                                            </div>

                                            <!-- Slip Upload & Reference Input -->
                                            <div style="display:grid; grid-template-columns:1fr 1fr; gap:14px;" class="slip-grid">
                                                <div>
                                                    <label style="display:block; font-size:0.78rem; font-weight:800; color:#1e293b; text-transform:uppercase; letter-spacing:0.4px; margin-bottom:6px;">
                                                        Payment Receipt / Slip Screenshot
                                                    </label>
                                                    <label for="slipFileInput" style="display:flex; align-items:center; justify-content:center; gap:8px; padding:11px 14px; background:#ffffff; border:1.5px dashed #818cf8; border-radius:10px; cursor:pointer; color:#4338ca; font-size:0.84rem; font-weight:750; transition:all 0.2s; box-shadow:0 1px 2px rgba(0,0,0,0.03);">
                                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="17 8 12 3 7 8"></polyline><line x1="12" y1="3" x2="12" y2="15"></line></svg>
                                                        <span id="slipFileLabel">Upload Slip Screenshot</span>
                                                    </label>
                                                    <input type="file" id="slipFileInput" name="payment_slip" accept="image/*" style="display:none;" onchange="handleSlipSelected(this)">
                                                    
                                                    <div id="slipThumbnailWrap" style="display:none; margin-top:8px; align-items:center; gap:10px; background:#ecfdf5; padding:8px 12px; border-radius:8px; border:1.5px solid #a7f3d0;">
                                                        <img id="slipThumbnail" src="" style="width:38px; height:38px; border-radius:6px; object-fit:cover; border:1px solid #6ee7b7;">
                                                        <div>
                                                            <span style="font-size:0.78rem; color:#065f46; font-weight:800; display:block;">✓ Receipt Attached</span>
                                                            <span id="slipFileNameText" style="font-size:0.72rem; color:#1e293b; font-weight:600;"></span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div>
                                                    <label style="display:block; font-size:0.78rem; font-weight:800; color:#1e293b; text-transform:uppercase; letter-spacing:0.4px; margin-bottom:6px;">
                                                        Transaction / Ref # (Optional)
                                                    </label>
                                                    <input type="text" name="payment_reference" placeholder="e.g. 84920491 or ABA Ref" class="form-control" style="font-size:0.88rem; height:44px;">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <label class="radio-card">
                                <div>
                                    <input type="radio" name="payment_method" value="Credit Card" {{ empty($qrSettings['enabled']) ? 'checked' : '' }} onchange="togglePaymentDetails()">
                                    <strong class="radio-title">Credit or Debit Card</strong>
                                    <span class="radio-sub">Visa, Mastercard, Amex, Apple Pay</span>
                                </div>
                                <span style="font-size:1.4rem;">💳</span>
                            </label>

                            <label class="radio-card">
                                <div>
                                    <input type="radio" name="payment_method" value="Cash on Delivery" onchange="togglePaymentDetails()">
                                    <strong class="radio-title">Cash on Delivery (COD)</strong>
                                    <span class="radio-sub">Pay cash directly upon parcel arrival</span>
                                </div>
                                <span style="font-size:1.4rem;">💵</span>
                            </label>

                            <label class="radio-card">
                                <div>
                                    <input type="radio" name="payment_method" value="PayPal" onchange="togglePaymentDetails()">
                                    <strong class="radio-title">PayPal Express</strong>
                                    <span class="radio-sub">Safe checkout via PayPal balance</span>
                                </div>
                                <span style="font-size:1.4rem;">🅿️</span>
                            </label>
                        </div>

                        <div class="form-group" style="margin-top:24px; margin-bottom: 0;">
                            <label class="form-label">Order Notes / Delivery Instructions (Optional)</label>
                            <textarea name="notes" class="form-control" rows="2" placeholder="e.g. Please leave with doorman or gate code #402"></textarea>
                        </div>
                    </div>
                </div>

                <!-- 5. Order Summary & Place Order -->
                <div>
                    <div class="order-summary-panel">
                        <h3 style="font-size: 1.25rem; font-weight:850; color:#0f172a; margin-bottom: 20px; padding-bottom: 14px; border-bottom: 1.5px solid #e2e8f0; letter-spacing:-0.2px;">
                            Items in Order ({{ count($cart) }})
                        </h3>

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

                        <div style="margin-top:20px; padding-top:16px; border-top:1.5px solid #e2e8f0;">
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
                                <span style="font-size:1.25rem; font-weight:900; color:#0f172a !important;">Total</span>
                                <span style="font-size:1.60rem; font-weight:900; color:#0f172a !important; letter-spacing:-0.5px;">${{ number_format($total, 2) }}</span>
                            </div>
                        </div>

                        <!-- Place Order Button -->
                        <button type="submit" class="place-order-btn">
                            <span>Place Order (${{ number_format($total, 2) }})</span>
                            <span style="font-size:1.1rem;">→</span>
                        </button>

                        <div style="background:#f8fafc; border:1px solid #e2e8f0; border-radius:10px; padding:10px 14px; text-align:center; margin-top:18px; font-size:0.80rem; font-weight:600; color:#475569; display:flex; align-items:center; justify-content:center; gap:8px;">
                            <span>🔒</span>
                            <span>256-Bit SSL Encrypted & Secure Checkout</span>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

<script>
    function togglePaymentDetails() {
        const qrRadio = document.getElementById('payMethodQR');
        const qrBox = document.getElementById('qrPaymentDetailBox');
        const qrCard = document.getElementById('qrOptionCard');
        if (qrRadio && qrBox) {
            if (qrRadio.checked) {
                qrBox.style.display = 'block';
                if (qrCard) {
                    qrCard.style.borderColor = '#e11d48';
                    qrCard.style.background = '#fff1f2';
                }
            } else {
                qrBox.style.display = 'none';
                if (qrCard) {
                    qrCard.style.borderColor = '#e2e8f0';
                    qrCard.style.background = '#ffffff';
                }
            }
        }
    }

    function copyAccountNumber() {
        const accEl = document.getElementById('qrAccNum');
        if (accEl) {
            const raw = accEl.innerText.replace(/[^0-9]/g, '');
            navigator.clipboard.writeText(raw || accEl.innerText.trim()).then(() => {
                const btn = document.getElementById('copyBtn');
                if (btn) {
                    const orig = btn.innerHTML;
                    btn.innerHTML = '✓ Copied!';
                    btn.style.color = '#059669';
                    btn.style.borderColor = '#059669';
                    btn.style.background = '#ecfdf5';
                    setTimeout(() => {
                        btn.innerHTML = orig;
                        btn.style.color = '#0f172a';
                        btn.style.borderColor = '#cbd5e1';
                        btn.style.background = '#ffffff';
                    }, 2000);
                }
            });
        }
    }

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
                if (label) label.innerText = 'Change Slip';
                const nameTxt = document.getElementById('slipFileNameText');
                if (nameTxt) nameTxt.innerText = file.name;
            }
            reader.readAsDataURL(file);
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        togglePaymentDetails();
    });
</script>
@endsection
