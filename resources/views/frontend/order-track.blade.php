@extends('layouts.store')

@section('title', 'Track Your Order — THREADCRAFT')

@section('styles')
<style>
    .track-wrap {
        max-width: 860px;
        margin: 50px auto 80px;
        padding: 0 24px;
    }

    .track-search-card {
        background: var(--bg-card);
        border: 1px solid var(--border-subtle);
        border-radius: var(--radius-lg);
        padding: 36px;
        text-align: center;
        margin-bottom: 36px;
    }

    .search-track-form {
        display: flex;
        gap: 12px;
        max-width: 550px;
        margin: 24px auto 0;
        flex-wrap: wrap;
    }

    .track-input {
        flex: 1;
        background: var(--bg-secondary);
        border: 1px solid var(--border-subtle);
        color: #ffffff;
        padding: 12px 18px;
        border-radius: var(--radius-full);
        font-size: 0.95rem;
        outline: none;
        min-width: 220px;
    }

    .track-input:focus {
        border-color: var(--border-highlight);
    }

    /* Tracking Stepper / Timeline */
    .timeline-card {
        background: var(--bg-card);
        border: 1px solid var(--border-subtle);
        border-radius: var(--radius-lg);
        padding: 36px;
    }

    .stepper-progress {
        display: flex;
        justify-content: space-between;
        position: relative;
        margin: 40px 0 30px;
    }

    .stepper-progress::before {
        content: '';
        position: absolute;
        top: 20px;
        left: 40px;
        right: 40px;
        height: 4px;
        background: rgba(255, 255, 255, 0.1);
        z-index: 1;
    }

    .progress-bar-fill {
        position: absolute;
        top: 20px;
        left: 40px;
        height: 4px;
        background: var(--accent-gradient);
        z-index: 2;
        transition: width 0.4s ease;
    }

    .step-node {
        position: relative;
        z-index: 3;
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
        width: 100px;
    }

    .node-circle {
        width: 44px;
        height: 44px;
        border-radius: var(--radius-full);
        background: var(--bg-secondary);
        border: 2px solid var(--border-subtle);
        color: var(--text-muted);
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 1rem;
        margin-bottom: 10px;
    }

    .step-node.completed .node-circle {
        background: var(--accent-gradient);
        border-color: transparent;
        color: #ffffff;
        box-shadow: 0 0 15px rgba(99, 102, 241, 0.5);
    }

    .step-node.active .node-circle {
        border-color: #6366f1;
        color: #6366f1;
        background: rgba(99, 102, 241, 0.15);
    }

    .node-label {
        font-size: 0.85rem;
        font-weight: 700;
        color: var(--text-sub);
    }

    .step-node.completed .node-label {
        color: #ffffff;
    }
</style>
@endsection

@section('content')

    <div class="track-wrap">
        <!-- Search Card -->
        <div class="track-search-card">
            <h1 style="font-size: 2.2rem; font-weight: 800; margin-bottom: 8px;">Track Your Package</h1>
            <p style="color: var(--text-muted); font-size: 0.95rem;">
                Enter your Order Number (e.g. TC-ABC12345) or Tracking Code (TRK-...) to view live courier status.
            </p>

            <form action="{{ route('order.track') }}" method="GET" class="search-track-form">
                <input type="text" name="code" class="track-input" placeholder="e.g. TC-..." value="{{ $trackingQuery }}" required>
                <button type="submit" class="btn-primary" style="padding: 12px 26px;">Track Package</button>
            </form>
        </div>

        @if ($order)
            <div class="timeline-card">
                <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:12px; margin-bottom:20px; padding-bottom:16px; border-bottom:1px solid var(--border-subtle);">
                    <div>
                        <span style="font-size:0.8rem; text-transform:uppercase; color:var(--text-muted); letter-spacing:0.5px;">Tracking Code</span>
                        <div style="font-size:1.3rem; font-weight:800; color:#a5b4fc;">{{ $order->tracking_code }}</div>
                    </div>
                    <div style="text-align:right;">
                        <span style="font-size:0.8rem; text-transform:uppercase; color:var(--text-muted); letter-spacing:0.5px;">Order Number</span>
                        <div style="font-size:1.1rem; font-weight:700; color:#ffffff;">{{ $order->order_number }}</div>
                    </div>
                </div>

                <!-- Interactive Stepper -->
                @php
                    $status = strtolower($order->status);
                    $fillWidth = '33%';
                    if ($status == 'processing') $fillWidth = '33%';
                    elseif ($status == 'shipped') $fillWidth = '66%';
                    elseif ($status == 'delivered') $fillWidth = '100%';
                    elseif (in_array($status, ['cancelled', 'cancel', 'canceled'])) $fillWidth = '0%';
                @endphp

                @if (in_array($status, ['cancelled', 'cancel', 'canceled']))
                    <div style="background: rgba(239, 68, 68, 0.12); border: 1px solid rgba(239, 68, 68, 0.35); border-radius: var(--radius-md); padding: 14px 18px; margin-bottom: 24px; display: flex; align-items: center; gap: 12px; color: #f87171;">
                        <div style="width: 32px; height: 32px; border-radius: 50%; background: rgba(239, 68, 68, 0.2); display: flex; align-items: center; justify-content: center; flex-shrink: 0; font-size: 0.9rem; font-weight: 800;">
                            ✕
                        </div>
                        <div>
                            <div style="font-weight: 800; font-size: 0.95rem; color: #fca5a5;">Order Cancelled</div>
                            <div style="font-size: 0.82rem; color: var(--text-muted); margin-top: 2px;">This order has been cancelled and is no longer being processed.</div>
                        </div>
                    </div>
                @endif

                <div class="stepper-progress">
                    <div class="progress-bar-fill" style="width: {{ $fillWidth }};"></div>

                    <div class="step-node completed">
                        <div class="node-circle">✓</div>
                        <div class="node-label">Order Placed</div>
                        <span style="font-size:0.75rem; color:var(--text-muted);">{{ $order->created_at->format('M d') }}</span>
                    </div>

                    <div class="step-node {{ in_array($status, ['processing', 'shipped', 'delivered']) ? 'completed' : 'active' }}">
                        <div class="node-circle">⚙</div>
                        <div class="node-label">Processing</div>
                        <span style="font-size:0.75rem; color:var(--text-muted);">In Workshop</span>
                    </div>

                    <div class="step-node {{ in_array($status, ['shipped', 'delivered']) ? 'completed' : ($status == 'processing' ? 'active' : '') }}">
                        <div class="node-circle">🚚</div>
                        <div class="node-label">Shipped</div>
                        <span style="font-size:0.75rem; color:var(--text-muted);">In Transit</span>
                    </div>

                    <div class="step-node {{ $status == 'delivered' ? 'completed' : '' }}">
                        <div class="node-circle">📦</div>
                        <div class="node-label">Delivered</div>
                        <span style="font-size:0.75rem; color:var(--text-muted);">Destination</span>
                    </div>
                </div>

                <!-- Destination Details -->
                <div style="margin-top:36px; padding:20px; background:var(--bg-secondary); border-radius:var(--radius-md); display:grid; grid-template-columns: 1fr 1fr; gap:16px;">
                    <div>
                        <div style="font-size:0.8rem; color:var(--text-muted); text-transform:uppercase;">Recipient</div>
                        <div style="font-weight:700; color:#ffffff; margin-top:4px;">{{ $order->customer_name }}</div>
                        <div style="font-size:0.85rem; color:var(--text-sub);">{{ $order->shipping_address }}, {{ $order->city }}</div>
                    </div>
                    <div>
                        <div style="font-size:0.8rem; color:var(--text-muted); text-transform:uppercase;">Carrier Method</div>
                        <div style="font-weight:700; color:#ffffff; margin-top:4px;">{{ $order->delivery_method }} Expedited Shipping</div>
                        <div style="font-size:0.85rem; color:#4ade80;">Estimated Delivery: 2-4 Days</div>
                    </div>
                </div>
            </div>
        @elseif($trackingQuery)
            <div style="text-align:center; padding:40px; background:var(--bg-card); border-radius:var(--radius-lg); border:1px solid var(--border-subtle);">
                <p style="color:#f87171; font-weight:700; font-size:1.1rem; margin-bottom:8px;">No order matching "{{ $trackingQuery }}"</p>
                <p style="color:var(--text-muted); font-size:0.9rem;">Please double check your order number from the confirmation email.</p>
            </div>
        @endif
    </div>

@endsection
