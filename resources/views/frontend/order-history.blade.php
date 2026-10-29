@extends('layouts.store')

@section('title', 'Order History — T-Shirt Online')

@section('styles')
<style>
    .history-container {
        max-width: 1000px;
        margin: 40px auto 80px;
        padding: 0 24px;
    }

    .order-history-card {
        background: var(--bg-card);
        border: 1px solid var(--border-subtle);
        border-radius: var(--radius-lg);
        padding: 24px;
        margin-bottom: 24px;
        transition: border-color 0.2s;
    }

    .order-history-card:hover {
        border-color: var(--border-highlight);
    }

    .order-history-head {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding-bottom: 16px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.06);
        margin-bottom: 16px;
        flex-wrap: wrap;
        gap: 12px;
    }

    .status-badge {
        padding: 4px 12px;
        border-radius: var(--radius-full);
        font-size: 0.8rem;
        font-weight: 700;
        text-transform: uppercase;
        background: rgba(99, 102, 241, 0.2);
        color: #a5b4fc;
    }

    .status-delivered,
    .status-completed {
        background: rgba(16, 185, 129, 0.18);
        color: #34d399;
        border: 1px solid rgba(16, 185, 129, 0.35);
    }

    .status-cancelled,
    .status-cancel,
    .status-canceled {
        background: rgba(239, 68, 68, 0.18);
        color: #f87171;
        border: 1px solid rgba(239, 68, 68, 0.45);
        box-shadow: 0 0 10px rgba(239, 68, 68, 0.2);
    }

    .status-shipped {
        background: rgba(14, 165, 233, 0.18);
        color: #38bdf8;
        border: 1px solid rgba(14, 165, 233, 0.35);
    }

    .status-pending {
        background: rgba(245, 158, 11, 0.18);
        color: #fbbf24;
        border: 1px solid rgba(245, 158, 11, 0.35);
    }
</style>
@endsection

@section('content')

    <div class="history-container">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:30px; flex-wrap:wrap; gap:16px;">
            <div>
                <h1 style="font-size:2.2rem; font-weight:800;">Order History</h1>
                <p style="color:var(--text-muted);">View all past purchases, tracking details, and receipts.</p>
            </div>
            <a href="{{ route('order.track') }}" class="btn-outline">Track Specific Order →</a>
        </div>

        @if ($orders->count() > 0)
            @foreach ($orders as $order)
                <div class="order-history-card">
                    <div class="order-history-head">
                        <div>
                            <span style="font-weight:800; font-size:1.1rem; color:#ffffff;">Order #{{ $order->order_number }}</span>
                            <span style="color:var(--text-muted); font-size:0.85rem; margin-left:10px;">{{ $order->created_at->format('M d, Y') }}</span>
                        </div>
                        <div style="display:flex; align-items:center; gap:14px;">
                            @php
                                $stHist = strtolower(trim($order->status));
                                $clsHist = 'status-' . $stHist;
                            @endphp
                            <span class="status-badge {{ $clsHist }}">
                                {{ $order->status }}
                            </span>
                            <span style="font-weight:800; font-size:1.15rem; color:#ffffff;">${{ number_format($order->total, 2) }}</span>
                        </div>
                    </div>

                    <div style="display:flex; flex-direction:column; gap:10px;">
                        @foreach ($order->items as $item)
                            <div style="display:flex; justify-content:space-between; align-items:center;">
                                <div style="display:flex; align-items:center; gap:12px;">
                                    <img src="{{ asset($item->image) }}" alt="" style="width:40px; height:40px; border-radius:6px; object-fit:cover;">
                                    <div>
                                        <div style="font-weight:600; font-size:0.92rem; color:#ffffff;">{{ $item->product_name }}</div>
                                        <div style="font-size:0.8rem; color:var(--text-muted);">Size: {{ $item->size }} &bull; Qty: {{ $item->quantity }}</div>
                                    </div>
                                </div>
                                <span style="font-size:0.92rem; font-weight:700;">${{ number_format($item->price * $item->quantity, 2) }}</span>
                            </div>
                        @endforeach
                    </div>

                    <div style="margin-top:18px; padding-top:14px; border-top:1px solid rgba(255,255,255,0.06); display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:10px;">
                        <span style="font-size:0.85rem; color:var(--text-muted);">Tracking: <code style="color:#a5b4fc;">{{ $order->tracking_code }}</code></span>
                        <div style="display:flex; align-items:center; gap:8px;">
                            <a href="{{ route('order.invoice', $order->order_number) }}?download=1" target="_blank" class="btn-outline" style="padding:6px 14px; font-size:0.82rem; color:#34d399; border-color:rgba(52,211,153,0.4); display:inline-flex; align-items:center; gap:6px;">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                                <span>Download PDF</span>
                            </a>
                            <a href="{{ route('order.invoice', $order->order_number) }}" target="_blank" class="btn-outline" style="padding:6px 14px; font-size:0.82rem; color:#38bdf8; border-color:rgba(56,189,248,0.4); display:inline-flex; align-items:center; gap:6px;">
                                <span>🖨️ Print</span>
                            </a>
                            <a href="{{ route('order.track', ['code' => $order->tracking_code]) }}" class="btn-outline" style="padding:6px 14px; font-size:0.82rem;">Track Package</a>
                        </div>
                    </div>
                </div>
            @endforeach

            <div style="margin-top:30px;">
                {{ $orders->links() }}
            </div>
        @else
            <div style="text-align:center; padding:70px 20px; background:var(--bg-card); border-radius:var(--radius-lg); border:1px solid var(--border-subtle);">
                <div style="font-size:3rem; margin-bottom:12px;">📦</div>
                <h3 style="font-size:1.5rem; margin-bottom:8px;">No orders found yet</h3>
                <p style="color:var(--text-muted); margin-bottom:24px;">When you place your first order, tracking and details will appear here.</p>
                <a href="{{ route('shop.index') }}" class="btn-primary" style="padding:10px 24px;">Shop T-Shirts Now</a>
            </div>
        @endif
    </div>

@endsection
