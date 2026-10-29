@extends('layouts.admin')

@section('title', 'Order Management')
@section('page-title', 'Order Management & Fulfillment')

@section('content')
    <!-- Top Action Bar -->
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:24px; flex-wrap:wrap; gap:16px;">
        <div>
            <div style="display:flex; align-items:center; gap:10px;">
                <h2 style="font-size:1.6rem; font-weight:850; color:#0f172a; letter-spacing:-0.4px; margin:0;">Store Orders</h2>
                <span style="background:#eef2ff; color:#4f46e5; font-size:0.75rem; font-weight:800; padding:3px 10px; border-radius:9999px; border:1px solid #c7d2fe;">
                    Fulfillment Hub
                </span>
            </div>
            <p style="color:#475569; font-size:0.92rem; font-weight:500; margin-top:4px; margin-bottom:0;">
                Fulfill customer purchases, update courier statuses, and dispatch tracking numbers.
            </p>
        </div>
    </div>

    <!-- Status Tabs -->
    <div style="display:flex; gap:10px; margin-bottom:24px; flex-wrap:wrap; align-items:center;">
        @foreach ($statusCounts as $stName => $stCount)
            @php
                $isActive = (request('status') == $stName) || (!request('status') && $stName == 'All');
            @endphp
            <a href="{{ route('admin.orders.index', ['status' => ($stName == 'All' ? null : $stName)]) }}" 
               class="btn-outline" 
               style="{{ $isActive ? 'background:#4f46e5; border-color:#4f46e5; color:#ffffff; font-weight:750; box-shadow:0 2px 6px rgba(79,70,229,0.25);' : 'background:#ffffff; border:1.5px solid #cbd5e1; color:#334155; font-weight:650;' }}">
                {{ $stName }} Orders
                <span style="background:{{ $isActive ? 'rgba(255,255,255,0.25)' : '#f1f5f9' }}; color:{{ $isActive ? '#ffffff' : '#475569' }}; padding:2px 8px; border-radius:10px; font-size:0.75rem; margin-left:6px; font-weight:800; border:{{ $isActive ? 'none' : '1px solid #e2e8f0' }};">
                    {{ $stCount }}
                </span>
            </a>
        @endforeach
    </div>

    <!-- Orders Table -->
    <div style="background:#ffffff; border:1.5px solid #e2e8f0; border-radius:16px; overflow:hidden; box-shadow:0 1px 3px rgba(0,0,0,0.04), 0 6px 18px rgba(0,0,0,0.02);">
        <table style="width:100%; border-collapse:collapse; text-align:left;">
            <thead>
                <tr style="background:#f8fafc; border-bottom:1.5px solid #e2e8f0;">
                    <th style="padding:15px 20px; font-size:0.8rem; font-weight:800; color:#334155; text-transform:uppercase; letter-spacing:0.6px;">Order #</th>
                    <th style="padding:15px 20px; font-size:0.8rem; font-weight:800; color:#334155; text-transform:uppercase; letter-spacing:0.6px;">Customer</th>
                    <th style="padding:15px 20px; font-size:0.8rem; font-weight:800; color:#334155; text-transform:uppercase; letter-spacing:0.6px;">Items</th>
                    <th style="padding:15px 20px; font-size:0.8rem; font-weight:800; color:#334155; text-transform:uppercase; letter-spacing:0.6px;">Total</th>
                    <th style="padding:15px 20px; font-size:0.8rem; font-weight:800; color:#334155; text-transform:uppercase; letter-spacing:0.6px;">Payment</th>
                    <th style="padding:15px 20px; font-size:0.8rem; font-weight:800; color:#334155; text-transform:uppercase; letter-spacing:0.6px;">Status</th>
                    <th style="padding:15px 20px; font-size:0.8rem; font-weight:800; color:#334155; text-transform:uppercase; letter-spacing:0.6px;">Date</th>
                    <th style="padding:15px 20px; font-size:0.8rem; font-weight:800; color:#334155; text-transform:uppercase; letter-spacing:0.6px; text-align:right;">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($orders as $order)
                    <tr style="border-bottom:1px solid #f1f5f9; transition:background 0.15s;" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background='#ffffff'">
                        <!-- Order # & Tracking -->
                        <td style="padding:16px 20px;">
                            <a href="{{ route('admin.orders.show', $order->id) }}" style="font-family:ui-monospace,SFMono-Regular,Consolas,monospace; font-weight:800; color:#0f172a; font-size:0.92rem; text-decoration:none; display:inline-block;" onmouseover="this.style.color='#4f46e5'" onmouseout="this.style.color='#0f172a'">
                                {{ $order->order_number }}
                            </a>
                            @if ($order->tracking_code)
                                <div style="font-size:0.75rem; color:#4f46e5; font-family:monospace; font-weight:700; margin-top:2px;">
                                    Track: {{ $order->tracking_code }}
                                </div>
                            @endif
                        </td>

                        <!-- Customer Details -->
                        <td style="padding:16px 20px;">
                            <div style="font-weight:750; color:#0f172a; font-size:0.92rem;">{{ $order->customer_name }}</div>
                            <div style="font-size:0.78rem; color:#64748b; font-weight:600; margin-top:2px;">{{ $order->customer_email }}</div>
                        </td>

                        <!-- Items Count -->
                        <td style="padding:16px 20px;">
                            <span style="font-size:0.85rem; font-weight:700; color:#334155; background:#f1f5f9; padding:3px 9px; border-radius:6px; border:1px solid #e2e8f0;">
                                {{ $order->items->count() }} item(s)
                            </span>
                        </td>

                        <!-- Total Amount -->
                        <td style="padding:16px 20px;">
                            <span style="font-weight:850; color:#0f172a; font-size:1.05rem;">
                                ${{ number_format($order->total, 2) }}
                            </span>
                        </td>

                        <!-- Payment Method -->
                        <td style="padding:16px 20px;">
                            <span style="font-size:0.88rem; font-weight:650; color:#1e293b;">
                                {{ $order->payment_method }}
                            </span>
                        </td>

                        <!-- Status Badge -->
                        <td style="padding:16px 20px;">
                            @php
                                $st = strtolower($order->status);
                            @endphp
                            @if ($st === 'delivered')
                                <span style="display:inline-flex; align-items:center; gap:5px; background:#dcfce7; color:#15803d; border:1.5px solid #bbf7d0; padding:5px 12px; border-radius:9999px; font-weight:850; font-size:0.75rem; letter-spacing:0.4px;">
                                    <span>✓</span> DELIVERED
                                </span>
                            @elseif ($st === 'shipped')
                                <span style="display:inline-flex; align-items:center; gap:5px; background:#e0e7ff; color:#4338ca; border:1.5px solid #c7d2fe; padding:5px 12px; border-radius:9999px; font-weight:850; font-size:0.75rem; letter-spacing:0.4px;">
                                    <span>🚚</span> SHIPPED
                                </span>
                            @elseif ($st === 'processing')
                                <span style="display:inline-flex; align-items:center; gap:5px; background:#f0fdf4; color:#166534; border:1.5px solid #bbf7d0; padding:5px 12px; border-radius:9999px; font-weight:850; font-size:0.75rem; letter-spacing:0.4px;">
                                    <span>⚙️</span> PROCESSING
                                </span>
                            @elseif ($st === 'pending')
                                <span style="display:inline-flex; align-items:center; gap:5px; background:#fef3c7; color:#b45309; border:1.5px solid #fde68a; padding:5px 12px; border-radius:9999px; font-weight:850; font-size:0.75rem; letter-spacing:0.4px;">
                                    <span>⏳</span> PENDING
                                </span>
                            @elseif ($st === 'cancelled')
                                <span style="display:inline-flex; align-items:center; gap:5px; background:#fee2e2; color:#b91c1c; border:1.5px solid #fecaca; padding:5px 12px; border-radius:9999px; font-weight:850; font-size:0.75rem; letter-spacing:0.4px;">
                                    <span>✕</span> CANCELLED
                                </span>
                            @else
                                <span style="display:inline-flex; align-items:center; gap:5px; background:#f1f5f9; color:#475569; border:1.5px solid #cbd5e1; padding:5px 12px; border-radius:9999px; font-weight:850; font-size:0.75rem; letter-spacing:0.4px;">
                                    {{ strtoupper($order->status) }}
                                </span>
                            @endif
                        </td>

                        <!-- Date -->
                        <td style="padding:16px 20px;">
                            <div style="font-size:0.85rem; color:#334155; font-weight:700;">
                                {{ $order->created_at->format('M d, Y') }}
                            </div>
                            <div style="font-size:0.75rem; color:#64748b; font-weight:600; font-family:monospace;">
                                {{ $order->created_at->format('H:i') }}
                            </div>
                        </td>

                        <!-- Action Buttons -->
                        <td style="padding:16px 20px; text-align:right;">
                            <div style="display:flex; justify-content:flex-end; align-items:center; gap:8px;">
                                <a href="{{ route('admin.orders.invoice', $order->id) }}?download=1" target="_blank" style="background:#ecfdf5; color:#047857; border:1.5px solid #a7f3d0; padding:6px 10px; font-size:0.78rem; font-weight:750; border-radius:8px; text-decoration:none; display:inline-flex; align-items:center; gap:4px; transition:all 0.15s;" onmouseover="this.style.background='#059669'; this.style.color='#ffffff';" onmouseout="this.style.background='#ecfdf5'; this.style.color='#047857';" title="Download PDF Invoice">
                                    📥 PDF
                                </a>
                                <a href="{{ route('admin.orders.invoice', $order->id) }}" target="_blank" style="background:#f0f9ff; color:#0369a1; border:1.5px solid #bae6fd; padding:6px 10px; font-size:0.78rem; font-weight:750; border-radius:8px; text-decoration:none; display:inline-flex; align-items:center; gap:4px; transition:all 0.15s;" onmouseover="this.style.background='#0284c7'; this.style.color='#ffffff';" onmouseout="this.style.background='#f0f9ff'; this.style.color='#0369a1';" title="Print Sales Receipt">
                                    🖨️ Receipt
                                </a>
                                <a href="{{ route('admin.orders.show', $order->id) }}" class="btn-primary" style="padding:6px 14px; font-size:0.78rem; font-weight:750;">
                                    Manage →
                                </a>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" style="text-align:center; padding:40px 20px; color:#64748b;">
                            <div style="font-size:2rem; margin-bottom:8px;">📦</div>
                            <div style="font-size:1rem; font-weight:750; color:#1e293b;">No orders found</div>
                            <div style="font-size:0.85rem; color:#64748b; margin-top:4px;">No purchase records match this status.</div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div style="margin-top:24px;">
        {{ $orders->links() }}
    </div>
@endsection
