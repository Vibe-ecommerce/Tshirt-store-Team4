@extends('layouts.admin')

@section('title', 'Customer Inquiries & Messages')
@section('page-title', 'Customer Inquiries')

@section('styles')
<style>
    .inquiries-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
        flex-wrap: wrap;
        gap: 16px;
    }

    .inquiries-title-block h2 {
        font-size: 1.55rem;
        font-weight: 850;
        color: #0f172a;
        letter-spacing: -0.4px;
        margin-bottom: 4px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .inquiries-title-block p {
        color: #64748b;
        font-size: 0.9rem;
        font-weight: 500;
        margin: 0;
    }

    /* Stats Grid */
    .inquiries-stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 16px;
        margin-bottom: 24px;
    }

    .inquiry-stat-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        padding: 20px 22px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.03);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .inquiry-stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.06);
    }

    .stat-meta .stat-label {
        font-size: 0.78rem;
        font-weight: 750;
        text-transform: uppercase;
        letter-spacing: 0.6px;
        color: #64748b;
        margin-bottom: 4px;
    }

    .stat-meta .stat-value {
        font-size: 1.85rem;
        font-weight: 900;
        color: #0f172a;
        line-height: 1.1;
        letter-spacing: -0.5px;
    }

    .stat-icon-wrap {
        width: 48px;
        height: 48px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .stat-icon-wrap svg {
        width: 24px;
        height: 24px;
    }

    .stat-icon-all {
        background: #eff6ff;
        color: #2563eb;
    }

    .stat-icon-unread {
        background: #fff1f2;
        color: #e11d48;
    }

    .stat-icon-replied {
        background: #ecfdf5;
        color: #059669;
    }

    .stat-icon-telegram {
        background: #f0f9ff;
        color: #0284c7;
    }

    /* Filter & Search Bar */
    .inquiries-control-bar {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        padding: 14px 18px;
        margin-bottom: 24px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 14px;
    }

    .filter-tabs {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
    }

    .filter-tab-pill {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 7px 15px;
        border-radius: 9999px;
        font-size: 0.84rem;
        font-weight: 700;
        text-decoration: none;
        border: 1px solid #cbd5e1;
        background: #ffffff;
        color: #475569;
        transition: all 0.18s ease;
    }

    .filter-tab-pill:hover {
        background: #f8fafc;
        border-color: #94a3b8;
        color: #0f172a;
    }

    .filter-tab-pill.active {
        background: #0f172a;
        border-color: #0f172a;
        color: #ffffff;
        box-shadow: 0 4px 12px rgba(15, 23, 42, 0.2);
    }

    .filter-tab-pill .tab-count {
        background: rgba(0, 0, 0, 0.08);
        padding: 1.5px 7px;
        border-radius: 999px;
        font-size: 0.75rem;
    }

    .filter-tab-pill.active .tab-count {
        background: rgba(255, 255, 255, 0.22);
        color: #ffffff;
    }

    .search-form-wrap {
        position: relative;
        display: flex;
        align-items: center;
        min-width: 280px;
    }

    .search-form-wrap input {
        width: 100%;
        background: #f8fafc;
        border: 1px solid #cbd5e1;
        border-radius: 9999px;
        padding: 8px 36px 8px 38px;
        font-size: 0.86rem;
        font-weight: 600;
        color: #0f172a;
        outline: none;
        transition: all 0.2s ease;
    }

    .search-form-wrap input:focus {
        background: #ffffff;
        border-color: #4f46e5;
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.15);
    }

    .search-form-icon {
        position: absolute;
        left: 13px;
        color: #94a3b8;
        pointer-events: none;
        display: flex;
    }

    .search-clear-btn {
        position: absolute;
        right: 10px;
        color: #94a3b8;
        cursor: pointer;
        text-decoration: none;
        font-size: 0.8rem;
        padding: 2px 5px;
    }

    /* Messages Table Card */
    .messages-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.03);
        overflow: hidden;
    }

    .messages-table-wrap {
        width: 100%;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }

    .custom-messages-table {
        width: 100%;
        border-collapse: collapse;
        text-align: left;
    }

    .custom-messages-table th {
        background: #f8fafc;
        padding: 13px 18px;
        font-size: 0.74rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.7px;
        color: #64748b;
        border-bottom: 1px solid #e2e8f0;
        white-space: nowrap;
    }

    .custom-messages-table td {
        padding: 16px 18px;
        border-bottom: 1px solid #f1f5f9;
        vertical-align: middle;
        font-size: 0.88rem;
    }

    .custom-messages-table tr:hover {
        background: #fafbfc;
    }

    .custom-messages-table tr.is-unread {
        background: #fffbfa;
    }

    .custom-messages-table tr.is-unread:hover {
        background: #fff5f2;
    }

    /* Customer Cell */
    .sender-cell {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .sender-avatar {
        width: 40px;
        height: 40px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #ffffff;
        font-weight: 850;
        font-size: 1rem;
        flex-shrink: 0;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .sender-meta {
        line-height: 1.35;
    }

    .sender-name {
        font-weight: 800;
        color: #0f172a;
        font-size: 0.94rem;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .sender-email {
        font-size: 0.8rem;
        color: #64748b;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }

    .sender-email:hover {
        color: #4f46e5;
        text-decoration: underline;
    }

    /* Subject Badges */
    .subject-pill {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 3px 9px;
        border-radius: 8px;
        font-size: 0.76rem;
        font-weight: 800;
        letter-spacing: 0.2px;
    }

    .pill-order { background: #eff6ff; color: #1d4ed8; border: 1px solid #bfdbfe; }
    .pill-sizing { background: #f5f3ff; color: #6d28d9; border: 1px solid #ddd6fe; }
    .pill-custom { background: #ecfdf5; color: #047857; border: 1px solid #a7f3d0; }
    .pill-returns { background: #fff1f2; color: #be123c; border: 1px solid #fecdd3; }
    .pill-wholesale { background: #fffbeb; color: #b45309; border: 1px solid #fde68a; }
    .pill-default { background: #f1f5f9; color: #334155; border: 1px solid #cbd5e1; }

    /* Message Preview */
    .msg-preview-text {
        color: #334155;
        font-size: 0.86rem;
        line-height: 1.45;
        max-width: 320px;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        cursor: pointer;
    }

    .msg-preview-text:hover {
        color: #0f172a;
    }

    /* Status Pills */
    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 3px 10px;
        border-radius: 9999px;
        font-size: 0.72rem;
        font-weight: 850;
        letter-spacing: 0.4px;
        text-transform: uppercase;
    }

    .status-unread {
        background: #ffe4e6;
        color: #e11d48;
        border: 1px solid #fecdd3;
    }

    .status-read {
        background: #f1f5f9;
        color: #64748b;
        border: 1px solid #e2e8f0;
    }

    .status-replied {
        background: #ecfdf5;
        color: #047857;
        border: 1px solid #a7f3d0;
    }

    .pulse-unread-dot {
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: #e11d48;
        box-shadow: 0 0 6px rgba(225, 29, 72, 0.8);
        animation: pulse-dot 1.5s infinite ease-in-out;
    }

    /* Action Buttons */
    .actions-cluster {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 6px;
    }

    .action-icon-btn {
        width: 34px;
        height: 34px;
        border-radius: 8px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: 1px solid #cbd5e1;
        background: #ffffff;
        color: #475569;
        text-decoration: none;
        cursor: pointer;
        transition: all 0.18s ease;
    }

    .action-icon-btn:hover {
        background: #f8fafc;
        border-color: #94a3b8;
        color: #0f172a;
        transform: translateY(-1px);
    }

    .action-btn-primary {
        background: #eff6ff;
        border-color: #bfdbfe;
        color: #2563eb;
    }

    .action-btn-primary:hover {
        background: #2563eb;
        border-color: #2563eb;
        color: #ffffff;
    }

    .action-btn-reply {
        background: #f5f3ff;
        border-color: #ddd6fe;
        color: #6d28d9;
    }

    .action-btn-reply:hover {
        background: #6d28d9;
        border-color: #6d28d9;
        color: #ffffff;
    }

    .action-btn-danger:hover {
        background: #ef4444;
        border-color: #ef4444;
        color: #ffffff;
    }

    /* Modal Backdrop & Dialog */
    .message-modal-overlay {
        position: fixed;
        inset: 0;
        background: rgba(15, 23, 42, 0.6);
        backdrop-filter: blur(4px);
        z-index: 1000;
        display: none;
        align-items: center;
        justify-content: center;
        padding: 16px;
    }

    .message-modal-overlay.active {
        display: flex;
    }

    .message-modal-card {
        background: #ffffff;
        border-radius: 20px;
        max-width: 650px;
        width: 100%;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        overflow: hidden;
        border: 1px solid #e2e8f0;
        animation: modalScaleIn 0.22s cubic-bezier(0.16, 1, 0.3, 1);
    }

    @keyframes modalScaleIn {
        from { transform: scale(0.95); opacity: 0; }
        to { transform: scale(1); opacity: 1; }
    }

    .modal-head {
        padding: 18px 24px;
        background: #f8fafc;
        border-bottom: 1px solid #e2e8f0;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .modal-head h3 {
        margin: 0;
        font-size: 1.15rem;
        font-weight: 850;
        color: #0f172a;
    }

    .modal-close-x {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        border: none;
        background: #f1f5f9;
        color: #64748b;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
        transition: background 0.15s ease;
    }

    .modal-close-x:hover {
        background: #e2e8f0;
        color: #0f172a;
    }

    .modal-body {
        padding: 24px;
        max-height: 72vh;
        overflow-y: auto;
    }

    .modal-foot {
        padding: 16px 24px;
        background: #f8fafc;
        border-top: 1px solid #e2e8f0;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 10px;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .inquiries-control-bar {
            flex-direction: column;
            align-items: stretch;
        }

        .search-form-wrap {
            min-width: 100%;
        }

        .filter-tabs {
            justify-content: flex-start;
            overflow-x: auto;
            padding-bottom: 4px;
        }
    }
</style>
@endsection

@section('content')
    <!-- Header -->
    <div class="inquiries-header">
        <div class="inquiries-title-block">
            <h2>
                <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="#2563eb" stroke-width="2.3" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                </svg>
                <span>Customer Inquiries & Messages</span>
            </h2>
            <p>គ្រប់គ្រងសារ និងសំណួរដែលអតិថិជនបានផ្ញើតាមរយៈទំព័រ Contact Page • ឆ្លើយតបអតិថិជនតាម Email ផ្ទាល់</p>
        </div>

        <div style="display:flex; align-items:center; gap:10px;">
            <a href="{{ route('admin.settings.index') }}#telegram" class="btn-outline" style="font-size:0.84rem; padding:8px 14px; display:inline-flex; align-items:center; gap:6px;">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#0284c7" stroke-width="2.2"><path d="M22 2L11 13"></path><polygon points="22 2 15 22 11 13 2 9 22 2"></polygon></svg>
                <span>Telegram Bot Alerts</span>
            </a>
            <a href="{{ route('contact') }}" target="_blank" class="btn-outline" style="font-size:0.84rem; padding:8px 14px; display:inline-flex; align-items:center; gap:6px;">
                <span>View Contact Page ↗</span>
            </a>
        </div>
    </div>

    <!-- Alert Messages -->
    @if (session('success'))
        <div style="background:#ecfdf5; border:1px solid #86efac; color:#15803d; padding:12px 18px; border-radius:12px; margin-bottom:20px; font-weight:700; font-size:0.9rem; display:flex; align-items:center; gap:8px;">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <!-- Metric Stat Cards -->
    <div class="inquiries-stats-grid">
        <div class="inquiry-stat-card">
            <div class="stat-meta">
                <div class="stat-label">Total Inquiries</div>
                <div class="stat-value">{{ number_format($counts['all']) }}</div>
            </div>
            <div class="stat-icon-wrap stat-icon-all">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
            </div>
        </div>

        <div class="inquiry-stat-card">
            <div class="stat-meta">
                <div class="stat-label">Unread Messages</div>
                <div class="stat-value" style="color:#e11d48;">{{ number_format($counts['unread']) }}</div>
            </div>
            <div class="stat-icon-wrap stat-icon-unread">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
            </div>
        </div>

        <div class="inquiry-stat-card">
            <div class="stat-meta">
                <div class="stat-label">Replied to Customers</div>
                <div class="stat-value" style="color:#059669;">{{ number_format($counts['replied'] ?? 0) }}</div>
            </div>
            <div class="stat-icon-wrap stat-icon-replied">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"></polyline></svg>
            </div>
        </div>

        <div class="inquiry-stat-card">
            <div class="stat-meta">
                <div class="stat-label">Telegram Channel</div>
                <div class="stat-value" style="font-size:1.15rem; font-weight:800; color:#0284c7; margin-top:6px;">
                    @php
                        $botConfigured = !empty(\App\Models\SiteSetting::get('telegram_bot_token')) && !empty(\App\Models\SiteSetting::get('telegram_chat_id'));
                    @endphp
                    @if ($botConfigured)
                        <span style="display:inline-flex; align-items:center; gap:5px; color:#059669; font-size:0.95rem;">
                            <span class="pulse-live-dot" style="background:#10b981;"></span> Connected
                        </span>
                    @else
                        <span style="color:#94a3b8; font-size:0.95rem;">Not Configured</span>
                    @endif
                </div>
            </div>
            <div class="stat-icon-wrap stat-icon-telegram">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 2L11 13"></path><polygon points="22 2 15 22 11 13 2 9 22 2"></polygon></svg>
            </div>
        </div>
    </div>

    <!-- Filter Tabs & Search -->
    <div class="inquiries-control-bar">
        <div class="filter-tabs">
            <a href="{{ route('admin.messages.index', array_filter(['search' => $search])) }}" class="filter-tab-pill {{ $status === 'all' || !$status ? 'active' : '' }}">
                <span>All Messages</span>
                <span class="tab-count">{{ $counts['all'] }}</span>
            </a>
            <a href="{{ route('admin.messages.index', array_filter(['status' => 'unread', 'search' => $search])) }}" class="filter-tab-pill {{ $status === 'unread' ? 'active' : '' }}">
                <span style="display:inline-flex; align-items:center; gap:4px;">
                    <span class="pulse-unread-dot"></span> Unread Only
                </span>
                <span class="tab-count">{{ $counts['unread'] }}</span>
            </a>
            <a href="{{ route('admin.messages.index', array_filter(['status' => 'replied', 'search' => $search])) }}" class="filter-tab-pill {{ $status === 'replied' ? 'active' : '' }}">
                <span>✓ Replied</span>
                <span class="tab-count">{{ $counts['replied'] ?? 0 }}</span>
            </a>
            <a href="{{ route('admin.messages.index', array_filter(['status' => 'read', 'search' => $search])) }}" class="filter-tab-pill {{ $status === 'read' ? 'active' : '' }}">
                <span>Read</span>
                <span class="tab-count">{{ $counts['read'] }}</span>
            </a>
        </div>

        <form action="{{ route('admin.messages.index') }}" method="GET" class="search-form-wrap">
            @if ($status && $status !== 'all')
                <input type="hidden" name="status" value="{{ $status }}">
            @endif
            <span class="search-form-icon">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.3"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
            </span>
            <input type="text" name="search" value="{{ $search }}" placeholder="Search customer, email, subject..." autocomplete="off">
            @if ($search)
                <a href="{{ route('admin.messages.index', array_filter(['status' => $status !== 'all' ? $status : null])) }}" class="search-clear-btn" title="Clear Search">✕</a>
            @endif
        </form>
    </div>

    <!-- Messages Table Card -->
    <div class="messages-card">
        <div class="messages-table-wrap">
            <table class="custom-messages-table">
                <thead>
                    <tr>
                        <th style="width:260px;">Customer / Sender</th>
                        <th style="width:170px;">Topic / Subject</th>
                        <th>Message Content</th>
                        <th style="width:150px;">Received At</th>
                        <th style="width:110px;">Status</th>
                        <th style="width:130px; text-align:right;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $avatarGradients = [
                            'linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%)',
                            'linear-gradient(135deg, #8b5cf6 0%, #6d28d9 100%)',
                            'linear-gradient(135deg, #ec4899 0%, #be185d 100%)',
                            'linear-gradient(135deg, #10b981 0%, #047857 100%)',
                            'linear-gradient(135deg, #f59e0b 0%, #b45309 100%)',
                            'linear-gradient(135deg, #06b6d4 0%, #0e7490 100%)',
                        ];
                    @endphp

                    @forelse ($messages as $idx => $msg)
                        @php
                            $grad = $avatarGradients[$idx % count($avatarGradients)];
                            $initial = strtoupper(substr($msg->name ?: 'C', 0, 1));
                            $subj = strtolower($msg->subject ?: '');
                            $pillClass = 'pill-default';
                            if (str_contains($subj, 'order') || str_contains($subj, 'track')) $pillClass = 'pill-order';
                            elseif (str_contains($subj, 'size') || str_contains($subj, 'sizing')) $pillClass = 'pill-sizing';
                            elseif (str_contains($subj, 'custom') || str_contains($subj, 'print')) $pillClass = 'pill-custom';
                            elseif (str_contains($subj, 'return') || str_contains($subj, 'exchange')) $pillClass = 'pill-returns';
                            elseif (str_contains($subj, 'whole') || str_contains($subj, 'press')) $pillClass = 'pill-wholesale';

                            $replyJson = json_encode([
                                'id' => $msg->id,
                                'name' => $msg->name,
                                'email' => $msg->email,
                                'subject' => $msg->subject,
                                'message' => $msg->message,
                                'reply_message' => $msg->reply_message,
                                'date' => $msg->created_at->format('M d, Y • h:i A'),
                                'replied_date' => $msg->replied_at ? $msg->replied_at->format('M d, Y • h:i A') : '',
                                'status' => $msg->status,
                            ]);
                        @endphp
                        <tr class="{{ $msg->status === 'unread' ? 'is-unread' : '' }}" id="message-row-{{ $msg->id }}">
                            <td>
                                <div class="sender-cell">
                                    <div class="sender-avatar" style="background: {{ $grad }};">
                                        {{ $initial }}
                                    </div>
                                    <div class="sender-meta">
                                        <div class="sender-name">
                                            <span>{{ $msg->name }}</span>
                                            @if ($msg->status === 'unread')
                                                <span class="pulse-unread-dot" title="New Unread Message"></span>
                                            @endif
                                        </div>
                                        <a href="mailto:{{ $msg->email }}?subject={{ rawurlencode('Re: ' . ($msg->subject ?: 'Your inquiry at T-Shirt Online')) }}" class="sender-email" title="Click to send email reply via client">
                                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
                                            <span>{{ $msg->email }}</span>
                                        </a>
                                    </div>
                                </div>
                            </td>

                            <td>
                                <span class="subject-pill {{ $pillClass }}">
                                    {{ $msg->subject ?: 'General Inquiry' }}
                                </span>
                            </td>

                            <td>
                                <div class="msg-preview-text" onclick='openMessageModal({!! htmlspecialchars($replyJson, ENT_QUOTES, "UTF-8") !!})' title="Click to read full message & reply">
                                    "{{ $msg->message }}"
                                </div>
                                @if ($msg->status === 'replied')
                                    <div style="font-size:0.75rem; color:#059669; font-weight:700; margin-top:3px; display:inline-flex; align-items:center; gap:4px;">
                                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"></polyline></svg>
                                        <span>Replied by admin</span>
                                    </div>
                                @endif
                            </td>

                            <td>
                                <div style="font-weight:700; color:#0f172a; font-size:0.84rem;">{{ $msg->created_at->format('M d, Y') }}</div>
                                <div style="font-size:0.75rem; color:#64748b; font-weight:600;">{{ $msg->created_at->format('h:i A') }} ({{ $msg->created_at->diffForHumans() }})</div>
                            </td>

                            <td>
                                @if ($msg->status === 'replied')
                                    <span class="status-badge status-replied" id="badge-status-{{ $msg->id }}">
                                        ✓ Replied
                                    </span>
                                @elseif ($msg->status === 'unread')
                                    <span class="status-badge status-unread" id="badge-status-{{ $msg->id }}">
                                        <span class="pulse-unread-dot"></span> Unread
                                    </span>
                                @else
                                    <span class="status-badge status-read" id="badge-status-{{ $msg->id }}">
                                        Read
                                    </span>
                                @endif
                            </td>

                            <td style="text-align:right;">
                                <div class="actions-cluster">
                                    <!-- 1. Quick View Modal -->
                                    <button type="button" class="action-icon-btn action-btn-primary" onclick='openMessageModal({!! htmlspecialchars($replyJson, ENT_QUOTES, "UTF-8") !!})' title="Read & Reply Inquiry">
                                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                                    </button>

                                    <!-- 2. Direct Reply Button (Opens modal with reply box focused) -->
                                    <button type="button" class="action-icon-btn action-btn-reply" onclick='openReplyModal({!! htmlspecialchars($replyJson, ENT_QUOTES, "UTF-8") !!})' title="Reply to Customer Email">
                                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
                                    </button>

                                    <!-- 3. Toggle Status (Read / Unread) -->
                                    <form action="{{ route('admin.messages.status', $msg->id) }}" method="POST" style="display:inline-block; margin:0;">
                                        @csrf
                                        <button type="submit" class="action-icon-btn" title="{{ $msg->status === 'unread' ? 'Mark as Read' : 'Mark as Unread' }}">
                                            @if ($msg->status === 'unread')
                                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#16a34a" stroke-width="2.4"><polyline points="20 6 9 17 4 12"></polyline></svg>
                                            @else
                                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#64748b" stroke-width="2.2"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                                            @endif
                                        </button>
                                    </form>

                                    <!-- 4. Delete Inquiry -->
                                    <form action="{{ route('admin.messages.destroy', $msg->id) }}" method="POST" style="display:inline-block; margin:0;"
                                          data-confirm="Are you sure you want to delete this customer inquiry from {{ $msg->name }}?"
                                          data-confirm-title="Delete Inquiry Message?"
                                          data-confirm-item="{{ $msg->subject ?: 'Inquiry' }} by {{ $msg->name }}"
                                          data-confirm-badge="INQUIRY PURGE"
                                          data-confirm-btn="Delete Inquiry"
                                          data-confirm-type="danger"
                                          data-confirm-icon="trash-2">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="action-icon-btn action-btn-danger" title="Permanently Delete Message">
                                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="text-align:center; padding:60px 20px;">
                                <div style="display:flex; flex-direction:column; align-items:center; justify-content:center; gap:12px;">
                                    <div style="width:60px; height:60px; border-radius:50%; background:#f1f5f9; display:flex; align-items:center; justify-content:center; color:#94a3b8;">
                                        <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path></svg>
                                    </div>
                                    <h4 style="margin:0; font-size:1.1rem; font-weight:800; color:#0f172a;">No Customer Inquiries Found</h4>
                                    <p style="margin:0; color:#64748b; font-size:0.88rem; max-width:380px;">
                                        @if ($search)
                                            No messages match your search "<strong>{{ $search }}</strong>". Try searching with another term.
                                        @else
                                            When visitors submit the contact form on your storefront, their inquiries will appear here instantly.
                                        @endif
                                    </p>
                                    @if ($search || ($status && $status !== 'all'))
                                        <a href="{{ route('admin.messages.index') }}" class="btn-outline" style="font-size:0.82rem; margin-top:8px;">Reset Filters</a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    @if ($messages->hasPages())
        <div style="margin-top:24px;">
            {{ $messages->links() }}
        </div>
    @endif

    <!-- Interactive Message Detail & Reply Modal -->
    <div class="message-modal-overlay" id="messageModalOverlay" onclick="closeMessageModalOnBackdrop(event)">
        <div class="message-modal-card">
            <div class="modal-head">
                <div style="display:flex; align-items:center; gap:10px;">
                    <div style="width:38px; height:38px; border-radius:10px; background:#eff6ff; color:#2563eb; display:flex; align-items:center; justify-content:center;">
                        <svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.3"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path></svg>
                    </div>
                    <div>
                        <h3 id="modalCustomerName">Customer Inquiry</h3>
                        <div style="font-size:0.75rem; color:#64748b; font-weight:600;" id="modalReceivedTime">Received date</div>
                    </div>
                </div>
                <button type="button" class="modal-close-x" onclick="closeMessageModal()">✕</button>
            </div>

            <div class="modal-body">
                <!-- Customer Info -->
                <div style="background:#f8fafc; border:1px solid #e2e8f0; border-radius:12px; padding:14px 16px; margin-bottom:16px;">
                    <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:8px; margin-bottom:6px;">
                        <div style="font-size:0.78rem; font-weight:800; color:#64748b; text-transform:uppercase;">Customer Email</div>
                        <span id="modalTopicBadge" class="subject-pill pill-default">Subject</span>
                    </div>
                    <div style="font-size:0.95rem; font-weight:800; color:#0f172a;" id="modalSenderEmail">customer@example.com</div>
                </div>

                <!-- Customer Message -->
                <div style="margin-bottom:16px;">
                    <div style="font-size:0.78rem; font-weight:800; color:#64748b; text-transform:uppercase; margin-bottom:6px;">Inquiry Content (សាររបស់អតិថិជន)</div>
                    <div style="background:#ffffff; border:1.5px solid #e2e8f0; border-radius:12px; padding:16px 18px; font-size:0.92rem; color:#1e293b; line-height:1.65; white-space:pre-wrap; font-weight:500;" id="modalMessageContent">
                        ...
                    </div>
                </div>

                <!-- Previous Reply if exists -->
                <div id="modalPreviousReplyBox" style="display:none; background:#ecfdf5; border:1.5px solid #86efac; border-radius:12px; padding:16px 18px; margin-bottom:16px;">
                    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:6px;">
                        <span style="font-size:0.78rem; font-weight:800; color:#15803d; text-transform:uppercase; display:inline-flex; align-items:center; gap:5px;">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"></polyline></svg>
                            <span>Official Reply Sent by Admin</span>
                        </span>
                        <span style="font-size:0.75rem; color:#16a34a; font-weight:700;" id="modalPreviousReplyDate">Date</span>
                    </div>
                    <div style="font-size:0.9rem; color:#14532d; white-space:pre-wrap; line-height:1.6;" id="modalPreviousReplyText"></div>
                </div>

                <!-- Reply Composer Box -->
                <div style="background:#f8fafc; border:1.5px solid #cbd5e1; border-radius:14px; padding:16px 18px;">
                    <form id="modalDirectReplyForm" method="POST" action="">
                        @csrf
                        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:8px;">
                            <label for="modalReplyTextarea" style="font-size:0.82rem; font-weight:800; color:#0f172a; display:flex; align-items:center; gap:6px;">
                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#4f46e5" stroke-width="2.3"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
                                <span>Write Reply to Customer (សរសេរសារឆ្លើយតប)</span>
                            </label>
                            <span style="font-size:0.72rem; color:#64748b; font-weight:600;">Sent via Official Email</span>
                        </div>

                        <textarea name="reply_message" id="modalReplyTextarea" rows="4" style="width:100%; border:1.5px solid #cbd5e1; border-radius:10px; padding:12px 14px; font-size:0.9rem; font-family:inherit; outline:none; transition:border-color 0.2s;" placeholder="Type your response to this customer here..." required></textarea>

                        <div style="display:flex; justify-content:space-between; align-items:center; margin-top:10px; flex-wrap:wrap; gap:8px;">
                            <a id="modalReplyMailto" href="#" class="btn-outline" style="font-size:0.78rem; padding:6px 12px; display:inline-flex; align-items:center; gap:5px; text-decoration:none;" title="Open external email app like Gmail or Outlook">
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path><polyline points="15 3 21 3 21 9"></polyline><line x1="10" y1="14" x2="21" y2="3"></line></svg>
                                <span>Open in Gmail / Mail App</span>
                            </a>

                            <button type="submit" class="btn-primary" style="background:linear-gradient(135deg, #4f46e5 0%, #3b82f6 100%); color:#ffffff; border:none; padding:8px 18px; border-radius:8px; font-weight:800; font-size:0.84rem; display:inline-flex; align-items:center; gap:6px; cursor:pointer; box-shadow:0 3px 10px rgba(79,70,229,0.3);">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4"><line x1="22" y1="2" x2="11" y2="13"></line><polygon points="22 2 15 22 11 13 2 9 22 2"></polygon></svg>
                                <span>Send Email to Customer</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="modal-foot">
                <div style="display:flex; align-items:center; gap:8px;">
                    <form id="modalToggleStatusForm" method="POST" style="margin:0;">
                        @csrf
                        <button type="submit" class="btn-outline" style="font-size:0.82rem; padding:8px 14px;" id="modalToggleBtn">
                            Toggle Status
                        </button>
                    </form>
                </div>

                <div style="display:flex; align-items:center; gap:8px;">
                    <button type="button" class="btn-outline" style="font-size:0.82rem; padding:8px 14px;" onclick="closeMessageModal()">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    let activeMessageId = null;

    function openMessageModal(data) {
        activeMessageId = data.id;

        document.getElementById('modalCustomerName').textContent = data.name || 'Customer Inquiry';
        document.getElementById('modalReceivedTime').textContent = data.date || '';
        document.getElementById('modalSenderEmail').textContent = data.email || '';
        document.getElementById('modalTopicBadge').textContent = data.subject || 'General Inquiry';
        document.getElementById('modalMessageContent').textContent = data.message || '';

        // Pre-fill email client mailto URL
        const replyUrl = `mailto:${encodeURIComponent(data.email)}?subject=${encodeURIComponent('Re: ' + (data.subject || 'Your inquiry at T-Shirt Online'))}`;
        document.getElementById('modalReplyMailto').setAttribute('href', replyUrl);

        // Direct Reply Form Action
        const directReplyForm = document.getElementById('modalDirectReplyForm');
        directReplyForm.setAttribute('action', `/admin/messages/${data.id}/reply`);

        // Check if there was a previous reply
        const prevReplyBox = document.getElementById('modalPreviousReplyBox');
        if (data.reply_message) {
            prevReplyBox.style.display = 'block';
            document.getElementById('modalPreviousReplyText').textContent = data.reply_message;
            document.getElementById('modalPreviousReplyDate').textContent = data.replied_date || 'Recently';
        } else {
            prevReplyBox.style.display = 'none';
        }

        // Toggle Status Form Action
        const toggleForm = document.getElementById('modalToggleStatusForm');
        toggleForm.setAttribute('action', `/admin/messages/${data.id}/status`);

        const toggleBtn = document.getElementById('modalToggleBtn');
        if (data.status === 'unread') {
            toggleBtn.innerHTML = '✓ Mark as Read';
        } else {
            toggleBtn.innerHTML = 'Mark as Unread';
        }

        // Open Modal
        document.getElementById('messageModalOverlay').classList.add('active');

        // Automatically call the show route via AJAX to mark it as read in the background
        if (data.status === 'unread') {
            fetch(`/admin/messages/${data.id}`, {
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            }).then(res => res.json()).then(resData => {
                if (resData.success) {
                    const row = document.getElementById(`message-row-${data.id}`);
                    if (row) row.classList.remove('is-unread');
                    const badge = document.getElementById(`badge-status-${data.id}`);
                    if (badge) {
                        badge.className = 'status-badge status-read';
                        badge.innerHTML = 'Read';
                    }
                }
            }).catch(err => console.log(err));
        }
    }

    function openReplyModal(data) {
        openMessageModal(data);
        setTimeout(() => {
            const textarea = document.getElementById('modalReplyTextarea');
            if (textarea) {
                textarea.focus();
                textarea.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
        }, 150);
    }

    function closeMessageModal() {
        document.getElementById('messageModalOverlay').classList.remove('active');
        activeMessageId = null;
    }

    function closeMessageModalOnBackdrop(e) {
        if (e.target.id === 'messageModalOverlay') {
            closeMessageModal();
        }
    }

    // Keyboard ESC to close modal
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeMessageModal();
        }
    });
</script>
@endsection
