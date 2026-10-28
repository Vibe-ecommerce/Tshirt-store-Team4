@extends('layouts.admin')

@section('title', 'Manage Order #' . $order->order_number)
@section('page-title', 'Order #' . $order->order_number)

@section('content')
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:24px; flex-wrap:wrap; gap:16px;">
        <div>
            <h2 style="font-size:1.6rem; font-weight:800; color:#ffffff;">Order Details: {{ $order->order_number }}</h2>
            <p style="color:var(--text-muted); font-size:0.9rem;">Placed on {{ $order->created_at->format('F d, Y \a\t h:i A') }}</p>
        </div>
        <div style="display:flex; align-items:center; gap:10px;">
            <a href="{{ route('admin.orders.invoice', $order->id) }}" target="_blank" class="btn-primary" style="padding:10px 18px; font-size:0.88rem; display:inline-flex; align-items:center; gap:8px; background:linear-gradient(135deg, #10b981, #059669); border:none;">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 6 2 18 2 18 9"></polyline><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path><rect x="6" y="14" width="12" height="8"></rect></svg>
                <span>🖨️ Print Customer Invoice / Receipt</span>
            </a>
            <a href="{{ route('admin.orders.index') }}" class="btn-outline">← Back to Orders</a>
        </div>
    </div>

    <div style="display:grid; grid-template-columns: 2fr 1.2fr; gap:28px;">
        <div>
            <!-- Order Items Table -->
            <div style="background:var(--bg-card); border:1px solid var(--border-subtle); border-radius:var(--radius-lg); padding:24px; margin-bottom:24px;">
                <h3 style="font-size:1.2rem; font-weight:800; margin-bottom:16px; color:#ffffff;">Ordered Items</h3>

                <table class="custom-table">
                    <thead>
                        <tr>
                            <th>Item</th>
                            <th>Size</th>
                            <th>Unit Price</th>
                            <th>Qty</th>
                            <th style="text-align:right;">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($order->items as $item)
                            <tr>
                                <td>
                                    <div style="display:flex; align-items:center; gap:10px;">
                                        <img src="{{ asset($item->image) }}" alt="" style="width:40px; height:40px; border-radius:6px; object-fit:cover;">
                                        <span style="font-weight:700; color:#ffffff;">{{ $item->product_name }}</span>
                                    </div>
                                </td>
                                <td><span style="background:var(--bg-input); padding:2px 8px; border-radius:4px; font-weight:700;">{{ $item->size }}</span></td>
                                <td>${{ number_format($item->price, 2) }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td style="text-align:right; font-weight:700; color:#ffffff;">${{ number_format($item->price * $item->quantity, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div style="margin-top:20px; padding-top:16px; border-top:1px solid var(--border-subtle); display:flex; flex-direction:column; gap:8px; align-items:flex-end;">
                    <div style="display:flex; gap:30px; font-size:0.9rem; color:var(--text-sub);">
                        <span>Subtotal:</span>
                        <span>${{ number_format($order->subtotal, 2) }}</span>
                    </div>
                    @if ($order->discount > 0)
                        <div style="display:flex; gap:30px; font-size:0.9rem; color:#4ade80;">
                            <span>Discount:</span>
                            <span>-${{ number_format($order->discount, 2) }}</span>
                        </div>
                    @endif
                    <div style="display:flex; gap:30px; font-size:0.9rem; color:var(--text-sub);">
                        <span>Shipping ({{ $order->delivery_method }}):</span>
                        <span>${{ number_format($order->shipping_fee, 2) }}</span>
                    </div>
                    <div style="display:flex; gap:30px; font-size:1.3rem; font-weight:800; color:#ffffff; margin-top:8px;">
                        <span>Total Paid:</span>
                        <span style="color:#a5b4fc;">${{ number_format($order->total, 2) }}</span>
                    </div>
                </div>
            </div>

            <!-- Customer & Delivery Notes -->
            <div style="background:var(--bg-card); border:1px solid var(--border-subtle); border-radius:var(--radius-lg); padding:24px;">
                <h3 style="font-size:1.2rem; font-weight:800; margin-bottom:16px; color:#ffffff;">Shipping Destination</h3>
                <div style="line-height:1.7; color:var(--text-sub);">
                    <strong>Recipient:</strong> {{ $order->customer_name }}<br>
                    <strong>Address:</strong> {{ $order->shipping_address }}, {{ $order->city }} {{ $order->postal_code }}<br>
                    <strong>Email:</strong> {{ $order->customer_email }}<br>
                    <strong>Phone:</strong> {{ $order->customer_phone }}<br>
                    @if ($order->notes)
                        <div style="margin-top:10px; padding:10px; background:var(--bg-input); border-radius:8px;">
                            <strong>Customer Instructions:</strong> {{ $order->notes }}
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Order Control Panel -->
        <div>
            <div style="background:var(--bg-card); border:1px solid var(--border-subtle); border-radius:var(--radius-lg); padding:28px; position:sticky; top:90px;">
                <h3 style="font-size:1.2rem; font-weight:800; margin-bottom:20px; color:#ffffff;">Fulfillment Actions</h3>

                <form action="{{ route('admin.orders.status', $order->id) }}" method="POST">
                    @csrf

                    <div style="margin-bottom:20px;">
                        <label style="display:block; font-size:0.85rem; font-weight:700; color:var(--text-muted); text-transform:uppercase; margin-bottom:8px;">Update Order Status</label>
                        <select name="status" style="width:100%; background:var(--bg-input); border:1px solid var(--border-subtle); color:#fff; padding:12px; border-radius:var(--radius-md); font-weight:700;">
                            @foreach ($statuses as $st)
                                <option value="{{ $st }}" {{ $order->status == $st ? 'selected' : '' }}>{{ $st }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div style="margin-bottom:24px;">
                        <label style="display:block; font-size:0.85rem; font-weight:700; color:var(--text-muted); text-transform:uppercase; margin-bottom:8px;">Courier Tracking Code</label>
                        <input type="text" name="tracking_code" style="width:100%; background:var(--bg-input); border:1px solid var(--border-subtle); color:#fff; padding:12px; border-radius:var(--radius-md);" value="{{ $order->tracking_code }}">
                    </div>

                    <button type="submit" class="btn-primary" style="width:100%; justify-content:center; padding:12px;">
                        Save Fulfillment Status →
                    </button>
                </form>

                <div style="margin-top:24px; padding-top:16px; border-top:1px solid var(--border-subtle); font-size:0.85rem; color:var(--text-muted);">
                    <div>Payment Method: 
                        <strong style="color:#ffffff;">
                            @if ($order->payment_method === 'QR Code')
                                📱 KHQR / Bank QR Scan
                            @else
                                {{ $order->payment_method }}
                            @endif
                        </strong>
                    </div>
                    @if ($order->payment_reference)
                        <div style="margin-top:4px;">
                            Payment Ref: <strong style="color:#a5b4fc;">{{ $order->payment_reference }}</strong>
                        </div>
                    @endif
                    <div style="margin-top:4px;">Shipping Method: <strong style="color:#ffffff;">{{ $order->delivery_method }}</strong></div>

                    @if ($order->payment_slip)
                        <div style="margin-top:14px; padding:12px; background:rgba(99,102,241,0.08); border:1px solid rgba(99,102,241,0.25); border-radius:8px;">
                            <div style="font-size:0.75rem; text-transform:uppercase; font-weight:700; color:#4ade80; margin-bottom:8px;">
                                📎 Customer Payment Slip Attached
                            </div>
                            <div style="display:flex; align-items:center; gap:12px;">
                                <a href="{{ asset($order->payment_slip) }}" target="_blank" title="Click to view full receipt">
                                    <img src="{{ asset($order->payment_slip) }}" alt="Payment Slip" style="width:56px; height:56px; border-radius:6px; object-fit:cover; border:1px solid var(--border-subtle); display:block;">
                                </a>
                                <div>
                                    <a href="{{ asset($order->payment_slip) }}" target="_blank" class="btn-outline" style="font-size:0.75rem; padding:4px 10px; display:inline-flex; align-items:center; gap:4px; color:#fff;">
                                        🔍 View Full Slip
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
