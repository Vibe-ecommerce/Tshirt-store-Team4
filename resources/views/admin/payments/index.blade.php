@extends('layouts.admin')

@section('title', 'Payment Management')
@section('page-title', 'Payment Management & Gateway History')

@section('content')
    <!-- Top Action Bar -->
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:24px; flex-wrap:wrap; gap:16px;">
        <div>
            <div style="display:flex; align-items:center; gap:10px;">
                <h2 style="font-size:1.6rem; font-weight:850; color:#0f172a; letter-spacing:-0.4px; margin:0;">Transactions & Payments</h2>
                <span style="background:#eef2ff; color:#4f46e5; font-size:0.75rem; font-weight:800; padding:3px 10px; border-radius:9999px; border:1px solid #c7d2fe;">
                    Financial Ledger
                </span>
            </div>
            <p style="color:#475569; font-size:0.92rem; font-weight:500; margin-top:4px; margin-bottom:0;">
                Audit incoming revenues, pending QR settlements, failed attempts, and process customer refunds.
            </p>
        </div>
        <div>
            <a href="{{ route('admin.settings.index', ['group' => 'payment']) }}" class="btn-primary" style="display:inline-flex; align-items:center; gap:8px; padding:9px 20px; font-size:0.88rem; font-weight:750; box-shadow:0 4px 14px rgba(79, 70, 229, 0.3);">
                <span>⚙️</span> QR & Payment Settings
            </a>
        </div>
    </div>

    <!-- Payment Overview KPI Cards -->
    <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(230px, 1fr)); gap:18px; margin-bottom:24px;">
        <!-- Card 1: All Transactions -->
        <div style="background:#ffffff; border:1.5px solid #e2e8f0; border-radius:14px; padding:20px 22px; box-shadow:0 1px 3px rgba(0,0,0,0.04), 0 4px 12px rgba(0,0,0,0.02); display:flex; flex-direction:column; justify-content:space-between;">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:10px;">
                <span style="background:#f1f5f9; color:#334155; font-size:0.75rem; font-weight:800; text-transform:uppercase; letter-spacing:0.5px; padding:3px 9px; border-radius:6px; border:1px solid #e2e8f0;">
                    Total Volume
                </span>
                <span style="font-size:1.1rem;">💳</span>
            </div>
            <div>
                <div style="font-size:2rem; font-weight:850; color:#0f172a; line-height:1.1;">
                    {{ number_format($counts['All'] ?? 0) }}
                    <span style="font-size:0.92rem; color:#64748b; font-weight:600;">records</span>
                </div>
                <div style="font-size:0.8rem; color:#475569; font-weight:600; margin-top:6px;">All gateway & manual transactions</div>
            </div>
        </div>

        <!-- Card 2: Successful -->
        <div style="background:#ffffff; border:1.5px solid #bbf7d0; border-radius:14px; padding:20px 22px; box-shadow:0 1px 3px rgba(16,185,129,0.06), 0 4px 12px rgba(16,185,129,0.04); display:flex; flex-direction:column; justify-content:space-between;">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:10px;">
                <span style="background:#dcfce7; color:#15803d; font-size:0.75rem; font-weight:800; text-transform:uppercase; letter-spacing:0.5px; padding:3px 9px; border-radius:6px; border:1px solid #86efac;">
                    Successful Settled
                </span>
                <span style="font-size:1.1rem;">✅</span>
            </div>
            <div>
                <div style="font-size:2rem; font-weight:850; color:#15803d; line-height:1.1;">
                    {{ number_format($counts['Successful'] ?? 0) }}
                    <span style="font-size:0.92rem; color:#166534; font-weight:600;">paid</span>
                </div>
                <div style="font-size:0.8rem; color:#15803d; font-weight:600; margin-top:6px;">Funds cleared and deposited</div>
            </div>
        </div>

        <!-- Card 3: Pending Verification -->
        <div style="background:#ffffff; border:1.5px solid #fde68a; border-radius:14px; padding:20px 22px; box-shadow:0 1px 3px rgba(245,158,11,0.06), 0 4px 12px rgba(245,158,11,0.04); display:flex; flex-direction:column; justify-content:space-between;">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:10px;">
                <span style="background:#fef3c7; color:#b45309; font-size:0.75rem; font-weight:800; text-transform:uppercase; letter-spacing:0.5px; padding:3px 9px; border-radius:6px; border:1px solid #fcd34d;">
                    Pending Verification
                </span>
                <span style="font-size:1.1rem;">⏳</span>
            </div>
            <div>
                <div style="font-size:2rem; font-weight:850; color:#b45309; line-height:1.1;">
                    {{ number_format($counts['Pending'] ?? 0) }}
                    <span style="font-size:0.92rem; color:#92400e; font-weight:600;">pending</span>
                </div>
                <div style="font-size:0.8rem; color:#b45309; font-weight:600; margin-top:6px;">Awaiting QR or COD confirmation</div>
            </div>
        </div>

        <!-- Card 4: Refunded / Failed -->
        @php
            $issuesCount = ($counts['Refunded'] ?? 0) + ($counts['Failed'] ?? 0);
        @endphp
        <div style="background:#ffffff; border:1.5px solid #fecaca; border-radius:14px; padding:20px 22px; box-shadow:0 1px 3px rgba(239,68,68,0.06), 0 4px 12px rgba(239,68,68,0.04); display:flex; flex-direction:column; justify-content:space-between;">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:10px;">
                <span style="background:#fee2e2; color:#b91c1c; font-size:0.75rem; font-weight:800; text-transform:uppercase; letter-spacing:0.5px; padding:3px 9px; border-radius:6px; border:1px solid #fca5a5;">
                    Refunded & Failed
                </span>
                <span style="font-size:1.1rem;">↩️</span>
            </div>
            <div>
                <div style="font-size:2rem; font-weight:850; color:#b91c1c; line-height:1.1;">
                    {{ number_format($issuesCount) }}
                    <span style="font-size:0.92rem; color:#991b1b; font-weight:600;">cases</span>
                </div>
                <div style="font-size:0.8rem; color:#b91c1c; font-weight:600; margin-top:6px;">{{ $counts['Refunded'] ?? 0 }} refunded, {{ $counts['Failed'] ?? 0 }} failed</div>
            </div>
        </div>
    </div>

    <!-- Status Filter Tabs -->
    <div style="display:flex; gap:10px; margin-bottom:24px; flex-wrap:wrap; align-items:center;">
        @foreach ($counts as $stName => $stCount)
            @php
                $isActive = (request('status') == $stName) || (!request('status') && $stName == 'All');
            @endphp
            <a href="{{ route('admin.payments.index', ['status' => ($stName == 'All' ? null : $stName)]) }}" 
               class="btn-outline" 
               style="{{ $isActive ? 'background:#4f46e5; border-color:#4f46e5; color:#ffffff; font-weight:750; box-shadow:0 2px 6px rgba(79,70,229,0.25);' : 'background:#ffffff; border:1.5px solid #cbd5e1; color:#334155; font-weight:650;' }}">
                {{ $stName }} Payments
                <span style="background:{{ $isActive ? 'rgba(255,255,255,0.25)' : '#f1f5f9' }}; color:{{ $isActive ? '#ffffff' : '#475569' }}; padding:2px 8px; border-radius:10px; font-size:0.75rem; margin-left:6px; font-weight:800; border:{{ $isActive ? 'none' : '1px solid #e2e8f0' }};">
                    {{ $stCount }}
                </span>
            </a>
        @endforeach
    </div>

    <!-- Payments Data Table -->
    <div style="background:#ffffff; border:1.5px solid #e2e8f0; border-radius:16px; overflow:hidden; box-shadow:0 1px 3px rgba(0,0,0,0.04), 0 6px 18px rgba(0,0,0,0.02);">
        <table style="width:100%; border-collapse:collapse; text-align:left;">
            <thead>
                <tr style="background:#f8fafc; border-bottom:1.5px solid #e2e8f0;">
                    <th style="padding:15px 20px; font-size:0.8rem; font-weight:800; color:#334155; text-transform:uppercase; letter-spacing:0.6px;">Transaction ID</th>
                    <th style="padding:15px 20px; font-size:0.8rem; font-weight:800; color:#334155; text-transform:uppercase; letter-spacing:0.6px;">Associated Order</th>
                    <th style="padding:15px 20px; font-size:0.8rem; font-weight:800; color:#334155; text-transform:uppercase; letter-spacing:0.6px;">Amount</th>
                    <th style="padding:15px 20px; font-size:0.8rem; font-weight:800; color:#334155; text-transform:uppercase; letter-spacing:0.6px;">Payment Method</th>
                    <th style="padding:15px 20px; font-size:0.8rem; font-weight:800; color:#334155; text-transform:uppercase; letter-spacing:0.6px;">Status</th>
                    <th style="padding:15px 20px; font-size:0.8rem; font-weight:800; color:#334155; text-transform:uppercase; letter-spacing:0.6px;">Timestamp</th>
                    <th style="padding:15px 20px; font-size:0.8rem; font-weight:800; color:#334155; text-transform:uppercase; letter-spacing:0.6px; text-align:right;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($payments as $payment)
                    <tr style="border-bottom:1px solid #f1f5f9; transition:background 0.15s;" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background='#ffffff'">
                        <!-- Transaction ID -->
                        <td style="padding:16px 20px;">
                            <div style="display:inline-flex; align-items:center; gap:6px;">
                                <span style="font-family:ui-monospace,SFMono-Regular,Consolas,monospace; font-weight:800; color:#0f172a; font-size:0.9rem; background:#f8fafc; padding:4px 8px; border-radius:6px; border:1px solid #cbd5e1;">
                                    {{ $payment->transaction_id }}
                                </span>
                            </div>
                            @if ($payment->refund_reason)
                                <div style="font-size:0.75rem; color:#b91c1c; font-weight:700; margin-top:4px;">
                                    Reason: {{ $payment->refund_reason }}
                                </div>
                            @endif
                        </td>

                        <!-- Associated Order -->
                        <td style="padding:16px 20px;">
                            @if ($payment->order)
                                <a href="{{ route('admin.orders.show', $payment->order->id) }}" style="display:inline-flex; align-items:center; gap:5px; background:#eef2ff; border:1.5px solid #c7d2fe; color:#4338ca; font-weight:800; font-family:ui-monospace,SFMono-Regular,Consolas,monospace; font-size:0.88rem; padding:4px 10px; border-radius:6px; text-decoration:none; transition:all 0.15s;" onmouseover="this.style.background='#4f46e5'; this.style.color='#ffffff'; this.style.borderColor='#4f46e5';" onmouseout="this.style.background='#eef2ff'; this.style.color='#4338ca'; this.style.borderColor='#c7d2fe;'">
                                    <span>📦</span> {{ $payment->order->order_number }}
                                </a>
                            @else
                                <span style="font-size:0.82rem; color:#64748b; font-weight:600; background:#f1f5f9; padding:3px 8px; border-radius:6px; border:1px solid #e2e8f0;">
                                    Direct Checkout
                                </span>
                            @endif
                        </td>

                        <!-- Amount -->
                        <td style="padding:16px 20px;">
                            <span style="font-weight:850; color:#0f172a; font-size:1.05rem;">
                                ${{ number_format($payment->amount, 2) }}
                            </span>
                        </td>

                        <!-- Payment Method -->
                        <td style="padding:16px 20px;">
                            <div>
                                <span style="font-weight:750; color:#1e293b; font-size:0.9rem; display:inline-flex; align-items:center; gap:6px;">
                                    @if ($payment->payment_method === 'QR Code' || str_contains(strtolower($payment->payment_method), 'qr'))
                                        <span>📱</span> KHQR Scan
                                    @elseif (str_contains(strtolower($payment->payment_method), 'card'))
                                        <span>💳</span> Credit Card
                                    @elseif (str_contains(strtolower($payment->payment_method), 'cash') || str_contains(strtolower($payment->payment_method), 'cod'))
                                        <span>💵</span> Cash on Delivery
                                    @else
                                        <span>🪙</span> {{ $payment->payment_method }}
                                    @endif
                                </span>
                                @if ($payment->payment_slip)
                                    <div style="margin-top:5px;">
                                        <a href="{{ asset($payment->payment_slip) }}" target="_blank" style="display:inline-flex; align-items:center; gap:4px; font-size:0.75rem; font-weight:750; color:#15803d; background:#dcfce7; border:1px solid #86efac; padding:3px 8px; border-radius:6px; text-decoration:none; transition:all 0.15s;" onmouseover="this.style.background='#15803d'; this.style.color='#ffffff';">
                                            📎 View Slip
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </td>

                        <!-- Status Badge -->
                        <td style="padding:16px 20px;">
                            @php
                                $st = strtolower($payment->status);
                            @endphp
                            @if ($st === 'successful')
                                <span style="display:inline-flex; align-items:center; gap:5px; background:#dcfce7; color:#15803d; border:1.5px solid #bbf7d0; padding:5px 12px; border-radius:9999px; font-weight:850; font-size:0.75rem; letter-spacing:0.4px;">
                                    <span>✓</span> SUCCESSFUL
                                </span>
                            @elseif ($st === 'pending')
                                <span style="display:inline-flex; align-items:center; gap:5px; background:#fef3c7; color:#b45309; border:1.5px solid #fde68a; padding:5px 12px; border-radius:9999px; font-weight:850; font-size:0.75rem; letter-spacing:0.4px;">
                                    <span>⏳</span> PENDING
                                </span>
                            @elseif ($st === 'failed')
                                <span style="display:inline-flex; align-items:center; gap:5px; background:#fee2e2; color:#b91c1c; border:1.5px solid #fecaca; padding:5px 12px; border-radius:9999px; font-weight:850; font-size:0.75rem; letter-spacing:0.4px;">
                                    <span>✕</span> FAILED
                                </span>
                            @elseif ($st === 'refunded')
                                <span style="display:inline-flex; align-items:center; gap:5px; background:#f1f5f9; color:#475569; border:1.5px solid #cbd5e1; padding:5px 12px; border-radius:9999px; font-weight:850; font-size:0.75rem; letter-spacing:0.4px;">
                                    <span>↩</span> REFUNDED
                                </span>
                            @else
                                <span style="display:inline-flex; align-items:center; gap:5px; background:#e0e7ff; color:#4338ca; border:1.5px solid #c7d2fe; padding:5px 12px; border-radius:9999px; font-weight:850; font-size:0.75rem; letter-spacing:0.4px;">
                                    {{ strtoupper($payment->status) }}
                                </span>
                            @endif
                        </td>

                        <!-- Timestamp -->
                        <td style="padding:16px 20px;">
                            <div style="font-size:0.85rem; color:#334155; font-weight:700;">
                                {{ $payment->created_at->format('M d, Y') }}
                            </div>
                            <div style="font-size:0.75rem; color:#64748b; font-weight:600; font-family:monospace;">
                                {{ $payment->created_at->format('H:i:s') }}
                            </div>
                        </td>

                        <!-- Action -->
                        <td style="padding:16px 20px; text-align:right;">
                            @if ($payment->status === 'Pending')
                                <form action="{{ route('admin.payments.confirm', $payment->id) }}" method="POST" style="display:inline-block; margin:0;">
                                    @csrf
                                    <button type="submit" style="background:#ecfdf5; color:#15803d; border:1.5px solid #86efac; padding:7px 14px; font-size:0.82rem; font-weight:750; border-radius:9999px; cursor:pointer; display:inline-flex; align-items:center; gap:5px; box-shadow:0 1px 2px rgba(16,185,129,0.1); transition:all 0.15s;" onmouseover="this.style.background='#10b981'; this.style.color='#ffffff'; this.style.borderColor='#10b981';" onmouseout="this.style.background='#ecfdf5'; this.style.color='#15803d'; this.style.borderColor='#86efac';">
                                        ✓ Confirm Paid
                                    </button>
                                </form>
                            @elseif ($payment->status === 'Successful')
                                <form action="{{ route('admin.payments.refund', $payment->id) }}" method="POST" style="display:inline; margin:0;"
                                      data-confirm="Process full customer refund of ${{ number_format($payment->amount, 2) }}? This will mark the ledger as Refunded and trigger notification."
                                      data-confirm-title="Issue Customer Refund?"
                                      data-confirm-item="💳 ${{ number_format($payment->amount, 2) }} (Txn: {{ $payment->transaction_id }})"
                                      data-confirm-badge="FINANCIAL REVERSAL"
                                      data-confirm-btn="Issue Refund Now"
                                      data-confirm-type="warning"
                                      data-confirm-icon="💸">
                                    @csrf
                                    <button type="submit" style="background:#fff1f2; color:#be123c; border:1.5px solid #fecdd3; padding:7px 14px; font-size:0.82rem; font-weight:750; border-radius:9999px; cursor:pointer; display:inline-flex; align-items:center; gap:5px; box-shadow:0 1px 2px rgba(225,29,72,0.06); transition:all 0.15s;" onmouseover="this.style.background='#e11d48'; this.style.color='#ffffff'; this.style.borderColor='#e11d48';" onmouseout="this.style.background='#fff1f2'; this.style.color='#be123c'; this.style.borderColor='#fecdd3';">
                                        Refund
                                    </button>
                                </form>
                            @else
                                <span style="font-size:0.8rem; color:#64748b; font-weight:750; background:#f1f5f9; padding:4px 10px; border-radius:9999px; border:1px solid #e2e8f0; display:inline-block;">
                                    ✓ Settled
                                </span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="text-align:center; padding:40px 20px; color:#64748b;">
                            <div style="font-size:2rem; margin-bottom:8px;">🧾</div>
                            <div style="font-size:1rem; font-weight:750; color:#1e293b;">No payment records found</div>
                            <div style="font-size:0.85rem; color:#64748b; margin-top:4px;">No transactions match the selected filter.</div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div style="margin-top:24px;">
        {{ $payments->links() }}
    </div>
@endsection
