@extends('layouts.store')

@section('title', 'Order Confirmed #' . $order->order_number . ' — THREADCRAFT')

@section('styles')
<style>
    .confirm-container {
        max-width: 860px;
        margin: 50px auto 80px;
        padding: 0 24px;
        text-align: center;
    }

    .success-icon-badge {
        width: 80px;
        height: 80px;
        border-radius: var(--radius-full);
        background: rgba(34, 197, 94, 0.15);
        border: 2px solid #22c55e;
        color: #22c55e;
        font-size: 2.4rem;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 24px;
        box-shadow: 0 0 30px rgba(34, 197, 94, 0.3);
    }

    .confirm-title {
        font-size: 2.4rem;
        font-weight: 800;
        margin-bottom: 12px;
    }

    .confirm-desc {
        color: var(--text-muted);
        font-size: 1.05rem;
        max-width: 580px;
        margin: 0 auto 36px;
    }

    .order-box {
        background: var(--bg-card);
        border: 1px solid var(--border-subtle);
        border-radius: var(--radius-lg);
        padding: 36px;
        text-align: left;
        margin-bottom: 30px;
    }

    .order-meta-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
        gap: 20px;
        padding-bottom: 24px;
        border-bottom: 1px solid var(--border-subtle);
        margin-bottom: 24px;
    }

    .meta-label {
        font-size: 0.8rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: var(--text-muted);
        margin-bottom: 4px;
    }

    .meta-value {
        font-size: 1.1rem;
        font-weight: 700;
        color: #0f172a;
    }

    .item-list-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 12px 0;
        border-bottom: 1px solid #f1f5f9;
    }

    .item-list-row:last-child {
        border-bottom: none;
    }

    .actions-cta {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 16px;
        flex-wrap: wrap;
    }
</style>
@endsection

@section('content')

    <div class="confirm-container">
        <div class="success-icon-badge">✓</div>
        <h1 class="confirm-title">Thank You For Your Order!</h1>
        <p class="confirm-desc">
            We've received your order and our workshop is preparing your items. A confirmation receipt has been sent to <strong>{{ $order->customer_email }}</strong>.
        </p>

        <div class="order-box">
            <div class="order-meta-grid">
                <div>
                    <div class="meta-label">Order Number</div>
                    <div class="meta-value">{{ $order->order_number }}</div>
                </div>
                <div>
                    <div class="meta-label">Tracking Code</div>
                    <div class="meta-value" style="color: #4f46e5;">{{ $order->tracking_code }}</div>
                </div>
                <div>
                    <div class="meta-label">Status</div>
                    <div class="meta-value" style="color: #059669;">{{ $order->status }}</div>
                </div>
                <div>
                    <div class="meta-label">Total Amount</div>
                    <div class="meta-value">${{ number_format($order->total, 2) }}</div>
                </div>
            </div>

            <h3 style="font-size: 1.1rem; font-weight: 700; margin-bottom: 16px; color: #0f172a;">Purchased Items</h3>
            @foreach ($order->items as $item)
                <div class="item-list-row">
                    <div style="display:flex; align-items:center; gap: 14px;">
                        <img src="{{ asset($item->image) }}" alt="" style="width:48px; height:48px; border-radius:8px; object-fit:cover; background:#f8fafc;">
                        <div>
                            <div style="font-weight:700; color:#0f172a;">{{ $item->product_name }}</div>
                            <div style="font-size:0.85rem; color:var(--text-muted);">Size: {{ $item->size }} &times; {{ $item->quantity }}</div>
                        </div>
                    </div>
                    <span style="font-weight:700; color:#0f172a;">${{ number_format($item->price * $item->quantity, 2) }}</span>
                </div>
            @endforeach

            <div style="margin-top:24px; padding-top:20px; border-top:1px solid var(--border-subtle); display:grid; grid-template-columns: 1fr 1fr; gap:20px;">
                <div>
                    <div class="meta-label">Shipping Destination</div>
                    <div style="color:var(--text-sub); font-size:0.92rem; margin-top:4px;">
                        {{ $order->customer_name }}<br>
                        {{ $order->shipping_address }}<br>
                        {{ $order->city }}, {{ $order->postal_code }}
                    </div>
                </div>
                <div>
                    <div class="meta-label">Delivery & Payment</div>
                    <div style="color:var(--text-sub); font-size:0.92rem; margin-top:4px;">
                        Delivery: {{ $order->delivery_method }} Courier<br>
                        Payment: <strong>{{ $order->payment_method === 'QR Code' ? '📱 KHQR / Bank QR Scan' : $order->payment_method }}</strong>
                        @if ($order->payment_reference)
                            <div style="font-size:0.8rem; color:#4f46e5; margin-top:3px;">Ref: {{ $order->payment_reference }}</div>
                        @endif
                        @if ($order->payment_slip)
                            <div style="margin-top:6px; display:inline-flex; align-items:center; gap:6px; background:#ecfdf5; padding:3px 8px; border-radius:4px; border:1px solid #a7f3d0; font-size:0.75rem; color:#059669;">
                                <span>✓ Payment Receipt Attached</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="actions-cta">
            <a href="{{ route('order.invoice', $order->order_number) }}" target="_blank" class="btn-primary" style="padding: 12px 26px; background:linear-gradient(135deg, #10b981, #059669); border:none; display:inline-flex; align-items:center; gap:8px;">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 6 2 18 2 18 9"></polyline><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path><rect x="6" y="14" width="12" height="8"></rect></svg>
                <span>🖨️ Print Sales Receipt</span>
            </a>
            <a href="{{ route('order.track', ['code' => $order->tracking_code]) }}" class="btn-primary" style="padding: 12px 28px;">
                Track This Order Live →
            </a>
            <a href="{{ route('shop.index') }}" class="btn-outline" style="padding: 12px 24px;">
                Back to Shop
            </a>
        </div>
    </div>

@endsection
