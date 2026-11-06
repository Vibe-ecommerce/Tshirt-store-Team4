@extends('layouts.store')

@section('title', 'Checkout — T-Shirt Online')

@section('styles')
<style>
    /* -------------------------------------------------------------
       LUXURY CHECKOUT STYLING
    ------------------------------------------------------------- */
    .checkout-wrap {
        max-width: 1240px;
        margin: 20px auto 60px;
        padding: 0 20px;
    }

    /* Stepper Progress Bar */
    .checkout-stepper {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 14px;
        margin-bottom: 20px;
        flex-wrap: wrap;
    }

    .step-item {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 0.84rem;
        font-weight: 750;
        color: #64748b;
        letter-spacing: 0.2px;
        transition: color 0.2s;
    }

    .step-item.active {
        color: #0f172a;
    }

    .step-number-circle {
        width: 28px;
        height: 28px;
        border-radius: 50%;
        background: #f1f5f9;
        border: 1.5px solid #cbd5e1;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.80rem;
        font-weight: 850;
        color: #475569;
        transition: all 0.2s;
    }

    .step-item.active .step-number-circle {
        background: #0f172a;
        border-color: #0f172a;
        color: #ffffff;
        box-shadow: 0 3px 10px rgba(15, 23, 42, 0.18);
    }

    .step-divider {
        width: 30px;
        height: 2px;
        background: #e2e8f0;
        border-radius: 2px;
    }

    .page-header-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 18px;
        flex-wrap: wrap;
        gap: 10px;
    }

    .checkout-page-title {
        font-size: 1.8rem;
        font-weight: 900;
        color: #0f172a;
        letter-spacing: -0.5px;
    }

    .checkout-secure-pill {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: #eff6ff;
        border: 1px solid #bfdbfe;
        color: #1d4ed8;
        padding: 5px 12px;
        border-radius: 9999px;
        font-size: 0.74rem;
        font-weight: 800;
        letter-spacing: 0.4px;
        text-transform: uppercase;
    }

    /* Main Grid */
    .checkout-grid {
        display: grid;
        grid-template-columns: 1.75fr 1.25fr;
        gap: 24px;
        align-items: start;
    }

    @media (max-width: 980px) {
        .checkout-grid {
            grid-template-columns: 1fr;
            gap: 20px;
        }
    }

    /* Panels */
    .card-panel {
        background: #ffffff;
        border: 1.5px solid #e2e8f0;
        border-radius: 16px;
        padding: 20px 22px;
        margin-bottom: 16px;
        box-shadow: 0 2px 12px -2px rgba(15, 23, 42, 0.03);
        transition: box-shadow 0.2s ease, border-color 0.2s ease;
    }

    .card-panel:hover {
        border-color: #cbd5e1;
    }

    .compact-panel-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 14px;
        flex-wrap: wrap;
        gap: 8px;
    }

    .user-quick-chip {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 9999px;
        padding: 4px 12px;
        font-size: 0.78rem;
        font-weight: 750;
        color: #334155;
    }

    .user-chip-dot {
        width: 7px;
        height: 7px;
        border-radius: 50%;
        background: #10b981;
    }

    .verified-tag {
        color: #059669;
        font-size: 0.72rem;
        font-weight: 800;
    }

    .panel-heading {
        font-size: 1.08rem;
        font-weight: 850;
        margin-bottom: 14px;
        display: flex;
        align-items: center;
        gap: 10px;
        color: #0f172a;
        letter-spacing: -0.2px;
    }

    .step-badge-num {
        width: 26px;
        height: 26px;
        border-radius: 50%;
        background: #0f172a;
        color: #ffffff;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 0.78rem;
        font-weight: 850;
        box-shadow: 0 2px 5px rgba(15, 23, 42, 0.2);
        flex-shrink: 0;
    }

    /* Form Inputs */
    .form-grid-2 {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 12px;
        margin-bottom: 12px;
    }

    @media (max-width: 620px) {
        .form-grid-2 {
            grid-template-columns: 1fr;
            gap: 10px;
        }
    }

    .form-group {
        display: flex;
        flex-direction: column;
        gap: 5px;
        margin-bottom: 12px;
    }

    .form-label {
        font-size: 0.76rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.35px;
        color: #334155;
    }

    .form-control {
        background: #f8fafc !important;
        border: 1.5px solid #cbd5e1 !important;
        color: #0f172a !important;
        padding: 9px 14px;
        border-radius: 10px;
        font-size: 0.88rem;
        font-weight: 600;
        outline: none;
        transition: all 0.2s ease;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.02);
    }

    .channels-compact-row {
        display: flex;
        align-items: center;
        gap: 8px;
        min-height: 38px;
    }

    .channel-pill-compact {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: #f8fafc;
        border: 1.5px solid #cbd5e1;
        border-radius: 8px;
        padding: 6px 11px;
        font-size: 0.78rem;
        font-weight: 750;
        color: #334155;
        cursor: pointer;
        user-select: none;
        transition: all 0.15s;
    }

    .channel-pill-compact:hover {
        background: #eff6ff;
        border-color: #93c5fd;
    }

    .channel-pill-compact input[type="checkbox"] {
        accent-color: #2563eb;
        width: 14px;
        height: 14px;
        cursor: pointer;
    }

    .deliv-price-badge {
        color: #059669;
        font-weight: 850;
        background: #ecfdf5;
        border: 1px solid #a7f3d0;
        padding: 2px 8px;
        border-radius: 9999px;
        font-size: 0.74rem;
    }

    .deliv-price-badge.express {
        color: #854d0e;
        background: #fef9c3;
        border-color: #fef08a;
    }
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
        border-radius: 16px;
        padding: 16px 20px;
        margin-bottom: 14px;
        transition: all 0.2s ease;
    }

    .bank-info-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
        margin-bottom: 10px;
        flex-wrap: wrap;
    }

    .bank-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: #ecfdf5;
        border: 1px solid #a7f3d0;
        color: #065f46;
        font-size: 0.72rem;
        font-weight: 800;
        padding: 3px 9px;
        border-radius: 9999px;
        letter-spacing: 0.3px;
    }

    .bank-acc-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 12px;
        flex-wrap: wrap;
    }

    .copy-acc-btn {
        padding: 8px 16px;
        font-size: 0.82rem;
        font-weight: 750;
        background: #ffffff;
        border: 1.5px solid #cbd5e1;
        border-radius: 10px;
        color: #0f172a;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
    }

    .copy-acc-btn:hover {
        background: #0f172a;
        border-color: #0f172a;
        color: #ffffff;
        transform: translateY(-1px);
    }

    .khqr-notice-card {
        font-size: 0.84rem;
        color: #1e40af;
        line-height: 1.55;
        margin-bottom: 16px;
        background: #eff6ff;
        border: 1px solid #bfdbfe;
        border-left: 4px solid #2563eb;
        padding: 12px 16px;
        border-radius: 12px;
        font-weight: 600;
        display: flex;
        align-items: flex-start;
        gap: 10px;
    }

    /* Slip Upload Zone */
    .slip-upload-dropzone {
        display: block;
        border: 2px dashed #93c5fd;
        background: #f8fafc;
        border-radius: 16px;
        padding: 22px 18px;
        text-align: center;
        cursor: pointer;
        transition: all 0.22s cubic-bezier(0.16, 1, 0.3, 1);
        position: relative;
    }

    .slip-upload-dropzone:hover, .slip-upload-dropzone.dragover {
        border-color: #2563eb;
        background: #eff6ff;
        transform: translateY(-1px);
        box-shadow: 0 4px 14px rgba(37, 99, 235, 0.08);
    }

    .slip-upload-icon-circle {
        width: 46px;
        height: 46px;
        border-radius: 50%;
        background: #eff6ff;
        border: 1px solid #bfdbfe;
        color: #2563eb;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 8px;
        transition: transform 0.2s ease;
    }

    .slip-upload-dropzone:hover .slip-upload-icon-circle {
        transform: scale(1.08);
        background: #2563eb;
        color: #ffffff;
    }

    .slip-thumb-preview {
        display: none;
        align-items: center;
        justify-content: space-between;
        gap: 14px;
        background: #ffffff;
        border: 1.5px solid #a7f3d0;
        border-radius: 14px;
        padding: 12px 16px;
        margin-top: 12px;
        box-shadow: 0 4px 16px rgba(16, 185, 129, 0.08);
    }

    .slip-preview-left {
        display: flex;
        align-items: center;
        gap: 12px;
        min-width: 0;
        flex: 1;
    }

    .slip-preview-img {
        width: 46px;
        height: 46px;
        border-radius: 10px;
        object-fit: cover;
        border: 1.5px solid #10b981;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.06);
        flex-shrink: 0;
    }

    .slip-btn-remove {
        background: #fee2e2;
        border: 1px solid #fca5a5;
        color: #b91c1c;
        border-radius: 8px;
        font-size: 0.78rem;
        font-weight: 750;
        padding: 6px 12px;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        transition: all 0.2s;
        flex-shrink: 0;
    }

    .slip-btn-remove:hover {
        background: #ef4444;
        color: #ffffff;
        border-color: #ef4444;
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

    /* -------------------------------------------------------------
       2-STEP CHECKOUT WIZARD STYLES (MOBILE-FIRST)
    ------------------------------------------------------------- */
    .checkout-wizard-bar {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 12px;
        background: #f8fafc;
        border: 1.5px solid #e2e8f0;
        border-radius: 16px;
        padding: 8px;
        margin-bottom: 24px;
    }

    .wizard-tab {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px 18px;
        border-radius: 12px;
        border: 1.5px solid transparent;
        background: transparent;
        cursor: pointer;
        text-align: left;
        transition: all 0.22s cubic-bezier(0.16, 1, 0.3, 1);
        font-family: inherit;
        width: 100%;
    }

    .wizard-tab:hover {
        background: #f1f5f9;
    }

    .wizard-tab.active {
        background: #ffffff;
        border-color: #cbd5e1;
        box-shadow: 0 4px 14px rgba(15, 23, 42, 0.06);
    }

    .wizard-tab.completed {
        background: #f0fdf4;
        border-color: #bbf7d0;
    }

    .wizard-tab-num {
        width: 34px;
        height: 34px;
        border-radius: 50%;
        background: #e2e8f0;
        color: #64748b;
        font-weight: 850;
        font-size: 0.90rem;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        transition: all 0.2s ease;
    }

    .wizard-tab.active .wizard-tab-num {
        background: #0f172a;
        color: #ffffff;
        box-shadow: 0 3px 10px rgba(15, 23, 42, 0.2);
    }

    .wizard-tab.completed .wizard-tab-num {
        background: #059669;
        color: #ffffff;
    }

    .wizard-tab-info {
        display: flex;
        flex-direction: column;
        min-width: 0;
    }

    .wizard-tab-sub {
        font-size: 0.70rem;
        font-weight: 800;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.4px;
    }

    .wizard-tab.active .wizard-tab-sub {
        color: #2563eb;
    }

    .wizard-tab.completed .wizard-tab-sub {
        color: #059669;
    }

    .wizard-tab-title {
        font-size: 0.92rem;
        font-weight: 850;
        color: #334155;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .wizard-tab.active .wizard-tab-title {
        color: #0f172a;
    }

    .wizard-tab.completed .wizard-tab-title {
        color: #065f46;
    }

    @media (max-width: 600px) {
        .checkout-wizard-bar {
            grid-template-columns: 1fr;
            gap: 6px;
            padding: 6px;
        }
        .wizard-tab {
            padding: 10px 14px;
        }
    }

    /* Address Review Card on Step 2 */
    .address-review-card {
        background: #f8fafc;
        border: 1.5px solid #cbd5e1;
        border-radius: 16px;
        padding: 16px 18px;
        margin-bottom: 18px;
        position: relative;
    }

    .review-card-head {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 10px;
        border-bottom: 1px solid #e2e8f0;
        padding-bottom: 8px;
    }

    .review-card-edit-btn {
        background: #ffffff;
        border: 1.5px solid #cbd5e1;
        color: #2563eb;
        padding: 5px 12px;
        border-radius: 8px;
        font-size: 0.78rem;
        font-weight: 800;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        transition: all 0.18s ease;
    }

    .review-card-edit-btn:hover {
        background: #eff6ff;
        border-color: #93c5fd;
        transform: translateY(-1px);
    }

    .review-user-line {
        font-size: 0.95rem;
        font-weight: 850;
        color: #0f172a;
        margin-bottom: 4px;
    }

    .review-separator {
        color: #94a3b8;
        margin: 0 6px;
    }

    .review-address-line {
        font-size: 0.88rem;
        color: #475569;
        font-weight: 600;
        line-height: 1.45;
        margin-bottom: 8px;
    }

    .review-delivery-line {
        font-size: 0.82rem;
        color: #1e40af;
        background: #dbeafe;
        padding: 6px 12px;
        border-radius: 8px;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-weight: 750;
    }

    /* Step Navigation Footers */
    .step-footer-actions {
        background: #ffffff;
        border: 1.5px solid #e2e8f0;
        border-radius: 16px;
        padding: 18px 22px;
        margin-top: 18px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        box-shadow: 0 4px 18px rgba(15, 23, 42, 0.04);
        flex-wrap: wrap;
    }

    .step-price-hint {
        display: flex;
        flex-direction: column;
    }

    .hint-label {
        font-size: 0.72rem;
        font-weight: 800;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.4px;
    }

    .hint-price {
        font-size: 1.35rem;
        font-weight: 900;
        color: #0f172a;
        line-height: 1.2;
    }

    .hint-khr {
        font-size: 0.78rem;
        font-weight: 700;
        color: #059669;
    }

    .btn-wizard-next {
        background: #0f172a;
        color: #ffffff;
        border: none;
        border-radius: 12px;
        padding: 14px 24px;
        font-size: 0.95rem;
        font-weight: 850;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        transition: all 0.22s cubic-bezier(0.16, 1, 0.3, 1);
        box-shadow: 0 6px 20px rgba(15, 23, 42, 0.18);
        min-height: 48px;
    }

    .btn-wizard-next:hover {
        background: #1e293b;
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(15, 23, 42, 0.25);
    }

    .step2-nav-footer {
        margin-top: 16px;
        display: flex;
        align-items: center;
        justify-content: flex-start;
    }

    .btn-wizard-back {
        background: #f1f5f9;
        border: 1.5px solid #e2e8f0;
        color: #475569;
        border-radius: 10px;
        padding: 10px 18px;
        font-size: 0.85rem;
        font-weight: 800;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.18s ease;
    }

    .btn-wizard-back:hover {
        background: #e2e8f0;
        color: #0f172a;
    }

    @media (max-width: 980px) {
        .checkout-summary-col.hide-on-mobile-step1 {
            display: none !important;
        }
        .step-footer-actions {
            flex-direction: column;
            align-items: stretch;
            gap: 12px;
        }
        .step-footer-actions .btn-wizard-next {
            width: 100%;
            justify-content: center;
        }
    }

    /* Notification Toast for validation errors */
    #stepNotifyToast {
        position: fixed;
        bottom: 24px;
        left: 50%;
        transform: translateX(-50%) translateY(100px);
        background: #0f172a;
        color: #ffffff;
        padding: 12px 22px;
        border-radius: 12px;
        font-size: 0.88rem;
        font-weight: 750;
        box-shadow: 0 8px 26px rgba(0, 0, 0, 0.25);
        z-index: 9999;
        display: flex;
        align-items: center;
        gap: 10px;
        opacity: 0;
        transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        pointer-events: none;
    }

    #stepNotifyToast.show {
        transform: translateX(-50%) translateY(0);
        opacity: 1;
        pointer-events: auto;
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

        <form action="{{ route('checkout.store') }}" method="POST" enctype="multipart/form-data" id="checkoutForm">
            @csrf

            <!-- Interactive 2-Step Wizard Navigation Bar -->
            <div class="checkout-wizard-bar">
                <button type="button" class="wizard-tab active" id="tabStep1" onclick="goToStep(1)">
                    <span class="wizard-tab-num" id="badgeStep1">1</span>
                    <div class="wizard-tab-info">
                        <span class="wizard-tab-sub">ជំហានទី ១</span>
                        <strong class="wizard-tab-title">ព័ត៌មានដឹកជញ្ជូន (Delivery)</strong>
                    </div>
                </button>
                <button type="button" class="wizard-tab" id="tabStep2" onclick="validateAndGoToStep(2)">
                    <span class="wizard-tab-num" id="badgeStep2">2</span>
                    <div class="wizard-tab-info">
                        <span class="wizard-tab-sub">ជំហានទី ២</span>
                        <strong class="wizard-tab-title">ការទូទាត់ប្រាក់ (Payment & Review)</strong>
                    </div>
                </button>
            </div>

            <div class="checkout-grid">
                <div class="checkout-left-col">
                    <!-- STEP 1 CONTAINER: Delivery & Shipping -->
                    <div id="checkoutStep1" class="checkout-step-panel">
                        <!-- 1. Unified Delivery & Contact Details (Compact Layout) -->
                    <div class="card-panel">
                        <div class="compact-panel-header">
                            <h3 class="panel-heading" style="margin-bottom:0;">
                                <span class="step-badge-num">1</span>
                                <span>Delivery & Contact Details</span>
                            </h3>
                            @if ($user)
                                <div class="user-quick-chip">
                                    <span class="user-chip-dot"></span>
                                    <span>Purchasing as <strong>{{ $user->name }}</strong></span>
                                    <span class="verified-tag">✓ Verified</span>
                                </div>
                            @endif
                        </div>

                        <!-- Row 1: Full Name & Phone Number -->
                        <div class="form-grid-2">
                            <div class="form-group">
                                <label class="form-label">Full Name *</label>
                                <input type="text" name="customer_name" class="form-control" value="{{ old('customer_name', $user->name ?? '') }}" required placeholder="e.g. John Doe">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Phone Number *</label>
                                <input type="tel" name="customer_phone" class="form-control" value="{{ old('customer_phone', $user->phone ?? '') }}" required placeholder="e.g. +855 12 345 678">
                            </div>
                        </div>

                        <!-- Row 2: Email Address & Updates Channels -->
                        <div class="form-grid-2">
                            <div class="form-group">
                                <label class="form-label">Email Address *</label>
                                <input type="email" name="customer_email" class="form-control" value="{{ old('customer_email', $user->email ?? '') }}" required placeholder="e.g. john@example.com">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Order Updates via</label>
                                <div class="channels-compact-row">
                                    <label class="channel-pill-compact" title="Receive delivery updates via Telegram">
                                        <input type="checkbox" name="notify_telegram" value="1" checked>
                                        <span style="display:inline-flex; align-items:center; gap:5px;">
                                            <svg width="14" height="14" viewBox="0 0 24 24" fill="#0284c7"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm4.64 6.8c-.15 1.58-.8 5.42-1.13 7.19-.14.75-.42 1-.68 1.03-.58.05-1.02-.38-1.58-.75-.88-.58-1.38-.94-2.23-1.5-.99-.65-.35-1.01.22-1.59.15-.15 2.71-2.48 2.76-2.69a.2.2 0 0 0-.05-.18c-.06-.05-.14-.03-.21-.02-.09.02-1.49.95-4.22 2.79-.4.27-.76.41-1.08.4-.36-.01-1.04-.2-1.55-.37-.63-.2-1.12-.31-1.08-.66.02-.18.27-.36.74-.55 2.92-1.27 4.86-2.11 5.83-2.52 2.78-1.16 3.35-1.36 3.73-1.36.08 0 .27.02.39.12.1.08.13.19.14.27-.01.06.01.24 0 .38z"/></svg>
                                            <span>Telegram</span>
                                        </span>
                                    </label>
                                    <label class="channel-pill-compact" title="Receive delivery updates via WhatsApp">
                                        <input type="checkbox" name="notify_whatsapp" value="1" checked>
                                        <span style="display:inline-flex; align-items:center; gap:5px;">
                                            <svg width="14" height="14" viewBox="0 0 24 24" fill="#16a34a"><path d="M12.04 2c-5.46 0-9.91 4.45-9.91 9.91 0 1.75.46 3.45 1.32 4.95L2.05 22l5.25-1.38c1.45.79 3.08 1.21 4.74 1.21 5.46 0 9.91-4.45 9.91-9.91 0-2.65-1.03-5.14-2.9-7.01A9.82 9.82 0 0 0 12.04 2m.01 1.67c2.2 0 4.26.86 5.82 2.42a8.23 8.23 0 0 1 2.41 5.83c0 4.54-3.7 8.24-8.24 8.24-1.48 0-2.93-.4-4.2-1.15l-.3-.18-3.12.82.83-3.04-.2-.31a8.19 8.19 0 0 1-1.26-4.38c0-4.54 3.7-8.24 8.24-8.24m4.52 11.63c-.25-.13-1.47-.72-1.7-.81-.23-.08-.39-.13-.56.13-.17.25-.64.81-.79.97-.14.17-.29.19-.54.06-.25-.13-1.06-.39-2.02-1.25-.75-.67-1.26-1.5-1.41-1.75-.15-.25-.02-.39.11-.51.11-.11.25-.29.38-.44.12-.14.17-.25.25-.42.08-.17.04-.31-.02-.44-.06-.13-.56-1.35-.77-1.85-.2-.49-.41-.42-.56-.43h-.48c-.17 0-.44.06-.67.31-.23.25-.88.86-.88 2.1 0 1.24.9 2.44 1.03 2.61.13.17 1.77 2.7 4.29 3.79.6.26 1.07.41 1.44.53.6.19 1.15.16 1.58.1.48-.07 1.47-.6 1.68-1.18.21-.58.21-1.07.15-1.18-.06-.11-.22-.18-.47-.3z"/></svg>
                                            <span>WhatsApp</span>
                                        </span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Row 3: Street Address -->
                        <div class="form-group">
                            <label class="form-label">Street Address *</label>
                            <input type="text" name="shipping_address" class="form-control" value="{{ old('shipping_address', $user->address ?? '') }}" required placeholder="Building, street address, apartment or landmark">
                        </div>

                        <!-- Row 4: City & Postal Code -->
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

                    <!-- 2. Delivery Method (WITH ESTIMATED DELIVERY DATES) -->
                    <div class="card-panel">
                        <h3 class="panel-heading">
                            <span class="step-badge-num">2</span>
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

                    <!-- Step 1 Continue Action Footer -->
                    <div class="step-footer-actions">
                        <div class="step-price-hint">
                            <span class="hint-label">សរុបបណ្តោះអាសន្ន (Est. Total):</span>
                            <div style="display:flex; align-items:baseline; gap:8px;">
                                <span class="hint-price">${{ number_format($total, 2) }}</span>
                                <span class="hint-khr">(@khr($total))</span>
                            </div>
                        </div>
                        <button type="button" class="btn-wizard-next" onclick="validateAndGoToStep(2)">
                            <span>បន្តទៅការទូទាត់ប្រាក់ (Continue to Payment)</span>
                            <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
                        </button>
                    </div>
                </div> <!-- End checkoutStep1 -->

                <!-- STEP 2 CONTAINER: Payment & Final Confirmation -->
                <div id="checkoutStep2" class="checkout-step-panel" style="display:none;">
                    <!-- Compact Address Review Card -->
                    <div class="address-review-card">
                        <div class="review-card-head">
                            <div style="display:flex; align-items:center; gap:8px;">
                                <span style="font-size:1.15rem;">📍</span>
                                <strong style="font-size:0.92rem; color:#0f172a;">ផ្ញើទៅកាន់ (Shipping to):</strong>
                            </div>
                            <button type="button" class="review-card-edit-btn" onclick="goToStep(1)">
                                <span>✏️ កែប្រែ (Edit)</span>
                            </button>
                        </div>
                        <div class="review-card-body">
                            <div class="review-user-line">
                                <span class="review-name" id="revName">{{ $user->name ?? 'Customer' }}</span>
                                <span class="review-separator">•</span>
                                <span class="review-phone" id="revPhone">{{ $user->phone ?? '' }}</span>
                            </div>
                            <div class="review-address-line" id="revAddress">
                                {{ $user->address ?? 'Address not entered' }}{{ !empty($user->city) ? ', ' . $user->city : '' }}
                            </div>
                            <div class="review-delivery-line" id="revDeliverySpeed">
                                🚚 <strong>Standard Ground</strong> • Est: {{ $estStandardStart }} – {{ $estStandardEnd }}
                            </div>
                        </div>
                    </div>

                    <!-- 3. Payment Method -->
                    <div class="card-panel" id="paymentSectionPanel">
                        <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:16px; flex-wrap:wrap; gap:10px;">
                            <h3 class="panel-heading" style="margin-bottom:0;">
                                <span class="step-badge-num">3</span>
                                <span>Select Payment Method</span>
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
                                    <div class="tile-desc">Scan & Pay with Bakong KHQR mobile banking</div>
                                    <div class="tile-logos-row" style="margin-top:10px; padding-left:28px;">
                                        <span class="brand-mini-pill" style="color:#e11d48; border-color:#fecdd3; font-weight:900;">KHQR</span>
                                        <span class="brand-mini-pill">Bakong</span>
                                        <span class="brand-mini-pill">Mobile Banking</span>
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
                                            <div class="khqr-amount-val">${{ number_format($total, 2) }} USD <span style="font-size:0.85rem; font-weight:700; color:#059669; display:block;">(~ @khr($total))</span></div>
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
                                                <div class="bank-info-header">
                                                    <div>
                                                        <div style="font-size:0.72rem; text-transform:uppercase; color:#64748b; font-weight:800; letter-spacing:0.5px;">Account Name</div>
                                                        <div style="font-size:1.05rem; font-weight:850; color:#0f172a; margin-top:2px;">{{ $qrSettings['account_name'] }}</div>
                                                    </div>
                                                    <span class="bank-badge">
                                                        <svg width="12" height="12" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"></path></svg>
                                                        <span>Official KHQR</span>
                                                    </span>
                                                </div>

                                                <div class="bank-acc-row">
                                                    <div>
                                                        <div style="font-size:0.72rem; text-transform:uppercase; color:#64748b; font-weight:800; letter-spacing:0.5px;">Account Number</div>
                                                        <div style="font-size:1.35rem; font-weight:900; color:#059669; letter-spacing:0.8px; margin-top:2px;" id="qrAccNum">{{ $qrSettings['account_number'] }}</div>
                                                    </div>
                                                    <button type="button" onclick="copyAccountNumber()" class="copy-acc-btn" id="copyBtn">
                                                        <span>📋</span>
                                                        <span id="copyBtnText">Copy Number</span>
                                                    </button>
                                                </div>
                                            </div>

                                            <div class="khqr-notice-card">
                                                <span style="font-size:1.15rem; line-height:1;">💡</span>
                                                <div>
                                                    <div style="font-weight:750; color:#1e3a8a; margin-bottom:2px;">របៀបទូទាត់ប្រាក់ (Payment Guide)</div>
                                                    <div style="font-size:0.80rem; color:#1e40af;">
                                                        ស្កេន KHQR ឬផ្ទេរប្រាក់តាមកម្មវិធី Mobile Banking ទៅកាន់គណនីខាងលើ រួចភ្ជាប់រូបភាពវិក្កយបត្រខាងក្រោមដើម្បីផ្ទៀងផ្ទាត់ការបញ្ជាទិញ។
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Full-Width Payment Receipt Slip Upload (Transaction Ref removed) -->
                                            <div style="margin-top:6px;">
                                                <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:8px;">
                                                    <label class="form-label" style="margin-bottom:0; font-size:0.88rem;">រូបភាពវិក្កយបត្រផ្ទេរប្រាក់ / Payment Receipt Slip</label>
                                                    <span style="font-size:0.72rem; color:#64748b; font-weight:700;">(PNG, JPG, WEBP • Max 6MB)</span>
                                                </div>

                                                <label for="slipFileInput" class="slip-upload-dropzone" id="slipDropzone">
                                                    <div class="slip-upload-icon-circle">
                                                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                                            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                                            <polyline points="17 8 12 3 7 8"></polyline>
                                                            <line x1="12" y1="3" x2="12" y2="15"></line>
                                                        </svg>
                                                    </div>
                                                    <span id="slipFileLabel" style="font-size:0.92rem; font-weight:750; color:#2563eb; display:block;">ចុចទីនេះដើម្បីភ្ជាប់រូបភាពវិក្កយបត្រ (Upload Slip)</span>
                                                    <span style="font-size:0.76rem; color:#64748b; display:block; margin-top:4px;">Drag & drop receipt screenshot here or click to browse</span>
                                                </label>
                                                <input type="file" id="slipFileInput" name="payment_slip" accept="image/*" style="display:none;" onchange="handleSlipSelected(this)">

                                                <div id="slipThumbnailWrap" class="slip-thumb-preview">
                                                    <div class="slip-preview-left">
                                                        <img id="slipThumbnail" src="" class="slip-preview-img" alt="Receipt preview">
                                                        <div style="overflow:hidden;">
                                                            <span style="font-size:0.80rem; color:#065f46; font-weight:800; display:flex; align-items:center; gap:4px;">
                                                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
                                                                <span>វិក្កយបត្របានភ្ជាប់ (Receipt Attached)</span>
                                                            </span>
                                                            <span id="slipFileNameText" style="font-size:0.76rem; color:#334155; font-weight:600; white-space:nowrap; text-overflow:ellipsis; overflow:hidden; display:block; margin-top:2px;"></span>
                                                        </div>
                                                    </div>
                                                    <button type="button" class="slip-btn-remove" onclick="removeSlipAttachment()" title="Remove attached receipt">
                                                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                                                        <span>ដកចេញ</span>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- Detail Panel 2: Credit Card Panel (Safe Gateway / No Raw Sensitive Inputs) -->
                        <div class="payment-detail-container" id="detailCard">
                            <div class="card-payment-box">
                                <div class="card-accepted-strip">
                                    <div style="font-weight:750; font-size:0.88rem; color:#0f172a;">Card Payment Gateway</div>
                                    <div style="display:flex; align-items:center; gap:6px;">
                                        <span class="brand-mini-pill" style="font-weight:900; color:#1e40af;">VISA</span>
                                        <span class="brand-mini-pill" style="font-weight:900; color:#ea580c;">MASTERCARD</span>
                                        <span class="brand-mini-pill">AMEX</span>
                                        <span class="brand-mini-pill">JCB</span>
                                    </div>
                                </div>

                                <div style="padding:16px; background:#f8fafc; border:1px solid #e2e8f0; border-radius:12px; margin-top:10px;">
                                    <div style="display:flex; align-items:flex-start; gap:12px;">
                                        <span style="font-size:1.4rem; line-height:1;">🛡️</span>
                                        <div>
                                            <div style="font-weight:800; font-size:0.92rem; color:#0f172a; margin-bottom:4px;">Secure Direct Authorization</div>
                                            <p style="font-size:0.82rem; color:#475569; margin:0; line-height:1.5;">
                                                Card orders are authorized via secure gateway simulation. You do not need to enter sensitive card numbers directly on this demo page. Simply click <strong>Place Order</strong> below to confirm.
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <div style="display:flex; align-items:center; gap:8px; margin-top:12px; font-size:0.78rem; color:#64748b;">
                                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                                    <span>Encrypted with standard SSL/TLS secure protocol.</span>
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

                        <!-- Order Notes (Expandable Collapsible Toggle) -->
                        <div style="margin-top:16px; padding-top:12px; border-top:1px dashed #e2e8f0;">
                            <a href="javascript:void(0)" onclick="toggleOrderNotes()" id="toggleNotesLink" style="font-size:0.82rem; font-weight:750; color:#2563eb; text-decoration:none; display:inline-flex; align-items:center; gap:6px;">
                                <span>📝 + Add Delivery Notes / Instructions (Optional)</span>
                            </a>
                            <div id="orderNotesWrap" style="display:none; margin-top:8px;">
                                <textarea name="notes" class="form-control" rows="2" placeholder="e.g. Please leave with security guard, or call upon arrival."></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Step 2 Navigation Footer -->
                    <div class="step2-nav-footer">
                        <button type="button" class="btn-wizard-back" onclick="goToStep(1)">
                            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                            <span>⬅ ត្រឡប់ទៅព័ត៌មានដឹកជញ្ជូន (Back to Delivery)</span>
                        </button>
                    </div>
                </div> <!-- End checkoutStep2 -->
            </div> <!-- End checkout-left-col -->

            <!-- 5. Order Summary Sidebar (Sticky on desktop, shown on Step 2 on mobile) -->
            <div class="checkout-summary-col hide-on-mobile-step1" id="checkoutSummaryCol">
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

                        <!-- Promo Code Box on Checkout (Auto-hides when promotions are disabled by Admin) -->
                        @if (!empty($hasActivePromotions) || !empty($coupon))
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
                        @endif

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
                                <div>
                                    <span style="font-size:1.20rem; font-weight:900; color:#0f172a !important;">Total</span>
                                    <div style="font-size:0.78rem; color:#64748b; font-weight:700;">≈ @khr($total)</div>
                                </div>
                                <span style="font-size:1.60rem; font-weight:900; color:#0f172a !important; letter-spacing:-0.5px;">${{ number_format($total, 2) }}</span>
                            </div>
                        </div>

                        <!-- Place Order Button -->
                        <button type="submit" class="place-order-btn" id="placeOrderBtn">
                            <span>Place Order (${{ number_format($total, 2) }} / ≈ @khr($total))</span>
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

        <!-- Floating Notification Toast -->
        <div id="stepNotifyToast">
            <span id="stepNotifyIcon">⚠️</span>
            <span id="stepNotifyText"></span>
        </div>
    </div>

<script>
    let currentStep = 1;

    // Delivery Method selection & sync with Review Card
    function selectDeliveryCard(type) {
        const stdCard = document.getElementById('deliveryCardStandard');
        const expCard = document.getElementById('deliveryCardExpress');
        const stdRadio = document.getElementById('delivStandard');
        const expRadio = document.getElementById('delivExpress');

        if (type === 'Standard') {
            if (stdRadio) stdRadio.checked = true;
            if (stdCard) stdCard.classList.add('active');
            if (expCard) expCard.classList.remove('active');
        } else {
            if (expRadio) expRadio.checked = true;
            if (expCard) expCard.classList.add('active');
            if (stdCard) stdCard.classList.remove('active');
        }
        updateReviewDeliverySpeed(type);
    }

    function updateReviewDeliverySpeed(type) {
        const revSpeed = document.getElementById('revDeliverySpeed');
        if (!revSpeed) return;
        const isExp = type ? (type === 'Express') : (document.getElementById('delivExpress')?.checked);
        if (isExp) {
            revSpeed.className = 'review-delivery-line';
            revSpeed.style.background = '#fef9c3';
            revSpeed.style.color = '#854d0e';
            revSpeed.innerHTML = '⚡ <strong>Express Air Courier ($9.99)</strong> • Est. Arrival: Tomorrow by 6:00 PM';
        } else {
            revSpeed.className = 'review-delivery-line';
            revSpeed.style.background = '#dbeafe';
            revSpeed.style.color = '#1e40af';
            revSpeed.innerHTML = '🚚 <strong>Standard Ground</strong> • Est. Arrival: {{ $estStandardStart }} – {{ $estStandardEnd }}';
        }
    }

    // Populate Address Review Card from current input values
    function updateReviewCard() {
        const nameVal = document.querySelector('input[name="customer_name"]')?.value.trim();
        const phoneVal = document.querySelector('input[name="customer_phone"]')?.value.trim();
        const addrVal = document.querySelector('input[name="shipping_address"]')?.value.trim();
        const cityVal = document.querySelector('input[name="city"]')?.value.trim();
        const zipVal = document.querySelector('input[name="postal_code"]')?.value.trim();

        const revName = document.getElementById('revName');
        const revPhone = document.getElementById('revPhone');
        const revAddress = document.getElementById('revAddress');

        if (revName) revName.textContent = nameVal || 'Customer';
        if (revPhone) revPhone.textContent = phoneVal || '';
        if (revAddress) {
            let fullAddr = addrVal || '';
            if (cityVal) fullAddr += (fullAddr ? ', ' : '') + cityVal;
            if (zipVal) fullAddr += ' (' + zipVal + ')';
            revAddress.textContent = fullAddr || 'Address details saved';
        }

        updateReviewDeliverySpeed();
    }

    // Floating Toast Notification
    let toastTimer = null;
    function showStepToast(message, isError = true) {
        const toast = document.getElementById('stepNotifyToast');
        const text = document.getElementById('stepNotifyText');
        const icon = document.getElementById('stepNotifyIcon');
        if (!toast || !text) return;

        text.textContent = message;
        icon.textContent = isError ? '⚠️' : '✓';
        toast.style.background = isError ? '#0f172a' : '#065f46';
        toast.classList.add('show');

        clearTimeout(toastTimer);
        toastTimer = setTimeout(() => {
            toast.classList.remove('show');
        }, 3600);
    }

    // Step 1 Validation & Transition to Step 2
    function validateAndGoToStep(targetStep) {
        if (targetStep === 2) {
            const nameInput = document.querySelector('input[name="customer_name"]');
            const phoneInput = document.querySelector('input[name="customer_phone"]');
            const emailInput = document.querySelector('input[name="customer_email"]');
            const addressInput = document.querySelector('input[name="shipping_address"]');
            const cityInput = document.querySelector('input[name="city"]');

            let firstInvalid = null;

            const checkField = (input, isValid) => {
                if (!input) return true;
                if (!isValid) {
                    input.style.borderColor = '#ef4444';
                    input.style.backgroundColor = '#fef2f2';
                    if (!firstInvalid) firstInvalid = input;
                    input.addEventListener('input', function handler() {
                        input.style.borderColor = '#cbd5e1';
                        input.style.backgroundColor = '#ffffff';
                        input.removeEventListener('input', handler);
                    });
                    return false;
                } else {
                    input.style.borderColor = '#cbd5e1';
                    input.style.backgroundColor = '#ffffff';
                    return true;
                }
            };

            const emailValid = emailInput && /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(emailInput.value.trim());

            const isNameOk = checkField(nameInput, nameInput && nameInput.value.trim().length > 0);
            const isPhoneOk = checkField(phoneInput, phoneInput && phoneInput.value.trim().length >= 6);
            const isEmailOk = checkField(emailInput, emailValid);
            const isAddressOk = checkField(addressInput, addressInput && addressInput.value.trim().length > 0);
            const isCityOk = checkField(cityInput, cityInput && cityInput.value.trim().length > 0);

            if (!isNameOk || !isPhoneOk || !isEmailOk || !isAddressOk || !isCityOk) {
                if (firstInvalid) {
                    firstInvalid.focus();
                    firstInvalid.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }
                showStepToast('សូមបំពេញព័ត៌មានដឹកជញ្ជូនឱ្យបានត្រឹមត្រូវសិន (Please fill in delivery details)', true);
                return false;
            }

            updateReviewCard();
            goToStep(2);
        } else {
            goToStep(targetStep);
        }
    }

    // Switch active step UI
    function goToStep(step) {
        currentStep = step;
        const step1 = document.getElementById('checkoutStep1');
        const step2 = document.getElementById('checkoutStep2');
        const tab1 = document.getElementById('tabStep1');
        const tab2 = document.getElementById('tabStep2');
        const badge1 = document.getElementById('badgeStep1');
        const badge2 = document.getElementById('badgeStep2');
        const summaryCol = document.getElementById('checkoutSummaryCol');
        const placeOrderBtn = document.getElementById('placeOrderBtn');

        if (step === 1) {
            if (step1) step1.style.display = 'block';
            if (step2) step2.style.display = 'none';

            if (tab1) {
                tab1.classList.add('active');
                tab1.classList.remove('completed');
            }
            if (tab2) {
                tab2.classList.remove('active', 'completed');
            }
            if (badge1) badge1.innerHTML = '1';
            if (badge2) badge2.innerHTML = '2';

            // Mobile summary visibility on Step 1
            if (summaryCol) {
                if (window.innerWidth <= 980) {
                    summaryCol.classList.add('hide-on-mobile-step1');
                } else {
                    summaryCol.classList.remove('hide-on-mobile-step1');
                }
            }

            if (placeOrderBtn && window.innerWidth > 980) {
                placeOrderBtn.innerHTML = '<span>បន្តទៅការទូទាត់ប្រាក់ (Continue to Payment)</span> <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>';
            }
        } else if (step === 2) {
            if (step1) step1.style.display = 'none';
            if (step2) step2.style.display = 'block';

            if (tab1) {
                tab1.classList.remove('active');
                tab1.classList.add('completed');
            }
            if (tab2) {
                tab2.classList.add('active');
            }
            if (badge1) badge1.innerHTML = '✓';
            if (badge2) badge2.innerHTML = '2';

            // Mobile summary always shown on Step 2
            if (summaryCol) {
                summaryCol.classList.remove('hide-on-mobile-step1');
            }

            if (placeOrderBtn) {
                placeOrderBtn.innerHTML = '<span>Place Order (${{ number_format($total, 2) }} / ≈ @khr($total))</span> <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>';
            }
        }

        // Smooth scroll to top of wizard
        const wizardBar = document.querySelector('.checkout-wizard-bar');
        if (wizardBar) {
            wizardBar.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
    }

    // Payment Method selection & dynamic details switching
    function selectPaymentMethod(method) {
        const radioQR = document.getElementById('payMethodQR');
        const radioCard = document.getElementById('payMethodCard');
        const radioCOD = document.getElementById('payMethodCOD');
        const radioPayPal = document.getElementById('payMethodPayPal');

        const tileQR = document.getElementById('tileKHQR');
        const tileCard = document.getElementById('tileCard');
        const tileCOD = document.getElementById('tileCOD');
        const tilePayPal = document.getElementById('tilePayPal');

        const detailQR = document.getElementById('detailKHQR');
        const detailCard = document.getElementById('detailCard');
        const detailCOD = document.getElementById('detailCOD');
        const detailPayPal = document.getElementById('detailPayPal');

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

    // Receipt Slip upload preview & remove
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
                if (label) label.innerText = '🔄 ចុចដើម្បីផ្លាស់ប្តូររូបភាព (Change Slip)';
                const nameTxt = document.getElementById('slipFileNameText');
                if (nameTxt) {
                    const sizeKB = (file.size / 1024).toFixed(0);
                    nameTxt.innerText = `${file.name} • ${sizeKB} KB`;
                }
            };
            reader.readAsDataURL(file);
        }
    }

    function removeSlipAttachment() {
        const input = document.getElementById('slipFileInput');
        if (input) input.value = '';
        const thumb = document.getElementById('slipThumbnail');
        if (thumb) thumb.src = '';
        const wrap = document.getElementById('slipThumbnailWrap');
        if (wrap) wrap.style.display = 'none';
        const label = document.getElementById('slipFileLabel');
        if (label) label.innerText = 'ចុចទីនេះដើម្បីភ្ជាប់រូបភាពវិក្កយបត្រ (Upload Slip)';
    }

    // Toggle Order Notes Expand/Collapse
    function toggleOrderNotes() {
        const wrap = document.getElementById('orderNotesWrap');
        const link = document.getElementById('toggleNotesLink');
        if (!wrap) return;
        if (wrap.style.display === 'none') {
            wrap.style.display = 'block';
            if (link) link.innerHTML = '<span>📝 &minus; Hide Delivery Notes</span>';
        } else {
            wrap.style.display = 'none';
            if (link) link.innerHTML = '<span>📝 + Add Delivery Notes / Instructions (Optional)</span>';
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        // Init selected payment method
        const checkedRadio = document.querySelector('input[name="payment_method"]:checked');
        if (checkedRadio) {
            selectPaymentMethod(checkedRadio.value);
        }

        // Init review card
        updateReviewCard();

        // Step 1: Prevent form submit, advance to Step 2
        const form = document.getElementById('checkoutForm');
        if (form) {
            form.addEventListener('submit', function(e) {
                if (currentStep === 1) {
                    e.preventDefault();
                    validateAndGoToStep(2);
                    return false;
                }
            });
        }

        // Step 1: Enter key in inputs advances to Step 2
        document.querySelectorAll('#checkoutStep1 input').forEach(inp => {
            inp.addEventListener('keydown', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    validateAndGoToStep(2);
                }
            });
        });

        // Window resize responsive sync
        window.addEventListener('resize', function() {
            const summaryCol = document.getElementById('checkoutSummaryCol');
            const placeOrderBtn = document.getElementById('placeOrderBtn');
            if (!summaryCol) return;

            if (currentStep === 1) {
                if (window.innerWidth <= 980) {
                    summaryCol.classList.add('hide-on-mobile-step1');
                } else {
                    summaryCol.classList.remove('hide-on-mobile-step1');
                    if (placeOrderBtn) {
                        placeOrderBtn.innerHTML = '<span>បន្តទៅការទូទាត់ប្រាក់ (Continue to Payment)</span> <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>';
                    }
                }
            } else {
                summaryCol.classList.remove('hide-on-mobile-step1');
                if (placeOrderBtn) {
                    placeOrderBtn.innerHTML = '<span>Place Order (${{ number_format($total, 2) }} / ≈ @khr($total))</span> <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>';
                }
            }
        });
    });
</script>
@endsection
