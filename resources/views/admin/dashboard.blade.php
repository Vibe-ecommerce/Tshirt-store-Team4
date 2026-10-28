@extends('layouts.admin')

@section('title', 'Admin Dashboard')
@section('page-title', 'Store Executive Dashboard')

@section('styles')
<style>
    .kpi-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }

    .kpi-card {
        background: var(--bg-card);
        border: 1px solid var(--border-subtle);
        border-radius: var(--radius-lg);
        padding: 24px;
        position: relative;
        overflow: hidden;
        transition: transform 0.2s, border-color 0.2s, box-shadow 0.2s;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05), 0 4px 12px rgba(0, 0, 0, 0.03);
    }

    .kpi-card:hover {
        transform: translateY(-3px);
        border-color: var(--border-active);
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.06), 0 16px 20px -4px rgba(0, 0, 0, 0.05);
    }

    .kpi-head {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 12px;
    }

    .kpi-label {
        font-size: 0.82rem;
        text-transform: uppercase;
        letter-spacing: 0.6px;
        color: var(--text-muted);
        font-weight: 700;
    }

    .kpi-icon {
        width: 44px;
        height: 44px;
        border-radius: var(--radius-md);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .kpi-icon svg {
        width: 22px;
        height: 22px;
        stroke: currentColor;
        fill: none;
        stroke-width: 2;
        stroke-linecap: round;
        stroke-linejoin: round;
    }

    .icon-sales { background: #eef2ff; color: #4f46e5; }
    .icon-orders { background: #f5f3ff; color: #7c3aed; }
    .icon-customers { background: #ecfdf5; color: #059669; }
    .icon-products { background: #fdf2f8; color: #db2777; }

    .kpi-value {
        font-size: 2rem;
        font-weight: 800;
        color: var(--text-main);
        letter-spacing: -0.5px;
    }

    .kpi-trend {
        font-size: 0.82rem;
        color: #059669;
        font-weight: 600;
        margin-top: 6px;
        display: flex;
        align-items: center;
        gap: 4px;
    }

    /* Dashboard Split */
    .dashboard-split {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 28px;
    }

    @media (max-width: 950px) {
        .dashboard-split {
            grid-template-columns: 1fr;
        }
    }

    .section-card {
        background: var(--bg-card);
        border: 1px solid var(--border-subtle);
        border-radius: var(--radius-lg);
        padding: 24px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05), 0 4px 12px rgba(0, 0, 0, 0.03);
    }

    .card-title-bar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 20px;
    }

    .status-bars {
        display: flex;
        flex-direction: column;
        gap: 16px;
        margin-top: 14px;
    }

    .status-row-item {
        display: flex;
        flex-direction: column;
        gap: 6px;
    }

    .status-label-count {
        display: flex;
        justify-content: space-between;
        font-size: 0.88rem;
        font-weight: 600;
    }

    .progress-track {
        height: 8px;
        background: #f1f5f9;
        border: 1px solid #e2e8f0;
        border-radius: var(--radius-full);
        overflow: hidden;
    }

    .progress-fill {
        height: 100%;
        border-radius: var(--radius-full);
    }
</style>
@endsection

@section('content')

    <!-- 1. KPI CARDS (Total Sales, Total Orders, Total Customers, Total Products) -->
    <div class="kpi-grid">
        <!-- Total Sales -->
        <div class="kpi-card">
            <div class="kpi-head">
                <span class="kpi-label">Total Sales</span>
                <span class="kpi-icon icon-sales">
                    <svg viewBox="0 0 24 24">
                        <line x1="12" y1="1" x2="12" y2="23"></line>
                        <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                    </svg>
                </span>
            </div>
            <div class="kpi-value">${{ number_format($totalSales, 2) }}</div>
            <div class="kpi-trend">↑ +18.4% vs last month</div>
        </div>

        <!-- Total Orders -->
        <div class="kpi-card">
            <div class="kpi-head">
                <span class="kpi-label">Total Orders</span>
                <span class="kpi-icon icon-orders">
                    <svg viewBox="0 0 24 24">
                        <path d="M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16Z"></path>
                        <path d="m3.3 7 8.7 5 8.7-5"></path>
                        <path d="M12 22V12"></path>
                    </svg>
                </span>
            </div>
            <div class="kpi-value">{{ $totalOrders }}</div>
            <div class="kpi-trend">↑ +12 new this week</div>
        </div>

        <!-- Total Customers -->
        <div class="kpi-card">
            <div class="kpi-head">
                <span class="kpi-label">Total Customers</span>
                <span class="kpi-icon icon-customers">
                    <svg viewBox="0 0 24 24">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                        <circle cx="9" cy="7" r="4"></circle>
                        <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                        <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                    </svg>
                </span>
            </div>
            <div class="kpi-value">{{ $totalCustomers }}</div>
            <div class="kpi-trend">↑ Active customer accounts</div>
        </div>

        <!-- Total Products -->
        <div class="kpi-card">
            <div class="kpi-head">
                <span class="kpi-label">Total Products</span>
                <span class="kpi-icon icon-products">
                    <svg viewBox="0 0 24 24">
                        <path d="M20.38 3.46L16 2a4 4 0 0 1-8 0L3.62 3.46a2 2 0 0 0-1.34 2.23l.58 3.47a1 1 0 0 0 .99.84H6v10c0 1.1.9 2 2 2h8a2 2 0 0 0 2-2V10h2.15a1 1 0 0 0 .99-.84l.58-3.47a2 2 0 0 0-1.34-2.23z"></path>
                    </svg>
                </span>
            </div>
            <div class="kpi-value">{{ $totalProducts }}</div>
            <div class="kpi-trend" style="color:var(--text-muted);">Across 4 apparel categories</div>
        </div>
    </div>

    <!-- 2. RECENT ORDERS & SALES OVERVIEW -->
    <div class="dashboard-split">
        <!-- Recent Orders Table -->
        <div class="section-card">
            <div class="card-title-bar">
                <h3 style="font-size:1.15rem; font-weight:800; color:var(--text-main);">Recent Orders</h3>
                <a href="{{ route('admin.orders.index') }}" class="btn-outline" style="font-size:0.8rem; padding:6px 12px;">View All Orders →</a>
            </div>

            <div class="table-card" style="border:none;">
                <table class="custom-table">
                    <thead>
                        <tr>
                            <th>Order</th>
                            <th>Customer</th>
                            <th>Items</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($recentOrders as $order)
                            <tr>
                                <td>
                                    <strong style="color:var(--text-main); font-weight:750;">{{ $order->order_number }}</strong>
                                    <div style="font-size:0.75rem; color:var(--text-muted);">{{ $order->created_at->diffForHumans() }}</div>
                                </td>
                                <td>
                                    <div style="font-weight:600; color:var(--text-main);">{{ $order->customer_name }}</div>
                                    <div style="font-size:0.78rem; color:var(--text-muted);">{{ $order->customer_email }}</div>
                                </td>
                                <td>{{ $order->items->count() }} tees</td>
                                <td style="font-weight:800; color:var(--text-main);">${{ number_format($order->total, 2) }}</td>
                                <td>
                                    @php
                                        $cls = 'badge-blue';
                                        $st = strtolower($order->status);
                                        if ($st == 'delivered') $cls = 'badge-green';
                                        elseif ($st == 'cancelled') $cls = 'badge-red';
                                        elseif ($st == 'pending') $cls = 'badge-yellow';
                                    @endphp
                                    <span class="badge-status {{ $cls }}">{{ $order->status }}</span>
                                </td>
                                <td>
                                    <a href="{{ route('admin.orders.show', $order->id) }}" class="btn-outline" style="padding:4px 10px; font-size:0.78rem;">Details</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" style="text-align:center; padding:30px; color:var(--text-muted);">No orders yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Sales Overview & Order Pipeline -->
        <div class="section-card">
            <h3 style="font-size:1.15rem; font-weight:800; color:var(--text-main); margin-bottom:14px;">Sales Overview & Pipeline</h3>
            <p style="color:var(--text-muted); font-size:0.85rem; margin-bottom:20px;">Breakdown of current orders progressing through fulfillment stages.</p>

            <div class="status-bars">
                @php
                    $colors = [
                        'Pending' => '#f59e0b',
                        'Processing' => '#6366f1',
                        'Shipped' => '#0ea5e9',
                        'Delivered' => '#10b981',
                        'Cancelled' => '#ef4444',
                    ];
                @endphp

                @foreach ($ordersByStatus as $status => $count)
                    @php
                        $percentage = $totalOrders > 0 ? round(($count / $totalOrders) * 100) : 0;
                    @endphp
                    <div class="status-row-item">
                        <div class="status-label-count">
                            <span style="color:var(--text-sub); font-weight:600;">{{ $status }}</span>
                            <span style="color:var(--text-main); font-weight:750;">{{ $count }} ({{ $percentage }}%)</span>
                        </div>
                        <div class="progress-track">
                            <div class="progress-fill" style="width: {{ $percentage }}%; background: {{ $colors[$status] ?? '#6366f1' }};"></div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Quick Action Shortcuts -->
            <div style="margin-top:28px; padding-top:20px; border-top:1px solid var(--border-subtle); display:flex; flex-direction:column; gap:8px;">
                <span style="font-size:0.8rem; text-transform:uppercase; color:var(--text-muted); font-weight:700;">Quick Shortcuts</span>
                <a href="{{ route('admin.products.create') }}" class="btn-primary" style="justify-content:center; gap:8px;">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                    <span>Create New T-Shirt</span>
                </a>
                <a href="{{ route('admin.promotions.index') }}" class="btn-outline" style="justify-content:center; gap:8px;">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"></path><circle cx="7" cy="7" r="1.5" fill="currentColor"></circle></svg>
                    <span>Manage Discounts</span>
                </a>
            </div>
        </div>
    </div>

@endsection
