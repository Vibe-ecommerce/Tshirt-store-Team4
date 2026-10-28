<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Sales Report: {{ $customer->name }} — {{ $storeInfo['name'] }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&family=Kantumruy+Pro:wght@400;600;700&display=swap" rel="stylesheet">
    
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Plus Jakarta Sans', 'Kantumruy Pro', sans-serif;
            background: #0b0f19;
            color: #0f172a;
            min-height: 100vh;
            padding-bottom: 60px;
        }

        .no-print-toolbar {
            background: rgba(15, 23, 42, 0.9);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            position: sticky;
            top: 0;
            z-index: 100;
            padding: 14px 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .btn-toolbar {
            padding: 9px 18px;
            border-radius: 8px;
            font-size: 0.88rem;
            font-weight: 700;
            cursor: pointer;
            border: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
        }

        .btn-print {
            background: linear-gradient(135deg, #4f46e5, #6366f1);
            color: #ffffff;
        }

        .btn-back {
            background: rgba(255, 255, 255, 0.08);
            color: #cbd5e1;
            border: 1px solid rgba(255, 255, 255, 0.15);
        }

        .statement-sheet {
            max-width: 900px;
            margin: 36px auto;
            background: #ffffff;
            border-radius: 12px;
            padding: 44px;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.5);
        }

        .header-grid {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            border-bottom: 2px solid #e2e8f0;
            padding-bottom: 20px;
            margin-bottom: 24px;
        }

        .summary-box-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 16px;
            margin-bottom: 28px;
        }

        .sum-card {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 14px;
            text-align: center;
        }

        .sum-card-label {
            font-size: 0.75rem;
            text-transform: uppercase;
            font-weight: 700;
            color: #64748b;
        }

        .sum-card-val {
            font-size: 1.4rem;
            font-weight: 800;
            color: #1e1b4b;
            margin-top: 4px;
        }

        .statement-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 28px;
        }

        .statement-table th {
            background: #f1f5f9;
            color: #475569;
            font-size: 0.78rem;
            font-weight: 800;
            text-transform: uppercase;
            padding: 10px 12px;
            border-top: 1px solid #e2e8f0;
            border-bottom: 1px solid #e2e8f0;
            text-align: left;
        }

        .statement-table td {
            padding: 12px;
            border-bottom: 1px solid #f1f5f9;
            font-size: 0.88rem;
        }

        @media print {
            @page { size: A4 portrait; margin: 10mm 12mm; }
            body { background: #ffffff !important; padding: 0 !important; }
            .no-print, .no-print-toolbar { display: none !important; }
            .statement-sheet { box-shadow: none !important; border: none !important; padding: 0 !important; }
            * { -webkit-print-color-adjust: exact !important; print-color-adjust: exact !important; }
        }
    </style>
</head>
<body>

    <div class="no-print-toolbar">
        <div style="color:#ffffff; font-weight:700;">
            📊 Customer Lifetime Sales Statement: {{ $customer->name }}
        </div>
        <div style="display:flex; gap:10px;">
            <button type="button" onclick="window.print()" class="btn-toolbar btn-print">
                🖨️ Print Statement Report
            </button>
            <a href="{{ route('admin.customers.show', $customer->id) }}" class="btn-toolbar btn-back">
                ← Back to Profile
            </a>
        </div>
    </div>

    <div class="statement-sheet">
        <div class="header-grid">
            <div>
                <h1 style="font-size:1.6rem; font-weight:900; color:#1e1b4b;">{{ $storeInfo['name'] }}</h1>
                <p style="font-size:0.85rem; color:#64748b;">
                    {{ $storeInfo['address'] }}<br>
                    Tel: {{ $storeInfo['phone'] }} | Email: {{ $storeInfo['email'] }}
                </p>
            </div>
            <div style="text-align:right;">
                <div style="font-size:1.4rem; font-weight:900; color:#0f172a; text-transform:uppercase;">CUSTOMER SALES REPORT</div>
                <div style="font-size:0.85rem; color:#6366f1; font-weight:700;">របាយការណ៍លក់ជូនអតិថិជន</div>
                <div style="font-size:0.78rem; color:#64748b; margin-top:4px;">Date: {{ now()->format('d M Y') }}</div>
            </div>
        </div>

        <!-- Customer Profile Card -->
        <div style="background:#f8fafc; border:1px solid #e2e8f0; border-radius:8px; padding:16px; margin-bottom:20px;">
            <div style="font-size:0.75rem; text-transform:uppercase; font-weight:700; color:#64748b; margin-bottom:4px;">Customer Information</div>
            <div style="font-size:1.15rem; font-weight:800; color:#0f172a;">{{ $customer->name }} (ID #{{ $customer->id }})</div>
            <div style="font-size:0.88rem; color:#475569; margin-top:4px;">
                Email: {{ $customer->email }} | Phone: {{ $customer->phone ?: 'N/A' }} | Address: {{ $customer->address ?: 'N/A' }}, {{ $customer->city ?: '' }}
            </div>
        </div>

        <!-- Summary Metrics -->
        <div class="summary-box-grid">
            <div class="sum-card">
                <div class="sum-card-label">Total Spend (ចំណូល)</div>
                <div class="sum-card-val" style="color:#16a34a;">${{ number_format($totalSpent, 2) }}</div>
            </div>
            <div class="sum-card">
                <div class="sum-card-label">Total Orders (ការកុម្ម៉ង់)</div>
                <div class="sum-card-val">{{ $orders->count() }}</div>
            </div>
            <div class="sum-card">
                <div class="sum-card-label">Items Bought (ចំនួនទំនិញ)</div>
                <div class="sum-card-val">{{ $totalItems }}</div>
            </div>
            <div class="sum-card">
                <div class="sum-card-label">Avg Order Value (មធ្យម)</div>
                <div class="sum-card-val">${{ $orders->count() > 0 ? number_format($totalSpent / $orders->count(), 2) : '0.00' }}</div>
            </div>
        </div>

        <!-- Orders Table -->
        <h3 style="font-size:1rem; font-weight:800; color:#0f172a; margin-bottom:12px;">Purchase Ledger History:</h3>
        <table class="statement-table">
            <thead>
                <tr>
                    <th>Order #</th>
                    <th>Date</th>
                    <th>Items Summary</th>
                    <th>Payment</th>
                    <th>Status</th>
                    <th style="text-align:right;">Total ($)</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($orders as $ord)
                    <tr>
                        <td>
                            <strong style="color:#0f172a;">{{ $ord->order_number }}</strong>
                        </td>
                        <td>{{ $ord->created_at->format('d/m/Y') }}</td>
                        <td>
                            <div style="font-size:0.82rem; color:#475569;">
                                @foreach ($ord->items as $it)
                                    <div>&bull; {{ $it->product_name }} ({{ $it->size ?: 'L' }} &times; {{ $it->quantity }})</div>
                                @endforeach
                            </div>
                        </td>
                        <td>{{ $ord->payment_method }}</td>
                        <td>
                            <span style="font-weight:700; font-size:0.8rem; color:{{ $ord->status === 'Delivered' ? '#16a34a' : '#4f46e5' }};">
                                {{ $ord->status }}
                            </span>
                        </td>
                        <td style="text-align:right; font-weight:800; color:#0f172a;">${{ number_format($ord->total, 2) }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="text-align:center; padding:24px; color:#64748b;">No purchase records found.</td>
                    </tr>
                @endforelse
            </tbody>
            <tfoot>
                <tr style="background:#f8fafc; font-weight:800; border-top:2px solid #e2e8f0;">
                    <td colspan="5" style="text-align:right; padding:12px; font-size:0.95rem;">LIFETIME ACCUMULATED SALES:</td>
                    <td style="text-align:right; padding:12px; font-size:1.15rem; color:#1e1b4b;">${{ number_format($totalSpent, 2) }}</td>
                </tr>
            </tfoot>
        </table>

        <!-- Signatures -->
        <div style="display:flex; justify-content:space-between; margin-top:40px; padding-top:20px; border-top:1px dashed #cbd5e1;">
            <div style="text-align:center; width:240px;">
                <div style="border-bottom:1px solid #94a3b8; height:45px; margin-bottom:8px;"></div>
                <div style="font-size:0.8rem; font-weight:700; color:#475569;">Store Representative</div>
                <div style="font-size:0.75rem; color:#64748b;">{{ $storeInfo['name'] }}</div>
            </div>

            <div style="text-align:center; width:240px;">
                <div style="border-bottom:1px solid #94a3b8; height:45px; margin-bottom:8px;"></div>
                <div style="font-size:0.8rem; font-weight:700; color:#475569;">Customer Acknowledgement</div>
                <div style="font-size:0.75rem; color:#64748b;">{{ $customer->name }}</div>
            </div>
        </div>
    </div>

</body>
</html>
