<!DOCTYPE html>
<html lang="km">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>INVOICE #{{ $order->order_number }} — {{ $storeInfo['name'] }}</title>
    
    <!-- Google Fonts: Plus Jakarta Sans for crisp English typography, Kantumruy Pro for Khmer -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&family=Kantumruy+Pro:wght@400;500;600;700;800&family=JetBrains+Mono:wght@500;700;800&display=swap" rel="stylesheet">
    
    <!-- html2pdf.js for client-side pixel-perfect PDF export -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    
    <style>
        :root {
            --brand-violet: #5444a5;
            --brand-violet-dark: #43338e;
            --brand-violet-light: #ece9fb;
            --text-dark: #111827;
            --text-muted: #64748b;
            --border-light: #e2e8f0;
            --row-border: #111827;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Plus Jakarta Sans', 'Kantumruy Pro', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: #0f172a;
            color: var(--text-dark);
            min-height: 100vh;
            padding-bottom: 60px;
            -webkit-font-smoothing: antialiased;
        }

        /* ==========================================================================
           1. TOP SCREEN ACTION BAR (Hidden in Print & PDF)
           ========================================================================== */
        .no-print-toolbar {
            background: rgba(15, 23, 42, 0.95);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.12);
            position: sticky;
            top: 0;
            z-index: 1000;
            padding: 12px 28px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.4);
        }

        .toolbar-info {
            display: flex;
            align-items: center;
            gap: 12px;
            color: #ffffff;
        }

        .toolbar-badge {
            background: linear-gradient(135deg, #5444a5, #7c3aed);
            color: #ffffff;
            font-size: 0.72rem;
            font-weight: 800;
            letter-spacing: 0.8px;
            padding: 4px 10px;
            border-radius: 6px;
            text-transform: uppercase;
        }

        .toolbar-title {
            font-weight: 700;
            font-size: 0.95rem;
            color: #f8fafc;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .toolbar-order-pill {
            font-family: 'JetBrains Mono', monospace;
            background: rgba(255, 255, 255, 0.1);
            color: #c4b5fd;
            padding: 2px 8px;
            border-radius: 4px;
            font-size: 0.82rem;
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
            font-size: 0.86rem;
            font-weight: 750;
            border-radius: 8px;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.2s ease;
            border: none;
        }

        .btn-print {
            background: #5444a5;
            color: #ffffff;
            box-shadow: 0 4px 12px rgba(84, 68, 165, 0.35);
        }

        .btn-print:hover {
            background: #43338e;
            transform: translateY(-1px);
        }

        .btn-pdf {
            background: #10b981;
            color: #ffffff;
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
        }

        .btn-pdf:hover {
            background: #059669;
            transform: translateY(-1px);
        }

        .btn-back {
            background: rgba(255, 255, 255, 0.12);
            color: #f1f5f9;
            border: 1px solid rgba(255, 255, 255, 0.18);
        }

        .btn-back:hover {
            background: rgba(255, 255, 255, 0.22);
            color: #ffffff;
        }

        /* ==========================================================================
           2. INVOICE A4 SHEET CONTAINER
           ========================================================================== */
        .invoice-sheet-container {
            max-width: 820px;
            margin: 35px auto 50px;
            padding: 0 15px;
        }

        .invoice-paper {
            background: #ffffff;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.45);
            border-radius: 4px;
            padding: 55px 60px 50px;
            min-height: 1060px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            position: relative;
        }

        /* ==========================================================================
           3. HEADER SECTION (Logo + Address vs INVOICE + Customer)
           ========================================================================== */
        .invoice-top-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
            margin-bottom: 35px;
        }

        /* Brand Left Column */
        .brand-col {
            display: flex;
            flex-direction: column;
        }

        .brand-logo-icon {
            margin-bottom: 8px;
            display: inline-block;
        }

        .business-title {
            font-size: 1.65rem;
            font-weight: 850;
            color: #0f172a;
            line-height: 1.15;
            margin-bottom: 24px;
            letter-spacing: -0.02em;
        }

        .office-address-block {
            line-height: 1.55;
        }

        .address-heading {
            font-size: 0.95rem;
            font-weight: 800;
            color: #0f172a;
            margin-bottom: 6px;
        }

        .address-detail {
            font-size: 0.88rem;
            color: #334155;
            font-weight: 500;
        }

        .address-phone {
            font-size: 0.88rem;
            color: #0f172a;
            font-weight: 700;
            margin-top: 10px;
        }

        /* Invoice Right Column */
        .invoice-meta-col {
            display: flex;
            flex-direction: column;
            text-align: left;
        }

        .invoice-word-title {
            font-size: 2.3rem;
            font-weight: 900;
            color: var(--brand-violet);
            letter-spacing: 0.05em;
            line-height: 1;
            margin-bottom: 6px;
        }

        .invoice-date-line {
            font-size: 1.05rem;
            font-weight: 800;
            color: #0f172a;
            margin-bottom: 26px;
        }

        .client-block {
            line-height: 1.55;
        }

        .to-label {
            font-size: 0.95rem;
            font-weight: 800;
            color: #0f172a;
            margin-bottom: 4px;
        }

        .client-name {
            font-size: 1.05rem;
            font-weight: 800;
            color: #0f172a;
            margin-bottom: 2px;
        }

        .client-address {
            font-size: 0.88rem;
            color: #334155;
            font-weight: 500;
        }

        .client-phone {
            font-size: 0.85rem;
            color: #64748b;
            font-weight: 600;
            margin-top: 4px;
        }

        /* ==========================================================================
           4. ITEMS TABLE (Solid Violet Header & Clean Row Dividers)
           ========================================================================== */
        .invoice-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }

        .invoice-table thead tr {
            background: var(--brand-violet);
            color: #ffffff;
        }

        .invoice-table thead th {
            padding: 13px 18px;
            font-size: 0.88rem;
            font-weight: 750;
            letter-spacing: 0.02em;
            border: none;
        }

        .th-desc { text-align: left; width: 48%; }
        .th-price { text-align: center; width: 18%; }
        .th-qty { text-align: center; width: 14%; }
        .th-total { text-align: right; width: 20%; }

        .invoice-table tbody tr {
            border-bottom: 1.5px solid var(--row-border);
        }

        .invoice-table tbody td {
            padding: 16px 18px;
            vertical-align: middle;
        }

        .td-desc {
            text-align: left;
        }

        .item-main-name {
            font-size: 0.95rem;
            font-weight: 800;
            color: #0f172a;
            margin-bottom: 3px;
        }

        .item-sub-desc {
            font-size: 0.76rem;
            color: #64748b;
            line-height: 1.4;
            font-weight: 500;
        }

        .td-price {
            text-align: center;
            font-size: 0.92rem;
            font-weight: 750;
            color: #0f172a;
        }

        .td-qty {
            text-align: center;
            font-size: 0.95rem;
            font-weight: 750;
            color: #0f172a;
        }

        .td-total {
            text-align: right;
            font-size: 0.95rem;
            font-weight: 850;
            color: #0f172a;
        }

        /* ==========================================================================
           5. TOTALS & NOTES SECTION
           ========================================================================== */
        .calculation-grid {
            display: grid;
            grid-template-columns: 1.1fr 1fr;
            gap: 30px;
            align-items: start;
            margin-bottom: 35px;
        }

        .notes-column {
            padding-right: 15px;
        }

        .notes-heading {
            font-size: 0.9rem;
            font-weight: 800;
            color: #0f172a;
            margin-bottom: 6px;
        }

        .notes-body {
            font-size: 0.78rem;
            color: #64748b;
            line-height: 1.6;
        }

        /* Calculations Right Column */
        .totals-column {
            display: flex;
            flex-direction: column;
        }

        .subtotal-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 0.88rem;
            font-weight: 750;
            color: #0f172a;
            padding: 4px 0;
            letter-spacing: 0.02em;
        }

        .subtotal-label {
            color: #0f172a;
            font-weight: 800;
        }

        .subtotal-value {
            font-weight: 800;
            color: #0f172a;
        }

        .total-due-banner {
            background: var(--brand-violet);
            color: #ffffff;
            padding: 14px 20px;
            margin-top: 14px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-radius: 2px;
        }

        .total-due-title {
            font-size: 1.05rem;
            font-weight: 850;
            letter-spacing: 0.05em;
        }

        .total-due-amount {
            font-size: 1.45rem;
            font-weight: 900;
            letter-spacing: -0.01em;
        }

        /* ==========================================================================
           6. THANK YOU & 3-COLUMN FOOTER
           ========================================================================== */
        .thank-you-banner {
            font-size: 1.25rem;
            font-weight: 850;
            color: var(--brand-violet);
            margin-bottom: 22px;
        }

        .footer-rule {
            width: 100%;
            height: 1.5px;
            background: var(--brand-violet);
            margin-bottom: 18px;
        }

        .footer-three-cols {
            display: grid;
            grid-template-columns: 1fr 1fr 1.2fr;
            gap: 24px;
            font-size: 0.78rem;
            color: #334155;
            line-height: 1.55;
        }

        .col-header {
            font-size: 0.85rem;
            font-weight: 850;
            color: var(--brand-violet);
            margin-bottom: 6px;
        }

        .meta-line {
            display: flex;
            gap: 6px;
            margin-bottom: 3px;
        }

        .meta-line-label {
            width: 78px;
            color: #0f172a;
            font-weight: 700;
            flex-shrink: 0;
        }

        .meta-line-sep {
            color: #64748b;
            flex-shrink: 0;
        }

        .meta-line-val {
            color: #0f172a;
            font-weight: 600;
            word-break: break-all;
        }

        .terms-note-text {
            color: #64748b;
            font-size: 0.74rem;
            line-height: 1.5;
        }

        /* ==========================================================================
           7. PRINT STYLES (Strict A4 Paper Optimization)
           ========================================================================== */
        @media print {
            body {
                background: #ffffff !important;
                padding: 0 !important;
                color: #000000 !important;
            }

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
                border-radius: 0 !important;
                padding: 24mm 20mm 20mm 20mm !important;
                min-height: auto !important;
            }

            @page {
                size: A4 portrait;
                margin: 0;
            }
        }
    </style>
</head>
<body>

    <!-- 1. Floating Top Navigation Toolbar (Screen Only) -->
    <div class="no-print-toolbar">
        <div class="toolbar-info">
            <span class="toolbar-badge">TAX INVOICE</span>
            <div class="toolbar-title">
                <span>📄</span>
                <span>Customer Invoice</span>
                <span class="toolbar-order-pill">#{{ $order->order_number }}</span>
            </div>
        </div>
        <div class="toolbar-actions">
            <button type="button" id="btnDownloadPdf" onclick="downloadInvoicePDF()" class="btn-action btn-pdf">
                <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                <span>📥 Download PDF</span>
            </button>
            <button type="button" onclick="window.print()" class="btn-action btn-print">
                <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="6 9 6 2 18 2 18 9"></polyline><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path><rect x="6" y="14" width="12" height="8"></rect></svg>
                <span>🖨️ Print Invoice</span>
            </button>
            <a href="javascript:history.back()" class="btn-action btn-back">
                <span>← Back</span>
            </a>
        </div>
    </div>

    @php
        // Standard Tax Calculation
        $appliedTaxRate = (isset($taxRate) && floatval($taxRate) > 0) ? floatval($taxRate) : 10.00;
        $subtotal = floatval($order->subtotal);
        $discount = floatval($order->discount);
        $shippingFee = floatval($order->shipping_fee);
        $totalCharged = floatval($order->total);

        // Tax calculation
        $taxAmount = round($subtotal * ($appliedTaxRate / 100), 2);
    @endphp

    <!-- 2. Printable Paper Sheet -->
    <div class="invoice-sheet-container">
        <div class="invoice-paper" id="printableInvoice">
            
            <div>
                <!-- Top Section: Header -->
                <div class="invoice-top-grid">
                    <!-- Brand Column -->
                    <div class="brand-col">
                        <div class="brand-logo-icon">
                            <!-- Minimalist Violet Swirl Icon -->
                            <svg width="48" height="48" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M24 6C14.0589 6 6 14.0589 6 24C6 33.9411 14.0589 42 24 42C33.9411 42 42 33.9411 42 24" stroke="#5444a5" stroke-width="5" stroke-linecap="round"/>
                                <path d="M24 15C19.0294 15 15 19.0294 15 24C15 28.9706 19.0294 33 24 33C28.9706 33 33 28.9706 33 24C33 20.5 30.5 18 27.5 18" stroke="#5444a5" stroke-width="5" stroke-linecap="round"/>
                            </svg>
                        </div>
                        <div class="business-title">{{ $storeInfo['name'] }}.</div>

                        <div class="office-address-block">
                            <div class="address-heading">Office Address</div>
                            <div class="address-detail">{{ $storeInfo['address'] }}</div>
                            <div class="address-phone">{{ $storeInfo['phone'] }}</div>
                        </div>
                    </div>

                    <!-- Invoice Column -->
                    <div class="invoice-meta-col">
                        <div class="invoice-word-title">INVOICE</div>
                        <div class="invoice-date-line">{{ $order->created_at->format('F d, Y') }}</div>

                        <div class="client-block">
                            <div class="to-label">To :</div>
                            <div class="client-name">{{ $order->customer_name }}</div>
                            <div class="client-address">{{ $order->shipping_address }}</div>
                            <div class="client-address">{{ $order->city }}{{ $order->postal_code ? ', ' . $order->postal_code : '' }}</div>
                            @if ($order->customer_phone)
                                <div class="client-phone">Tel: {{ $order->customer_phone }}</div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Items Table -->
                <table class="invoice-table">
                    <thead>
                        <tr>
                            <th class="th-desc">Items Description</th>
                            <th class="th-price">Unit Price</th>
                            <th class="th-qty">Qnt</th>
                            <th class="th-total">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($order->items as $item)
                            <tr>
                                <td class="td-desc">
                                    <div class="item-main-name">{{ $item->product_name }}</div>
                                    <div class="item-sub-desc">
                                        @if($item->size) Size: {{ $item->size }} &bull; @endif
                                        @if($item->color) Color: {{ $item->color }} &bull; @endif
                                        Premium 100% Cotton Streetwear
                                    </div>
                                </td>
                                <td class="td-price">$ {{ number_format($item->price, 2) }}</td>
                                <td class="td-qty">{{ $item->quantity }}</td>
                                <td class="td-total">$ {{ number_format($item->price * $item->quantity, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Calculation Grid -->
                <div class="calculation-grid">
                    <!-- Note Column -->
                    <div class="notes-column">
                        <div class="notes-heading">Note:</div>
                        <div class="notes-body">
                            {{ $order->notes ?: 'Thank you for your order! All items have been carefully inspected prior to dispatch. For any inquiries or exchanges within 14 days, please present this invoice with tags attached.' }}
                        </div>
                    </div>

                    <!-- Totals Column -->
                    <div class="totals-column">
                        <div class="subtotal-row">
                            <span class="subtotal-label">SUBTOTAL :</span>
                            <span class="subtotal-value">$ {{ number_format($order->subtotal, 2) }}</span>
                        </div>

                        @if ($taxRate > 0)
                            <div class="subtotal-row">
                                <span class="subtotal-label">Tax VAT {{ number_format($taxRate, 0) }}% :</span>
                                <span class="subtotal-value">$ {{ number_format($taxAmount, 2) }}</span>
                            </div>
                        @endif

                        @if ($order->discount > 0)
                            <div class="subtotal-row">
                                <span class="subtotal-label">DISCOUNT :</span>
                                <span class="subtotal-value" style="color:#10b981;">-$ {{ number_format($order->discount, 2) }}</span>
                            </div>
                        @endif

                        @if ($order->shipping_fee > 0)
                            <div class="subtotal-row">
                                <span class="subtotal-label">SHIPPING :</span>
                                <span class="subtotal-value">$ {{ number_format($order->shipping_fee, 2) }}</span>
                            </div>
                        @endif

                        <!-- Total Due Solid Banner -->
                        <div class="total-due-banner">
                            <span class="total-due-title">TOTAL DUE :</span>
                            <span class="total-due-amount">$ {{ number_format($order->total, 2) }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bottom Section: Thank You + 3 Columns -->
            <div>
                <div class="thank-you-banner">Thank you for your Business</div>
                <div class="footer-rule"></div>

                <div class="footer-three-cols">
                    <!-- Col 1: Questions -->
                    <div>
                        <div class="col-header">Questions?</div>
                        <div class="meta-line">
                            <span class="meta-line-label">Email us</span>
                            <span class="meta-line-sep">:</span>
                            <span class="meta-line-val">{{ $storeInfo['email'] }}</span>
                        </div>
                        <div class="meta-line">
                            <span class="meta-line-label">Call us</span>
                            <span class="meta-line-sep">:</span>
                            <span class="meta-line-val">{{ $storeInfo['phone'] }}</span>
                        </div>
                    </div>

                    <!-- Col 2: Payment Info -->
                    <div>
                        <div class="col-header">Payment Info :</div>
                        <div class="meta-line">
                            <span class="meta-line-label">Method</span>
                            <span class="meta-line-sep">:</span>
                            <span class="meta-line-val">{{ $order->payment_method }}</span>
                        </div>
                        <div class="meta-line">
                            <span class="meta-line-label">Status</span>
                            <span class="meta-line-sep">:</span>
                            <span class="meta-line-val">{{ in_array($order->status, ['Delivered', 'Processing', 'Shipped']) || $order->payment_method === 'Credit Card' ? 'Verified / Paid' : 'Pending Verification' }}</span>
                        </div>
                        <div class="meta-line">
                            <span class="meta-line-label">Invoice Ref</span>
                            <span class="meta-line-sep">:</span>
                            <span class="meta-line-val">{{ $order->order_number }}</span>
                        </div>
                    </div>

                    <!-- Col 3: Terms -->
                    <div>
                        <div class="col-header">Terms & Conditions/Note:</div>
                        <div class="terms-note-text">
                            All items are thoroughly inspected prior to dispatch. Exchanges accepted within 14 days with original packaging and receipt.
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Client-Side PDF Generation Script -->
    <script>
        function downloadInvoicePDF() {
            const btn = document.getElementById('btnDownloadPdf');
            const origHtml = btn ? btn.innerHTML : '';
            if (btn) {
                btn.innerHTML = '<span>⏳</span> <span>Generating PDF...</span>';
                btn.disabled = true;
            }

            const element = document.getElementById('printableInvoice');
            if (!element) {
                window.print();
                return;
            }

            const opt = {
                margin:       [8, 8, 8, 8],
                filename:     'Invoice-{{ $order->order_number }}.pdf',
                image:        { type: 'jpeg', quality: 0.98 },
                html2canvas:  { 
                    scale: 2, 
                    useCORS: true, 
                    letterRendering: true,
                    logging: false,
                    windowWidth: 1000
                },
                jsPDF:        { unit: 'mm', format: 'a4', orientation: 'portrait' },
                pagebreak:    { mode: ['avoid-all', 'css', 'legacy'] }
            };

            if (typeof html2pdf !== 'undefined') {
                html2pdf().set(opt).from(element).save().then(() => {
                    if (btn) {
                        btn.innerHTML = '<span>✓</span> <span>Downloaded!</span>';
                        setTimeout(() => {
                            btn.innerHTML = origHtml;
                            btn.disabled = false;
                        }, 2500);
                    }
                }).catch(err => {
                    console.error('PDF Generation Error:', err);
                    window.print();
                    if (btn) {
                        btn.innerHTML = origHtml;
                        btn.disabled = false;
                    }
                });
            } else {
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
                setTimeout(function() {
                    downloadInvoicePDF();
                }, 700);
            }
        });
    </script>
</body>
</html>
