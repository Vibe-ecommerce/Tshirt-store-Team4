<!DOCTYPE html>
<html lang="km">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>វិក្កយបត្រពន្ធ (Tax Invoice) #{{ $order->order_number }} — {{ $storeInfo['name'] }}</title>
    
    <!-- Google Fonts: Plus Jakarta Sans for crisp English typography, Kantumruy Pro for beautiful modern Khmer -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&family=Kantumruy+Pro:wght@400;500;600;700;800&family=JetBrains+Mono:wght@500;700;800&display=swap" rel="stylesheet">
    
    <!-- html2pdf.js for client-side pixel-perfect PDF export -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    
    <style>
        :root {
            --primary: #4f46e5;
            --primary-dark: #3730a3;
            --primary-light: #eef2ff;
            --dark-navy: #0b1329;
            --slate-header: #0f172a;
            --text-main: #0f172a;
            --text-sub: #334155;
            --text-muted: #64748b;
            --border-color: #e2e8f0;
            --border-subtle: #cbd5e1;
            --bg-card: #f8fafc;
            --accent-green: #059669;
            --accent-gold: #b45309;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Plus Jakarta Sans', 'Kantumruy Pro', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: #090e17;
            background-image: 
                radial-gradient(at 0% 0%, rgba(79, 70, 229, 0.15) 0px, transparent 50%),
                radial-gradient(at 100% 0%, rgba(14, 165, 233, 0.12) 0px, transparent 50%),
                radial-gradient(at 50% 100%, rgba(99, 102, 241, 0.1) 0px, transparent 50%);
            color: var(--text-main);
            min-height: 100vh;
            padding-bottom: 70px;
            -webkit-font-smoothing: antialiased;
        }

        /* ==========================================================================
           1. TOP ACTION BAR (Screen Only)
           ========================================================================== */
        .no-print-toolbar {
            background: rgba(11, 19, 41, 0.92);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.12);
            position: sticky;
            top: 0;
            z-index: 1000;
            padding: 12px 28px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
        }

        .toolbar-info {
            display: flex;
            align-items: center;
            gap: 14px;
            color: #ffffff;
        }

        .toolbar-badge {
            background: linear-gradient(135deg, #4f46e5, #6366f1);
            color: #ffffff;
            font-size: 0.72rem;
            font-weight: 800;
            letter-spacing: 0.8px;
            padding: 4px 10px;
            border-radius: 6px;
            text-transform: uppercase;
            box-shadow: 0 2px 8px rgba(79, 70, 229, 0.4);
        }

        .toolbar-title {
            font-weight: 700;
            font-size: 0.95rem;
            color: #f1f5f9;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .toolbar-order-pill {
            font-family: 'JetBrains Mono', monospace;
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.16);
            color: #38bdf8;
            padding: 3px 9px;
            border-radius: 6px;
            font-size: 0.82rem;
            font-weight: 700;
        }

        .toolbar-actions {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .btn-action {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 9px 18px;
            border-radius: 8px;
            font-size: 0.88rem;
            font-weight: 700;
            cursor: pointer;
            border: none;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            text-decoration: none;
        }

        .btn-print {
            background: linear-gradient(135deg, #4f46e5 0%, #6366f1 100%);
            color: #ffffff;
            box-shadow: 0 4px 16px rgba(79, 70, 229, 0.45);
        }

        .btn-print:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(79, 70, 229, 0.6);
            background: linear-gradient(135deg, #4338ca 0%, #4f46e5 100%);
        }

        .btn-pdf {
            background: linear-gradient(135deg, #059669 0%, #10b981 100%);
            color: #ffffff;
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 4px 16px rgba(16, 185, 129, 0.4);
        }

        .btn-pdf:hover {
            background: linear-gradient(135deg, #047857 0%, #059669 100%);
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(16, 185, 129, 0.55);
            color: #ffffff;
        }

        .btn-pdf:disabled {
            opacity: 0.7;
            cursor: not-allowed;
            transform: none !important;
        }

        @keyframes spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        .spin-icon {
            animation: spin 0.8s linear infinite;
        }

        .btn-back {
            background: rgba(255, 255, 255, 0.08);
            color: #cbd5e1;
            border: 1px solid rgba(255, 255, 255, 0.15);
        }

        .btn-back:hover {
            background: rgba(255, 255, 255, 0.16);
            color: #ffffff;
        }

        /* ==========================================================================
           2. INVOICE PAPER CONTAINER (Screen & Print Base)
           ========================================================================== */
        .invoice-sheet-container {
            max-width: 880px;
            margin: 36px auto 0;
            padding: 0 16px;
        }

        .invoice-paper {
            background: #ffffff;
            border-radius: 14px;
            padding: 44px 50px;
            box-shadow: 0 30px 80px rgba(0, 0, 0, 0.55), 0 0 0 1px rgba(0, 0, 0, 0.08);
            position: relative;
            border: 1px solid #cbd5e1;
            overflow: hidden;
        }

        /* High-End Dual Accent Line */
        .paper-top-accent {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 6px;
            background: linear-gradient(90deg, #1e1b4b 0%, #4f46e5 35%, #06b6d4 70%, #f59e0b 100%);
        }

        /* ==========================================================================
           3. BRAND & INVOICE HEADER
           ========================================================================== */
        .invoice-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            padding-bottom: 24px;
            border-bottom: 2px solid #e2e8f0;
            margin-bottom: 24px;
            gap: 24px;
        }

        .brand-section {
            flex: 1.2;
        }

        .brand-logo-badge {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 10px;
        }

        .brand-icon-box {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            background: linear-gradient(135deg, #0b1329 0%, #1e1b4b 50%, #312e81 100%);
            color: #ffffff;
            font-weight: 900;
            font-size: 1.25rem;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 6px 18px rgba(30, 27, 75, 0.35);
            border: 1.5px solid rgba(255, 255, 255, 0.15);
            letter-spacing: -0.5px;
        }

        .brand-name-wrap {
            line-height: 1.2;
        }

        .brand-khmer-title {
            font-size: 1rem;
            font-weight: 800;
            color: #0f172a;
            letter-spacing: -0.3px;
        }

        .brand-english-title {
            font-size: 0.85rem;
            font-weight: 800;
            color: #4f46e5;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        .store-legal-details {
            font-size: 0.82rem;
            color: #475569;
            line-height: 1.55;
            margin-top: 8px;
        }

        .vat-number-pill {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: #f1f5f9;
            border: 1px solid #cbd5e1;
            padding: 4px 12px;
            border-radius: 6px;
            font-size: 0.8rem;
            font-weight: 700;
            color: #0f172a;
            margin-top: 10px;
        }

        .vat-number-pill strong {
            color: #1e1b4b;
            font-family: 'JetBrains Mono', monospace;
            font-size: 0.85rem;
        }

        /* Right Meta Header */
        .invoice-meta-section {
            flex: 0.9;
            text-align: right;
            display: flex;
            flex-direction: column;
            align-items: flex-end;
        }

        .invoice-main-title {
            font-size: 1.85rem;
            font-weight: 900;
            color: #0b1329;
            letter-spacing: -0.5px;
            text-transform: uppercase;
            line-height: 1.1;
        }

        .invoice-title-khmer {
            font-size: 1.05rem;
            font-weight: 800;
            color: #4f46e5;
            margin-top: 2px;
        }

        .invoice-sub-badge {
            font-size: 0.72rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            color: #64748b;
            margin-top: 4px;
        }

        /* Realistic Rubber Seal Stamp */
        .rubber-stamp {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 14px;
            border-radius: 8px;
            font-size: 0.82rem;
            font-weight: 900;
            letter-spacing: 0.8px;
            text-transform: uppercase;
            margin-top: 12px;
            transform: rotate(-3deg);
            user-select: none;
        }

        .stamp-paid {
            border: 2.5px solid #16a34a;
            color: #15803d;
            background: rgba(22, 163, 74, 0.07);
            box-shadow: 0 0 14px rgba(22, 163, 74, 0.15);
        }

        .stamp-pending {
            border: 2.5px solid #f59e0b;
            color: #b45309;
            background: rgba(245, 158, 11, 0.08);
        }

        /* ==========================================================================
           4. BILLED TO & ORDER SPECIFICATION (2-Card Symmetrical Grid)
           ========================================================================== */
        .cards-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 18px;
            margin-bottom: 24px;
        }

        .meta-card {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 18px 20px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .meta-card-header {
            font-size: 0.74rem;
            text-transform: uppercase;
            letter-spacing: 0.6px;
            font-weight: 800;
            color: #475569;
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            border-bottom: 1px solid #e2e8f0;
            padding-bottom: 8px;
        }

        .customer-name-heading {
            font-size: 1.15rem;
            font-weight: 800;
            color: #0b1329;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .card-row {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            font-size: 0.86rem;
            color: #334155;
            margin-bottom: 6px;
            line-height: 1.5;
        }

        .card-row-icon {
            font-size: 0.95rem;
            width: 18px;
            flex-shrink: 0;
            text-align: center;
            color: #64748b;
        }

        .kv-table {
            width: 100%;
            font-size: 0.85rem;
            border-collapse: collapse;
        }

        .kv-table td {
            padding: 4px 0;
            vertical-align: middle;
        }

        .kv-label {
            color: #64748b;
            font-weight: 600;
            width: 50%;
            white-space: nowrap;
        }

        .kv-value {
            color: #0f172a;
            font-weight: 700;
            text-align: right;
            white-space: nowrap;
        }

        .mono-value {
            font-family: 'JetBrains Mono', monospace;
            font-weight: 800;
            color: #4f46e5;
        }

        /* ==========================================================================
           5. PRODUCT ITEMS TABLE
           ========================================================================== */
        .items-card {
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            overflow: hidden;
            margin-bottom: 24px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.02);
        }

        .items-table {
            width: 100%;
            border-collapse: collapse;
        }

        .items-table th {
            background: #0b1329;
            color: #ffffff;
            font-size: 0.78rem;
            text-transform: uppercase;
            letter-spacing: 0.6px;
            font-weight: 800;
            padding: 13px 16px;
            text-align: left;
        }

        .items-table td {
            padding: 14px 16px;
            border-bottom: 1px solid #f1f5f9;
            font-size: 0.88rem;
            vertical-align: middle;
        }

        .items-table tbody tr:last-child td {
            border-bottom: none;
        }

        .items-table tbody tr:nth-child(even) {
            background: #fbfcfe;
        }

        .item-info-flex {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .item-thumb {
            width: 46px;
            height: 46px;
            border-radius: 8px;
            object-fit: cover;
            border: 1px solid #e2e8f0;
            background: #f8fafc;
            flex-shrink: 0;
        }

        .item-title {
            font-weight: 800;
            color: #0b1329;
            font-size: 0.94rem;
            line-height: 1.3;
        }

        .item-sub {
            font-size: 0.78rem;
            color: #64748b;
            margin-top: 3px;
        }

        .size-tag {
            background: #eef2ff;
            color: #4338ca;
            border: 1px solid #c7d2fe;
            padding: 3px 10px;
            border-radius: 6px;
            font-weight: 800;
            font-size: 0.8rem;
            display: inline-block;
        }

        /* ==========================================================================
           6. FINANCIAL BREAKDOWN & OFFICIAL TAX CALCULATION
           ========================================================================== */
        .finance-section {
            display: grid;
            grid-template-columns: 1.15fr 0.95fr;
            gap: 22px;
            margin-bottom: 24px;
            align-items: start;
        }

        /* Left Side: Tax Certification & Security Box */
        .tax-compliance-box {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 18px 20px;
            font-size: 0.83rem;
            color: #475569;
            line-height: 1.6;
        }

        .tax-compliance-title {
            font-weight: 800;
            color: #0b1329;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 0.88rem;
            border-bottom: 1px solid #e2e8f0;
            padding-bottom: 8px;
        }

        .tax-meta-grid {
            margin-top: 10px;
            display: grid;
            grid-template-columns: 1fr;
            gap: 6px;
            font-size: 0.8rem;
        }

        .tax-meta-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 4px 0;
            border-bottom: 1px dashed #e2e8f0;
        }

        .tax-meta-item:last-child {
            border-bottom: none;
        }

        /* Right Side: Totals Calculation Card */
        .calculation-card {
            background: #ffffff;
            border: 1.5px solid #e2e8f0;
            border-radius: 12px;
            padding: 18px 22px;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.03);
        }

        .calc-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 0.9rem;
            padding: 6px 0;
            color: #475569;
        }

        .calc-row strong {
            color: #0b1329;
            font-weight: 700;
        }

        /* PROMINENT TAX HIGHLIGHT ROW */
        .tax-highlight-row {
            background: linear-gradient(135deg, rgba(79, 70, 229, 0.08) 0%, rgba(99, 102, 241, 0.12) 100%);
            margin: 6px -12px;
            padding: 10px 14px;
            border-radius: 8px;
            border-left: 4px solid #4f46e5;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .tax-highlight-title {
            font-weight: 800;
            color: #312e81;
            font-size: 0.88rem;
            display: flex;
            flex-direction: column;
            gap: 2px;
        }

        .tax-highlight-amount {
            font-family: 'JetBrains Mono', monospace;
            font-size: 1.05rem;
            font-weight: 800;
            color: #312e81;
            text-align: right;
        }

        /* GRAND TOTAL SECTION */
        .grand-total-block {
            margin-top: 12px;
            padding-top: 14px;
            border-top: 2px solid #0b1329;
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
        }

        .grand-total-label {
            font-size: 1.05rem;
            font-weight: 900;
            color: #0b1329;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            line-height: 1.2;
            white-space: nowrap;
        }

        .grand-total-amount {
            font-size: 1.7rem;
            font-weight: 900;
            color: #0b1329;
            text-align: right;
            line-height: 1.1;
            letter-spacing: -0.5px;
        }

        .grand-total-khr {
            font-size: 0.95rem;
            font-weight: 800;
            color: #059669;
            display: block;
            margin-top: 4px;
            text-align: right;
        }

        /* ==========================================================================
           7. AUTHORIZED SIGNATURES & OFFICIAL SEALS
           ========================================================================== */
        .signatures-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 40px;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1.5px dashed #cbd5e1;
        }

        .sig-box {
            text-align: center;
        }

        .sig-placeholder-line {
            width: 78%;
            height: 48px;
            margin: 0 auto 8px;
            border-bottom: 1.5px solid #94a3b8;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .sig-badge-watermark {
            font-size: 0.74rem;
            color: #94a3b8;
            font-style: italic;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .sig-label {
            font-size: 0.85rem;
            font-weight: 800;
            color: #0b1329;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .sig-sub {
            font-size: 0.76rem;
            color: #64748b;
            margin-top: 2px;
        }

        /* ==========================================================================
           8. FOOTER & BARCODE
           ========================================================================== */
        .invoice-footer {
            margin-top: 28px;
            padding-top: 18px;
            border-top: 1px solid #e2e8f0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 0.78rem;
            color: #64748b;
            flex-wrap: wrap;
            gap: 14px;
        }

        .barcode-simulation {
            display: inline-flex;
            flex-direction: column;
            align-items: center;
        }

        .barcode-lines {
            letter-spacing: 4px;
            font-family: 'JetBrains Mono', 'Courier New', monospace;
            font-weight: 900;
            font-size: 1.25rem;
            color: #0f172a;
            user-select: none;
            line-height: 1;
        }

        /* ==========================================================================
           9. PRINT STYLES (@media print): Pure A4 perfection, no waste
           ========================================================================== */
        @media print {
            @page {
                size: A4 portrait;
                margin: 8mm 12mm;
            }

            html, body {
                background: #ffffff !important;
                color: #000000 !important;
                padding: 0 !important;
                margin: 0 !important;
                min-height: auto !important;
            }

            .no-print,
            .no-print-toolbar {
                display: none !important;
            }

            .invoice-sheet-container {
                max-width: 100% !important;
                margin: 0 !important;
                padding: 0 !important;
            }

            .invoice-paper {
                box-shadow: none !important;
                border: none !important;
                padding: 4mm 0 !important;
                border-radius: 0 !important;
            }

            .paper-top-accent {
                display: none !important;
            }

            .rubber-stamp {
                transform: rotate(-2deg) !important;
            }

            .items-table th {
                background: #0b1329 !important;
                color: #ffffff !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }

            .tax-highlight-row {
                background: #f1f5f9 !important;
                border-left: 3px solid #000000 !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }

            * {
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }

            .signatures-grid,
            .finance-section,
            .items-card {
                page-break-inside: avoid;
            }
        }
    </style>
</head>
<body>

    <!-- 1. Floating Top Navigation Toolbar (Screen Only) -->
    <div class="no-print-toolbar">
        <div class="toolbar-info">
            <span class="toolbar-badge">OFFICIAL INVOICE</span>
            <div class="toolbar-title">
                <span>📄</span>
                <span>Customer Tax Invoice & Sales Receipt</span>
                <span class="toolbar-order-pill">#{{ $order->order_number }}</span>
            </div>
        </div>
        <div class="toolbar-actions">
            <button type="button" id="btnDownloadPdf" onclick="downloadInvoicePDF()" class="btn-action btn-pdf">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                <span>📥 Download PDF (ទាញយកវិក្កយបត្រ)</span>
            </button>
            <button type="button" onclick="window.print()" class="btn-action btn-print">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="6 9 6 2 18 2 18 9"></polyline><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path><rect x="6" y="14" width="12" height="8"></rect></svg>
                <span>🖨️ Print (បោះពុម្ព)</span>
            </button>
            <a href="javascript:history.back()" class="btn-action btn-back">
                <span>← Back</span>
            </a>
        </div>
    </div>

    @php
        // Standard VAT Rate (Default 10.00% if not set or 0)
        $appliedTaxRate = (isset($taxRate) && floatval($taxRate) > 0) ? floatval($taxRate) : 10.00;
        
        $totalCharged = floatval($order->total);
        $shippingFee = floatval($order->shipping_fee);
        $discount = floatval($order->discount);
        $subtotal = floatval($order->subtotal);

        // Retail prices are VAT-Inclusive standard in Cambodia:
        // Calculate Net Taxable Base (មុនគិតពន្ធ) and VAT Amount (អាករ ១០%)
        $taxableGross = max(0, $subtotal - $discount);
        $netTaxableBase = round($taxableGross / (1 + ($appliedTaxRate / 100)), 2);
        $vatTaxAmount = round($taxableGross - $netTaxableBase, 2);

        // Official NBC Exchange Rate (1 USD = 4,100 KHR)
        $khrExchangeRate = 4100;
        $totalKHR = $totalCharged * $khrExchangeRate;
        $vatKHR = $vatTaxAmount * $khrExchangeRate;
    @endphp

    <!-- 2. Printable Paper Sheet -->
    <div class="invoice-sheet-container">
        <div class="invoice-paper" id="printableInvoice">
            <div class="paper-top-accent"></div>
            
            <!-- 3. Header Section -->
            <div class="invoice-header">
                <div class="brand-section">
                    <div class="brand-logo-badge">
                        <div class="brand-icon-box">TC</div>
                        <div class="brand-name-wrap">
                            <div class="brand-khmer-title">ក្រុមហ៊ុន ត្រេដក្រាហ្វ ស្ទ័រ (ខេមបូឌា)</div>
                            <div class="brand-english-title">{{ $storeInfo['name'] }} CO., LTD.</div>
                        </div>
                    </div>
                    <div class="store-legal-details">
                        {{ $storeInfo['tagline'] }}<br>
                        📍 {{ $storeInfo['address'] }}<br>
                        📞 {{ $storeInfo['phone'] }} &bull; ✉️ {{ $storeInfo['email'] }}
                    </div>
                    <div class="vat-number-pill">
                        <span>🏛️</span>
                        <span>លេខអត្តសញ្ញាណកម្មសារពើពន្ធ (VAT TIN): <strong>{{ $storeInfo['tax_id'] ?? 'K008-902188442' }}</strong></span>
                    </div>
                </div>

                <div class="invoice-meta-section">
                    <div class="invoice-main-title">TAX INVOICE</div>
                    <div class="invoice-title-khmer">វិក្កយបត្រពន្ធ</div>
                    <div class="invoice-sub-badge">Official Sales & VAT Receipt (ច្បាប់ដើម)</div>
                    
                    <div>
                        @if ($order->payment_method === 'Cash on Delivery' && $order->status !== 'Delivered')
                            <div class="rubber-stamp stamp-pending">
                                <span>⏳ PENDING COD • មិនទាន់ទូទាត់</span>
                            </div>
                        @else
                            <div class="rubber-stamp stamp-paid">
                                <span>★ OFFICIAL PAID • បានទូទាត់រួចរាល់ ★</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- 4. Customer & Order Specification Cards Grid -->
            <div class="cards-grid">
                <!-- Customer Information -->
                <div class="meta-card">
                    <div class="meta-card-header">
                        <span>BILLED & DELIVERED TO (អតិថិជន)</span>
                        <span style="color:#16a34a; font-weight:700;">✓ Verified Buyer</span>
                    </div>
                    <div class="customer-name-heading">
                        <span style="font-size:1.1rem;">👤</span>
                        <span>{{ $order->customer_name }}</span>
                    </div>
                    
                    <div class="card-row">
                        <span class="card-row-icon">📞</span>
                        <span>{{ $order->customer_phone }}</span>
                    </div>
                    <div class="card-row">
                        <span class="card-row-icon">✉️</span>
                        <span>{{ $order->customer_email }}</span>
                    </div>
                    <div class="card-row">
                        <span class="card-row-icon">📍</span>
                        <span>{{ $order->shipping_address }}, {{ $order->city }} {{ $order->postal_code }}</span>
                    </div>
                    @if ($order->notes)
                        <div class="card-row" style="margin-top:6px; font-style:italic; color:#64748b;">
                            <span class="card-row-icon">📝</span>
                            <span>Instructions: {{ $order->notes }}</span>
                        </div>
                    @endif
                </div>

                <!-- Invoice & Fulfillment Details -->
                <div class="meta-card">
                    <div class="meta-card-header">
                        <span>INVOICE PARTICULARS (ព័ត៌មានវិក្កយបត្រ)</span>
                        <span style="color:#4f46e5; font-weight:800;">TAX SPEC</span>
                    </div>

                    <table class="kv-table">
                        <tr>
                            <td class="kv-label">Invoice Number:</td>
                            <td class="kv-value mono-value">INV-{{ $order->order_number }}</td>
                        </tr>
                        <tr>
                            <td class="kv-label">Issue Date (កាលបរិច្ឆេទ):</td>
                            <td class="kv-value">{{ $order->created_at->format('d M Y, h:i A') }}</td>
                        </tr>
                        <tr>
                            <td class="kv-label">Tracking Code (កូដបញ្ញើ):</td>
                            <td class="kv-value" style="font-family:'JetBrains Mono', monospace; font-size:0.82rem;">{{ $order->tracking_code }}</td>
                        </tr>
                        <tr>
                            <td class="kv-label">Delivery Service:</td>
                            <td class="kv-value">{{ $order->delivery_method }} Courier (Express Delivery)</td>
                        </tr>
                        <tr>
                            <td class="kv-label">Payment Mode:</td>
                            <td class="kv-value">
                                @if ($order->payment_method === 'QR Code')
                                    <span style="color:#059669; font-weight:800;">📱 KHQR / Bank QR Scan</span>
                                @elseif ($order->payment_method === 'Credit Card')
                                    <span>💳 Credit Card (Stripe)</span>
                                @else
                                    <span>{{ $order->payment_method }}</span>
                                @endif
                            </td>
                        </tr>
                        @if ($order->payment_reference)
                            <tr>
                                <td class="kv-label">Payment Ref #:</td>
                                <td class="kv-value" style="color:#059669; font-family:'JetBrains Mono', monospace;">{{ $order->payment_reference }}</td>
                            </tr>
                        @endif
                    </table>
                </div>
            </div>

            <!-- 5. Itemized Products Table -->
            <div class="items-card">
                <table class="items-table">
                    <thead>
                        <tr>
                            <th style="width: 44px; text-align:center;">#</th>
                            <th>Product Description (បរិយាយមុខទំនិញ)</th>
                            <th style="text-align:center; width:80px;">Size</th>
                            <th style="text-align:right; width:120px;">Unit Price (តម្លៃរាយ)</th>
                            <th style="text-align:center; width:70px;">Qty</th>
                            <th style="text-align:right; width:130px;">Amount ($)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($order->items as $idx => $item)
                            <tr>
                                <td style="text-align:center; font-weight:700; color:#64748b;">{{ $idx + 1 }}</td>
                                <td>
                                    <div class="item-info-flex">
                                        @if (!empty($item->image))
                                            <img src="{{ asset($item->image) }}" alt="" class="item-thumb">
                                        @endif
                                        <div>
                                            <div class="item-title">{{ $item->product_name }}</div>
                                            <div class="item-sub">
                                                @if (!empty($item->color))
                                                    Color: {{ $item->color }} &bull;
                                                @endif
                                                SKU: TC-{{ str_pad($item->id ?? $idx + 1, 4, '0', STR_PAD_LEFT) }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td style="text-align:center;">
                                    <span class="size-tag">{{ $item->size ?: 'L' }}</span>
                                </td>
                                <td style="text-align:right; font-weight:600; color:#334155;">
                                    ${{ number_format($item->price, 2) }}
                                </td>
                                <td style="text-align:center; font-weight:700; color:#0b1329;">
                                    {{ $item->quantity }}
                                </td>
                                <td style="text-align:right; font-weight:800; color:#0b1329;">
                                    ${{ number_format($item->price * $item->quantity, 2) }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- 6. Financial Breakdown with EXPLICIT TAX (VAT) Row -->
            <div class="finance-section">
                <!-- Compliance Specification Box -->
                <div class="tax-compliance-box">
                    <div class="tax-compliance-title">
                        <span>🏛️</span>
                        <span>TAX & STATUTORY SPECIFICATIONS (សេចក្តីបញ្ជាក់សារពើពន្ធ)</span>
                    </div>
                    <p style="font-size:0.8rem; color:#475569;">
                        This official Tax Invoice is issued by <strong>{{ $storeInfo['name'] }}</strong> in compliance with the Law on Taxation of the Kingdom of Cambodia (GDT Registered Taxpayer).
                    </p>

                    <div class="tax-meta-grid">
                        <div class="tax-meta-item">
                            <span>Tax Regime (ប្រភេទអាករ):</span>
                            <strong>Value Added Tax (VAT / អាករលើតម្លៃបន្ថែម)</strong>
                        </div>
                        <div class="tax-meta-item">
                            <span>Standard VAT Rate (អត្រាពន្ធ):</span>
                            <strong style="color:#4f46e5;">{{ number_format($appliedTaxRate, 1) }}% Applied</strong>
                        </div>
                        <div class="tax-meta-item">
                            <span>NBC Reference Exchange Rate:</span>
                            <strong>$1.00 USD = 4,100 KHR (អត្រាប្តូរប្រាក់ផ្លូវការ)</strong>
                        </div>
                        <div class="tax-meta-item">
                            <span>Tax Classification:</span>
                            <strong>Standard-Rated Taxable Supply (10%)</strong>
                        </div>
                    </div>
                </div>

                <!-- Financial Calculation Ledger Card -->
                <div class="calculation-card">
                    <div class="calc-row">
                        <span>Subtotal (តម្លៃមិនរួមពន្ធ / Net Base):</span>
                        <strong>${{ number_format($netTaxableBase, 2) }}</strong>
                    </div>

                    @if ($discount > 0)
                        <div class="calc-row" style="color:#16a34a;">
                            <span>Coupon Discount (បញ្ចុះតម្លៃ):</span>
                            <strong style="color:#16a34a;">-${{ number_format($discount, 2) }}</strong>
                        </div>
                    @endif

                    <!-- HIGH PROFILE EXPLICIT TAX / VAT ROW -->
                    <div class="tax-highlight-row">
                        <div class="tax-highlight-title">
                            <div>🏛️ Sales Tax / VAT ({{ number_format($appliedTaxRate, 1) }}%):</div>
                            <div style="font-size:0.75rem; color:#4338ca; font-weight:600;">អាករលើតម្លៃបន្ថែម (១០%)</div>
                        </div>
                        <div>
                            <div class="tax-highlight-amount">+${{ number_format($vatTaxAmount, 2) }} <span style="font-size:0.8rem;">USD</span></div>
                            <div style="font-size:0.72rem; color:#4338ca; font-weight:700; text-align:right;">≈ ៛{{ number_format($vatKHR) }} KHR</div>
                        </div>
                    </div>

                    <div class="calc-row">
                        <span>Shipping Fee (សេវាដឹកជញ្ជូន):</span>
                        <strong>{{ $shippingFee == 0 ? 'FREE ($0.00)' : '$' . number_format($shippingFee, 2) }}</strong>
                    </div>

                    <!-- Grand Total Payable -->
                    <div class="grand-total-block">
                        <div>
                            <div class="grand-total-label">TOTAL DUE <span style="font-size:0.88rem; color:#4338ca; font-weight:800; white-space:nowrap;">(សរុបត្រូវបង់)</span></div>
                            <div style="font-size:0.75rem; color:#64748b; font-weight:600; margin-top:3px;">(All Taxes & Delivery Included)</div>
                        </div>
                        <div>
                            <div class="grand-total-amount">${{ number_format($totalCharged, 2) }} <span style="font-size:1rem; font-weight:700; color:#4f46e5;">USD</span></div>
                            <span class="grand-total-khr">≈ ៛{{ number_format($totalKHR) }} KHR</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 7. Signatures Section -->
            <div class="signatures-grid">
                <div class="sig-box">
                    <div class="sig-placeholder-line">
                        <span class="sig-badge-watermark">Official Merchant Seal</span>
                    </div>
                    <div class="sig-label">Authorized Seller (ហត្ថលេខា និងត្រាអ្នកលក់)</div>
                    <div class="sig-sub">{{ $storeInfo['name'] }} Management</div>
                </div>

                <div class="sig-box">
                    <div class="sig-placeholder-line">
                        <span class="sig-badge-watermark">Customer Acknowledgment</span>
                    </div>
                    <div class="sig-label">Customer Signature (ហត្ថលេខាអ្នកទិញ)</div>
                    <div class="sig-sub">{{ $order->customer_name }}</div>
                </div>
            </div>

            <!-- 8. Footer & Barcode Simulation -->
            <div class="invoice-footer">
                <div>
                    <strong style="color:#0b1329;">Thank you for shopping with {{ $storeInfo['name'] }}!</strong><br>
                    <span>សូមអរគុណសម្រាប់ការទិញទំនិញនៅហាងយើងខ្ញុំ! Goods can be exchanged within 30 days with original tax receipt.</span>
                </div>

                <div class="barcode-simulation">
                    <div class="barcode-lines">||||| | |||| ||| |||| | |||||</div>
                    <div style="font-size:0.72rem; color:#475569; letter-spacing:1px; font-weight:800; font-family:'JetBrains Mono', monospace;">*INV-{{ $order->order_number }}*</div>
                </div>
            </div>

        </div>
    </div>

    <script>
        function downloadInvoicePDF() {
            const btn = document.getElementById('btnDownloadPdf');
            const origHtml = btn ? btn.innerHTML : '';
            if (btn) {
                btn.disabled = true;
                btn.innerHTML = `
                    <svg class="spin-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <circle cx="12" cy="12" r="10" stroke-opacity="0.25"></circle>
                        <path d="M12 2a10 10 0 0 1 10 10" stroke-linecap="round"></path>
                    </svg>
                    <span>Generating PDF... (កំពុងបង្កើត)</span>
                `;
            }

            const element = document.getElementById('printableInvoice');
            if (!element) {
                window.print();
                return;
            }

            const origBoxShadow = element.style.boxShadow;
            element.style.boxShadow = 'none';

            const opt = {
                margin:       [6, 6, 6, 6],
                filename:     'Tax-Invoice-{{ $order->order_number }}.pdf',
                image:        { type: 'jpeg', quality: 0.98 },
                html2canvas:  { 
                    scale: 2, 
                    useCORS: true, 
                    letterRendering: true,
                    logging: false,
                    windowWidth: 1100
                },
                jsPDF:        { unit: 'mm', format: 'a4', orientation: 'portrait' },
                pagebreak:    { mode: ['avoid-all', 'css', 'legacy'] }
            };

            if (typeof html2pdf !== 'undefined') {
                html2pdf().set(opt).from(element).save().then(() => {
                    element.style.boxShadow = origBoxShadow;
                    if (btn) {
                        btn.innerHTML = '<span>✓</span> <span>Downloaded! (ទាញយកជោគជ័យ)</span>';
                        setTimeout(() => {
                            btn.innerHTML = origHtml;
                            btn.disabled = false;
                        }, 2500);
                    }
                }).catch(err => {
                    console.error('PDF Generation Error:', err);
                    element.style.boxShadow = origBoxShadow;
                    window.print();
                    if (btn) {
                        btn.innerHTML = origHtml;
                        btn.disabled = false;
                    }
                });
            } else {
                element.style.boxShadow = origBoxShadow;
                window.print();
                if (btn) {
                    btn.innerHTML = origHtml;
                    btn.disabled = false;
                }
            }
        }

        // Auto-download PDF if URL contains ?download=1
        document.addEventListener('DOMContentLoaded', function() {
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.get('download') === '1') {
                // Short timeout to guarantee Google Fonts (Plus Jakarta Sans & Kantumruy Pro) finish rendering
                setTimeout(function() {
                    downloadInvoicePDF();
                }, 750);
            }
        });
    </script>
</body>
</html>
