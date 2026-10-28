@extends('layouts.admin')

@section('title', 'Customer Management')
@section('page-title', 'Customer Accounts')

@section('styles')
<style>
    .customers-header-bar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
        flex-wrap: wrap;
        gap: 16px;
    }

    .search-box-wrapper {
        position: relative;
        display: flex;
        align-items: center;
    }

    .search-input-icon {
        position: absolute;
        left: 14px;
        color: #64748b;
        pointer-events: none;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .customer-search-input {
        background: #ffffff;
        border: 1.5px solid #cbd5e1;
        color: #0f172a;
        padding: 9px 38px 9px 40px;
        border-radius: var(--radius-full);
        font-size: 0.88rem;
        font-weight: 600;
        width: 320px;
        outline: none;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.04);
        transition: all 0.2s ease;
    }

    .customer-search-input:focus {
        border-color: #4f46e5;
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.15);
        width: 350px;
    }

    .search-clear-btn {
        position: absolute;
        right: 8px;
        background: #f1f5f9;
        border: 1px solid #cbd5e1;
        color: #64748b;
        width: 24px;
        height: 24px;
        border-radius: 50%;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.75rem;
        transition: all 0.2s ease;
        text-decoration: none;
    }

    .search-clear-btn:hover {
        background: #fee2e2;
        border-color: #fecaca;
        color: #b91c1c;
    }

    .search-submit-btn {
        background: var(--accent-gradient);
        color: #ffffff;
        border: none;
        padding: 9px 20px;
        border-radius: var(--radius-full);
        font-size: 0.88rem;
        font-weight: 750;
        cursor: pointer;
        box-shadow: 0 4px 14px rgba(79, 70, 229, 0.35);
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .search-submit-btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 6px 18px rgba(79, 70, 229, 0.45);
    }

    .search-results-pill {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: #eef2ff;
        border: 1.5px solid #c7d2fe;
        padding: 5px 14px;
        border-radius: var(--radius-full);
        font-size: 0.82rem;
        font-weight: 650;
        color: #4338ca;
        margin-top: 8px;
    }

    .search-results-pill a {
        color: #b91c1c;
        font-weight: 750;
        text-decoration: none;
        margin-left: 4px;
    }

    .search-results-pill a:hover {
        text-decoration: underline;
    }

    .customer-table-wrap {
        background: #ffffff;
        border: 1.5px solid #e2e8f0;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04), 0 6px 18px rgba(0, 0, 0, 0.02);
    }

    .custom-table {
        width: 100%;
        border-collapse: collapse;
        text-align: left;
    }

    .custom-table th {
        background: #f8fafc;
        padding: 15px 20px;
        font-size: 0.8rem;
        text-transform: uppercase;
        letter-spacing: 0.6px;
        color: #334155;
        font-weight: 800;
        border-bottom: 1.5px solid #e2e8f0;
    }

    .custom-table td {
        padding: 16px 20px;
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

    .avatar-sm {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        background: var(--accent-gradient);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #ffffff;
        font-weight: 800;
        font-size: 0.85rem;
        flex-shrink: 0;
        box-shadow: 0 2px 6px rgba(79, 70, 229, 0.25);
    }

    .badge-status {
        padding: 4px 10px;
        border-radius: var(--radius-full);
        font-size: 0.75rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.4px;
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }

    .badge-blue {
        background: #e0e7ff;
        color: #4338ca;
        border: 1.5px solid #c7d2fe;
    }

    .badge-spend {
        color: #0f172a;
        font-weight: 850;
        font-size: 1rem;
    }

    .btn-profile {
        background: #ffffff;
        border: 1.5px solid #cbd5e1;
        color: #1e293b;
        padding: 6px 14px;
        border-radius: 8px;
        font-size: 0.82rem;
        font-weight: 750;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: all 0.15s ease;
        text-decoration: none;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.04);
    }

    .btn-profile:hover {
        background: #eef2ff;
        border-color: #c7d2fe;
        color: #4f46e5;
        transform: translateY(-1px);
    }

    .btn-delete-customer {
        background: #fff1f2;
        border: 1.5px solid #fecdd3;
        color: #be123c;
        padding: 6px 12px;
        border-radius: 8px;
        font-size: 0.82rem;
        font-weight: 750;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        cursor: pointer;
        transition: all 0.15s ease;
    }

    .btn-delete-customer:hover {
        background: #e11d48;
        border-color: #e11d48;
        color: #ffffff;
        transform: translateY(-1px);
    }
</style>
@endsection

@section('content')

    <div class="customers-header-bar">
        <div>
            <div style="display:flex; align-items:center; gap:10px;">
                <h2 style="font-size:1.6rem; font-weight:850; color:#0f172a; letter-spacing:-0.4px; margin:0;">
                    User & Admin Accounts ({{ $customers->total() }})
                </h2>
                <span style="background:#eef2ff; color:#4f46e5; font-size:0.75rem; font-weight:800; padding:3px 10px; border-radius:9999px; border:1px solid #c7d2fe;">
                    Directory
                </span>
            </div>
            <p style="color:#475569; font-size:0.92rem; font-weight:500; margin-top:4px; margin-bottom:0;">
                Search and manage customer profiles, admin emails, total orders, and user accounts.
            </p>

            @if(request('search'))
                <div class="search-results-pill">
                    <span>Filtering by: <strong>"{{ request('search') }}"</strong> ({{ $customers->total() }} matches)</span>
                    <a href="{{ route('admin.customers.index', ['role' => request('role', 'all')]) }}" title="Clear search filter">✕ Reset</a>
                </div>
            @endif
        </div>

        <!-- SEARCH FORM -->
        <form action="{{ route('admin.customers.index') }}" method="GET" id="customerSearchForm" style="display:flex; gap:10px; align-items:center;">
            @if(request('role'))
                <input type="hidden" name="role" value="{{ request('role') }}">
            @endif
            <div class="search-box-wrapper">
                <span class="search-input-icon">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="11" cy="11" r="8"></circle>
                        <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                    </svg>
                </span>

                <input type="text" 
                       name="search" 
                       id="customerSearchInput"
                       placeholder="Search name, admin email, phone..." 
                       value="{{ request('search') }}" 
                       class="customer-search-input"
                       autocomplete="off">

                @if(request('search'))
                    <a href="{{ route('admin.customers.index', ['role' => request('role', 'all')]) }}" class="search-clear-btn" title="Clear search">✕</a>
                @endif
            </div>

            <button type="submit" class="search-submit-btn">
                <span>Search</span>
            </button>
        </form>
    </div>

    <!-- OVERVIEW KPI CARDS -->
    <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(220px, 1fr)); gap:18px; margin-bottom:24px;">
        <!-- Card 1: All Accounts -->
        <div style="background:#ffffff; border:1.5px solid #e2e8f0; border-radius:14px; padding:18px 20px; box-shadow:0 1px 3px rgba(0,0,0,0.04), 0 4px 12px rgba(0,0,0,0.02); display:flex; flex-direction:column; justify-content:space-between;">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:8px;">
                <span style="background:#f1f5f9; color:#334155; font-size:0.75rem; font-weight:800; text-transform:uppercase; letter-spacing:0.5px; padding:3px 9px; border-radius:6px; border:1px solid #e2e8f0;">
                    Total Accounts
                </span>
                <span style="font-size:1.1rem;">👥</span>
            </div>
            <div>
                <div style="font-size:1.9rem; font-weight:850; color:#0f172a; line-height:1.1;">
                    {{ number_format($roleCounts['all'] ?? 0) }}
                    <span style="font-size:0.88rem; color:#64748b; font-weight:600;">registered</span>
                </div>
                <div style="font-size:0.78rem; color:#475569; font-weight:600; margin-top:4px;">All platform users & admins</div>
            </div>
        </div>

        <!-- Card 2: Customers -->
        <div style="background:#ffffff; border:1.5px solid #bbf7d0; border-radius:14px; padding:18px 20px; box-shadow:0 1px 3px rgba(16,185,129,0.06), 0 4px 12px rgba(16,185,129,0.04); display:flex; flex-direction:column; justify-content:space-between;">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:8px;">
                <span style="background:#dcfce7; color:#15803d; font-size:0.75rem; font-weight:800; text-transform:uppercase; letter-spacing:0.5px; padding:3px 9px; border-radius:6px; border:1px solid #86efac;">
                    Store Shoppers
                </span>
                <span style="font-size:1.1rem;">🛍️</span>
            </div>
            <div>
                <div style="font-size:1.9rem; font-weight:850; color:#15803d; line-height:1.1;">
                    {{ number_format($roleCounts['user'] ?? 0) }}
                    <span style="font-size:0.88rem; color:#166534; font-weight:600;">customers</span>
                </div>
                <div style="font-size:0.78rem; color:#15803d; font-weight:600; margin-top:4px;">Buying & browsing accounts</div>
            </div>
        </div>

        <!-- Card 3: Admins -->
        <div style="background:#ffffff; border:1.5px solid #d8b4fe; border-radius:14px; padding:18px 20px; box-shadow:0 1px 3px rgba(168,85,247,0.06), 0 4px 12px rgba(168,85,247,0.04); display:flex; flex-direction:column; justify-content:space-between;">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:8px;">
                <span style="background:#f3e8ff; color:#7e22ce; font-size:0.75rem; font-weight:800; text-transform:uppercase; letter-spacing:0.5px; padding:3px 9px; border-radius:6px; border:1px solid #d8b4fe;">
                    Admin Accounts
                </span>
                <span style="font-size:1.1rem;">🛡️</span>
            </div>
            <div>
                <div style="font-size:1.9rem; font-weight:850; color:#7e22ce; line-height:1.1;">
                    {{ number_format($roleCounts['admin'] ?? 0) }}
                    <span style="font-size:0.88rem; color:#6b21a8; font-weight:600;">managers</span>
                </div>
                <div style="font-size:0.78rem; color:#7e22ce; font-weight:600; margin-top:4px;">Store operations & staff</div>
            </div>
        </div>
    </div>

    <!-- ROLE FILTER TABS -->
    <div style="display:flex; gap:10px; margin-bottom:22px; flex-wrap:wrap; align-items:center;">
        @php
            $currentRole = request('role', 'all');
        @endphp
        <a href="{{ route('admin.customers.index', array_merge(request()->except(['page', 'role']), ['role' => 'all'])) }}" 
           class="btn-outline" 
           style="{{ $currentRole === 'all' ? 'background:#4f46e5; border-color:#4f46e5; color:#ffffff; font-weight:750; box-shadow:0 2px 6px rgba(79,70,229,0.25);' : 'background:#ffffff; border:1.5px solid #cbd5e1; color:#334155; font-weight:650;' }}">
            👥 All Accounts
            <span style="background:{{ $currentRole === 'all' ? 'rgba(255,255,255,0.25)' : '#f1f5f9' }}; color:{{ $currentRole === 'all' ? '#ffffff' : '#475569' }}; padding:2px 8px; border-radius:10px; font-size:0.75rem; margin-left:6px; font-weight:800; border:{{ $currentRole === 'all' ? 'none' : '1px solid #e2e8f0' }};">
                {{ $roleCounts['all'] ?? 0 }}
            </span>
        </a>

        <a href="{{ route('admin.customers.index', array_merge(request()->except(['page', 'role']), ['role' => 'admin'])) }}" 
           class="btn-outline" 
           style="{{ $currentRole === 'admin' ? 'background:#7e22ce; border-color:#7e22ce; color:#ffffff; font-weight:750; box-shadow:0 2px 6px rgba(126,34,206,0.25);' : 'background:#ffffff; border:1.5px solid #cbd5e1; color:#334155; font-weight:650;' }}">
            🛡️ Admin Accounts (អ៊ីមែល Admin)
            <span style="background:{{ $currentRole === 'admin' ? 'rgba(255,255,255,0.25)' : '#f3e8ff' }}; color:{{ $currentRole === 'admin' ? '#ffffff' : '#7e22ce' }}; padding:2px 8px; border-radius:10px; font-size:0.75rem; margin-left:6px; font-weight:800; border:{{ $currentRole === 'admin' ? 'none' : '1px solid #d8b4fe' }};">
                {{ $roleCounts['admin'] ?? 0 }}
            </span>
        </a>

        <a href="{{ route('admin.customers.index', array_merge(request()->except(['page', 'role']), ['role' => 'user'])) }}" 
           class="btn-outline" 
           style="{{ $currentRole === 'user' ? 'background:#0284c7; border-color:#0284c7; color:#ffffff; font-weight:750; box-shadow:0 2px 6px rgba(2,132,199,0.25);' : 'background:#ffffff; border:1.5px solid #cbd5e1; color:#334155; font-weight:650;' }}">
            👤 Customers (អតិថិជន)
            <span style="background:{{ $currentRole === 'user' ? 'rgba(255,255,255,0.25)' : '#f0f9ff' }}; color:{{ $currentRole === 'user' ? '#ffffff' : '#0369a1' }}; padding:2px 8px; border-radius:10px; font-size:0.75rem; margin-left:6px; font-weight:800; border:{{ $currentRole === 'user' ? 'none' : '1px solid #bae6fd' }};">
                {{ $roleCounts['user'] ?? 0 }}
            </span>
        </a>
    </div>

    <!-- CUSTOMERS & ADMINS TABLE -->
    <div class="customer-table-wrap">
        <table class="custom-table" id="customersTable">
            <thead>
                <tr>
                    <th>Account / Name</th>
                    <th>Email Address (អ៊ីមែល)</th>
                    <th>Account Role</th>
                    <th>Orders Placed</th>
                    <th>Lifetime Spend</th>
                    <th>Member Since</th>
                    <th style="text-align:right;">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($customers as $customer)
                    <tr class="customer-row">
                        <!-- Account / Name -->
                        <td>
                            <div style="display:flex; align-items:center; gap:12px;">
                                @if($customer->avatar)
                                    <img src="{{ asset($customer->avatar) }}" alt="{{ $customer->name }}" class="avatar-sm" style="object-fit:cover;">
                                @else
                                    <div class="avatar-sm" style="{{ $customer->role === 'admin' ? 'background:linear-gradient(135deg, #7c3aed, #a855f7);' : '' }}">
                                        {{ strtoupper(substr($customer->name, 0, 1)) }}
                                    </div>
                                @endif
                                <div>
                                    <div style="display:flex; align-items:center; gap:6px;">
                                        <a href="{{ route('admin.customers.show', $customer->id) }}" style="color:#0f172a; font-size:0.95rem; font-weight:800; text-decoration:none;" class="customer-name" onmouseover="this.style.color='#4f46e5'" onmouseout="this.style.color='#0f172a'">
                                            {{ $customer->name }}
                                        </a>
                                        @if($customer->id === auth()->id())
                                            <span style="background:#dcfce7; color:#15803d; border:1px solid #86efac; font-size:0.68rem; padding:1px 7px; border-radius:4px; font-weight:800;">
                                                You / គណនីអ្នក
                                            </span>
                                        @endif
                                    </div>
                                    @if($customer->phone || $customer->city)
                                        <div style="font-size:0.78rem; color:#64748b; font-weight:600; margin-top:2px;">
                                            {{ $customer->phone ?? '' }} {{ $customer->city ? '• ' . $customer->city : '' }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </td>

                        <!-- Email Address -->
                        <td>
                            <span class="customer-email" style="color:#1e293b; font-family:ui-monospace,SFMono-Regular,Consolas,monospace; font-weight:700; font-size:0.88rem; background:#f8fafc; padding:4px 8px; border-radius:6px; border:1px solid #e2e8f0; display:inline-block;">
                                {{ $customer->email }}
                            </span>
                        </td>

                        <!-- Account Role -->
                        <td>
                            @if ($customer->role === 'admin')
                                <span class="badge-status" style="background:#f3e8ff; color:#7e22ce; border:1.5px solid #d8b4fe; font-weight:850; padding:4px 10px; border-radius:9999px; font-size:0.75rem;">
                                    🛡️ Admin
                                </span>
                            @else
                                <span class="badge-status badge-blue">
                                    👤 Customer
                                </span>
                            @endif
                        </td>

                        <!-- Orders Placed -->
                        <td>
                            <span style="font-size:0.88rem; font-weight:750; color:#0f172a; background:#f1f5f9; padding:3px 9px; border-radius:6px; border:1px solid #e2e8f0;">
                                {{ $customer->orders_count }} order(s)
                            </span>
                        </td>

                        <!-- Lifetime Spend -->
                        <td>
                            <span class="badge-spend">
                                ${{ number_format($customer->orders_sum_total ?? 0, 2) }}
                            </span>
                        </td>

                        <!-- Member Since -->
                        <td style="color:#475569; font-weight:650; font-size:0.85rem;">
                            {{ $customer->created_at->format('M d, Y') }}
                        </td>

                        <!-- Actions -->
                        <td style="text-align:right;">
                            <div style="display:flex; justify-content:flex-end; align-items:center; gap:8px;">
                                <a href="{{ route('admin.customers.show', $customer->id) }}" class="btn-profile" title="View account profile & activity">
                                    <span>Profile</span>
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                        <line x1="5" y1="12" x2="19" y2="12"></line>
                                        <polyline points="12 5 19 12 12 19"></polyline>
                                    </svg>
                                </a>

                                @if(auth()->id() !== $customer->id)
                                    <form action="{{ route('admin.customers.destroy', $customer->id) }}" 
                                          method="POST" 
                                          style="display:inline-block; margin:0;"
                                          data-confirm-title="Delete Account?"
                                          data-confirm-message="Are you sure you want to delete account '{{ addslashes($customer->name) }}' ({{ $customer->email }})? Past order records will be preserved for store accounting."
                                          data-confirm-item="{{ $customer->name }}"
                                          data-confirm-badge="USER DELETION"
                                          data-confirm-btn="Yes, Delete Account"
                                          data-cancel-btn="Keep Account"
                                          onsubmit="return confirm('Are you sure you want to delete account \'{{ addslashes($customer->name) }}\'? (តើអ្នកប្រាកដថាចង់លុបគណនីនេះទេ?)');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-delete-customer" title="Delete account">
                                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                                <polyline points="3 6 5 6 21 6"></polyline>
                                                <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                                <line x1="10" y1="11" x2="10" y2="17"></line>
                                                <line x1="14" y1="11" x2="14" y2="17"></line>
                                            </svg>
                                            <span>Delete</span>
                                        </button>
                                    </form>
                                @else
                                    <span style="font-size:0.75rem; color:#15803d; font-weight:800; padding:6px 12px; background:#dcfce7; border-radius:8px; border:1.5px solid #86efac;">
                                        Active
                                    </span>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="text-align:center; padding:50px 20px;">
                            <div style="font-size:2.2rem; margin-bottom:12px;">🔍</div>
                            <h3 style="color:#0f172a; font-size:1.15rem; font-weight:850; margin-bottom:6px;">No Accounts Found</h3>
                            @if(request('search'))
                                <p style="color:#64748b; font-size:0.9rem; margin-bottom:16px;">
                                    We couldn't find any accounts matching "<strong>{{ request('search') }}</strong>".
                                </p>
                                <a href="{{ route('admin.customers.index') }}" class="search-submit-btn" style="text-decoration:none; display:inline-flex;">
                                    Clear Search & View All
                                </a>
                            @else
                                <p style="color:#64748b; font-size:0.9rem; margin-bottom:16px;">
                                    No registered accounts found under this tab.
                                </p>
                                <a href="{{ route('admin.customers.index', ['role' => 'all']) }}" class="search-submit-btn" style="text-decoration:none; display:inline-flex;">
                                    View All Accounts ({{ $roleCounts['all'] ?? 0 }})
                                </a>
                            @endif
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- PAGINATION -->
    <div style="margin-top:24px;">
        {{ $customers->links() }}
    </div>

@endsection

@section('scripts')
<script>
    // Live Search (Instant Real-Time Client Filtering + Debounced Server Submit)
    document.addEventListener('DOMContentLoaded', function () {
        const searchInput = document.getElementById('customerSearchInput');
        const rows = document.querySelectorAll('.customer-row');

        if (searchInput) {
            // Real-time table filter as user types (instant feedback)
            searchInput.addEventListener('input', function () {
                const term = this.value.toLowerCase().trim();

                rows.forEach(row => {
                    const text = row.textContent.toLowerCase();
                    if (text.includes(term)) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            });

            // Focus on hotkey "/"
            document.addEventListener('keydown', function (e) {
                if (e.key === '/' && document.activeElement !== searchInput && !['INPUT', 'TEXTAREA'].includes(document.activeElement.tagName)) {
                    e.preventDefault();
                    searchInput.focus();
                }
            });
        }
    });
</script>
@endsection
