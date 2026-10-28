@extends('layouts.admin')

@section('title', 'Analytics & Reports')
@section('page-title', 'Store Performance Reports')

@section('styles')
<style>
    /* ==========================================================================
       SCREEN VIEW STYLING (Modern High-Contrast Dark Analytics)
       ========================================================================== */

    .reports-action-bar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 28px;
        flex-wrap: wrap;
        gap: 16px;
    }

    .report-btn-group {
        display: flex;
        align-items: center;
        gap: 12px;
        flex-wrap: wrap;
    }

    .btn-print-primary {
        background: var(--accent-gradient);
        color: #ffffff;
        font-weight: 700;
        font-size: 0.9rem;
        padding: 10px 20px;
        border-radius: var(--radius-md);
        display: inline-flex;
        align-items: center;
        gap: 8px;
        border: none;
        cursor: pointer;
        box-shadow: 0 4px 18px rgba(99, 102, 241, 0.4);
        transition: all 0.2s ease;
    }

    .btn-print-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 24px rgba(99, 102, 241, 0.6);
        color: #ffffff;
    }

    .btn-action-outline {
        background: #ffffff;
        border: 1.5px solid #cbd5e1;
        color: #1e293b;
        font-weight: 700;
        font-size: 0.88rem;
        padding: 9px 18px;
        border-radius: var(--radius-md);
        display: inline-flex;
        align-items: center;
        gap: 8px;
        cursor: pointer;
        transition: all 0.2s ease;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.04);
    }

    .btn-action-outline:hover {
        background: #f8fafc;
        border-color: #94a3b8;
        color: #4f46e5;
        transform: translateY(-1px);
    }

    /* Screen Metrics Cards */
    .screen-metrics-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(230px, 1fr));
        gap: 20px;
        margin-bottom: 32px;
    }

    .screen-metric-card {
        background: #ffffff;
        border: 1.5px solid #e2e8f0;
        border-radius: 14px;
        padding: 22px 24px;
        position: relative;
        overflow: hidden;
        transition: all 0.25s ease;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04), 0 4px 12px rgba(0, 0, 0, 0.02);
    }

    .screen-metric-card:hover {
        transform: translateY(-2px);
        border-color: #cbd5e1;
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.06);
    }

    .metric-icon-bubble {
        position: absolute;
        top: 20px;
        right: 20px;
        width: 44px;
        height: 44px;
        border-radius: 12px;
        background: #f8fafc;
        border: 1.5px solid #e2e8f0;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.35rem;
    }

    .metric-top-label {
        font-size: 0.78rem;
        text-transform: uppercase;
        letter-spacing: 0.6px;
        color: #475569;
        font-weight: 800;
        margin-bottom: 6px;
    }

    .metric-main-value {
        font-size: 2.1rem;
        font-weight: 850;
        line-height: 1.1;
        margin-bottom: 6px;
    }

    .metric-sub-detail {
        font-size: 0.82rem;
        color: #64748b;
        font-weight: 600;
    }

    /* Screen Tables Layout */
    .screen-reports-two-col {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 28px;
        margin-bottom: 30px;
    }

    @media (max-width: 960px) {
        .screen-reports-two-col {
            grid-template-columns: 1fr;
        }
    }

    .table-card {
        background: #ffffff;
        border: 1.5px solid #e2e8f0;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04), 0 6px 18px rgba(0, 0, 0, 0.02);
    }

    .table-card-header {
        padding: 18px 22px;
        border-bottom: 1.5px solid #e2e8f0;
        display: flex;
        align-items: center;
        justify-content: space-between;
        background: #ffffff;
    }

    .table-card-header h3 {
        font-size: 1.1rem;
        font-weight: 850;
        color: #0f172a;
        margin: 0;
    }

    .custom-table {
        width: 100%;
        border-collapse: collapse;
        text-align: left;
    }

    .custom-table th {
        background: #f8fafc;
        padding: 14px 22px;
        font-size: 0.8rem;
        text-transform: uppercase;
        letter-spacing: 0.6px;
        color: #334155;
        font-weight: 800;
        border-bottom: 1.5px solid #e2e8f0;
    }

    .custom-table td {
        padding: 16px 22px;
        font-size: 0.92rem;
        border-bottom: 1px solid #f1f5f9;
        color: #1e293b;
    }

    .custom-table tr:last-child td {
        border-bottom: none;
    }

    .custom-table tr:hover td {
        background: #f8fafc;
    }

    .badge-status {
        padding: 4px 10px;
        border-radius: var(--radius-full);
        font-size: 0.75rem;
        font-weight: 850;
        text-transform: uppercase;
        letter-spacing: 0.4px;
        display: inline-block;
    }

    .badge-blue {
        background: #e0e7ff;
        color: #4338ca;
        border: 1.5px solid #c7d2fe;
    }

    .badge-green {
        background: #dcfce7;
        color: #15803d;
        border: 1.5px solid #bbf7d0;
    }

    .badge-amber {
        background: #fef3c7;
        color: #b45309;
        border: 1.5px solid #fde68a;
    }

    .badge-red {
        background: #fee2e2;
        color: #b91c1c;
        border: 1.5px solid #fecaca;
    }

    /* ==========================================================================
       PRINT PREVIEW MODAL (ON SCREEN)
       ========================================================================== */
    .print-modal-backdrop {
        position: fixed;
        inset: 0;
        background: rgba(3, 7, 18, 0.88);
        backdrop-filter: blur(14px);
        -webkit-backdrop-filter: blur(14px);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 99999;
        opacity: 0;
        visibility: hidden;
        transition: all 0.25s ease;
        padding: 24px;
    }

    .print-modal-backdrop.is-open {
        opacity: 1;
        visibility: visible;
    }

    .print-modal-box {
        background: #ffffff;
        color: #0f172a;
        width: 100%;
        max-width: 900px;
        max-height: 90vh;
        border-radius: 18px;
        overflow-y: auto;
        box-shadow: 0 25px 60px rgba(0, 0, 0, 0.8);
        display: flex;
        flex-direction: column;
    }

    .print-modal-toolbar {
        background: #0f172a;
        color: #ffffff;
        padding: 16px 24px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        position: sticky;
        top: 0;
        z-index: 10;
    }

    /* ==========================================================================
       OFFICIAL PRINT REPORT DOCUMENT ARCHITECTURE
       ========================================================================== */

    /* Hide printable report on screen by default */
    .print-report-sheet {
        display: none;
    }

    /* Print Preview inside modal */
    .print-modal-box .print-report-sheet {
        display: block;
        padding: 40px;
    }

    /* Specific Print Rules */
    @media print {
        /* Hide all admin chrome, navigations, sidebars, headers, and screen elements */
        .admin-sidebar,
        .admin-header,
        .screen-dashboard,
        .print-modal-backdrop,
        .flash-box,
        header,
        aside,
        nav,
        button,
        .no-print {
            display: none !important;
            visibility: hidden !important;
        }

        body {
            background: #ffffff !important;
            color: #0f172a !important;
            font-family: 'Plus Jakarta Sans', -apple-system, sans-serif !important;
            font-size: 10pt !important;
            margin: 0 !important;
            padding: 0 !important;
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }

        .admin-layout,
        .admin-main,
        .admin-content {
            display: block !important;
            margin: 0 !important;
            padding: 0 !important;
            width: 100% !important;
            max-width: 100% !important;
            background: #ffffff !important;
        }

        @page {
            size: A4 portrait;
            margin: 12mm 14mm 14mm 14mm;
        }

        /* Show the official report sheet cleanly */
        .print-report-sheet {
            display: block !important;
            width: 100% !important;
            background: #ffffff !important;
            color: #0f172a !important;
            padding: 0 !important;
        }

        /* Prevent awkward breaks */
        .print-card-break-avoid,
        .print-table-wrap,
        .print-header-block,
        .print-sign-block {
            page-break-inside: avoid !important;
            break-inside: avoid !important;
        }
    }

    /* Document Sheet Elements */
    .sheet-letterhead {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        padding-bottom: 22px;
        border-bottom: 2px solid #0f172a;
        margin-bottom: 24px;
    }

    .sheet-brand-left {
        display: flex;
        align-items: center;
        gap: 14px;
    }

    .sheet-logo-badge {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        background: #0f172a;
        color: #ffffff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        flex-shrink: 0;
    }

    .sheet-brand-title h1 {
        font-size: 1.45rem;
        font-weight: 850;
        letter-spacing: -0.4px;
        color: #0f172a;
        margin: 0;
        line-height: 1.15;
    }

    .sheet-brand-title p {
        font-size: 0.78rem;
        color: #64748b;
        margin: 2px 0 0;
        font-weight: 600;
        letter-spacing: 0.5px;
        text-transform: uppercase;
    }

    .sheet-meta-right {
        text-align: right;
        font-size: 0.8rem;
        color: #475569;
        line-height: 1.5;
    }

    .sheet-audit-badge {
        display: inline-block;
        background: #f1f5f9;
        border: 1px solid #cbd5e1;
        padding: 3px 8px;
        border-radius: 6px;
        font-size: 0.7rem;
        font-weight: 800;
        color: #0f172a;
        letter-spacing: 0.6px;
        text-transform: uppercase;
        margin-bottom: 4px;
    }

    /* Print Metrics Row */
    .sheet-metrics-row {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 14px;
        margin-bottom: 26px;
    }

    .sheet-metric-box {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-top: 3px solid #4f46e5;
        border-radius: 8px;
        padding: 12px 14px;
    }

    .sheet-metric-box.revenue-box {
        border-top-color: #16a34a;
    }

    .sheet-metric-box.units-box {
        border-top-color: #0284c7;
    }

    .sheet-metric-box.aov-box {
        border-top-color: #9333ea;
    }

    .sheet-metric-label {
        font-size: 0.68rem;
        font-weight: 750;
        text-transform: uppercase;
        letter-spacing: 0.6px;
        color: #64748b;
        margin-bottom: 4px;
    }

    .sheet-metric-val {
        font-size: 1.45rem;
        font-weight: 850;
        color: #0f172a;
        line-height: 1.1;
    }

    .sheet-metric-note {
        font-size: 0.68rem;
        color: #64748b;
        margin-top: 3px;
    }

    /* Print Tables */
    .sheet-section-title {
        font-size: 0.96rem;
        font-weight: 800;
        color: #0f172a;
        margin-bottom: 10px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        border-bottom: 1px solid #e2e8f0;
        padding-bottom: 6px;
    }

    .sheet-section-title span {
        font-size: 0.72rem;
        font-weight: 600;
        color: #64748b;
        text-transform: uppercase;
    }

    .sheet-table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 24px;
        font-size: 0.82rem;
    }

    .sheet-table th {
        background: #f1f5f9;
        color: #1e293b;
        font-weight: 800;
        font-size: 0.72rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding: 9px 12px;
        border: 1px solid #cbd5e1;
        text-align: left;
    }

    .sheet-table td {
        padding: 8px 12px;
        border: 1px solid #e2e8f0;
        color: #334155;
    }

    .sheet-table tr:nth-child(even) td {
        background: #f8fafc;
    }

    .sheet-badge {
        display: inline-block;
        padding: 2px 7px;
        border-radius: 4px;
        font-size: 0.68rem;
        font-weight: 750;
        text-transform: uppercase;
    }

    .sheet-badge-green {
        background: #dcfce7;
        color: #166534;
        border: 1px solid #bbf7d0;
    }

    .sheet-badge-blue {
        background: #e0e7ff;
        color: #3730a3;
        border: 1px solid #c7d2fe;
    }

    .sheet-badge-amber {
        background: #fef3c7;
        color: #92400e;
        border: 1px solid #fde68a;
    }

    .sheet-badge-red {
        background: #fee2e2;
        color: #991b1b;
        border: 1px solid #fecaca;
    }

    /* Print Two-Column Tables Grid */
    .sheet-tables-row {
        display: grid;
        grid-template-columns: 1.2fr 0.8fr;
        gap: 20px;
        margin-bottom: 22px;
    }

    /* Executive Observations Box */
    .sheet-notes-card {
        background: #f8fafc;
        border: 1px solid #cbd5e1;
        border-left: 3px solid #4f46e5;
        border-radius: 6px;
        padding: 12px 16px;
        margin-bottom: 24px;
        font-size: 0.78rem;
        color: #334155;
        line-height: 1.55;
    }

    .sheet-notes-card strong {
        color: #0f172a;
        display: block;
        margin-bottom: 4px;
    }

    /* Signature & Legal Verification Block */
    .sheet-signatures-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 20px;
        padding-top: 18px;
        border-top: 1px dashed #cbd5e1;
        margin-bottom: 20px;
    }

    .sign-box {
        text-align: center;
    }

    .sign-label {
        font-size: 0.68rem;
        text-transform: uppercase;
        font-weight: 700;
        color: #64748b;
        margin-bottom: 30px;
    }

    .sign-line {
        border-bottom: 1px solid #0f172a;
        margin-bottom: 5px;
    }

    .sign-name {
        font-size: 0.74rem;
        font-weight: 750;
        color: #0f172a;
    }

    .stamp-box {
        border: 2px dashed #94a3b8;
        border-radius: 8px;
        padding: 10px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        height: 75px;
        color: #64748b;
        font-size: 0.68rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .sheet-footer-legal {
        text-align: center;
        font-size: 0.68rem;
        color: #94a3b8;
        border-top: 1px solid #e2e8f0;
        padding-top: 10px;
        line-height: 1.4;
    }
</style>
@endsection

@section('content')

<!-- ==========================================================================
     1. SCREEN-ONLY ANALYTICS DASHBOARD
     ========================================================================== -->
<div class="screen-dashboard">
    <div class="reports-action-bar">
        <div>
            <div style="display:flex; align-items:center; gap:10px;">
                <h2 style="font-size:1.6rem; font-weight:850; color:#0f172a; letter-spacing:-0.4px; margin:0;">Performance & Financial Reports</h2>
                <span style="background:#eef2ff; color:#4f46e5; font-size:0.75rem; font-weight:800; padding:3px 10px; border-radius:9999px; border:1px solid #c7d2fe;">
                    Analytics
                </span>
            </div>
            <p style="color:#475569; font-size:0.92rem; font-weight:500; margin-top:4px; margin-bottom:0;">Analyze sales volume, best-performing t-shirts, order throughput, and top customers.</p>
        </div>

        <div class="report-btn-group">
            <!-- Print Preview Modal Trigger -->
            <button type="button" class="btn-action-outline" onclick="openPrintPreview();">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                    <circle cx="12" cy="12" r="3"></circle>
                </svg>
                <span>Preview Document Sheet</span>
            </button>

            <!-- CSV Exporter Button -->
            <button type="button" class="btn-action-outline" onclick="exportReportToCSV();" title="Download raw report as Excel / CSV">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                    <polyline points="7 10 12 15 17 10"></polyline>
                    <line x1="12" y1="15" x2="12" y2="3"></line>
                </svg>
                <span>Export CSV</span>
            </button>

            <!-- Export / Print PDF Button (Triggers window.print with our clean @media print stylesheet) -->
            <button type="button" class="btn-print-primary" onclick="window.print();">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="6 9 6 2 18 2 18 9"></polyline>
                    <path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path>
                    <rect x="6" y="14" width="12" height="8"></rect>
                </svg>
                <span>Export / Print PDF</span>
            </button>
        </div>
    </div>

    <!-- Summary Metrics -->
    <div class="screen-metrics-grid">
        <div class="screen-metric-card" style="border-color:#bbf7d0;">
            <div class="metric-icon-bubble" style="background:#dcfce7; border-color:#86efac;">💵</div>
            <div class="metric-top-label" style="color:#15803d;">Gross Revenue</div>
            <div class="metric-main-value" style="color:#15803d;">${{ number_format($totalRevenue, 2) }}</div>
            <div class="metric-sub-detail">Total verified store sales</div>
        </div>

        <div class="screen-metric-card">
            <div class="metric-icon-bubble">📊</div>
            <div class="metric-top-label">Average Order Value</div>
            <div class="metric-main-value" style="color:#0f172a;">${{ number_format($averageOrderValue, 2) }}</div>
            <div class="metric-sub-detail">Per transaction checkout</div>
        </div>

        <div class="screen-metric-card" style="border-color:#c7d2fe;">
            <div class="metric-icon-bubble" style="background:#eef2ff; border-color:#c7d2fe;">👕</div>
            <div class="metric-top-label" style="color:#4338ca;">Total Units Sold</div>
            <div class="metric-main-value" style="color:#4338ca;">{{ number_format($totalUnitsSold ?? 0) }} <span style="font-size:1.1rem; color:#64748b; font-weight:600;">pcs</span></div>
            <div class="metric-sub-detail">Across all catalog categories</div>
        </div>

        <div class="screen-metric-card">
            <div class="metric-icon-bubble">👥</div>
            <div class="metric-top-label">Customer Accounts</div>
            <div class="metric-main-value" style="color:#0f172a;">{{ number_format($totalCustomers) }} <span style="font-size:1.1rem; color:#64748b; font-weight:600;">buyers</span></div>
            <div class="metric-sub-detail">Registered shoppers database</div>
        </div>
    </div>

    <!-- Two-Column Reports Layout -->
    <div class="screen-reports-two-col">
        <!-- 1. Top Selling Products -->
        <div class="table-card">
            <div class="table-card-header">
                <h3>Top Selling Designs & Products</h3>
                <span style="font-size:0.75rem; color:#4338ca; background:#eef2ff; border:1px solid #c7d2fe; padding:3px 9px; border-radius:9999px; font-weight:800;">BY QUANTITY</span>
            </div>
            <table class="custom-table">
                <thead>
                    <tr>
                        <th>T-Shirt Design</th>
                        <th>Units</th>
                        <th style="text-align:right;">Generated Revenue</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($topProducts as $tp)
                        <tr>
                            <td style="font-weight:800; color:#0f172a;">{{ $tp->product_name }}</td>
                            <td style="font-weight:650; color:#334155;">{{ $tp->total_qty }} pcs</td>
                            <td style="text-align:right; font-weight:850; color:#0f172a;">${{ number_format($tp->total_revenue, 2) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" style="text-align:center; padding:24px; color:#64748b;">No product sales recorded yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- 2. Order Pipeline By Status -->
        <div class="table-card">
            <div class="table-card-header">
                <h3>Order Fulfillment Pipeline</h3>
                <span style="font-size:0.75rem; color:#334155; background:#f1f5f9; border:1px solid #e2e8f0; padding:3px 9px; border-radius:9999px; font-weight:800;">{{ $totalOrders }} TOTAL ORDERS</span>
            </div>
            <table class="custom-table">
                <thead>
                    <tr>
                        <th>Status Stage</th>
                        <th>Volume</th>
                        <th style="text-align:right;">Stage Value</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($ordersByStatus as $obs)
                        <tr>
                            <td>
                                @php
                                    $st = strtolower($obs->status);
                                    $badgeClass = 'badge-blue';
                                    if(in_array($st, ['delivered', 'completed', 'paid'])) $badgeClass = 'badge-green';
                                    elseif(in_array($st, ['processing', 'pending'])) $badgeClass = 'badge-amber';
                                    elseif(in_array($st, ['cancelled', 'failed', 'refunded'])) $badgeClass = 'badge-red';
                                @endphp
                                <span class="badge-status {{ $badgeClass }}">{{ strtoupper($obs->status) }}</span>
                            </td>
                            <td style="font-weight:650; color:#334155;">{{ $obs->count }} orders</td>
                            <td style="text-align:right; font-weight:850; color:#0f172a;">${{ number_format($obs->revenue, 2) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" style="text-align:center; padding:24px; color:#64748b;">No orders in pipeline.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- 3. Top VIP Customers -->
    <div class="table-card">
        <div class="table-card-header">
            <h3>VIP Customers by Lifetime Value (LTV)</h3>
            <span style="font-size:0.75rem; color:#15803d; background:#dcfce7; border:1px solid #86efac; padding:3px 9px; border-radius:9999px; font-weight:800;">TOP ACCOUNTS</span>
        </div>
        <table class="custom-table">
            <thead>
                <tr>
                    <th>Customer Name</th>
                    <th>Email Address</th>
                    <th>Completed Orders</th>
                    <th style="text-align:right;">Lifetime Spend</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($topCustomers as $tc)
                    <tr>
                        <td style="font-weight:800; color:#0f172a;">
                            <div style="display:flex; align-items:center; gap:10px;">
                                <div style="width:32px; height:32px; border-radius:50%; background:var(--accent-gradient); display:flex; align-items:center; justify-content:center; color:#ffffff; font-size:0.78rem; font-weight:800; box-shadow:0 2px 6px rgba(79,70,229,0.25);">
                                    {{ strtoupper(substr($tc->customer_name, 0, 1)) }}
                                </div>
                                <span>{{ $tc->customer_name }}</span>
                            </div>
                        </td>
                        <td style="font-family:ui-monospace,SFMono-Regular,Consolas,monospace; font-weight:650; color:#1e293b; font-size:0.88rem;">{{ $tc->customer_email }}</td>
                        <td style="font-weight:650; color:#334155;">{{ $tc->order_count }} purchases</td>
                        <td style="text-align:right; font-weight:850; color:#0f172a; font-size:1rem;">${{ number_format($tc->spend, 2) }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" style="text-align:center; padding:24px; color:#64748b;">No customer purchase history yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>


<!-- ==========================================================================
     2. OFFICIAL EXECUTIVE PRINT REPORT SHEET (RENDERED FOR PRINT & MODAL)
     ========================================================================== -->
<div class="print-report-sheet" id="officialReportSheet">
    <!-- Letterhead -->
    <div class="sheet-letterhead print-header-block">
        <div class="sheet-brand-left">
            <div class="sheet-logo-badge">🧵</div>
            <div class="sheet-brand-title">
                <h1>THREADCRAFT STORE STUDIO</h1>
                <p>Architectural Apparel Atelier • Performance & Revenue Audit</p>
                <div style="font-size:0.72rem; color:#64748b; margin-top:3px;">
                    Studio 4A, Phnom Penh, Cambodia • internal-audit@threadcraft.store
                </div>
            </div>
        </div>

        <div class="sheet-meta-right">
            <div><span class="sheet-audit-badge">OFFICIAL FINANCIAL AUDIT</span></div>
            <div><strong>Audit Ref:</strong> TC-REP-{{ date('Ymd') }}-{{ strtoupper(substr(md5($totalRevenue . $totalOrders), 0, 6)) }}</div>
            <div><strong>Generated:</strong> {{ now()->format('M d, Y • h:i A') }}</div>
            <div><strong>Auditor:</strong> {{ Auth::user()->name ?? 'Administrator' }} (Store Director)</div>
            <div><strong>Scope:</strong> All-Time Store Operations</div>
        </div>
    </div>

    <!-- Executive Metrics Strip -->
    <div class="sheet-metrics-row print-card-break-avoid">
        <div class="sheet-metric-box revenue-box">
            <div class="sheet-metric-label">Gross Revenue</div>
            <div class="sheet-metric-val">${{ number_format($totalRevenue, 2) }}</div>
            <div class="sheet-metric-note">100% verified sales volume</div>
        </div>

        <div class="sheet-metric-box aov-box">
            <div class="sheet-metric-label">Average Order Value</div>
            <div class="sheet-metric-val">${{ number_format($averageOrderValue, 2) }}</div>
            <div class="sheet-metric-note">Mean basket size per checkout</div>
        </div>

        <div class="sheet-metric-box units-box">
            <div class="sheet-metric-label">Total Units Fulfilled</div>
            <div class="sheet-metric-val">{{ number_format($totalUnitsSold ?? 0) }} pcs</div>
            <div class="sheet-metric-note">Physical apparel items shipped</div>
        </div>

        <div class="sheet-metric-box">
            <div class="sheet-metric-label">Active Customer Accounts</div>
            <div class="sheet-metric-val">{{ number_format($totalCustomers) }} buyers</div>
            <div class="sheet-metric-note">{{ $totalOrders }} lifetime orders recorded</div>
        </div>
    </div>

    <!-- Two-Column Data Section: Products & Status -->
    <div class="sheet-tables-row print-card-break-avoid">
        <!-- Top Products Table -->
        <div>
            <div class="sheet-section-title">
                <span>Top Selling Designs & Products</span>
                <span>By Gross Revenue</span>
            </div>
            <table class="sheet-table">
                <thead>
                    <tr>
                        <th style="width:30px;">#</th>
                        <th>Product Title</th>
                        <th style="text-align:center;">Units</th>
                        <th style="text-align:right;">Total Revenue</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($topProducts as $index => $tp)
                        <tr>
                            <td style="font-weight:750; color:#64748b;">{{ $index + 1 }}</td>
                            <td style="font-weight:750; color:#0f172a;">{{ $tp->product_name }}</td>
                            <td style="text-align:center;">{{ $tp->total_qty }} pcs</td>
                            <td style="text-align:right; font-weight:800; color:#16a34a;">${{ number_format($tp->total_revenue, 2) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" style="text-align:center; color:#64748b;">No product sales records.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Order Fulfillment Status Table -->
        <div>
            <div class="sheet-section-title">
                <span>Pipeline Breakdown</span>
                <span>{{ $totalOrders }} Total Orders</span>
            </div>
            <table class="sheet-table">
                <thead>
                    <tr>
                        <th>Status Stage</th>
                        <th style="text-align:center;">Orders</th>
                        <th style="text-align:right;">Stage Value</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($ordersByStatus as $obs)
                        @php
                            $st = strtolower($obs->status);
                            $badgeStyle = 'sheet-badge-blue';
                            if(in_array($st, ['delivered', 'completed', 'paid'])) $badgeStyle = 'sheet-badge-green';
                            elseif(in_array($st, ['processing', 'pending'])) $badgeStyle = 'sheet-badge-amber';
                            elseif(in_array($st, ['cancelled', 'failed', 'refunded'])) $badgeStyle = 'sheet-badge-red';
                        @endphp
                        <tr>
                            <td>
                                <span class="sheet-badge {{ $badgeStyle }}">{{ strtoupper($obs->status) }}</span>
                            </td>
                            <td style="text-align:center; font-weight:600;">{{ $obs->count }}</td>
                            <td style="text-align:right; font-weight:750; color:#0f172a;">${{ number_format($obs->revenue, 2) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" style="text-align:center; color:#64748b;">No pipeline records.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- VIP Customers Table -->
    <div class="print-table-wrap print-card-break-avoid">
        <div class="sheet-section-title">
            <span>High Lifetime Value (LTV) Customer Accounts</span>
            <span>Top Registered Buyers</span>
        </div>
        <table class="sheet-table">
            <thead>
                <tr>
                    <th style="width:30px;">#</th>
                    <th>Customer Name</th>
                    <th>Account Email</th>
                    <th style="text-align:center;">Completed Checkouts</th>
                    <th style="text-align:right;">Lifetime Spend</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($topCustomers as $index => $tc)
                    <tr>
                        <td style="font-weight:750; color:#64748b;">{{ $index + 1 }}</td>
                        <td style="font-weight:750; color:#0f172a;">{{ $tc->customer_name }}</td>
                        <td>{{ $tc->customer_email }}</td>
                        <td style="text-align:center; font-weight:600;">{{ $tc->order_count }} purchases</td>
                        <td style="text-align:right; font-weight:800; color:#16a34a;">${{ number_format($tc->spend, 2) }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="text-align:center; color:#64748b;">No customer transactions recorded.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Executive Observation Notes -->
    <div class="sheet-notes-card print-card-break-avoid">
        <strong>Audit Observations & Operational Summary:</strong>
        <div>• Store operations have achieved a cumulative gross revenue throughput of <strong>${{ number_format($totalRevenue, 2) }}</strong> across <strong>{{ $totalOrders }}</strong> customer transactions.</div>
        <div>• Average basket size stands at <strong>${{ number_format($averageOrderValue, 2) }}</strong> with <strong>{{ number_format($totalUnitsSold) }}</strong> total physical garments fulfilled to date.</div>
        <div>• Financial ledger reflects verified transaction settlement records extracted directly from the THREADCRAFT relational database.</div>
    </div>

    <!-- Sign-off & Verification Block -->
    <div class="sheet-signatures-grid print-sign-block">
        <div class="sign-box">
            <div class="sign-label">Prepared & Exported By</div>
            <div class="sign-line"></div>
            <div class="sign-name">{{ Auth::user()->name ?? 'Store Administrator' }}</div>
            <div style="font-size:0.68rem; color:#64748b;">Store Manager / Lead Auditor</div>
        </div>

        <div class="sign-box">
            <div class="sign-label">Audited & Approved By</div>
            <div class="sign-line"></div>
            <div class="sign-name">Chief Financial Officer</div>
            <div style="font-size:0.68rem; color:#64748b;">Executive Leadership Review</div>
        </div>

        <div class="stamp-box">
            <div style="font-size:1.1rem; margin-bottom:2px;">🛡️</div>
            <div>THREADCRAFT APPAREL</div>
            <div style="font-size:0.6rem; color:#94a3b8;">VERIFIED AUDIT RECORD</div>
        </div>
    </div>

    <!-- Document Footer -->
    <div class="sheet-footer-legal">
        CONFIDENTIAL & PROPRIETARY — FOR INTERNAL AUDIT AND MANAGEMENT DIRECTIVES ONLY.<br>
        THREADCRAFT STUDIO • PHNOM PENH, CAMBODIA • REPORT GENERATED VIA CERTIFIED ADMIN CONSOLE • PAGE 1 OF 1
    </div>
</div>


<!-- ==========================================================================
     3. PRINT PREVIEW MODAL (ON-SCREEN INTERACTIVE PREVIEW)
     ========================================================================== -->
<div class="print-modal-backdrop" id="printPreviewModal" onclick="handleBackdropClick(event);">
    <div class="print-modal-box">
        <div class="print-modal-toolbar">
            <div style="display:flex; align-items:center; gap:10px;">
                <span style="font-size:1.2rem;">📄</span>
                <div>
                    <h4 style="font-size:0.95rem; font-weight:800; margin:0;">Print / PDF Document Preview</h4>
                    <span style="font-size:0.75rem; color:#94a3b8;">Format: Standard A4 Portrait • Executive Financial Report</span>
                </div>
            </div>

            <div style="display:flex; align-items:center; gap:10px;">
                <button type="button" class="btn-print-primary" onclick="window.print();" style="padding:8px 16px; font-size:0.85rem;">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="6 9 6 2 18 2 18 9"></polyline><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path><rect x="6" y="14" width="12" height="8"></rect></svg>
                    <span>Print Document Now</span>
                </button>
                <button type="button" class="btn-action-outline" onclick="closePrintPreview();" style="padding:8px 14px; font-size:0.85rem; color:#ffffff;">
                    ✕ Close
                </button>
            </div>
        </div>

        <div id="modalPrintSheetContent">
            <!-- Sheet content is mirrored dynamically here when preview opens -->
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    // 1. OPEN PRINT PREVIEW MODAL
    function openPrintPreview() {
        const sheet = document.getElementById('officialReportSheet');
        const modalTarget = document.getElementById('modalPrintSheetContent');
        if (sheet && modalTarget) {
            modalTarget.innerHTML = sheet.outerHTML;
            // Ensure mirrored sheet is visible in modal
            const childSheet = modalTarget.querySelector('.print-report-sheet');
            if (childSheet) childSheet.style.display = 'block';
        }
        const modal = document.getElementById('printPreviewModal');
        if (modal) modal.classList.add('is-open');
    }

    // 2. CLOSE PRINT PREVIEW MODAL
    function closePrintPreview() {
        const modal = document.getElementById('printPreviewModal');
        if (modal) modal.classList.remove('is-open');
    }

    function handleBackdropClick(e) {
        if (e.target.id === 'printPreviewModal') {
            closePrintPreview();
        }
    }

    // 3. EXPORT CLEAN CSV DATA (CLIENT-SIDE ONE-CLICK DOWNLOAD)
    function exportReportToCSV() {
        const rows = [
            ["THREADCRAFT APPAREL STUDIO — OFFICIAL PERFORMANCE & REVENUE AUDIT"],
            ["Audit Reference", "TC-REP-{{ date('Ymd') }}-{{ strtoupper(substr(md5($totalRevenue . $totalOrders), 0, 6)) }}"],
            ["Generated At", "{{ now()->format('Y-m-d H:i:s') }}"],
            ["Auditor", "{{ Auth::user()->name ?? 'Administrator' }}"],
            [""],
            ["EXECUTIVE FINANCIAL SUMMARY"],
            ["Gross Revenue ($)", "{{ number_format($totalRevenue, 2, '.', '') }}"],
            ["Average Order Value ($)", "{{ number_format($averageOrderValue, 2, '.', '') }}"],
            ["Total Units Sold (pcs)", "{{ $totalUnitsSold ?? 0 }}"],
            ["Total Orders", "{{ $totalOrders }}"],
            ["Total Customer Base", "{{ $totalCustomers }}"],
            [""],
            ["TOP PERFORMING PRODUCTS"],
            ["Rank", "Product Name", "Units Sold", "Gross Revenue ($)"],
            @foreach ($topProducts as $idx => $tp)
            ["{{ $idx + 1 }}", "{{ addslashes($tp->product_name) }}", "{{ $tp->total_qty }}", "{{ number_format($tp->total_revenue, 2, '.', '') }}"],
            @endforeach
            [""],
            ["ORDER PIPELINE BY STATUS"],
            ["Status Stage", "Order Volume", "Valuation ($)"],
            @foreach ($ordersByStatus as $obs)
            ["{{ strtoupper($obs->status) }}", "{{ $obs->count }}", "{{ number_format($obs->revenue, 2, '.', '') }}"],
            @endforeach
            [""],
            ["VIP CUSTOMERS BY LIFETIME SPEND"],
            ["Rank", "Customer Name", "Customer Email", "Completed Orders", "Lifetime Spend ($)"],
            @foreach ($topCustomers as $idx => $tc)
            ["{{ $idx + 1 }}", "{{ addslashes($tc->customer_name) }}", "{{ addslashes($tc->customer_email) }}", "{{ $tc->order_count }}", "{{ number_format($tc->spend, 2, '.', '') }}"],
            @endforeach
        ];

        let csvContent = "data:text/csv;charset=utf-8," 
            + rows.map(e => e.map(item => `"${(item || '').toString().replace(/"/g, '""')}"`).join(",")).join("\n");

        const encodedUri = encodeURI(csvContent);
        const link = document.createElement("a");
        link.setAttribute("href", encodedUri);
        link.setAttribute("download", "threadcraft_store_audit_{{ date('Y-m-d') }}.csv");
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    }
</script>
@endsection
