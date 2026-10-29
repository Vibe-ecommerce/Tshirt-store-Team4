@extends('layouts.admin')

@section('title', 'Product Management')
@section('page-title', 'Product Management')

@section('styles')
<style>
    /* -------------------------------------------------------------
       LUXURY PRODUCT MANAGEMENT STYLING
    ------------------------------------------------------------- */
    .catalog-header-card {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
        flex-wrap: wrap;
        gap: 16px;
    }

    .catalog-title-wrap {
        display: flex;
        align-items: center;
        gap: 12px;
        flex-wrap: wrap;
    }

    .catalog-title {
        font-size: 1.65rem;
        font-weight: 900;
        color: #0f172a;
        letter-spacing: -0.6px;
        line-height: 1.2;
    }

    .catalog-count-badge {
        background: #eff6ff;
        border: 1px solid #bfdbfe;
        color: #1d4ed8;
        font-size: 0.82rem;
        font-weight: 850;
        padding: 3px 10px;
        border-radius: 9999px;
        letter-spacing: 0.2px;
    }

    .catalog-desc {
        color: #64748b;
        font-size: 0.88rem;
        font-weight: 500;
        margin-top: 4px;
    }

    /* Action Buttons */
    .btn-action-primary {
        background: linear-gradient(135deg, #2563eb 0%, #4f46e5 100%);
        color: #ffffff !important;
        border: none;
        padding: 9px 20px;
        border-radius: 12px;
        font-size: 0.86rem;
        font-weight: 750;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        text-decoration: none;
        box-shadow: 0 4px 14px rgba(37, 99, 235, 0.35);
        transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
        cursor: pointer;
    }

    .btn-action-primary:hover {
        background: linear-gradient(135deg, #1d4ed8 0%, #4338ca 100%);
        transform: translateY(-1px);
        box-shadow: 0 6px 18px rgba(37, 99, 235, 0.45);
    }

    .btn-action-outline {
        background: #ffffff;
        border: 1.5px solid #cbd5e1;
        color: #1e293b;
        padding: 8.5px 18px;
        border-radius: 12px;
        font-size: 0.86rem;
        font-weight: 750;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        text-decoration: none;
        box-shadow: 0 1px 3px rgba(15, 23, 42, 0.04);
        transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
    }

    .btn-action-outline:hover {
        background: #f8fafc;
        border-color: #94a3b8;
        color: #0f172a;
        transform: translateY(-1px);
    }

    /* Filter & Search Bar */
    .filter-search-card {
        background: #ffffff;
        border: 1.5px solid #e2e8f0;
        border-radius: 18px;
        padding: 16px 20px;
        margin-bottom: 24px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 16px;
        box-shadow: 0 2px 10px rgba(15, 23, 42, 0.03);
    }

    .category-pills-wrap {
        display: flex;
        gap: 7px;
        flex-wrap: wrap;
        align-items: center;
    }

    .cat-pill {
        display: inline-flex;
        align-items: center;
        padding: 6px 14px;
        border-radius: 9999px;
        font-size: 0.80rem;
        font-weight: 650;
        text-decoration: none;
        transition: all 0.18s cubic-bezier(0.16, 1, 0.3, 1);
        border: 1.5px solid #e2e8f0;
        background: #f8fafc;
        color: #475569;
    }

    .cat-pill:hover {
        background: #eff6ff !important;
        border-color: #bfdbfe !important;
        color: #1d4ed8 !important;
        transform: translateY(-1px);
    }

    .cat-pill.active {
        background: #0f172a !important;
        border-color: #0f172a !important;
        color: #ffffff !important;
        font-weight: 800;
        box-shadow: 0 2px 8px rgba(15, 23, 42, 0.25);
    }

    /* Search Box */
    .search-input-wrap {
        position: relative;
        display: flex;
        align-items: center;
    }

    .search-input-field {
        background: #f8fafc !important;
        border: 1.5px solid #cbd5e1 !important;
        color: #0f172a !important;
        padding: 9px 36px 9px 38px;
        border-radius: 9999px;
        font-size: 0.86rem;
        font-weight: 600;
        outline: none;
        width: 270px;
        transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
    }

    .search-input-field:focus {
        background: #ffffff !important;
        border-color: #2563eb !important;
        width: 320px;
        box-shadow: 0 0 0 3.5px rgba(37, 99, 235, 0.15) !important;
    }

    .search-submit-btn {
        background: linear-gradient(135deg, #2563eb, #1d4ed8);
        color: #ffffff;
        border: none;
        font-weight: 750;
        font-size: 0.82rem;
        padding: 8.5px 20px;
        border-radius: 9999px;
        cursor: pointer;
        box-shadow: 0 2px 8px rgba(37, 99, 235, 0.3);
        transition: all 0.18s ease;
    }

    .search-submit-btn:hover {
        background: #1d4ed8;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(37, 99, 235, 0.4);
    }

    /* Main Table Card */
    .table-container-card {
        background: #ffffff;
        border: 1.5px solid #e2e8f0;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 4px 20px -2px rgba(15, 23, 42, 0.04);
        margin-bottom: 24px;
    }

    .table-container-card table {
        width: 100%;
        border-collapse: collapse;
        text-align: left;
    }

    .table-container-card th {
        background: #f8fafc;
        color: #475569;
        font-size: 0.74rem;
        font-weight: 850;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        padding: 15px 20px;
        border-bottom: 1.5px solid #e2e8f0;
    }

    .table-container-card td {
        padding: 16px 20px;
        vertical-align: middle;
        border-bottom: 1px solid #f1f5f9;
        font-size: 0.88rem;
    }

    .product-row {
        transition: background-color 0.15s ease;
    }

    .product-row:hover {
        background-color: #fafbfc;
    }

    .product-row:last-child td {
        border-bottom: none;
    }

    /* Product ID Pill */
    .product-id-pill {
        font-family: 'JetBrains Mono', monospace;
        font-size: 0.78rem;
        font-weight: 800;
        background: #eff6ff;
        border: 1px solid #bfdbfe;
        color: #1d4ed8;
        padding: 3.5px 8px;
        border-radius: 7px;
        display: inline-block;
    }

    /* Category Badges */
    .cat-badge {
        font-size: 0.72rem;
        font-weight: 850;
        padding: 3.5px 10px;
        border-radius: 9999px;
        display: inline-flex;
        align-items: center;
        letter-spacing: 0.3px;
        text-transform: uppercase;
    }

    .cat-badge-indigo {
        background: #eff6ff;
        color: #1d4ed8;
        border: 1px solid #bfdbfe;
    }

    .cat-badge-purple {
        background: #f5f3ff;
        color: #6d28d9;
        border: 1px solid #ddd6fe;
    }

    .cat-badge-green {
        background: #f0fdf4;
        color: #15803d;
        border: 1px solid #bbf7d0;
    }

    .cat-badge-amber {
        background: #fff7ed;
        color: #c2410c;
        border: 1px solid #fed7aa;
    }

    /* Stock Badge */
    .stock-badge-in {
        background: #ecfdf5;
        color: #059669;
        border: 1px solid #a7f3d0;
        font-size: 0.74rem;
        font-weight: 850;
        padding: 3px 10px;
        border-radius: 9999px;
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }

    .stock-badge-out {
        background: #fef2f2;
        color: #dc2626;
        border: 1px solid #fecaca;
        font-size: 0.74rem;
        font-weight: 850;
        padding: 3px 10px;
        border-radius: 9999px;
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }

    .stock-dot {
        width: 6px;
        height: 6px;
        border-radius: 50%;
        display: inline-block;
    }

    /* Featured Badge */
    .featured-badge {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        background: #fffbeb;
        color: #b45309;
        border: 1px solid #fde68a;
        padding: 3px 10px;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 850;
    }

    /* Action Buttons */
    .action-edit-btn {
        background: #ffffff;
        border: 1.5px solid #cbd5e1;
        color: #1e293b;
        font-weight: 750;
        font-size: 0.78rem;
        padding: 6px 13px;
        border-radius: 8px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        transition: all 0.15s ease;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.02);
    }

    .action-edit-btn:hover {
        background: #0f172a;
        color: #ffffff;
        border-color: #0f172a;
        transform: translateY(-1px);
        box-shadow: 0 3px 8px rgba(15, 23, 42, 0.15);
    }

    .action-delete-btn {
        background: #fff1f2;
        border: 1.5px solid #fecdd3;
        color: #e11d48;
        font-weight: 750;
        font-size: 0.78rem;
        padding: 6px 13px;
        border-radius: 8px;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        transition: all 0.15s ease;
        box-shadow: 0 1px 2px rgba(225, 29, 72, 0.04);
    }

    .action-delete-btn:hover {
        background: #e11d48;
        color: #ffffff;
        border-color: #e11d48;
        transform: translateY(-1px);
        box-shadow: 0 3px 8px rgba(225, 29, 72, 0.25);
    }
</style>
@endsection

@section('content')
    <!-- Top Action Bar -->
    <div class="catalog-header-card">
        <div>
            <div class="catalog-title-wrap">
                <h2 class="catalog-title">All Products</h2>
                <span class="catalog-count-badge" id="productTotalCount">{{ $products->total() }} Products</span>
                @if (request('search'))
                    <span style="background:#eff6ff; border:1px solid #bfdbfe; color:#1d4ed8; font-size:0.75rem; font-weight:750; padding:3px 10px; border-radius:9999px;">
                        Filtered: "{{ request('search') }}"
                    </span>
                @endif
            </div>
            <p class="catalog-desc">Catalog of all store products, prices, categories, and inventory statuses.</p>
        </div>

        <div style="display:flex; gap:10px; align-items:center;">
            <a href="{{ route('admin.products.inventory') }}" class="btn-action-outline">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16Z"></path>
                    <path d="m3.3 7 8.7 5 8.7-5"></path>
                    <path d="M12 22V12"></path>
                </svg>
                <span>View Inventory</span>
            </a>
            <a href="{{ route('admin.products.create') }}" class="btn-action-primary">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="12" y1="5" x2="12" y2="19"></line>
                    <line x1="5" y1="12" x2="19" y2="12"></line>
                </svg>
                <span>Add Product</span>
            </a>
        </div>
    </div>

    <!-- Filter & Search Bar -->
    <div class="filter-search-card">
        <!-- Categories Filter -->
        <div class="category-pills-wrap">
            <a href="{{ route('admin.products.index', array_filter(['search' => request('search')])) }}" 
               class="cat-pill {{ !request('category') ? 'active' : '' }}">
               All
            </a>
            @foreach ($categories as $cat)
                @if (!empty(trim($cat)))
                    <a href="{{ route('admin.products.index', array_filter(['category' => $cat, 'search' => request('search')])) }}" 
                       class="cat-pill {{ request('category') == $cat ? 'active' : '' }}">
                        {{ $cat }}
                    </a>
                @endif
            @endforeach
        </div>

        <!-- Integrated Search Bar -->
        <form action="{{ route('admin.products.index') }}" method="GET" id="searchForm" style="display:flex; align-items:center; gap:8px; margin:0;">
            @if (request('category'))
                <input type="hidden" name="category" value="{{ request('category') }}">
            @endif

            <div class="search-input-wrap">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" style="position:absolute; left:13px; color:#64748b; pointer-events:none;">
                    <circle cx="11" cy="11" r="8"></circle>
                    <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                </svg>

                <input type="text" id="adminSearchInput" name="search" placeholder="Search by ID (e.g. #1), title, color..." 
                       value="{{ request('search') }}" 
                       autocomplete="off"
                       class="search-input-field">

                <button type="button" id="clearSearchBtn" onclick="clearAdminSearch()" 
                        style="position:absolute; right:12px; background:none; border:none; color:#64748b; cursor:pointer; font-size:0.85rem; padding:2px; display:{{ request('search') ? 'block' : 'none' }}; line-height:1;" title="Clear search">
                    ✕
                </button>
            </div>

            <button type="submit" class="search-submit-btn">
                Search
            </button>
        </form>
    </div>

    <!-- Active Search Info Bar -->
    @if (request('search'))
        <div style="display:flex; justify-content:space-between; align-items:center; background:#eff6ff; border:1px solid #bfdbfe; border-radius:12px; padding:12px 18px; margin-bottom:20px;">
            <div style="font-size:0.88rem; color:#1e293b;">
                Showing results for <strong style="color:#1d4ed8;">"{{ request('search') }}"</strong>
                @if (request('category'))
                    in category <strong style="color:#0f172a;">{{ request('category') }}</strong>
                @endif
                <span style="color:#64748b;">({{ $products->total() }} items found)</span>
            </div>
            <a href="{{ route('admin.products.index', array_filter(['category' => request('category')])) }}" style="font-size:0.82rem; color:#dc2626; text-decoration:none; display:inline-flex; align-items:center; gap:5px; font-weight:750;">
                ✕ Clear Search Filter
            </a>
        </div>
    @endif

    <!-- Main Products Table -->
    <div class="table-container-card">
        <table id="productsTable">
            <thead>
                <tr>
                    <th style="width:75px;">ID</th>
                    <th>Product</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th>Color & Sizes</th>
                    <th>Stock</th>
                    <th>Featured</th>
                    <th style="text-align:right;">Actions</th>
                </tr>
            </thead>
            <tbody id="productsTableBody">
                @forelse ($products as $product)
                    @php
                        $catLower = strtolower($product->category);
                        if (str_contains($catLower, 'shirt')) {
                            $badgeClass = 'cat-badge-indigo';
                        } elseif (str_contains($catLower, 'watch') || str_contains($catLower, 'shoe') || str_contains($catLower, 'bag')) {
                            $badgeClass = 'cat-badge-purple';
                        } elseif (str_contains($catLower, 'trouser') || str_contains($catLower, 'hat')) {
                            $badgeClass = 'cat-badge-green';
                        } else {
                            $badgeClass = 'cat-badge-amber';
                        }
                    @endphp
                    <tr class="product-row" data-id="{{ $product->id }}" data-name="{{ strtolower($product->name) }}" data-color="{{ strtolower($product->color ?? '') }}" data-cat="{{ strtolower($product->category) }}" data-sizes="{{ strtolower($product->sizes ?? '') }}" data-price="{{ $product->price }}">
                        <td>
                            <span class="product-id-pill">#{{ $product->id }}</span>
                        </td>
                        <td>
                            <div style="display:flex; align-items:center; gap:14px;">
                                <img src="{{ asset($product->image) }}" alt="" style="width:48px; height:48px; border-radius:10px; object-fit:cover; background:#f8fafc; border:1.5px solid #e2e8f0; box-shadow:0 2px 6px rgba(0,0,0,0.03);">
                                <div>
                                    <strong class="product-title" style="color:#0f172a; font-size:0.94rem; font-weight:800; display:block; text-transform:capitalize;">{{ $product->name }}</strong>
                                    <div style="font-size:0.75rem; color:#64748b; font-weight:600; margin-top:2px;">
                                        <span style="color:#f59e0b;">★</span> {{ number_format($product->rating, 1) }} 
                                        <span style="color:#94a3b8;">({{ $product->review_count }} reviews)</span>
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="cat-badge {{ $badgeClass }}">{{ $product->category }}</span>
                        </td>
                        <td>
                            <strong style="color:#0f172a; font-weight:900; font-size:1.02rem;">${{ number_format($product->price, 2) }}</strong>
                            @if ($product->original_price && $product->original_price > $product->price)
                                <div style="font-size:0.75rem; color:#94a3b8; text-decoration:line-through; font-weight:600;">${{ number_format($product->original_price, 2) }}</div>
                            @endif
                        </td>
                        <td>
                            <div style="font-size:0.86rem; font-weight:750; color:#1e293b; text-transform:capitalize;">{{ $product->color ?? 'Standard' }}</div>
                            <div style="font-size:0.74rem; color:#64748b; font-weight:600; margin-top:2px;">Sizes: {{ $product->sizes }}</div>
                        </td>
                        <td>
                            @if ($product->in_stock)
                                <span class="stock-badge-in">
                                    <span class="stock-dot" style="background:#10b981;"></span>
                                    <span>In Stock</span>
                                </span>
                            @else
                                <span class="stock-badge-out">
                                    <span class="stock-dot" style="background:#ef4444;"></span>
                                    <span>Out of Stock</span>
                                </span>
                            @endif
                        </td>
                        <td>
                            @if ($product->is_featured)
                                <span class="featured-badge">★ Featured</span>
                            @else
                                <span style="color:#94a3b8; font-size:0.80rem; font-weight:600;">Standard</span>
                            @endif
                        </td>
                        <td style="text-align:right;">
                            <div style="display:flex; justify-content:flex-end; gap:8px; align-items:center;">
                                <a href="{{ route('admin.products.edit', $product->id) }}" class="action-edit-btn" title="Edit Product">
                                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                                    <span>Edit</span>
                                </a>
                                <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST"
                                      data-confirm="Are you sure you want to permanently delete this product? All size variants, inventory counts, and customer associations will be deleted from the catalog."
                                      data-confirm-title="Delete Product?"
                                      data-confirm-item="👕 {{ $product->name }}"
                                      data-confirm-badge="CATALOG DESTRUCTION"
                                      data-confirm-btn="Delete Product"
                                      data-confirm-type="danger"
                                      data-confirm-icon="🗑️"
                                      style="margin:0;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="action-delete-btn" title="Delete Product">
                                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                                        <span>Delete</span>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" style="text-align:center; padding:54px 20px;">
                            <div style="font-size:2.4rem; margin-bottom:10px;">🔍</div>
                            <h4 style="font-size:1.15rem; color:#0f172a; font-weight:800; margin-bottom:6px;">No Products Found</h4>
                            <p style="color:#64748b; font-size:0.88rem; max-width:420px; margin:0 auto 18px;">
                                @if (request('search'))
                                    No products matching <strong>"{{ request('search') }}"</strong> were found in {{ request('category') ?: 'any category' }}.
                                @else
                                    No products found in this category.
                                @endif
                            </p>
                            <a href="{{ route('admin.products.index') }}" class="btn-action-primary" style="font-size:0.84rem; padding:8px 20px;">
                                Clear Filters & View All
                            </a>
                        </td>
                    </tr>
                @endforelse

                <!-- Live Client-Side Empty Row -->
                <tr id="liveEmptyRow" style="display:none;">
                    <td colspan="8" style="text-align:center; padding:40px 20px;">
                        <div style="font-size:1.8rem; margin-bottom:8px;">🔎</div>
                        <h4 style="font-size:1.05rem; color:#0f172a; font-weight:750; margin-bottom:4px;">No products match "<span id="liveQuerySpan" style="color:#2563eb;"></span>"</h4>
                        <p style="color:#64748b; font-size:0.82rem; margin-bottom:12px;">
                            Press <strong>Enter</strong> or click <strong>Search</strong> to query the entire database.
                        </p>
                        <button type="button" onclick="clearAdminSearch()" class="btn-action-outline" style="font-size:0.78rem; padding:5px 14px;">
                            Clear Filter
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div style="margin-top:20px;" id="paginationWrap">
        {{ $products->links() }}
    </div>
@endsection

@section('scripts')
<script>
    const searchInput = document.getElementById('adminSearchInput');
    const clearBtn = document.getElementById('clearSearchBtn');
    const rows = document.querySelectorAll('.product-row');
    const liveEmptyRow = document.getElementById('liveEmptyRow');
    const liveQuerySpan = document.getElementById('liveQuerySpan');
    const paginationWrap = document.getElementById('paginationWrap');

    // Instant real-time filtering as you type (matches ID, name, color, category, sizes, price)
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const query = this.value.trim().toLowerCase();
            const cleanId = query.replace(/^#/, '').replace(/^id[\s:=]*/i, '').trim();
            const isNumeric = cleanId !== '' && !isNaN(cleanId);
            
            // Toggle clear button
            if (clearBtn) {
                clearBtn.style.display = query.length > 0 ? 'block' : 'none';
            }

            if (!rows.length) return;

            let visibleCount = 0;

            rows.forEach(row => {
                const id = row.getAttribute('data-id') || '';
                const name = row.getAttribute('data-name') || '';
                const color = row.getAttribute('data-color') || '';
                const cat = row.getAttribute('data-cat') || '';
                const sizes = row.getAttribute('data-sizes') || '';
                const price = row.getAttribute('data-price') || '';

                const matchesId = (isNumeric && (id === cleanId || id.startsWith(cleanId))) || ('#' + id) === query || ('id:' + id) === query || ('id ' + id) === query;
                const matchesOther = name.includes(query) || color.includes(query) || cat.includes(query) || sizes.includes(query) || price.includes(query);

                if (!query || matchesId || matchesOther) {
                    row.style.display = '';
                    visibleCount++;
                } else {
                    row.style.display = 'none';
                }
            });

            // Show live empty message if no rows match on current page
            if (visibleCount === 0 && query.length > 0) {
                if (liveEmptyRow) {
                    liveEmptyRow.style.display = '';
                    if (liveQuerySpan) liveQuerySpan.textContent = query;
                }
            } else {
                if (liveEmptyRow) liveEmptyRow.style.display = 'none';
            }

            // Hide pagination while client filtering is active
            if (paginationWrap) {
                paginationWrap.style.display = query.length > 0 ? 'none' : '';
            }
        });
    }

    function clearAdminSearch() {
        if (searchInput) {
            searchInput.value = '';
            if (clearBtn) clearBtn.style.display = 'none';
            
            // Reset all rows
            rows.forEach(row => row.style.display = '');
            if (liveEmptyRow) liveEmptyRow.style.display = 'none';
            if (paginationWrap) paginationWrap.style.display = '';
            
            // If the URL already had ?search=..., navigate back to clean URL
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.has('search')) {
                urlParams.delete('search');
                const newQuery = urlParams.toString();
                window.location.href = window.location.pathname + (newQuery ? '?' + newQuery : '');
            } else {
                searchInput.focus();
            }
        }
    }
</script>
@endsection
