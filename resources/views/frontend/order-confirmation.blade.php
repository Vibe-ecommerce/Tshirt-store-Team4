@extends('layouts.store')

@section('title', 'Order Confirmed #' . $order->order_number . ' — T-Shirt Online')

@section('styles')
<style>
    /* ==========================================================================
       LUXURY ORDER CONFIRMATION STUDIO STYLES
       ========================================================================== */
    .confirm-container {
        max-width: 900px;
        margin: 40px auto 90px;
        padding: 0 20px;
        text-align: center;
    }

    /* Top Floating Pill */
    .confirm-eyebrow-pill {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 7px 18px;
        background: #ecfdf5;
        border: 1.5px solid #a7f3d0;
        border-radius: 9999px;
        color: #065f46;
        font-size: 0.82rem;
        font-weight: 850;
        letter-spacing: 0.05em;
        text-transform: uppercase;
        margin-bottom: 24px;
        box-shadow: 0 2px 8px rgba(16, 185, 129, 0.12);
    }

    /* Animated Concentric Glowing Success Badge */
    .luxury-success-badge-wrap {
        position: relative;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 22px;
    }

    .badge-pulse-glow {
        position: absolute;
        width: 104px;
        height: 104px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(16, 185, 129, 0.25) 0%, rgba(16, 185, 129, 0) 70%);
        animation: pulse-ring 2.8s infinite cubic-bezier(0.25, 1, 0.5, 1);
    }

    @keyframes pulse-ring {
        0% { transform: scale(0.92); opacity: 0.8; }
        50% { transform: scale(1.15); opacity: 0.4; }
        100% { transform: scale(0.92); opacity: 0.8; }
    }

    .luxury-success-badge {
        position: relative;
        width: 82px;
        height: 82px;
        border-radius: 50%;
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: #ffffff;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 12px 28px -6px rgba(16, 185, 129, 0.45), 0 0 0 6px #ffffff, 0 0 0 9px #e2e8f0;
        animation: badge-pop 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }

    @keyframes badge-pop {
        0% { transform: scale(0.7); opacity: 0; }
        70% { transform: scale(1.06); }
        100% { transform: scale(1); opacity: 1; }
    }

    .confirm-title {
        font-size: clamp(2.1rem, 4.2vw, 2.85rem);
        font-weight: 900;
        letter-spacing: -0.035em;
        color: #0f172a;
        margin-bottom: 12px;
        line-height: 1.15;
    }

    .confirm-desc {
        color: #64748b;
        font-size: 1.05rem;
        max-width: 600px;
        margin: 0 auto 34px;
        line-height: 1.6;
    }

    .confirm-desc strong {
        color: #0f172a;
        font-weight: 750;
    }

    /* ==========================================================================
       LIFECYCLE PROGRESS STEPPER (VISUAL ORDER TRACKER)
       ========================================================================== */
    .lifecycle-stepper-card {
        background: #ffffff;
        border: 1.5px solid #e2e8f0;
        border-radius: 20px;
        padding: 22px 28px;
        margin-bottom: 28px;
        box-shadow: 0 4px 18px rgba(15, 23, 42, 0.03);
    }

    .stepper-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        position: relative;
        gap: 12px;
    }

    .stepper-item {
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
        position: relative;
        z-index: 2;
    }

    .step-icon-circle {
        width: 44px;
        height: 44px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 850;
        font-size: 0.95rem;
        margin-bottom: 9px;
        transition: all 0.25s;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
        background: #ffffff;
        border: 2px solid #e2e8f0;
        color: #94a3b8;
    }

    .step-icon-circle.is-done {
        background: #ecfdf5;
        border-color: #10b981;
        color: #059669;
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.22);
    }

    .step-icon-circle.is-active {
        background: #0f172a;
        border-color: #0f172a;
        color: #ffffff;
        box-shadow: 0 6px 18px rgba(15, 23, 42, 0.25);
        animation: active-step-pulse 2s infinite ease-in-out;
    }

    @keyframes active-step-pulse {
        0%, 100% { transform: scale(1); box-shadow: 0 4px 12px rgba(15, 23, 42, 0.25); }
        50% { transform: scale(1.06); box-shadow: 0 8px 22px rgba(79, 70, 229, 0.4); }
    }

    .step-label {
        font-size: 0.85rem;
        font-weight: 800;
        color: #0f172a;
        margin-bottom: 2px;
    }

    .step-sub {
        font-size: 0.72rem;
        color: #64748b;
        font-weight: 600;
    }

    /* Connecting Progress Track Line behind steps */
    .stepper-track-bar {
        position: absolute;
        top: 22px;
        left: 12%;
        right: 12%;
        height: 3px;
        background: #e2e8f0;
        z-index: 1;
        border-radius: 999px;
    }

    .stepper-track-fill {
        height: 100%;
        background: linear-gradient(90deg, #10b981 0%, #10b981 60%, #3b82f6 85%, #e2e8f0 100%);
        border-radius: 999px;
        width: 65%;
    }

    /* ==========================================================================
       MAIN LUXURY RECEIPT CARD
       ========================================================================== */
    .order-receipt-card {
        background: #ffffff;
        border: 1.5px solid #e2e8f0;
        border-radius: 24px;
        text-align: left;
        margin-bottom: 32px;
        box-shadow: 0 20px 45px -15px rgba(15, 23, 42, 0.06), 0 2px 6px rgba(15, 23, 42, 0.02);
        overflow: hidden;
    }

    /* Card Top Header / Meta Grid */
    .receipt-meta-banner {
        background: #f8fafc;
        border-bottom: 1.5px solid #e2e8f0;
        padding: 24px 32px;
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
    }

    .receipt-meta-cell {
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .meta-eyebrow {
        font-size: 0.72rem;
        text-transform: uppercase;
        letter-spacing: 0.6px;
        color: #64748b;
        font-weight: 750;
        margin-bottom: 6px;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .meta-headline-val {
        font-size: 1.15rem;
        font-weight: 850;
        color: #0f172a;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .order-ref-code {
        font-family: 'JetBrains Mono', monospace;
        letter-spacing: -0.3px;
        color: #0f172a;
    }

    .btn-copy-chip {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 2px 8px;
        background: #ffffff;
        border: 1px solid #cbd5e1;
        border-radius: 6px;
        font-size: 0.72rem;
        font-weight: 700;
        color: #475569;
        cursor: pointer;
        transition: all 0.15s;
    }

    .btn-copy-chip:hover {
        background: #0f172a;
        color: #ffffff;
        border-color: #0f172a;
    }

    .tracking-link-pill {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: #eff6ff;
        border: 1.5px solid #bfdbfe;
        color: #1d4ed8;
        padding: 3px 10px;
        border-radius: 9999px;
        font-family: 'JetBrains Mono', monospace;
        font-size: 0.85rem;
        font-weight: 800;
        text-decoration: none;
        transition: all 0.2s;
    }

    .tracking-link-pill:hover {
        background: #1d4ed8;
        color: #ffffff;
        border-color: #1d4ed8;
        box-shadow: 0 4px 12px rgba(29, 78, 216, 0.25);
    }

    .status-badge-pulse {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        background: #ecfdf5;
        border: 1.5px solid #a7f3d0;
        color: #065f46;
        padding: 4px 12px;
        border-radius: 9999px;
        font-size: 0.82rem;
        font-weight: 850;
    }

    .status-dot-glow {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: #10b981;
        box-shadow: 0 0 8px #10b981;
        animation: pulse-dot 2s infinite ease-in-out;
    }

    @keyframes pulse-dot {
        0%, 100% { opacity: 1; transform: scale(1); }
        50% { opacity: 0.4; transform: scale(0.85); }
    }

    .total-paid-figure {
        font-size: 1.35rem;
        font-weight: 900;
        color: #0f172a;
    }

    /* Card Main Body Content */
    .receipt-body-content {
        padding: 32px;
    }

    /* Purchased Items List */
    .items-header-bar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 18px;
        padding-bottom: 12px;
        border-bottom: 1.5px solid #f1f5f9;
    }

    .items-header-title {
        font-size: 1.12rem;
        font-weight: 850;
        color: #0f172a;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .items-count-badge {
        font-size: 0.72rem;
        font-weight: 850;
        background: #f1f5f9;
        color: #475569;
        border: 1px solid #e2e8f0;
        padding: 2px 8px;
        border-radius: 9999px;
    }

    .item-luxury-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 16px 0;
        border-bottom: 1px solid #f1f5f9;
        transition: background 0.15s;
    }

    .item-luxury-row:last-child {
        border-bottom: none;
    }

    .item-media-box {
        display: flex;
        align-items: center;
        gap: 16px;
    }

    .item-thumb-img {
        width: 60px;
        height: 60px;
        border-radius: 12px;
        object-fit: cover;
        background: #f8fafc;
        border: 1.5px solid #e2e8f0;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
        flex-shrink: 0;
    }

    .item-title-meta {
        display: flex;
        flex-direction: column;
        gap: 4px;
    }

    .item-name-heading {
        font-weight: 800;
        font-size: 0.98rem;
        color: #0f172a;
        line-height: 1.35;
    }

    .item-pills-row {
        display: flex;
        align-items: center;
        gap: 8px;
        flex-wrap: wrap;
    }

    .item-spec-pill {
        display: inline-flex;
        align-items: center;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        color: #475569;
        padding: 2px 8px;
        border-radius: 6px;
        font-size: 0.75rem;
        font-weight: 700;
    }

    .item-pricing-box {
        text-align: right;
    }

    .item-line-total {
        font-size: 1.08rem;
        font-weight: 850;
        color: #0f172a;
    }

    .item-unit-note {
        font-size: 0.75rem;
        color: #94a3b8;
        font-weight: 600;
        margin-top: 2px;
    }

    /* Split Details (Shipping vs Payment) */
    .receipt-split-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
        margin-top: 28px;
        padding-top: 24px;
        border-top: 1.5px solid #f1f5f9;
    }

    .detail-card-panel {
        background: #f8fafc;
        border: 1.5px solid #e2e8f0;
        border-radius: 16px;
        padding: 20px 22px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .detail-panel-title {
        font-size: 0.84rem;
        font-weight: 850;
        color: #0f172a;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 12px;
        padding-bottom: 8px;
        border-bottom: 1px solid #e2e8f0;
    }

    .detail-panel-content {
        color: #334155;
        font-size: 0.92rem;
        line-height: 1.6;
    }

    .detail-recipient-name {
        font-weight: 800;
        color: #0f172a;
        font-size: 0.98rem;
        margin-bottom: 2px;
    }

    .detail-phone-tag {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        color: #475569;
        font-size: 0.82rem;
        margin-top: 6px;
        font-weight: 600;
    }

    .payment-verified-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: #ecfdf5;
        border: 1px solid #a7f3d0;
        color: #059669;
        padding: 3px 10px;
        border-radius: 6px;
        font-size: 0.78rem;
        font-weight: 800;
        margin-top: 8px;
    }

    /* Financial Ledger Summary */
    .receipt-ledger-box {
        margin-top: 24px;
        background: #ffffff;
        border: 1.5px solid #e2e8f0;
        border-radius: 16px;
        padding: 18px 24px;
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .ledger-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        font-size: 0.92rem;
        color: #64748b;
        font-weight: 600;
    }

    .ledger-row.is-total {
        margin-top: 8px;
        padding-top: 12px;
        border-top: 1.5px solid #e2e8f0;
        font-size: 1.18rem;
        font-weight: 900;
        color: #0f172a;
    }

    .total-gradient-number {
        font-size: 1.35rem;
        font-weight: 900;
        color: #0f172a;
    }

    /* ==========================================================================
       ACTION DOCK CTA BUTTONS
       ========================================================================== */
    .actions-cta-dock {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 14px;
        flex-wrap: wrap;
        margin-bottom: 32px;
    }

    .btn-cta-pdf {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        background: linear-gradient(135deg, #059669 0%, #10b981 100%);
        color: #ffffff !important;
        font-weight: 850;
        font-size: 0.96rem;
        padding: 14px 26px;
        border-radius: 14px;
        text-decoration: none;
        box-shadow: 0 8px 22px -4px rgba(16, 185, 129, 0.4);
        border: none;
        transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
    }

    .btn-cta-pdf:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 28px -4px rgba(16, 185, 129, 0.55);
        color: #ffffff !important;
    }

    .btn-cta-print {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: #ffffff;
        border: 1.5px solid #cbd5e1;
        color: #0f172a !important;
        font-weight: 800;
        font-size: 0.92rem;
        padding: 13px 22px;
        border-radius: 14px;
        text-decoration: none;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.03);
        transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
    }

    .btn-cta-print:hover {
        background: #f8fafc;
        border-color: #94a3b8;
        transform: translateY(-1px);
        color: #0f172a !important;
    }

    .btn-cta-track {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: #0f172a;
        border: 1.5px solid #0f172a;
        color: #ffffff !important;
        font-weight: 850;
        font-size: 0.92rem;
        padding: 13px 24px;
        border-radius: 14px;
        text-decoration: none;
        box-shadow: 0 6px 18px rgba(15, 23, 42, 0.2);
        transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
    }

    .btn-cta-track:hover {
        background: #1e293b;
        transform: translateY(-1px);
        box-shadow: 0 10px 24px rgba(15, 23, 42, 0.3);
        color: #ffffff !important;
    }

    .btn-cta-shop {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: transparent;
        border: 1.5px solid #e2e8f0;
        color: #475569 !important;
        font-weight: 750;
        font-size: 0.92rem;
        padding: 13px 22px;
        border-radius: 14px;
        text-decoration: none;
        transition: all 0.2s;
    }

    .btn-cta-shop:hover {
        background: #f8fafc;
        border-color: #cbd5e1;
        color: #0f172a !important;
    }

    /* Support Callout Banner */
    .support-concierge-card {
        background: #f8fafc;
        border: 1.5px dashed #cbd5e1;
        border-radius: 16px;
        padding: 18px 24px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
        text-align: left;
    }

    .concierge-left {
        display: flex;
        align-items: center;
        gap: 14px;
    }

    .concierge-icon {
        width: 42px;
        height: 42px;
        border-radius: 12px;
        background: #ffffff;
        border: 1.5px solid #e2e8f0;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
        flex-shrink: 0;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.04);
    }

    .concierge-text h4 {
        margin: 0 0 2px;
        font-size: 0.95rem;
        font-weight: 850;
        color: #0f172a;
    }

    .concierge-text p {
        margin: 0;
        font-size: 0.82rem;
        color: #64748b;
    }

    .concierge-links {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-shrink: 0;
    }

    .concierge-pill-link {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: #ffffff;
        border: 1.5px solid #e2e8f0;
        padding: 6px 14px;
        border-radius: 9999px;
        font-size: 0.80rem;
        font-weight: 750;
        color: #0f172a;
        text-decoration: none;
        transition: all 0.2s;
    }

    .concierge-pill-link:hover {
        background: #0f172a;
        color: #ffffff;
        border-color: #0f172a;
    }

    /* Responsive Queries */
    @media (max-width: 768px) {
        .receipt-meta-banner {
            grid-template-columns: 1fr 1fr;
            gap: 16px;
            padding: 20px;
        }

        .receipt-split-grid {
            grid-template-columns: 1fr;
            gap: 16px;
        }

        .stepper-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 16px;
        }

        .stepper-track-bar {
            display: none;
        }

        .support-concierge-card {
            flex-direction: column;
            align-items: flex-start;
        }

        .actions-cta-dock {
            flex-direction: column;
            width: 100%;
        }

        .actions-cta-dock a {
            width: 100%;
            justify-content: center;
        }
    }
</style>
@endsection

@section('content')

    <div class="confirm-container">
        <!-- 1. Top Status Eyebrow Badge -->
        <div class="confirm-eyebrow-pill">
            <span>🎉</span>
            <span>Order Confirmed & In Production • បានទទួលការកុម្ម៉ង់ជោគជ័យ</span>
        </div>

        <!-- 2. Concentric Glowing Success Badge -->
        <div class="luxury-success-badge-wrap">
            <div class="badge-pulse-glow"></div>
            <div class="luxury-success-badge">
                <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="20 6 9 17 4 12"></polyline>
                </svg>
            </div>
        </div>

        <h1 class="confirm-title">Thank You For Your Order!</h1>
        <p class="confirm-desc">
            We've received your order and our atelier workshop is carefully preparing your apparel. An official receipt & dispatch confirmation has been sent to <strong>{{ $order->customer_email }}</strong>.
        </p>

        <!-- 3. Lifecycle Progress Stepper (Visual Order Tracker) -->
        <div class="lifecycle-stepper-card">
            <div class="stepper-grid">
                <div class="stepper-track-bar">
                    <div class="stepper-track-fill"></div>
                </div>

                <!-- Step 1: Placed -->
                <div class="stepper-item">
                    <div class="step-icon-circle is-done">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="20 6 9 17 4 12"></polyline>
                        </svg>
                    </div>
                    <div class="step-label">Order Placed</div>
                    <div class="step-sub">{{ $order->created_at->format('M d, h:i A') }}</div>
                </div>

                <!-- Step 2: Payment Verified -->
                <div class="stepper-item">
                    <div class="step-icon-circle is-done">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="20 6 9 17 4 12"></polyline>
                        </svg>
                    </div>
                    <div class="step-label">Payment Verified</div>
                    <div class="step-sub">{{ $order->payment_method === 'QR Code' ? 'KHQR Paid' : $order->payment_method }}</div>
                </div>

                <!-- Step 3: Workshop Production -->
                <div class="stepper-item">
                    <div class="step-icon-circle is-active">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10"></circle>
                            <polyline points="12 6 12 12 16 14"></polyline>
                        </svg>
                    </div>
                    <div class="step-label">In Production</div>
                    <div class="step-sub">Garment Atelier</div>
                </div>

                <!-- Step 4: Dispatched -->
                <div class="stepper-item">
                    <div class="step-icon-circle">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="1" y="3" width="15" height="13"></rect>
                            <polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon>
                            <circle cx="5.5" cy="18.5" r="2.5"></circle>
                            <circle cx="18.5" cy="18.5" r="2.5"></circle>
                        </svg>
                    </div>
                    <div class="step-label">Out for Delivery</div>
                    <div class="step-sub">{{ $order->delivery_method }} Courier</div>
                </div>
            </div>
        </div>

        <!-- 4. Main Luxury Receipt Card -->
        <div class="order-receipt-card">
            <!-- Meta Strip -->
            <div class="receipt-meta-banner">
                <div class="receipt-meta-cell">
                    <span class="meta-eyebrow">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline></svg>
                        Order Reference
                    </span>
                    <div class="meta-headline-val">
                        <span class="order-ref-code" id="orderRefText">#{{ $order->order_number }}</span>
                        <button type="button" class="btn-copy-chip" id="copyRefBtn" onclick="copyOrderRef('{{ $order->order_number }}')" title="Copy Order Number">
                            <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path></svg>
                            <span id="copyBtnLabel">Copy</span>
                        </button>
                    </div>
                </div>

                <div class="receipt-meta-cell">
                    <span class="meta-eyebrow">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 14 14"></polyline></svg>
                        Tracking Code
                    </span>
                    <div class="meta-headline-val">
                        <a href="{{ route('order.track', ['code' => $order->tracking_code]) }}" class="tracking-link-pill" title="Track Order Live">
                            <span>{{ $order->tracking_code }}</span>
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><line x1="7" y1="17" x2="17" y2="7"></line><polyline points="7 7 17 7 17 17"></polyline></svg>
                        </a>
                    </div>
                </div>

                <div class="receipt-meta-cell">
                    <span class="meta-eyebrow">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                        Fulfillment Status
                    </span>
                    <div class="meta-headline-val">
                        <span class="status-badge-pulse">
                            <span class="status-dot-glow"></span>
                            <span>{{ $order->status ?? 'Processing' }}</span>
                        </span>
                    </div>
                </div>

                <div class="receipt-meta-cell">
                    <span class="meta-eyebrow">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="1" x2="12" y2="23"></line><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path></svg>
                        Total Amount Paid
                    </span>
                    <div class="meta-headline-val">
                        <span class="total-paid-figure">${{ number_format($order->total, 2) }}</span>
                    </div>
                </div>
            </div>

            <!-- Body Details -->
            <div class="receipt-body-content">
                <!-- Purchased Items Section -->
                <div class="items-header-bar">
                    <div class="items-header-title">
                        <span>Purchased Items</span>
                        <span class="items-count-badge">{{ $order->items->count() }} {{ Str::plural('Item', $order->items->count()) }}</span>
                    </div>
                    <span style="font-size:0.75rem; color:#94a3b8; font-weight:700;">Direct from Atelier Workshop</span>
                </div>

                @foreach ($order->items as $item)
                    <div class="item-luxury-row">
                        <div class="item-media-box">
                            <img src="{{ asset($item->image) }}" alt="{{ $item->product_name }}" class="item-thumb-img" onerror="this.src='/images/placeholder.jpg';">
                            <div class="item-title-meta">
                                <span class="item-name-heading">{{ $item->product_name }}</span>
                                <div class="item-pills-row">
                                    <span class="item-spec-pill">Size: {{ $item->size }}</span>
                                    @if ($item->color)
                                        <span class="item-spec-pill">Color: {{ $item->color }}</span>
                                    @endif
                                    <span class="item-spec-pill">Qty: {{ $item->quantity }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="item-pricing-box">
                            <div class="item-line-total">${{ number_format($item->price * $item->quantity, 2) }}</div>
                            @if ($item->quantity > 1)
                                <div class="item-unit-note">(${{ number_format($item->price, 2) }} each)</div>
                            @endif
                        </div>
                    </div>
                @endforeach

                <!-- Split Grid: Shipping & Payment -->
                <div class="receipt-split-grid">
                    <!-- Left: Shipping Destination -->
                    <div class="detail-card-panel">
                        <div>
                            <div class="detail-panel-title">
                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#2563eb" stroke-width="2.5"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                                <span>Shipping Destination (អាសយដ្ឋានដឹក)</span>
                            </div>
                            <div class="detail-panel-content">
                                <div class="detail-recipient-name">{{ $order->customer_name }}</div>
                                <div>{{ $order->shipping_address }}</div>
                                <div>{{ $order->city }}, {{ $order->postal_code }}</div>
                                @if ($order->customer_phone)
                                    <div class="detail-phone-tag">
                                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
                                        <span>{{ $order->customer_phone }}</span>
                                    </div>
                                @endif
                                @if ($order->notes)
                                    <div style="margin-top:8px; font-size:0.78rem; color:#64748b; font-style:italic; background:#ffffff; padding:5px 9px; border-radius:6px; border:1px solid #e2e8f0;">
                                        Note: {{ $order->notes }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Right: Delivery & Payment Details -->
                    <div class="detail-card-panel">
                        <div>
                            <div class="detail-panel-title">
                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#059669" stroke-width="2.5"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect><line x1="1" y1="10" x2="23" y2="10"></line></svg>
                                <span>Delivery & Payment (ការទូទាត់)</span>
                            </div>
                            <div class="detail-panel-content">
                                <div><strong>Courier:</strong> {{ $order->delivery_method }} Courier (Express Dispatch)</div>
                                <div style="margin-top:3px;">
                                    <strong>Method:</strong>
                                    <span>{{ $order->payment_method === 'QR Code' ? '📱 KHQR / Bank QR Scan' : $order->payment_method }}</span>
                                </div>
                                @if ($order->payment_reference)
                                    <div style="font-size:0.8rem; color:#4f46e5; font-family:'JetBrains Mono', monospace; margin-top:4px;">
                                        Transaction Ref: {{ $order->payment_reference }}
                                    </div>
                                @endif
                                <div class="payment-verified-badge">
                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"></polyline></svg>
                                    <span>Payment Confirmed & Verified</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Financial Ledger Summary -->
                <div class="receipt-ledger-box">
                    <div class="ledger-row">
                        <span>Items Subtotal (សរុបតម្លៃទំនិញ)</span>
                        <span style="font-weight:750; color:#0f172a;">${{ number_format($order->subtotal, 2) }}</span>
                    </div>

                    <div class="ledger-row">
                        <span>Shipping & Handling Fee (ថ្លៃដឹកជញ្ជូន)</span>
                        <span style="font-weight:750; color:#0f172a;">
                            @if ($order->shipping_fee > 0)
                                ${{ number_format($order->shipping_fee, 2) }}
                            @else
                                <span style="color:#059669; font-weight:800;">Free Shipping</span>
                            @endif
                        </span>
                    </div>

                    @if ($order->discount > 0)
                        <div class="ledger-row" style="color:#059669;">
                            <span>Promo Voucher Discount (បញ្ចុះតម្លៃ)</span>
                            <span style="font-weight:750;">-${{ number_format($order->discount, 2) }}</span>
                        </div>
                    @endif

                    <div class="ledger-row is-total">
                        <span>Total Settled (ចំនួនទឹកប្រាក់ទូទាត់សរុប)</span>
                        <span class="total-gradient-number">${{ number_format($order->total, 2) }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- 5. Action Dock CTA Buttons -->
        <div class="actions-cta-dock">
            <a href="{{ route('order.invoice', $order->order_number) }}?download=1" target="_blank" class="btn-cta-pdf" title="Download Official Tax Invoice PDF">
                <svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                <span>Download Invoice (PDF) / ទាញយកវិក្កយបត្រ</span>
            </a>

            <a href="{{ route('order.invoice', $order->order_number) }}" target="_blank" class="btn-cta-print" title="Print Invoice">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><polyline points="6 9 6 2 18 2 18 9"></polyline><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path><rect x="6" y="14" width="12" height="8"></rect></svg>
                <span>Print Invoice (បោះពុម្ព)</span>
            </a>

            <a href="{{ route('order.track', ['code' => $order->tracking_code]) }}" class="btn-cta-track" title="Track Live Status">
                <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"></circle><polygon points="16.24 7.76 14.12 14.12 7.76 16.24 9.88 9.88 16.24 7.76"></polygon></svg>
                <span>Track Live Delivery →</span>
            </a>

            <a href="{{ route('shop.index') }}" class="btn-cta-shop">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path><line x1="3" y1="6" x2="21" y2="6"></line><path d="M16 10a4 4 0 0 1-8 0"></path></svg>
                <span>Back to Shop</span>
            </a>
        </div>

        <!-- 6. Customer Concierge Support Banner -->
        <div class="support-concierge-card">
            <div class="concierge-left">
                <div class="concierge-icon">💬</div>
                <div class="concierge-text">
                    <h4>Need help or want to modify your order?</h4>
                    <p>Our dedicated customer support concierge is available 7 days a week to assist you.</p>
                </div>
            </div>
            <div class="concierge-links">
                <a href="https://t.me/Tdelivery4_bot" target="_blank" class="concierge-pill-link">
                    <span>📱 Telegram Bot</span>
                </a>
                <a href="{{ route('contact') }}" class="concierge-pill-link">
                    <span>Contact Concierge ↗</span>
                </a>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
<script>
    function copyOrderRef(text) {
        if (!navigator.clipboard) {
            const input = document.createElement('input');
            input.value = text;
            document.body.appendChild(input);
            input.select();
            document.execCommand('copy');
            document.body.removeChild(input);
            showCopiedUI();
            return;
        }

        navigator.clipboard.writeText(text).then(function() {
            showCopiedUI();
        });
    }

    function showCopiedUI() {
        const label = document.getElementById('copyBtnLabel');
        const btn = document.getElementById('copyRefBtn');
        if (label && btn) {
            const originalText = label.textContent;
            label.textContent = 'Copied!';
            btn.style.background = '#0f172a';
            btn.style.color = '#ffffff';
            btn.style.borderColor = '#0f172a';
            setTimeout(function() {
                label.textContent = originalText;
                btn.style.background = '';
                btn.style.color = '';
                btn.style.borderColor = '';
            }, 2000);
        }
    }
</script>
@endsection
