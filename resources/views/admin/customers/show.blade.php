@extends('layouts.admin')

@section('title', 'Customer ' . $customer->name)
@section('page-title', 'Customer Profile #' . $customer->id)

@section('content')
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:24px; flex-wrap:wrap; gap:16px;">
        <div>
            <h2 style="font-size:1.6rem; font-weight:800; color:#ffffff;">{{ $customer->name }}</h2>
            <p style="color:var(--text-muted); font-size:0.9rem;">Member since {{ $customer->created_at->format('F d, Y') }}</p>
        </div>
        <div style="display:flex; align-items:center; gap:10px; flex-wrap:wrap;">
            <a href="{{ route('admin.customers.statement', $customer->id) }}" target="_blank" class="btn-primary" style="padding:8px 16px; font-size:0.85rem; display:inline-flex; align-items:center; gap:6px; background:linear-gradient(135deg, #4f46e5, #6366f1); border:none;">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 6 2 18 2 18 9"></polyline><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path><rect x="6" y="14" width="12" height="8"></rect></svg>
                <span>🖨️ Print Customer Sales Report</span>
            </a>

            @if(auth()->id() !== $customer->id)
                <form action="{{ route('admin.customers.destroy', $customer->id) }}" 
                      method="POST" 
                      style="display:inline-block; margin:0;"
                      data-confirm-title="Delete Customer Account?"
                      data-confirm-message="Are you sure you want to delete customer account '{{ addslashes($customer->name) }}' ({{ $customer->email }})? Past order history will be kept for accounting."
                      data-confirm-item="{{ $customer->name }}"
                      data-confirm-badge="PERMANENT REMOVAL"
                      data-confirm-btn="Yes, Delete Customer"
                      data-cancel-btn="Cancel"
                      onsubmit="return confirm('Are you sure you want to delete this customer? (តើអ្នកប្រាកដថាចង់លុបគណនីអតិថិជននេះទេ?)');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-outline" style="padding:8px 14px; font-size:0.85rem; color:#f87171; border-color:rgba(239,68,68,0.4); display:inline-flex; align-items:center; gap:6px; cursor:pointer;" title="Delete customer account">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="3 6 5 6 21 6"></polyline>
                            <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                            <line x1="10" y1="11" x2="10" y2="17"></line>
                            <line x1="14" y1="11" x2="14" y2="17"></line>
                        </svg>
                        <span>Delete Customer</span>
                    </button>
                </form>
            @endif

            <a href="{{ route('admin.customers.index') }}" class="btn-outline">← Back to Customers</a>
        </div>
    </div>

    <!-- Customer Overview Cards -->
    <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap:20px; margin-bottom:28px;">
        <div style="background:var(--bg-card); border:1px solid var(--border-subtle); border-radius:var(--radius-lg); padding:20px;">
            <div style="font-size:0.8rem; text-transform:uppercase; color:var(--text-muted);">Total Spend</div>
            <div style="font-size:1.8rem; font-weight:800; color:#4ade80; margin-top:4px;">${{ number_format($totalSpent, 2) }}</div>
        </div>

        <div style="background:var(--bg-card); border:1px solid var(--border-subtle); border-radius:var(--radius-lg); padding:20px;">
            <div style="font-size:0.8rem; text-transform:uppercase; color:var(--text-muted);">Orders Count</div>
            <div style="font-size:1.8rem; font-weight:800; color:#ffffff; margin-top:4px;">{{ $customer->orders->count() }}</div>
        </div>

        <div style="background:var(--bg-card); border:1px solid var(--border-subtle); border-radius:var(--radius-lg); padding:20px;">
            <div style="font-size:0.8rem; text-transform:uppercase; color:var(--text-muted);">Account Status</div>
            <div style="font-size:1.2rem; font-weight:800; color:#a5b4fc; margin-top:8px;">
                <span class="badge-status badge-blue">{{ ucfirst($customer->role) }}</span>
            </div>
        </div>
    </div>

    <!-- Customer Orders History -->
    <div class="table-card">
        <div style="padding:20px; border-bottom:1px solid var(--border-subtle);">
            <h3 style="font-size:1.15rem; font-weight:800; color:#ffffff;">Order History</h3>
        </div>

        <table class="custom-table">
            <thead>
                <tr>
                    <th>Order #</th>
                    <th>Date</th>
                    <th>Items</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th style="text-align:right;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($customer->orders as $order)
                    <tr>
                        <td><strong style="color:#ffffff;">{{ $order->order_number }}</strong></td>
                        <td>{{ $order->created_at->format('M d, Y') }}</td>
                        <td>{{ $order->items->count() }} tees</td>
                        <td style="font-weight:800; color:#ffffff;">${{ number_format($order->total, 2) }}</td>
                        <td><span class="badge-status badge-blue">{{ $order->status }}</span></td>
                        <td style="text-align:right;">
                            <div style="display:flex; justify-content:flex-end; align-items:center; gap:6px;">
                                <a href="{{ route('admin.orders.invoice', $order->id) }}" target="_blank" class="btn-outline" style="padding:4px 10px; font-size:0.75rem; color:#38bdf8; border-color:rgba(56,189,248,0.3); display:inline-flex; align-items:center; gap:4px;" title="Print Customer Sales Receipt">
                                    🖨️ Print
                                </a>
                                <a href="{{ route('admin.orders.show', $order->id) }}" class="btn-outline" style="padding:4px 10px; font-size:0.8rem;">
                                    View
                                </a>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="text-align:center; padding:30px; color:var(--text-muted);">No orders recorded for this customer.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
