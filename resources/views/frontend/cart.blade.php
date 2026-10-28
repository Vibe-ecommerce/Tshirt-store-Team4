@extends('layouts.store')

@section('title', 'Shopping Bag — THREADCRAFT')

@section('styles')
<style>
    .cart-page-wrap {
        max-width: 1280px;
        margin: 36px auto 90px;
        padding: 0 24px;
    }

    /* Checkout Stepper Progress */
    .cart-stepper {
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
        font-size: 0.9rem;
        font-weight: 750;
        color: #64748b;
        letter-spacing: 0.2px;
    }

    .step-item.active {
        color: #0f172a;
    }

    .step-number {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        background: #f1f5f9;
        border: 1.5px solid #cbd5e1;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.84rem;
        font-weight: 850;
        color: #475569;
    }

    .step-item.active .step-number {
        background: #0f172a;
        border-color: #0f172a;
        color: #ffffff;
        box-shadow: 0 4px 12px rgba(15, 23, 42, 0.2);
    }

    .step-divider {
        width: 32px;
        height: 1.5px;
        background: #cbd5e1;
    }

    /* Header Bar */
    .cart-header {
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        margin-bottom: 26px;
        flex-wrap: wrap;
        gap: 16px;
        padding-bottom: 20px;
        border-bottom: 1px solid #e2e8f0;
    }

    .cart-title-wrap {
        display: flex;
        flex-direction: column;
        gap: 6px;
    }

    .cart-title {
        font-size: clamp(1.8rem, 3vw, 2.4rem);
        font-weight: 850;
        letter-spacing: -0.8px;
        color: #0f172a;
        display: flex;
        align-items: center;
        gap: 12px;
        line-height: 1.15;
    }

    .cart-badge-counter {
        font-size: 0.82rem;
        font-weight: 800;
        padding: 4px 12px;
        border-radius: var(--radius-full);
        background: #dbeafe;
        border: 1px solid #93c5fd;
        color: #1d4ed8;
        letter-spacing: 0.5px;
        vertical-align: middle;
    }

    .cart-subtitle {
        color: #475569;
        font-size: 0.95rem;
        font-weight: 500;
    }

    .btn-continue-shopping {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 9px 20px;
        border-radius: var(--radius-full);
        border: 1.5px solid #cbd5e1;
        background: #ffffff;
        color: #0f172a;
        font-size: 0.88rem;
        font-weight: 750;
        transition: all 0.25s ease;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
        text-decoration: none;
    }

    .btn-continue-shopping:hover {
        background: #f8fafc;
        border-color: #0f172a;
        color: #0f172a;
        transform: translateX(-3px);
    }

    /* Free Shipping Perk Meter */
    .shipping-perk-card {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: var(--radius-md);
        padding: 16px 22px;
        margin-bottom: 28px;
        display: flex;
        flex-direction: column;
        gap: 10px;
        position: relative;
        overflow: hidden;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.03);
    }

    .shipping-perk-card.unlocked {
        background: #ecfdf5;
        border-color: #a7f3d0;
    }

    .perk-info-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        flex-wrap: wrap;
    }

    .perk-message {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 0.92rem;
        color: #0f172a;
    }

    .perk-icon-circle {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: #eff6ff;
        border: 1px solid #bfdbfe;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
        color: #2563eb;
        flex-shrink: 0;
    }

    .shipping-perk-card.unlocked .perk-icon-circle {
        background: #d1fae5;
        border-color: #6ee7b7;
        color: #059669;
    }

    .perk-threshold-tag {
        font-size: 0.8rem;
        font-weight: 700;
        color: #2563eb;
        background: #eff6ff;
        padding: 3px 10px;
        border-radius: var(--radius-full);
    }

    .shipping-perk-card.unlocked .perk-threshold-tag {
        color: #059669;
        background: #d1fae5;
    }

    .perk-progress-track {
        width: 100%;
        height: 7px;
        background: #e2e8f0;
        border-radius: var(--radius-full);
        overflow: hidden;
        position: relative;
    }

    .perk-progress-bar {
        height: 100%;
        border-radius: var(--radius-full);
        background: #0f172a;
        transition: width 0.6s cubic-bezier(0.16, 1, 0.3, 1);
    }

    .shipping-perk-card.unlocked .perk-progress-bar {
        background: linear-gradient(90deg, #10b981 0%, #059669 100%);
    }

    /* Main Cart Layout Grid */
    .cart-grid-layout {
        display: grid;
        grid-template-columns: 1fr 390px;
        gap: 32px;
        align-items: start;
    }

    @media (max-width: 1020px) {
        .cart-grid-layout {
            grid-template-columns: 1fr;
        }
    }

    /* Items List Container */
    .cart-items-panel {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .cart-items-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: var(--radius-lg);
        overflow: hidden;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04);
    }

    .items-card-header {
        padding: 18px 26px;
        border-bottom: 1px solid #f1f5f9;
        display: flex;
        justify-content: space-between;
        align-items: center;
        background: #f8fafc;
    }

    .items-card-header span {
        font-size: 0.78rem;
        font-weight: 850;
        text-transform: uppercase;
        letter-spacing: 1.2px;
        color: #475569;
    }

    /* Individual Item Row */
    .cart-row {
        display: grid;
        grid-template-columns: 100px 1fr auto auto auto;
        align-items: center;
        gap: 22px;
        padding: 24px 26px;
        border-bottom: 1px solid #f1f5f9;
        transition: background 0.2s ease;
    }

    .cart-row:last-child {
        border-bottom: none;
    }

    .cart-row:hover {
        background: #f8fafc;
    }

    .cart-item-image-wrap {
        width: 100px;
        height: 100px;
        border-radius: var(--radius-md);
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        overflow: hidden;
        position: relative;
        flex-shrink: 0;
    }

    .cart-item-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .cart-item-image-wrap:hover .cart-item-image {
        transform: scale(1.08);
    }

    .cart-item-details {
        display: flex;
        flex-direction: column;
        gap: 6px;
        min-width: 0;
    }

    .cart-item-title {
        font-size: 1.1rem;
        font-weight: 800;
        color: #0f172a;
        line-height: 1.35;
        transition: color 0.2s;
        text-decoration: none;
        text-transform: capitalize;
    }

    .cart-item-title:hover {
        color: #2563eb;
    }

    .cart-item-chips {
        display: flex;
        align-items: center;
        gap: 8px;
        flex-wrap: wrap;
    }

    .item-chip {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        background: #f1f5f9;
        border: 1px solid #cbd5e1;
        padding: 3px 10px;
        border-radius: 6px;
        font-size: 0.8rem;
        color: #334155;
        font-weight: 600;
    }

    .item-chip strong {
        color: #0f172a;
        font-weight: 800;
    }

    .item-unit-price {
        font-size: 0.88rem;
        color: #475569;
        font-weight: 700;
    }

    /* Stepper */
    .cart-stepper-wrap {
        display: flex;
        align-items: center;
        border: 1px solid #cbd5e1;
        background: #f8fafc;
        border-radius: var(--radius-full);
        padding: 2px;
        transition: border-color 0.2s ease;
    }

    .cart-stepper-wrap:focus-within,
    .cart-stepper-wrap:hover {
        border-color: #0f172a;
    }

    .stepper-action-btn {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: transparent;
        border: none;
        color: #334155;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.05rem;
        font-weight: bold;
        transition: all 0.2s;
    }

    .stepper-action-btn:hover:not(:disabled) {
        background: #e2e8f0;
        color: #0f172a;
        transform: scale(1.1);
    }

    .stepper-action-btn:disabled {
        opacity: 0.25;
        cursor: not-allowed;
    }

    .stepper-val {
        width: 34px;
        text-align: center;
        font-weight: 800;
        font-size: 0.92rem;
        color: #0f172a;
        user-select: none;
    }

    /* Total Price Column */
    .cart-item-total {
        font-size: 1.28rem;
        font-weight: 850;
        color: #0f172a;
        letter-spacing: -0.3px;
        min-width: 95px;
        text-align: right;
    }

    /* Delete Button */
    .cart-remove-btn {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background: rgba(239, 68, 68, 0.08);
        border: 1px solid rgba(239, 68, 68, 0.2);
        color: #f87171;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.2s ease;
        flex-shrink: 0;
    }

    .cart-remove-btn:hover {
        background: rgba(239, 68, 68, 0.22);
        border-color: rgba(239, 68, 68, 0.45);
        color: #ffffff;
        transform: scale(1.08) rotate(5deg);
        box-shadow: 0 0 14px rgba(239, 68, 68, 0.35);
    }

    @media (max-width: 720px) {
        .cart-row {
            grid-template-columns: 80px 1fr;
            grid-template-areas:
                "img details"
                "img qty"
                "total remove";
            gap: 14px;
            padding: 18px 16px;
        }

        .cart-item-image-wrap {
            grid-area: img;
            width: 80px;
            height: 80px;
        }

        .cart-item-details {
            grid-area: details;
        }

        .cart-stepper-wrap {
            grid-area: qty;
            width: fit-content;
        }

        .cart-item-total {
            grid-area: total;
            text-align: left;
        }

        .cart-remove-btn {
            grid-area: remove;
            justify-self: end;
        }

        .items-card-header {
            display: none;
        }
    }

    /* Card Bottom Actions */
    .items-card-footer {
        padding: 16px 26px;
        border-top: 1px solid var(--border-subtle);
        background: rgba(255, 255, 255, 0.015);
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 12px;
    }

    .btn-clear-cart {
        background: #fef2f2;
        border: 1px solid #fecaca;
        color: #dc2626;
        font-size: 0.84rem;
        font-weight: 750;
        padding: 8px 18px;
        border-radius: var(--radius-full);
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: all 0.2s ease;
        cursor: pointer;
    }

    .btn-clear-cart:hover {
        background: #dc2626;
        border-color: #dc2626;
        color: #ffffff;
        transform: translateY(-1px);
        box-shadow: 0 4px 14px rgba(220, 38, 38, 0.25);
    }

    .cart-security-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 0.84rem;
        font-weight: 600;
        color: #334155;
    }

    /* Trust Highlights Bento Cards */
    .trust-bento-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 16px;
        margin-top: 24px;
    }

    @media (max-width: 860px) {
        .trust-bento-grid {
            grid-template-columns: 1fr;
        }
    }

    .trust-bento-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: var(--radius-md);
        padding: 18px;
        display: flex;
        align-items: flex-start;
        gap: 14px;
        transition: all 0.25s ease;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.03);
    }

    .trust-bento-card:hover {
        background: #f8fafc;
        border-color: #cbd5e1;
        transform: translateY(-2px);
    }

    .trust-icon-box {
        width: 38px;
        height: 38px;
        border-radius: 10px;
        background: #eff6ff;
        border: 1px solid #bfdbfe;
        color: #2563eb;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .trust-card-title {
        font-size: 0.95rem;
        font-weight: 800;
        color: #0f172a;
        margin-bottom: 3px;
    }

    .trust-card-desc {
        font-size: 0.82rem;
        color: #475569;
        line-height: 1.45;
        font-weight: 500;
    }

    /* Order Summary Card */
    .cart-summary-sticky {
        position: sticky;
        top: 100px;
    }

    .summary-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: var(--radius-lg);
        padding: 28px;
        box-shadow: 0 20px 45px rgba(0, 0, 0, 0.08);
        position: relative;
        overflow: hidden;
    }

    /* Top Accent Line */
    .summary-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 3px;
        background: #0f172a;
    }

    .summary-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding-bottom: 18px;
        margin-bottom: 20px;
        border-bottom: 1px solid #f1f5f9;
    }

    .summary-title {
        font-size: 1.3rem;
        font-weight: 850;
        color: #0f172a;
        letter-spacing: -0.4px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .summary-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 14px;
        font-size: 0.94rem;
        font-weight: 600;
        color: #334155;
    }

    .summary-row strong {
        color: #0f172a;
        font-weight: 800;
    }

    .badge-shipping-free {
        background: #ecfdf5;
        border: 1px solid #a7f3d0;
        color: #059669;
        font-size: 0.74rem;
        font-weight: 850;
        padding: 3px 10px;
        border-radius: var(--radius-full);
        letter-spacing: 0.5px;
    }

    /* Promo Code Field */
    .promo-section {
        margin: 22px 0;
        padding: 16px;
        background: #f8fafc;
        border: 1px dashed #cbd5e1;
        border-radius: var(--radius-md);
    }

    .promo-input-group {
        display: flex;
        gap: 8px;
    }

    .promo-input {
        flex: 1;
        background: #ffffff;
        border: 1.5px solid #cbd5e1;
        border-radius: var(--radius-md);
        color: #0f172a;
        padding: 11px 14px;
        font-size: 0.88rem;
        font-weight: 750;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        outline: none;
        transition: border-color 0.2s;
    }

    .promo-input::placeholder {
        color: #94a3b8;
        font-weight: 600;
    }

    .promo-input:focus {
        border-color: #0f172a;
        box-shadow: 0 0 0 2px rgba(15, 23, 42, 0.1);
    }

    .promo-submit-btn {
        background: #0f172a;
        border: 1px solid #0f172a;
        color: #ffffff;
        padding: 0 20px;
        border-radius: var(--radius-md);
        font-weight: 750;
        font-size: 0.88rem;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .promo-submit-btn:hover {
        background: #2563eb;
        border-color: #2563eb;
        box-shadow: 0 4px 14px rgba(37, 99, 235, 0.25);
    }

    .quick-coupons-wrap {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-top: 10px;
        font-size: 0.8rem;
        color: #475569;
        font-weight: 600;
    }

    .coupon-chip {
        background: #dbeafe;
        border: 1px solid #93c5fd;
        color: #1d4ed8;
        padding: 3px 10px;
        border-radius: 6px;
        cursor: pointer;
        font-weight: 800;
        transition: all 0.2s;
    }

    .coupon-chip:hover {
        background: #1d4ed8;
        color: #ffffff;
        transform: translateY(-1px);
    }

    /* Active Coupon Bar */
    .active-coupon-tag {
        display: flex;
        align-items: center;
        justify-content: space-between;
        background: #ecfdf5;
        border: 1px solid #a7f3d0;
        padding: 8px 12px;
        border-radius: 8px;
        font-size: 0.82rem;
        color: #059669;
        margin-top: 10px;
    }

    .active-coupon-remove {
        color: #ef4444;
        font-size: 0.78rem;
        font-weight: 700;
        text-decoration: none;
        padding: 2px 6px;
        border-radius: 4px;
        transition: background 0.2s;
    }

    .active-coupon-remove:hover {
        background: #fee2e2;
    }

    /* Total Row */
    .summary-total-row {
        margin-top: 18px;
        padding-top: 18px;
        border-top: 1px solid #f1f5f9;
        display: flex;
        align-items: baseline;
        justify-content: space-between;
    }

    .summary-total-label {
        font-size: 1.12rem;
        font-weight: 800;
        color: #0f172a;
    }

    .summary-total-price {
        font-size: 1.85rem;
        font-weight: 900;
        letter-spacing: -0.8px;
        color: #0f172a;
    }

    /* Main CTA Checkout Button */
    .btn-checkout-primary {
        width: 100%;
        margin-top: 22px;
        padding: 16px 24px;
        border-radius: var(--radius-full);
        background: #0f172a;
        border: none;
        color: #ffffff;
        font-size: 1.05rem;
        font-weight: 800;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        box-shadow: 0 6px 20px rgba(15, 23, 42, 0.2);
        transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
        text-decoration: none;
    }

    .btn-checkout-primary:hover {
        background: #000000;
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(15, 23, 42, 0.3);
    }

    .btn-checkout-primary svg {
        transition: transform 0.2s;
    }

    .btn-checkout-primary:hover svg {
        transform: translateX(3px);
    }

    /* Payment Badges */
    .payment-trust-tray {
        margin-top: 22px;
        padding-top: 18px;
        border-top: 1px solid #e2e8f0;
        text-align: center;
    }

    .payment-tray-title {
        font-size: 0.74rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: #64748b;
        margin-bottom: 12px;
    }

    .payment-icons-row {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        flex-wrap: wrap;
    }

    .payment-badge {
        background: #f8fafc;
        border: 1px solid #cbd5e1;
        border-radius: 8px;
        padding: 5px 12px;
        font-size: 0.74rem;
        font-weight: 850;
        color: #1e293b;
        letter-spacing: 0.5px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
    }

    /* Recommended Cross-Sell Section */
    .cross-sell-section {
        margin-top: 60px;
        padding-top: 36px;
        border-top: 1px solid #e2e8f0;
    }

    .cross-sell-header {
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        margin-bottom: 24px;
        flex-wrap: wrap;
        gap: 14px;
    }

    .cross-sell-title {
        font-size: 1.55rem;
        font-weight: 850;
        color: #0f172a;
        letter-spacing: -0.02em;
        display: flex;
        align-items: center;
        gap: 10px;
        line-height: 1.2;
    }

    .cross-sell-icon {
        font-size: 1.3rem;
    }

    .cross-sell-pill {
        font-size: 0.72rem;
        background: #eff6ff;
        color: #2563eb;
        border: 1px solid #bfdbfe;
        padding: 4px 10px;
        border-radius: 9999px;
        font-weight: 800;
        letter-spacing: 0.05em;
    }

    .cross-sell-sub {
        color: #475569;
        font-size: 0.92rem;
        margin-top: 4px;
        font-weight: 500;
    }

    .cross-sell-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 22px;
    }

    @media (max-width: 1080px) {
        .cross-sell-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 580px) {
        .cross-sell-grid {
            grid-template-columns: 1fr;
        }
    }

    .suggested-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 20px;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        box-shadow: 0 4px 16px rgba(15, 23, 42, 0.04);
        position: relative;
    }

    .suggested-card:hover {
        transform: translateY(-5px);
        border-color: #cbd5e1;
        box-shadow: 0 16px 36px rgba(15, 23, 42, 0.09);
    }

    .suggested-media {
        width: 100%;
        aspect-ratio: 1 / 1;
        position: relative;
        background: #f8fafc;
        overflow: hidden;
        display: block;
    }

    .suggested-media img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.4s ease;
    }

    .suggested-card:hover .suggested-media img {
        transform: scale(1.06);
    }

    .suggested-tag {
        position: absolute;
        top: 10px;
        left: 10px;
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(8px);
        border: 1px solid #e2e8f0;
        color: #0f172a;
        font-size: 0.7rem;
        font-weight: 800;
        letter-spacing: 0.05em;
        text-transform: uppercase;
        padding: 4px 10px;
        border-radius: 9999px;
        box-shadow: 0 2px 8px rgba(15, 23, 42, 0.08);
        z-index: 2;
    }

    .suggested-discount-tag {
        position: absolute;
        top: 10px;
        right: 10px;
        background: #0f172a;
        color: #ffffff;
        font-size: 0.7rem;
        font-weight: 800;
        letter-spacing: 0.05em;
        padding: 4px 9px;
        border-radius: 9999px;
        box-shadow: 0 2px 8px rgba(15, 23, 42, 0.15);
        z-index: 2;
    }

    .suggested-body {
        padding: 18px 20px 20px;
        display: flex;
        flex-direction: column;
        flex: 1;
        justify-content: space-between;
    }

    .suggested-cat-sub {
        font-size: 0.7rem;
        font-weight: 800;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        color: #475569;
        margin-bottom: 4px;
        display: block;
    }

    .suggested-name {
        font-size: 1.02rem;
        font-weight: 800;
        color: #0f172a;
        margin-bottom: 8px;
        line-height: 1.35;
        text-transform: capitalize;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-decoration: none;
        transition: color 0.2s ease;
    }

    .suggested-name:hover {
        color: #2563eb;
    }

    .suggested-price-row {
        display: flex;
        align-items: baseline;
        gap: 8px;
        margin-bottom: 16px;
    }

    .suggested-price {
        font-size: 1.2rem;
        font-weight: 850;
        color: #0f172a;
        letter-spacing: -0.02em;
    }

    .suggested-original-price {
        font-size: 0.88rem;
        color: #64748b;
        text-decoration: line-through;
        font-weight: 600;
    }

    .btn-quick-add {
        width: 100%;
        height: 42px;
        border-radius: 9999px;
        background: #0f172a;
        border: 1px solid #0f172a;
        color: #ffffff;
        font-size: 0.88rem;
        font-weight: 800;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        box-shadow: 0 4px 12px rgba(15, 23, 42, 0.12);
        transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
    }

    .btn-quick-add:hover {
        background: #2563eb;
        border-color: #2563eb;
        color: #ffffff;
        box-shadow: 0 6px 18px rgba(37, 99, 235, 0.35);
        transform: translateY(-2px);
    }

    /* Empty Cart State Art */
    .empty-cart-hero {
        text-align: center;
        padding: 90px 24px;
        background: #ffffff;
        backdrop-filter: blur(16px);
        border-radius: var(--radius-lg);
        border: 1px solid #e2e8f0;
        max-width: 780px;
        margin: 0 auto;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.04);
    }

    .empty-cart-icon-orbit {
        width: 90px;
        height: 90px;
        border-radius: 50%;
        background: #f1f5f9;
        border: 1px solid #cbd5e1;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 24px;
        color: #0f172a;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.05);
    }

    .empty-cart-title {
        font-size: 1.85rem;
        font-weight: 850;
        color: #0f172a;
        margin-bottom: 10px;
        letter-spacing: -0.5px;
    }

    .empty-cart-desc {
        color: #475569;
        font-size: 0.98rem;
        font-weight: 500;
        max-width: 480px;
        margin: 0 auto 30px;
        line-height: 1.6;
    }

    .empty-cart-actions {
        display: flex;
        gap: 12px;
        justify-content: center;
        flex-wrap: wrap;
    }

    /* -------------------------------------------------------------
       LUXURY CART CONFIRMATION ALERT MODAL
    ------------------------------------------------------------- */
    .cart-modal-backdrop {
        position: fixed;
        inset: 0;
        background: rgba(15, 23, 42, 0.6);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        z-index: 99999;
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        visibility: hidden;
        transition: opacity 0.25s cubic-bezier(0.16, 1, 0.3, 1), visibility 0.25s;
        padding: 20px;
    }

    .cart-modal-backdrop.is-open {
        opacity: 1;
        visibility: visible;
    }

    .cart-modal-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 26px;
        padding: 38px 32px 32px;
        max-width: 470px;
        width: 100%;
        position: relative;
        overflow: hidden;
        text-align: center;
        transform: scale(0.88) translateY(24px);
        transition: transform 0.32s cubic-bezier(0.34, 1.56, 0.64, 1);
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.18);
    }

    .cart-modal-backdrop.is-open .cart-modal-card {
        transform: scale(1) translateY(0);
    }

    .cart-modal-close {
        position: absolute;
        top: 16px;
        right: 16px;
        width: 34px;
        height: 34px;
        border-radius: 50%;
        background: #f1f5f9;
        border: 1px solid #e2e8f0;
        color: #64748b;
        font-size: 0.95rem;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.2s;
    }

    .cart-modal-close:hover {
        background: #e2e8f0;
        color: #0f172a;
        transform: rotate(90deg);
    }

    .cart-modal-glow {
        position: absolute;
        top: -65px;
        left: 50%;
        transform: translateX(-50%);
        width: 230px;
        height: 230px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(239, 68, 68, 0.15) 0%, rgba(239, 68, 68, 0) 70%);
        pointer-events: none;
    }

    .cart-modal-icon-wrap {
        width: 76px;
        height: 76px;
        border-radius: 24px;
        margin: 0 auto 18px;
        background: rgba(239, 68, 68, 0.1);
        border: 1px solid rgba(239, 68, 68, 0.25);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #ef4444;
        position: relative;
        animation: modalIconFloat 3s ease-in-out infinite;
    }

    .cart-modal-icon-wrap::after {
        content: '';
        position: absolute;
        inset: -6px;
        border-radius: 28px;
        border: 2px solid rgba(239, 68, 68, 0.2);
        animation: modalRingPulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
    }

    @keyframes modalRingPulse {
        0%, 100% { transform: scale(1); opacity: 0.8; }
        50% { transform: scale(1.15); opacity: 0.1; }
    }

    @keyframes modalIconFloat {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-4px); }
    }

    .cart-modal-badge {
        display: inline-block;
        padding: 4px 14px;
        border-radius: 9999px;
        font-size: 0.72rem;
        font-weight: 800;
        letter-spacing: 0.8px;
        text-transform: uppercase;
        background: rgba(239, 68, 68, 0.1);
        color: #dc2626;
        border: 1px solid rgba(239, 68, 68, 0.25);
        margin-bottom: 12px;
    }

    .cart-modal-title {
        font-size: 1.45rem;
        font-weight: 850;
        color: #0f172a;
        margin-bottom: 10px;
        letter-spacing: -0.4px;
    }

    .cart-modal-target-pill {
        display: inline-block;
        max-width: 90%;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        background: #f8fafc;
        border: 1px solid #cbd5e1;
        color: #0f172a;
        font-size: 0.84rem;
        font-weight: 700;
        padding: 4px 14px;
        border-radius: var(--radius-full);
    }

    .cart-modal-desc {
        color: #64748b;
        font-size: 0.92rem;
        line-height: 1.55;
        margin-bottom: 24px;
    }

    .cart-modal-actions {
        display: flex;
        gap: 12px;
        justify-content: center;
    }

    .cart-modal-btn-cancel {
        flex: 1;
        padding: 13px 20px;
        background: #f1f5f9;
        border: 1px solid #cbd5e1;
        border-radius: 14px;
        color: #0f172a;
        font-size: 0.92rem;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .cart-modal-btn-cancel:hover {
        background: #e2e8f0;
        color: #0f172a;
        border-color: #94a3b8;
        transform: translateY(-1px);
    }

    .cart-modal-btn-confirm {
        flex: 1.25;
        padding: 13px 22px;
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 50%, #b91c1c 100%);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 14px;
        color: #ffffff;
        font-size: 0.92rem;
        font-weight: 800;
        cursor: pointer;
        box-shadow: 0 4px 20px rgba(239, 68, 68, 0.45);
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        text-decoration: none;
    }

    .cart-modal-btn-confirm:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(239, 68, 68, 0.65);
        filter: brightness(1.1);
    }
</style>
@endsection

@section('content')
<div class="cart-page-wrap">

    <!-- 1. Checkout Journey Stepper -->
    <div class="cart-stepper">
        <div class="step-item active">
            <span class="step-number">1</span>
            <span>Shopping Bag</span>
        </div>
        <div class="step-divider"></div>
        <div class="step-item">
            <span class="step-number">2</span>
            <span>Shipping & Payment</span>
        </div>
        <div class="step-divider"></div>
        <div class="step-item">
            <span class="step-number">3</span>
            <span>Order Confirmed</span>
        </div>
    </div>

    <!-- 2. Header Bar -->
    <div class="cart-header">
        <div class="cart-title-wrap">
            <h1 class="cart-title">
                <span>Your Cart</span>
                @if (count($cart) > 0)
                    <span class="cart-badge-counter">{{ count($cart) }} {{ count($cart) === 1 ? 'Piece' : 'Pieces' }}</span>
                @endif
            </h1>
            <p class="cart-subtitle">Review your selected luxury streetwear drops and proceed to express checkout.</p>
        </div>
        <a href="{{ route('shop.index') }}" class="btn-continue-shopping">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
            <span>Continue Shopping</span>
        </a>
    </div>

    @if (count($cart) > 0)
        @php
            $hasStockoutItems = false;
            $productsInCart = [];
            foreach ($cart as $it) {
                if (!empty($it['id'])) {
                    $p = \App\Models\Product::find($it['id']);
                    if ($p) {
                        $productsInCart[$it['id']] = $p;
                        if ($p->isOutOfStock() || $it['quantity'] > $p->stock) {
                            $hasStockoutItems = true;
                        }
                    }
                }
            }
            $freeShippingThreshold = 50.00;
            $isFreeShipping = $subtotal >= $freeShippingThreshold;
            $amountNeededForFree = max(0, $freeShippingThreshold - $subtotal);
            $perkPercent = min(100, round(($subtotal / $freeShippingThreshold) * 100));
        @endphp

        <!-- 3. Free Express Shipping Progress Meter -->
        <div class="shipping-perk-card {{ $isFreeShipping ? 'unlocked' : '' }}">
            <div class="perk-info-row">
                <div class="perk-message">
                    <div class="perk-icon-circle">
                        @if ($isFreeShipping)
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#10b981" stroke-width="3"><polyline points="20 6 9 17 4 12"></polyline></svg>
                        @else
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#818cf8" stroke-width="2"><rect x="1" y="3" width="15" height="13"></rect><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon><circle cx="5.5" cy="18.5" r="2.5"></circle><circle cx="18.5" cy="18.5" r="2.5"></circle></svg>
                        @endif
                    </div>
                    <div>
                        @if ($isFreeShipping)
                            <span><strong>Worldwide Express Shipping Unlocked!</strong> (Worth $9.99 — Now <strong>$0.00 FREE</strong>)</span>
                        @else
                            <span>Add <strong>${{ number_format($amountNeededForFree, 2) }}</strong> more to unlock <strong>FREE Worldwide Express Shipping</strong>!</span>
                        @endif
                    </div>
                </div>
                <div class="perk-threshold-tag">
                    {{ $isFreeShipping ? '100% UNLOCKED' : $perkPercent . '% COMPLETED' }}
                </div>
            </div>
            <div class="perk-progress-track">
                <div class="perk-progress-bar" style="width: {{ $isFreeShipping ? 100 : $perkPercent }}%;"></div>
            </div>
        </div>

        @if ($hasStockoutItems)
            <div style="background:#fef2f2; border:1.5px solid #fca5a5; border-radius:var(--radius-md); padding:16px 22px; margin-bottom:24px; display:flex; align-items:center; gap:14px; color:#991b1b;">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#dc2626" stroke-width="2" style="flex-shrink:0;"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
                <span style="font-size:0.92rem; font-weight:600;">One or more items in your cart are currently <strong style="color:#b91c1c;">out of stock (Stockout)</strong> or exceed available studio inventory. Please remove or adjust quantities to proceed.</span>
            </div>
        @endif

        <!-- 4. Main Cart Two-Column Grid -->
        <div class="cart-grid-layout">
            
            <!-- Left: Items List -->
            <div class="cart-items-panel">
                <div class="cart-items-card">
                    <div class="items-card-header">
                        <span>Product Item</span>
                        <span>Quantity & Subtotal</span>
                    </div>

                    @foreach ($cart as $key => $item)
                        @php
                            $prod = !empty($item['id']) && isset($productsInCart[$item['id']]) ? $productsInCart[$item['id']] : null;
                            $isStockout = $prod ? $prod->isOutOfStock() : false;
                            $exceedsStock = $prod && !$isStockout && ($item['quantity'] > $prod->stock);
                            $itemSubtotal = $item['price'] * $item['quantity'];
                        @endphp

                        <div class="cart-row" style="{{ ($isStockout || $exceedsStock) ? 'border-left: 3px solid #ef4444; background: rgba(239,68,68,0.04);' : '' }}">
                            
                            <!-- Thumbnail with Link -->
                            <a href="{{ !empty($item['id']) ? route('product.detail', $item['id']) : '#' }}" class="cart-item-image-wrap">
                                <img src="{{ asset($item['image']) }}" alt="{{ $item['name'] }}" class="cart-item-image" onerror="this.src='https://placehold.co/120x120/182234/ffffff?text=Tee'">
                            </a>

                            <!-- Title & Spec Badges -->
                            <div class="cart-item-details">
                                <a href="{{ !empty($item['id']) ? route('product.detail', $item['id']) : '#' }}" class="cart-item-title">
                                    {{ $item['name'] }}
                                </a>

                                <div class="cart-item-chips">
                                    <span class="item-chip">Size: <strong>{{ $item['size'] ?? 'L' }}</strong></span>
                                    <span class="item-chip">
                                        <span style="width:8px; height:8px; border-radius:50%; background:#818cf8; display:inline-block;"></span>
                                        <strong>{{ $item['color'] ?? 'Standard' }}</strong>
                                    </span>
                                    <span class="item-unit-price">${{ number_format($item['price'], 2) }} / unit</span>
                                </div>

                                @if ($isStockout)
                                    <div style="margin-top:4px;">
                                        <span style="background:#fee2e2; border:1px solid #fca5a5; color:#dc2626; font-size:0.72rem; font-weight:800; padding:3px 10px; border-radius:9999px;">
                                            ✕ OUT OF STOCK
                                        </span>
                                    </div>
                                @elseif ($exceedsStock)
                                    <div style="margin-top:4px;">
                                        <span style="background:#fef3c7; border:1px solid #fcd34d; color:#b45309; font-size:0.72rem; font-weight:800; padding:3px 10px; border-radius:9999px;">
                                            ⚠️ Only {{ $prod->stock }} units left in warehouse
                                        </span>
                                    </div>
                                @endif
                            </div>

                            <!-- Stepper Controls -->
                            <form action="{{ route('cart.update', $key) }}" method="POST" class="cart-stepper-wrap">
                                @csrf
                                <button type="submit" name="quantity" value="{{ $item['quantity'] - 1 }}" class="stepper-action-btn" title="Decrease Quantity">
                                    &minus;
                                </button>
                                <span class="stepper-val">{{ $item['quantity'] }}</span>
                                <button type="submit" name="quantity" value="{{ $item['quantity'] + 1 }}" class="stepper-action-btn" {{ ($prod && $item['quantity'] >= $prod->stock) ? 'disabled' : '' }} title="Increase Quantity">
                                    &plus;
                                </button>
                            </form>

                            <!-- Subtotal Price -->
                            <div class="cart-item-total">
                                ${{ number_format($itemSubtotal, 2) }}
                            </div>

                            <!-- Trash / Remove Action with Luxury Confirmation -->
                            <button type="button" class="cart-remove-btn" onclick="openRemoveItemModal('{{ route('cart.remove', $key) }}', '{{ addslashes($item['name']) }}')" title="Remove {{ $item['name'] }} from cart">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                            </button>
                        </div>
                    @endforeach

                    <!-- Bottom Bar Inside Items Card -->
                    <div class="items-card-footer">
                        <button type="button" class="btn-clear-cart" onclick="openClearBagModal()">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                            <span>Clear Entire Bag</span>
                        </button>

                        <div class="cart-security-badge">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#10b981" stroke-width="2.2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>
                            <span>Prices and discounts locked for your session</span>
                        </div>
                    </div>
                </div>

                <!-- 5. Trust Guarantee Bento Cards -->
                <div class="trust-bento-grid">
                    <div class="trust-bento-card">
                        <div class="trust-icon-box">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon></svg>
                        </div>
                        <div>
                            <div class="trust-card-title">24H Fast Dispatch</div>
                            <div class="trust-card-desc">Orders placed before 3 PM ship the same day with live tracking.</div>
                        </div>
                    </div>

                    <div class="trust-bento-card">
                        <div class="trust-icon-box">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>
                        </div>
                        <div>
                            <div class="trust-card-title">30-Day Free Returns</div>
                            <div class="trust-card-desc">Love it or send it back for a 100% full refund or free size exchange.</div>
                        </div>
                    </div>

                    <div class="trust-bento-card">
                        <div class="trust-icon-box">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                        </div>
                        <div>
                            <div class="trust-card-title">Bank-Level Security</div>
                            <div class="trust-card-desc">Protected with 256-bit SSL encryption & PCI-DSS compliance.</div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Right: Order Summary Sticky Card -->
            <div class="cart-summary-sticky">
                <div class="summary-card">
                    <div class="summary-header">
                        <div class="summary-title">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#2563eb" stroke-width="2.2"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path><line x1="3" y1="6" x2="21" y2="6"></line><path d="M16 10a4 4 0 0 1-8 0"></path></svg>
                            <span>Order Summary</span>
                        </div>
                        <span style="font-size:0.75rem; color:#475569; font-weight:800; background:#f1f5f9; padding:3px 9px; border-radius:6px; border:1px solid #cbd5e1;">USD</span>
                    </div>

                    <div class="summary-row">
                        <span>Subtotal ({{ count($cart) }} {{ count($cart) === 1 ? 'item' : 'items' }})</span>
                        <strong>${{ number_format($subtotal, 2) }}</strong>
                    </div>

                    @if ($discount > 0)
                        <div class="summary-row" style="color: #059669; font-weight:700;">
                            <span style="display:flex; align-items:center; gap:6px;">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
                                <span>Promo ({{ $coupon['code'] }})</span>
                            </span>
                            <strong>-${{ number_format($discount, 2) }}</strong>
                        </div>
                    @endif

                    <div class="summary-row">
                        <span>Worldwide Shipping</span>
                        @if ($shipping == 0)
                            <span class="badge-shipping-free">FREE</span>
                        @else
                            <strong>${{ number_format($shipping, 2) }}</strong>
                        @endif
                    </div>

                    <div class="summary-row" style="font-size:0.86rem; color:#475569; font-weight:600;">
                        <span>Estimated Taxes</span>
                        <span style="color:#64748b; font-weight:700;">Calculated at checkout</span>
                    </div>

                    <!-- Promo Code Form (Auto-hides when promotions are disabled) -->
                    @if (!empty($hasActivePromotions) || !empty($coupon))
                        <div class="promo-section">
                            @if (!empty($hasActivePromotions))
                                <form action="{{ route('cart.coupon') }}" method="POST">
                                    @csrf
                                    <div class="promo-input-group">
                                        <input type="text" id="coupon_input" name="coupon_code" class="promo-input" placeholder="PROMO CODE" value="{{ $coupon['code'] ?? '' }}">
                                        <button type="submit" class="promo-submit-btn">Apply</button>
                                    </div>
                                </form>

                                @if (!empty($activePromotions) && $activePromotions->isNotEmpty())
                                    <div class="quick-coupons-wrap">
                                        <span>Available:</span>
                                        @foreach ($activePromotions as $activePromo)
                                            <span class="coupon-chip" onclick="document.getElementById('coupon_input').value='{{ $activePromo->code }}';">
                                                {{ $activePromo->code }} ({{ $activePromo->discount_percent }}% OFF)
                                            </span>
                                        @endforeach
                                    </div>
                                @endif
                            @endif

                            @if (!empty($coupon))
                                <div class="active-coupon-tag">
                                    <span>✓ Applied: <strong>{{ $coupon['code'] }} ({{ $coupon['percent'] }}% off)</strong></span>
                                    <a href="{{ route('cart.coupon.remove') }}" class="active-coupon-remove">Remove ✕</a>
                                </div>
                            @endif
                        </div>
                    @endif

                    <!-- Total Row -->
                    <div class="summary-total-row">
                        <div class="summary-total-label">Total Due</div>
                        <div class="summary-total-price">${{ number_format($total, 2) }}</div>
                    </div>

                    <!-- Checkout CTA Button -->
                    @if ($hasStockoutItems)
                        <button type="button" class="btn-checkout-primary" style="background:#fee2e2; border:1.5px solid #fca5a5; color:#991b1b; cursor:not-allowed; box-shadow:none; font-weight:750;" disabled>
                            Adjust Items to Checkout
                        </button>
                    @else
                        @auth
                            <a href="{{ route('checkout.index') }}" class="btn-checkout-primary">
                                <span>Proceed to Checkout</span>
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
                            </a>
                        @else
                            <a href="{{ route('checkout.index') }}" class="btn-checkout-primary">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                                <span>Login to Checkout</span>
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
                            </a>
                            <div style="margin-top: 10px; font-size: 0.8rem; color: #475569; text-align: center; font-weight: 500;">
                                <span>🔒 Seamless guest login • Your bag is securely preserved</span>
                            </div>
                        @endauth
                    @endif

                    <!-- Payment Trust Badges -->
                    <div class="payment-trust-tray">
                        <div class="payment-tray-title">Guaranteed Safe Checkout</div>
                        <div class="payment-icons-row">
                            <span class="payment-badge">VISA</span>
                            <span class="payment-badge">MASTERCARD</span>
                            <span class="payment-badge">APPLE PAY</span>
                            <span class="payment-badge">GOOGLE PAY</span>
                            <span class="payment-badge">PAYPAL</span>
                            <span class="payment-badge">KHQR</span>
                        </div>
                    </div>

                </div>
            </div>

        </div>

        <!-- 6. "Complete Your Fit" / Recommended Cross-Sell -->
        @if (isset($suggestedProducts) && count($suggestedProducts) > 0)
            <div class="cross-sell-section">
                <div class="cross-sell-header">
                    <div>
                        <h3 class="cross-sell-title">
                            <span class="cross-sell-icon">✨</span>
                            <span>Complete Your Fit</span>
                            <span class="cross-sell-pill">RECOMMENDED DROPS</span>
                        </h3>
                        <p class="cross-sell-sub">Curated heavyweight streetwear essentials that match your style.</p>
                    </div>
                    <a href="{{ route('shop.index') }}" class="btn-continue-shopping" style="font-size:0.84rem; font-weight:750; padding:8px 18px;">
                        <span>Browse Entire Catalog →</span>
                    </a>
                </div>

                <div class="cross-sell-grid">
                    @foreach ($suggestedProducts as $rec)
                        <div class="suggested-card">
                            <a href="{{ route('product.detail', $rec->id) }}" class="suggested-media">
                                <img src="{{ asset($rec->image) }}" alt="{{ $rec->name }}" onerror="this.src='https://placehold.co/400x400/f8fafc/0f172a?text={{ urlencode($rec->name) }}'">
                                @if (!empty($rec->category))
                                    <span class="suggested-tag">{{ strtoupper($rec->category) }}</span>
                                @endif
                                @if (!empty($rec->original_price) && $rec->original_price > $rec->price)
                                    @php $recDiscount = round((($rec->original_price - $rec->price) / $rec->original_price) * 100); @endphp
                                    <span class="suggested-discount-tag">-{{ $recDiscount }}%</span>
                                @endif
                            </a>

                            <div class="suggested-body">
                                <div>
                                    <span class="suggested-cat-sub">{{ strtoupper($rec->category ?? 'STREETWEAR') }}</span>
                                    <a href="{{ route('product.detail', $rec->id) }}" class="suggested-name" title="{{ $rec->name }}">
                                        {{ ucwords($rec->name) }}
                                    </a>

                                    <div class="suggested-price-row">
                                        <span class="suggested-price">${{ number_format($rec->price, 2) }}</span>
                                        @if (!empty($rec->original_price) && $rec->original_price > $rec->price)
                                            <span class="suggested-original-price">${{ number_format($rec->original_price, 2) }}</span>
                                        @endif
                                    </div>
                                </div>

                                <form action="{{ route('cart.add', $rec->id) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="quantity" value="1">
                                    <input type="hidden" name="size" value="L">
                                    <button type="submit" class="btn-quick-add">
                                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path><line x1="3" y1="6" x2="21" y2="6"></line><path d="M16 10a4 4 0 0 1-8 0"></path></svg>
                                        <span>+ Add to Bag</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

    @else
        <!-- Empty Cart Luxury State -->
        <div class="empty-cart-hero">
            <div class="empty-cart-icon-orbit">
                <svg width="42" height="42" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path><line x1="3" y1="6" x2="21" y2="6"></line><path d="M16 10a4 4 0 0 1-8 0"></path></svg>
            </div>
            <h2 class="empty-cart-title">Your shopping bag is currently empty</h2>
            <p class="empty-cart-desc">
                Looks like you haven't added any luxury streetwear to your bag yet. Explore our curated drop collections of heavyweight graphic tees, accessories, and shoes.
            </p>
            <div class="empty-cart-actions">
                <a href="{{ route('shop.index') }}" class="btn-primary" style="padding:14px 34px; font-size:0.98rem;">
                    <span>Explore New Drops →</span>
                </a>
                <a href="{{ route('home') }}" class="btn-outline" style="padding:14px 28px; font-size:0.98rem;">
                    <span>Back to Homepage</span>
                </a>
            </div>
        </div>
    @endif

</div>

<!-- ============================================================
     LUXURY CONFIRMATION ALERT MODAL (Shopping Bag)
     ============================================================ -->
<div id="luxuryConfirmModal" class="cart-modal-backdrop" aria-hidden="true" role="dialog">
    <div class="cart-modal-card">
        <!-- Close 'X' Button -->
        <button type="button" class="cart-modal-close" onclick="closeLuxuryModal()" aria-label="Close dialog">✕</button>

        <!-- Ambient Glow Orb -->
        <div class="cart-modal-glow" id="modalGlow"></div>

        <!-- Animated Pulsing Icon -->
        <div class="cart-modal-icon-wrap" id="modalIconWrap">
            <span id="modalIcon">
                <svg width="34" height="34" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="3 6 5 6 21 6"></polyline>
                    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                    <line x1="10" y1="11" x2="10" y2="17"></line>
                    <line x1="14" y1="11" x2="14" y2="17"></line>
                </svg>
            </span>
        </div>

        <!-- Action Badge -->
        <div class="cart-modal-badge" id="modalBadge">BAG ACTION</div>

        <!-- Title -->
        <h3 class="cart-modal-title" id="modalTitle">Clear Entire Shopping Bag?</h3>

        <!-- Optional Item Name Pill -->
        <div id="modalTargetWrap" style="display:none; margin: 0 0 14px 0;">
            <span id="modalTarget" class="cart-modal-target-pill"></span>
        </div>

        <!-- Description -->
        <p class="cart-modal-desc" id="modalDesc">
            Are you sure you want to remove all pieces from your bag? Your session discounts, reservations, and promo codes will be reset.
        </p>

        <!-- Action Buttons -->
        <div class="cart-modal-actions">
            <button type="button" class="cart-modal-btn-cancel" onclick="closeLuxuryModal()">
                Keep My Items
            </button>
            <a href="#" id="modalConfirmBtn" class="cart-modal-btn-confirm">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="3 6 5 6 21 6"></polyline>
                    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6"></path>
                </svg>
                <span id="modalConfirmText">Yes, Clear Bag Now</span>
            </a>
        </div>
    </div>
</div>

<script>
    function openClearBagModal() {
        const modal = document.getElementById('luxuryConfirmModal');
        if (!modal) return;
        document.getElementById('modalBadge').textContent = 'BAG RESET';
        document.getElementById('modalTitle').textContent = 'Clear Entire Shopping Bag?';
        document.getElementById('modalDesc').textContent = 'Are you sure you want to remove all pieces from your shopping bag? Your session discounts, reservations, and promo codes will be reset.';
        document.getElementById('modalTargetWrap').style.display = 'none';
        document.getElementById('modalConfirmText').textContent = 'Yes, Clear Bag Now';
        document.getElementById('modalConfirmBtn').href = "{{ route('cart.clear') }}";
        modal.classList.add('is-open');
        modal.setAttribute('aria-hidden', 'false');
        document.body.style.overflow = 'hidden';
    }

    function openRemoveItemModal(url, itemName) {
        const modal = document.getElementById('luxuryConfirmModal');
        if (!modal) return;
        document.getElementById('modalBadge').textContent = 'REMOVE PIECE';
        document.getElementById('modalTitle').textContent = 'Remove from Bag?';
        document.getElementById('modalTargetWrap').style.display = 'block';
        document.getElementById('modalTarget').textContent = itemName;
        document.getElementById('modalDesc').textContent = 'Are you sure you want to remove this piece from your bag?';
        document.getElementById('modalConfirmText').textContent = 'Remove Item';
        document.getElementById('modalConfirmBtn').href = url;
        modal.classList.add('is-open');
        modal.setAttribute('aria-hidden', 'false');
        document.body.style.overflow = 'hidden';
    }

    function closeLuxuryModal() {
        const modal = document.getElementById('luxuryConfirmModal');
        if (!modal) return;
        modal.classList.remove('is-open');
        modal.setAttribute('aria-hidden', 'true');
        document.body.style.overflow = '';
    }

    // Close on escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') closeLuxuryModal();
    });

    // Close when clicking outside modal card
    document.getElementById('luxuryConfirmModal')?.addEventListener('click', function(e) {
        if (e.target === this) closeLuxuryModal();
    });
</script>
@endsection
