@extends('layouts.store')

@section('title', 'Track Your Package — T-Shirt Online')

@section('styles')
<style>
    /* -------------------------------------------------------------
       TRACKING PAGE - MODERN LUXURY THEME
    ------------------------------------------------------------- */
    .track-wrap {
        max-width: 960px;
        margin: 36px auto 80px;
        padding: 0 20px;
    }

    /* Page Header */
    .track-hero-header {
        text-align: center;
        margin-bottom: 30px;
    }

    .track-hero-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: #eff6ff;
        border: 1px solid #bfdbfe;
        color: #1d4ed8;
        padding: 5px 14px;
        border-radius: 9999px;
        font-size: 0.78rem;
        font-weight: 800;
        letter-spacing: 0.4px;
        text-transform: uppercase;
        margin-bottom: 12px;
    }

    .track-hero-title {
        font-size: 2.2rem;
        font-weight: 900;
        color: #0f172a;
        letter-spacing: -0.6px;
        margin-bottom: 8px;
    }

    .track-hero-sub {
        font-size: 0.96rem;
        color: #64748b;
        max-width: 580px;
        margin: 0 auto;
        line-height: 1.5;
    }

    /* Search Box Card */
    .track-search-card {
        background: #ffffff;
        border: 1.5px solid #e2e8f0;
        border-radius: 20px;
        padding: 24px 28px;
        box-shadow: 0 4px 20px -2px rgba(15, 23, 42, 0.04);
        margin-bottom: 30px;
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
    }

    .track-search-card:hover {
        border-color: #cbd5e1;
        box-shadow: 0 8px 28px -4px rgba(15, 23, 42, 0.07);
    }

    .search-track-form {
        display: flex;
        gap: 12px;
        align-items: center;
        flex-wrap: wrap;
    }

    .search-input-wrap {
        position: relative;
        flex: 1;
        min-width: 260px;
        display: flex;
        align-items: center;
    }

    .search-input-icon {
        position: absolute;
        left: 18px;
        color: #94a3b8;
        display: flex;
        align-items: center;
        pointer-events: none;
    }

    .track-input {
        width: 100%;
        background: #f8fafc;
        border: 1.5px solid #cbd5e1;
        color: #0f172a !important; /* Fixed: dark high contrast text */
        padding: 13px 18px 13px 48px;
        border-radius: 14px;
        font-size: 0.98rem;
        font-weight: 600;
        outline: none;
        transition: all 0.2s ease;
        letter-spacing: 0.3px;
    }

    .track-input::placeholder {
        color: #94a3b8;
        font-weight: 500;
    }

    .track-input:focus {
        background: #ffffff;
        border-color: #2563eb;
        box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.12);
    }

    .track-btn-submit {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        background: #0f172a;
        color: #ffffff;
        border: none;
        padding: 14px 28px;
        border-radius: 14px;
        font-size: 0.95rem;
        font-weight: 800;
        cursor: pointer;
        transition: all 0.2s ease;
        white-space: nowrap;
    }

    .track-btn-submit:hover {
        background: #1e293b;
        transform: translateY(-1px);
        box-shadow: 0 6px 18px rgba(15, 23, 42, 0.18);
    }

    /* Result Card */
    .timeline-card {
        background: #ffffff;
        border: 1.5px solid #e2e8f0;
        border-radius: 20px;
        padding: 32px;
        box-shadow: 0 4px 24px -2px rgba(15, 23, 42, 0.05);
        margin-bottom: 24px;
    }

    /* Header Bar within Result */
    .tracking-result-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        flex-wrap: wrap;
        gap: 16px;
        padding-bottom: 24px;
        border-bottom: 1.5px solid #f1f5f9;
        margin-bottom: 28px;
    }

    .tracking-code-pill-wrap {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
    }

    .tracking-code-title {
        font-size: 0.74rem;
        font-weight: 800;
        text-transform: uppercase;
        color: #64748b;
        letter-spacing: 0.6px;
        margin-bottom: 4px;
    }

    .tracking-code-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: #eff6ff;
        border: 1.5px solid #bfdbfe;
        color: #1d4ed8;
        font-size: 1.15rem;
        font-weight: 900;
        padding: 6px 14px;
        border-radius: 10px;
        font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace;
        letter-spacing: 0.5px;
    }

    .copy-btn-mini {
        background: #f1f5f9;
        border: 1px solid #cbd5e1;
        color: #475569;
        border-radius: 8px;
        padding: 6px 10px;
        font-size: 0.75rem;
        font-weight: 750;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        transition: all 0.15s ease;
    }

    .copy-btn-mini:hover {
        background: #e2e8f0;
        color: #0f172a;
    }

    /* Status Pill Variants */
    .status-badge-lg {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 16px;
        border-radius: 9999px;
        font-size: 0.85rem;
        font-weight: 850;
        letter-spacing: 0.3px;
    }

    .status-badge-processing {
        background: #fffbeb;
        color: #b45309;
        border: 1.5px solid #fde68a;
    }

    .status-badge-shipped {
        background: #eff6ff;
        color: #1d4ed8;
        border: 1.5px solid #bfdbfe;
    }

    .status-badge-delivered {
        background: #ecfdf5;
        color: #047857;
        border: 1.5px solid #a7f3d0;
    }

    .status-badge-cancelled {
        background: #fef2f2;
        color: #b91c1c;
        border: 1.5px solid #fecaca;
    }

    .pulse-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        display: inline-block;
    }

    .pulse-dot.amber {
        background: #f59e0b;
        box-shadow: 0 0 0 0 rgba(245, 158, 11, 0.7);
        animation: pulseAmber 1.8s infinite;
    }

    .pulse-dot.blue {
        background: #3b82f6;
        box-shadow: 0 0 0 0 rgba(59, 130, 246, 0.7);
        animation: pulseBlue 1.8s infinite;
    }

    .pulse-dot.green {
        background: #10b981;
    }

    @keyframes pulseAmber {
        0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(245, 158, 11, 0.7); }
        70% { transform: scale(1); box-shadow: 0 0 0 6px rgba(245, 158, 11, 0); }
        100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(245, 158, 11, 0); }
    }

    @keyframes pulseBlue {
        0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(59, 130, 246, 0.7); }
        70% { transform: scale(1); box-shadow: 0 0 0 6px rgba(59, 130, 246, 0); }
        100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(59, 130, 246, 0); }
    }

    /* ETA Banner */
    .eta-banner {
        background: linear-gradient(135deg, #f0fdf4 0%, #ecfdf5 100%);
        border: 1.5px solid #bbf7d0;
        border-radius: 14px;
        padding: 16px 20px;
        margin-bottom: 32px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 12px;
    }

    .eta-banner-left {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .eta-icon-box {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        background: #dcfce7;
        color: #15803d;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
    }

    .eta-title {
        font-size: 0.78rem;
        font-weight: 750;
        color: #166534;
        text-transform: uppercase;
        letter-spacing: 0.4px;
    }

    .eta-val {
        font-size: 1.05rem;
        font-weight: 850;
        color: #065f46;
    }

    /* Modern 4-Step Stepper */
    .stepper-container {
        margin: 36px 0 40px;
        padding: 0 10px;
        position: relative;
    }

    .stepper-track-bg {
        position: absolute;
        top: 24px;
        left: 50px;
        right: 50px;
        height: 5px;
        background: #e2e8f0;
        border-radius: 9999px;
        z-index: 1;
    }

    .stepper-track-fill {
        position: absolute;
        top: 24px;
        left: 50px;
        height: 5px;
        background: linear-gradient(90deg, #2563eb 0%, #3b82f6 50%, #10b981 100%);
        border-radius: 9999px;
        z-index: 2;
        transition: width 0.5s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .stepper-nodes-row {
        position: relative;
        z-index: 3;
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
    }

    .step-item-node {
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
        width: 120px;
    }

    .step-circle {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        background: #ffffff;
        border: 2.5px solid #cbd5e1;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.1rem;
        color: #94a3b8;
        font-weight: 800;
        transition: all 0.3s ease;
        margin-bottom: 12px;
        box-shadow: 0 2px 8px rgba(15, 23, 42, 0.04);
    }

    /* Completed state */
    .step-item-node.completed .step-circle {
        background: #2563eb;
        border-color: #2563eb;
        color: #ffffff;
        box-shadow: 0 4px 14px rgba(37, 99, 235, 0.3);
    }

    /* Active state (in-progress) */
    .step-item-node.active .step-circle {
        background: #ffffff;
        border-color: #2563eb;
        color: #2563eb;
        box-shadow: 0 0 0 5px rgba(37, 99, 235, 0.18);
        transform: scale(1.08);
    }

    .step-title {
        font-size: 0.88rem;
        font-weight: 800;
        color: #64748b;
        margin-bottom: 3px;
        line-height: 1.3;
    }

    .step-item-node.completed .step-title,
    .step-item-node.active .step-title {
        color: #0f172a; /* Fixed: dark high-contrast */
    }

    .step-desc {
        font-size: 0.74rem;
        font-weight: 600;
        color: #94a3b8;
        line-height: 1.3;
    }

    .step-item-node.completed .step-desc,
    .step-item-node.active .step-desc {
        color: #475569;
    }

    @media (max-width: 680px) {
        .stepper-container {
            margin: 24px 0 30px;
        }
        .stepper-track-bg, .stepper-track-fill {
            left: 30px;
            right: 30px;
            top: 20px;
        }
        .step-item-node {
            width: 78px;
        }
        .step-circle {
            width: 38px;
            height: 38px;
            font-size: 0.95rem;
        }
        .step-title {
            font-size: 0.76rem;
        }
        .step-desc {
            font-size: 0.68rem;
        }
    }

    /* Detail Grid (2-Column Cards) */
    .track-details-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
        margin-top: 32px;
    }

    @media (max-width: 768px) {
        .track-details-grid {
            grid-template-columns: 1fr;
        }
    }

    .info-card {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        padding: 20px 22px;
    }

    .info-card-header {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 0.82rem;
        font-weight: 800;
        color: #475569;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 14px;
        padding-bottom: 10px;
        border-bottom: 1px dashed #cbd5e1;
    }

    .info-data-row {
        margin-bottom: 10px;
    }

    .info-data-row:last-child {
        margin-bottom: 0;
    }

    .info-label {
        font-size: 0.76rem;
        font-weight: 600;
        color: #64748b;
        margin-bottom: 2px;
    }

    .info-value-bold {
        font-size: 0.94rem;
        font-weight: 800;
        color: #0f172a; /* Fixed: High contrast */
    }

    .info-value-sub {
        font-size: 0.86rem;
        color: #334155;
        line-height: 1.4;
    }

    /* Package Items Section */
    .package-items-card {
        background: #ffffff;
        border: 1.5px solid #e2e8f0;
        border-radius: 18px;
        padding: 24px;
        margin-top: 24px;
    }

    .package-items-heading {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 16px;
        flex-wrap: wrap;
        gap: 10px;
    }

    .package-item-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 12px 0;
        border-bottom: 1px solid #f1f5f9;
        gap: 14px;
    }

    .package-item-row:last-child {
        border-bottom: none;
        padding-bottom: 0;
    }

    .item-thumb-box {
        width: 52px;
        height: 52px;
        border-radius: 10px;
        background: #f1f5f9;
        border: 1px solid #e2e8f0;
        overflow: hidden;
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .item-thumb-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .item-meta-col {
        flex: 1;
        min-width: 0;
    }

    .item-title-text {
        font-size: 0.90rem;
        font-weight: 750;
        color: #0f172a;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .item-badge-pill {
        display: inline-block;
        background: #f1f5f9;
        color: #475569;
        font-size: 0.72rem;
        font-weight: 700;
        padding: 2px 8px;
        border-radius: 6px;
        margin-top: 3px;
    }

    .item-price-col {
        text-align: right;
        flex-shrink: 0;
    }

    .item-price-val {
        font-size: 0.92rem;
        font-weight: 850;
        color: #0f172a;
    }

    .item-qty-val {
        font-size: 0.76rem;
        color: #64748b;
        font-weight: 600;
    }

    /* Action Toolbar at Bottom */
    .track-actions-bar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 12px;
        margin-top: 28px;
        padding-top: 20px;
        border-top: 1px solid #e2e8f0;
    }

    .action-link-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 18px;
        border-radius: 10px;
        font-size: 0.86rem;
        font-weight: 750;
        text-decoration: none;
        transition: all 0.15s ease;
    }

    .action-link-default {
        background: #f8fafc;
        border: 1px solid #cbd5e1;
        color: #334155;
    }

    .action-link-default:hover {
        background: #e2e8f0;
        color: #0f172a;
    }

    .action-link-primary {
        background: #0f172a;
        color: #ffffff;
    }

    .action-link-primary:hover {
        background: #1e293b;
    }

    /* Empty state card */
    .empty-track-box {
        text-align: center;
        padding: 50px 24px;
        background: #ffffff;
        border: 1.5px solid #e2e8f0;
        border-radius: 20px;
        box-shadow: 0 4px 20px -2px rgba(15, 23, 42, 0.04);
    }
</style>
@endsection

@section('content')

<div class="track-wrap">
    <!-- Hero Header -->
    <div class="track-hero-header">
        <span class="track-hero-badge">📦 Live Tracking</span>
        <h1 class="track-hero-title">Track Your Package</h1>
        <p class="track-hero-sub">
            បញ្ចូលលេខកូដតាមដានទំនិញ (Tracking Code) ឬលេខបញ្ជាទិញ (Order Number) ដើម្បីពិនិត្យមើលស្ថានភាពដឹកជញ្ជូនជាក់ស្តែង។
        </p>
    </div>

    <!-- Search Form Card -->
    <div class="track-search-card">
        <form action="{{ route('order.track') }}" method="GET" class="search-track-form">
            <div class="search-input-wrap">
                <span class="search-input-icon">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="11" cy="11" r="8"></circle>
                        <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                    </svg>
                </span>
                <input type="text" name="code" class="track-input" placeholder="e.g. TRK-20261105-... or TC-..." value="{{ $trackingQuery }}" required autofocus>
            </div>
            <button type="submit" class="track-btn-submit">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"></polyline>
                </svg>
                <span>Track Package</span>
            </button>
        </form>

        @if(!$order && empty($trackingQuery))
            <div style="display:flex; align-items:center; justify-content:center; gap:8px; margin-top:14px; font-size:0.78rem; color:#64748b; flex-wrap:wrap;">
                <span>💡 Hint: You can find your tracking code in your order confirmation email or invoice.</span>
            </div>
        @endif
    </div>

    @if ($order)
        @php
            $statusRaw = strtolower(trim($order->status));
            
            // Stepper state calculations
            $isCancelled = in_array($statusRaw, ['cancelled', 'cancel', 'canceled']);
            $isDelivered = in_array($statusRaw, ['delivered', 'completed']);
            $isShipped = in_array($statusRaw, ['shipped', 'in_transit', 'out_for_delivery']) || $isDelivered;
            $isProcessing = in_array($statusRaw, ['processing', 'confirmed', 'paid', 'pending']) || $isShipped;

            $fillWidth = '12%';
            if ($isCancelled) {
                $fillWidth = '0%';
            } elseif ($isDelivered) {
                $fillWidth = '100%';
            } elseif ($isShipped) {
                $fillWidth = '66%';
            } elseif ($isProcessing) {
                $fillWidth = '33%';
            }

            // Estimated Delivery Date calculation
            $orderDate = $order->created_at ?: now();
            if ($order->delivery_method === 'Express') {
                $etaStart = $orderDate->copy()->addDays(1)->format('D, M d');
                $etaEnd = $orderDate->copy()->addDays(2)->format('D, M d');
                $etaDays = '1 - 2 Business Days';
            } else {
                $etaStart = $orderDate->copy()->addDays(2)->format('D, M d');
                $etaEnd = $orderDate->copy()->addDays(4)->format('D, M d');
                $etaDays = '2 - 4 Business Days';
            }
        @endphp

        <!-- Main Tracking Result Panel -->
        <div class="timeline-card">
            
            <!-- Result Header -->
            <div class="tracking-result-header">
                <div>
                    <div class="tracking-code-title">Tracking Number / លេខកូដតាមដាន</div>
                    <div class="tracking-code-pill-wrap">
                        <span class="tracking-code-badge" id="trackingCodeText">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="1" y="3" width="15" height="13"></rect>
                                <polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon>
                                <circle cx="5.5" cy="18.5" r="2.5"></circle>
                                <circle cx="18.5" cy="18.5" r="2.5"></circle>
                            </svg>
                            <span>{{ $order->tracking_code ?: 'TRK-' . date('Ymd', strtotime($order->created_at)) . '-' . $order->id }}</span>
                        </span>
                        <button type="button" class="copy-btn-mini" onclick="copyTrackingCode('{{ $order->tracking_code }}')">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path></svg>
                            <span id="copyBtnLabel">Copy</span>
                        </button>
                    </div>
                </div>

                <!-- Live Status Badge -->
                <div style="text-align:right;">
                    <div class="tracking-code-title">Current Status / ស្ថានភាពបច្ចុប្បន្ន</div>
                    @if ($isCancelled)
                        <span class="status-badge-lg status-badge-cancelled">
                            <span>✕</span>
                            <span>Cancelled</span>
                        </span>
                    @elseif ($isDelivered)
                        <span class="status-badge-lg status-badge-delivered">
                            <span class="pulse-dot green"></span>
                            <span>Delivered Successfully</span>
                        </span>
                    @elseif ($isShipped)
                        <span class="status-badge-lg status-badge-shipped">
                            <span class="pulse-dot blue"></span>
                            <span>In Transit / On the Way</span>
                        </span>
                    @else
                        <span class="status-badge-lg status-badge-processing">
                            <span class="pulse-dot amber"></span>
                            <span>Processing & Packing</span>
                        </span>
                    @endif
                    <div style="font-size:0.75rem; color:#64748b; margin-top:4px; font-weight:600;">
                        Order #{{ $order->order_number }}
                    </div>
                </div>
            </div>

            <!-- Estimated Delivery Banner -->
            @if (!$isCancelled)
                <div class="eta-banner">
                    <div class="eta-banner-left">
                        <div class="eta-icon-box">
                            🚚
                        </div>
                        <div>
                            <div class="eta-title">
                                @if($isDelivered) Package Delivered @else Estimated Arrival Window @endif
                            </div>
                            <div class="eta-val">
                                @if($isDelivered)
                                    Delivered on {{ $order->updated_at ? $order->updated_at->format('M d, Y') : now()->format('M d, Y') }}
                                @else
                                    {{ $etaStart }} &ndash; {{ $etaEnd }} ({{ $etaDays }})
                                @endif
                            </div>
                        </div>
                    </div>
                    <div>
                        <span style="font-size:0.78rem; font-weight:750; background:#ffffff; border:1px solid #bbf7d0; color:#15803d; padding:5px 12px; border-radius:9999px;">
                            {{ $order->delivery_method ?: 'Standard' }} Delivery
                        </span>
                    </div>
                </div>
            @else
                <div style="background:#fef2f2; border:1.5px solid #fecaca; border-radius:14px; padding:16px 20px; margin-bottom:30px; display:flex; align-items:center; gap:12px; color:#991b1b;">
                    <span style="font-size:1.4rem;">⚠️</span>
                    <div>
                        <div style="font-weight:800; font-size:0.95rem;">Order Cancelled</div>
                        <div style="font-size:0.82rem; color:#b91c1c;">This order has been cancelled and will not be dispatched. If you need assistance, please contact customer support.</div>
                    </div>
                </div>
            @endif

            <!-- 4-Step Interactive Stepper -->
            <div class="stepper-container">
                <div class="stepper-track-bg"></div>
                <div class="stepper-track-fill" style="width: {{ $fillWidth }};"></div>

                <div class="stepper-nodes-row">
                    <!-- Step 1: Placed -->
                    <div class="step-item-node completed">
                        <div class="step-circle">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="20 6 9 17 4 12"></polyline>
                            </svg>
                        </div>
                        <div class="step-title">Order Placed</div>
                        <div class="step-desc">{{ $order->created_at->format('M d, Y') }}</div>
                    </div>

                    <!-- Step 2: Processing -->
                    <div class="step-item-node {{ $isProcessing && !$isCancelled ? ($isShipped ? 'completed' : 'active') : '' }}">
                        <div class="step-circle">
                            @if ($isShipped)
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
                            @else
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="12" cy="12" r="3"></circle>
                                    <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path>
                                </svg>
                            @endif
                        </div>
                        <div class="step-title">Processing</div>
                        <div class="step-desc">Quality & Packing</div>
                    </div>

                    <!-- Step 3: Shipped -->
                    <div class="step-item-node {{ $isShipped && !$isCancelled ? ($isDelivered ? 'completed' : 'active') : '' }}">
                        <div class="step-circle">
                            @if ($isDelivered)
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
                            @else
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.3" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="1" y="3" width="15" height="13"></rect>
                                    <polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon>
                                    <circle cx="5.5" cy="18.5" r="2.5"></circle>
                                    <circle cx="18.5" cy="18.5" r="2.5"></circle>
                                </svg>
                            @endif
                        </div>
                        <div class="step-title">Shipped</div>
                        <div class="step-desc">In Courier Transit</div>
                    </div>

                    <!-- Step 4: Delivered -->
                    <div class="step-item-node {{ $isDelivered && !$isCancelled ? 'completed' : '' }}">
                        <div class="step-circle">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.3" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path>
                                <polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline>
                                <line x1="12" y1="22.08" x2="12" y2="12"></line>
                            </svg>
                        </div>
                        <div class="step-title">Delivered</div>
                        <div class="step-desc">Destination Arrival</div>
                    </div>
                </div>
            </div>

            <!-- Two-Column Information Cards (Fixed: 100% High Contrast Text) -->
            <div class="track-details-grid">
                <!-- Card 1: Delivery Information -->
                <div class="info-card">
                    <div class="info-card-header">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                        <span>Delivery Destination / អាសយដ្ឋានដឹកជញ្ជូន</span>
                    </div>

                    <div class="info-data-row">
                        <div class="info-label">Recipient Name</div>
                        <div class="info-value-bold">{{ $order->customer_name }}</div>
                    </div>

                    <div class="info-data-row">
                        <div class="info-label">Contact Phone & Email</div>
                        <div class="info-value-sub">
                            <strong>{{ $order->customer_phone }}</strong>
                            @if($order->customer_email)
                                <span style="color:#64748b; font-size:0.80rem;">&bull; {{ $order->customer_email }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="info-data-row">
                        <div class="info-label">Street Address & City</div>
                        <div class="info-value-sub">
                            {{ $order->shipping_address }}
                            @if($order->city), {{ $order->city }} @endif
                            @if($order->postal_code) (Postal: {{ $order->postal_code }}) @endif
                        </div>
                    </div>

                    <div class="info-data-row" style="margin-top:12px; padding-top:10px; border-top:1px dashed #e2e8f0;">
                        <div class="info-label">Shipping Method</div>
                        <div style="display:flex; align-items:center; gap:8px;">
                            <span style="font-weight:800; font-size:0.88rem; color:#0f172a;">{{ $order->delivery_method ?: 'Standard' }} Delivery</span>
                            <span style="font-size:0.75rem; color:#15803d; font-weight:750; background:#dcfce7; padding:2px 8px; border-radius:6px;">{{ $etaDays }}</span>
                        </div>
                    </div>
                </div>

                <!-- Card 2: Payment & Order Information -->
                <div class="info-card">
                    <div class="info-card-header">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect><line x1="1" y1="10" x2="23" y2="10"></line></svg>
                        <span>Payment & Order Summary / ការទូទាត់ប្រាក់</span>
                    </div>

                    <div class="info-data-row">
                        <div class="info-label">Order Reference Number</div>
                        <div class="info-value-bold" style="font-family:ui-monospace, monospace; color:#1d4ed8;">#{{ $order->order_number }}</div>
                    </div>

                    <div class="info-data-row">
                        <div class="info-label">Payment Method</div>
                        <div style="display:flex; align-items:center; gap:8px; margin-top:2px;">
                            <span style="font-size:0.92rem; font-weight:800; color:#0f172a;">
                                @if($order->payment_method === 'QR Code')
                                    🏦 Bakong KHQR (Scan & Pay)
                                @elseif($order->payment_method === 'Cash on Delivery')
                                    💵 Cash on Delivery (COD)
                                @elseif($order->payment_method === 'Credit Card')
                                    💳 Credit / Debit Card
                                @else
                                    {{ $order->payment_method }}
                                @endif
                            </span>
                        </div>
                    </div>

                    <div class="info-data-row">
                        <div class="info-label">Total Amount</div>
                        <div style="display:flex; align-items:baseline; gap:8px;">
                            <span style="font-size:1.25rem; font-weight:900; color:#0f172a;">${{ number_format($order->total, 2) }}</span>
                            <span style="font-size:0.86rem; font-weight:750; color:#64748b;">(≈ @khr($order->total))</span>
                        </div>
                    </div>

                    <div class="info-data-row" style="margin-top:12px; padding-top:10px; border-top:1px dashed #e2e8f0; display:flex; justify-content:space-between; align-items:center;">
                        <div>
                            <div class="info-label">Order Date</div>
                            <div style="font-size:0.82rem; font-weight:700; color:#334155;">{{ $order->created_at->format('M d, Y • h:i A') }}</div>
                        </div>
                        <a href="{{ route('order.invoice', $order->order_number) }}" target="_blank" style="font-size:0.80rem; font-weight:800; color:#2563eb; text-decoration:none; display:inline-flex; align-items:center; gap:4px;">
                            <span>📄 Invoice</span>
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path><polyline points="15 3 21 3 21 9"></polyline><line x1="10" y1="14" x2="21" y2="3"></line></svg>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Items in this Shipment -->
            @if($order->items && $order->items->count() > 0)
                <div class="package-items-card">
                    <div class="package-items-heading">
                        <div style="font-size:0.92rem; font-weight:850; color:#0f172a; display:flex; align-items:center; gap:8px;">
                            <span>📦 Items in this Shipment</span>
                            <span style="font-size:0.75rem; background:#eff6ff; color:#1d4ed8; font-weight:800; padding:2px 8px; border-radius:9999px;">{{ $order->items->count() }} {{ Str::plural('item', $order->items->count()) }}</span>
                        </div>
                    </div>

                    <div class="package-items-list">
                        @foreach($order->items as $item)
                            <div class="package-item-row">
                                <div class="item-thumb-box">
                                    @if($item->image)
                                        <img src="{{ asset($item->image) }}" alt="{{ $item->product_name }}" class="item-thumb-img" onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1521572267360-ee0c2909d518?auto=format&fit=crop&w=150&q=80';">
                                    @else
                                        <span style="font-size:1.4rem;">👕</span>
                                    @endif
                                </div>
                                <div class="item-meta-col">
                                    <div class="item-title-text">{{ $item->product_name }}</div>
                                    <div style="display:flex; gap:6px; flex-wrap:wrap;">
                                        @if($item->size)
                                            <span class="item-badge-pill">Size: {{ strtoupper($item->size) }}</span>
                                        @endif
                                        @if($item->color)
                                            <span class="item-badge-pill">Color: {{ ucfirst($item->color) }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="item-price-col">
                                    <div class="item-price-val">${{ number_format($item->price, 2) }}</div>
                                    <div class="item-qty-val">Qty: {{ $item->quantity }}</div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Bottom Action Toolbar -->
            <div class="track-actions-bar">
                <a href="{{ route('shop.index') }}" class="action-link-btn action-link-default">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                    <span>Continue Shopping</span>
                </a>

                <div style="display:flex; gap:10px; flex-wrap:wrap;">
                    @php
                        $tgSupport = \App\Models\SiteSetting::get('social_telegram', 'https://t.me/Tdelivery4_bot');
                        if (!str_starts_with($tgSupport, 'http://') && !str_starts_with($tgSupport, 'https://')) {
                            $tgSupport = 'https://t.me/' . ltrim($tgSupport, '@');
                        }
                    @endphp
                    <a href="{{ $tgSupport }}" target="_blank" class="action-link-btn action-link-default">
                        <span>💬 Courier Support</span>
                    </a>
                    <a href="{{ route('order.invoice', $order->order_number) }}" target="_blank" class="action-link-btn action-link-primary">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="6 9 6 2 18 2 18 9"></polyline><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path><rect x="6" y="14" width="12" height="8"></rect></svg>
                        <span>Download Invoice</span>
                    </a>
                </div>
            </div>

        </div>
    @elseif($trackingQuery)
        <!-- Empty / Not Found State -->
        <div class="empty-track-box">
            <div style="width:64px; height:64px; border-radius:50%; background:#fee2e2; color:#ef4444; display:flex; align-items:center; justify-content:center; font-size:1.8rem; margin:0 auto 16px;">
                🔍
            </div>
            <h3 style="font-size:1.3rem; font-weight:850; color:#0f172a; margin-bottom:8px;">
                រកមិនឃើញការបញ្ជាទិញ "{{ $trackingQuery }}"
            </h3>
            <p style="color:#64748b; font-size:0.92rem; max-width:480px; margin:0 auto 20px; line-height:1.5;">
                សូមពិនិត្យមើលលេខកូដតាមដាន ឬលេខបញ្ជាទិញម្តងទៀត ដែលបានផ្ញើទៅកាន់អ៊ីមែលរបស់អ្នក ឬចូលមើលក្នុងប្រវត្តិបញ្ជាទិញ។
            </p>
            <div style="display:flex; justify-content:center; gap:12px; flex-wrap:wrap;">
                <a href="{{ route('order.track') }}" class="action-link-btn action-link-default">
                    <span>ព្យាយាមម្តងទៀត</span>
                </a>
                @auth
                    <a href="{{ route('order.history') }}" class="action-link-btn action-link-primary">
                        <span>មើលប្រវត្តិបញ្ជាទិញ</span>
                    </a>
                @endauth
            </div>
        </div>
    @endif
</div>

<script>
function copyTrackingCode(code) {
    if (!code) return;
    navigator.clipboard.writeText(code).then(() => {
        const label = document.getElementById('copyBtnLabel');
        if (label) {
            const original = label.innerText;
            label.innerText = 'Copied! ✓';
            label.style.color = '#15803d';
            setTimeout(() => {
                label.innerText = original;
                label.style.color = '';
            }, 2000);
        }
    }).catch(err => {
        console.error('Copy failed:', err);
    });
}
</script>

@endsection
