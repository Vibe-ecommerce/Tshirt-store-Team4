@extends('layouts.admin')

@section('title', 'Product Management')
@section('page-title', 'Product Management')

@section('content')
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px; flex-wrap:wrap; gap:16px;">
        <div>
            <div style="display:flex; align-items:center; gap:10px;">
                <h2 style="font-size:1.5rem; font-weight:850; color:#0f172a; letter-spacing:-0.3px;">All Products (<span id="productTotalCount">{{ $products->total() }}</span>)</h2>
                @if (request('search'))
                    <span style="background:#eef2ff; border:1px solid #c7d2fe; color:#4338ca; font-size:0.75rem; font-weight:750; padding:3px 10px; border-radius:9999px;">
                        Filtered: "{{ request('search') }}"
                    </span>
                @endif
            </div>
            <p style="color:var(--text-muted); font-size:0.85rem; margin-top:2px;">Catalog of all t-shirts, prices, categories, and inventory statuses.</p>
        </div>
        <div style="display:flex; gap:10px;">
            <a href="{{ route('admin.products.inventory') }}" class="btn-outline" style="gap:7px; font-size:0.85rem; padding:7px 16px;">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16Z"></path><path d="m3.3 7 8.7 5 8.7-5"></path><path d="M12 22V12"></path></svg>
                <span>View Inventory</span>
            </a>
            <a href="{{ route('admin.products.create') }}" class="btn-primary" style="gap:7px; font-size:0.85rem; padding:7px 18px;">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                <span>+ Add Product</span>
            </a>
        </div>
    </div>

    <!-- Filter & Search Bar -->
    <div style="background:var(--bg-card); border:1px solid var(--border-subtle); border-radius:var(--radius-md); padding:14px 18px; margin-bottom:20px; display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:14px;">
        <!-- Categories Filter -->
        <div style="display:flex; gap:6px; flex-wrap:wrap; align-items:center;">
            <a href="{{ route('admin.products.index', array_filter(['search' => request('search')])) }}" 
               class="btn-outline category-pill {{ !request('category') ? 'active' : '' }}" 
               style="{{ !request('category') ? 'background:#4f46e5; border-color:#4f46e5; color:#ffffff; font-weight:750;' : 'background:#ffffff; color:#334155; font-weight:600;' }}">
               All
            </a>
            @foreach ($categories as $cat)
                <a href="{{ route('admin.products.index', array_filter(['category' => $cat, 'search' => request('search')])) }}" 
                   class="btn-outline category-pill {{ request('category') == $cat ? 'active' : '' }}" 
                   style="{{ request('category') == $cat ? 'background:#4f46e5; border-color:#4f46e5; color:#ffffff; font-weight:750;' : 'background:#ffffff; color:#334155; font-weight:600;' }}">
                    {{ $cat }}
                </a>
            @endforeach
        </div>

        <!-- Integrated Search Bar with Live Filter & Clear Button -->
        <form action="{{ route('admin.products.index') }}" method="GET" id="searchForm" style="display:flex; align-items:center; gap:8px; margin:0;">
            @if (request('category'))
                <input type="hidden" name="category" value="{{ request('category') }}">
            @endif

            <div style="position:relative; display:flex; align-items:center;">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" style="position:absolute; left:12px; color:var(--text-muted); pointer-events:none;">
                    <circle cx="11" cy="11" r="8"></circle>
                    <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                </svg>

                <input type="text" id="adminSearchInput" name="search" placeholder="Search by ID (e.g. #1), product, color..." 
                       value="{{ request('search') }}" 
                       autocomplete="off"
                       style="background:var(--bg-input); border:1px solid var(--border-subtle); color:#fff; padding:8px 34px 8px 34px; border-radius:var(--radius-full); font-size:0.84rem; outline:none; width:250px; transition:all 0.2s ease;">

                <button type="button" id="clearSearchBtn" onclick="clearAdminSearch()" 
                        style="position:absolute; right:10px; background:none; border:none; color:var(--text-muted); cursor:pointer; font-size:0.85rem; padding:2px; display:{{ request('search') ? 'block' : 'none' }}; line-height:1;" title="Clear search">
                    ✕
                </button>
            </div>

            <button type="submit" class="btn-primary" style="padding:7px 16px; font-size:0.82rem; border-radius:var(--radius-full); cursor:pointer;">
                Search
            </button>
        </form>
    </div>

    <!-- Active Search Info Bar -->
    @if (request('search'))
        <div style="display:flex; justify-content:space-between; align-items:center; background:rgba(99,102,241,0.08); border:1px solid rgba(99,102,241,0.25); border-radius:var(--radius-sm); padding:10px 16px; margin-bottom:16px;">
            <div style="font-size:0.85rem; color:#cbd5e1;">
                Showing search results for <strong style="color:#ffffff;">"{{ request('search') }}"</strong>
                @if (request('category'))
                    in category <strong style="color:#a5b4fc;">{{ request('category') }}</strong>
                @endif
                ({{ $products->total() }} total found)
            </div>
            <a href="{{ route('admin.products.index', array_filter(['category' => request('category')])) }}" style="font-size:0.8rem; color:#f87171; text-decoration:none; display:inline-flex; align-items:center; gap:4px; font-weight:700;">
                ✕ Clear Search Filter
            </a>
        </div>
    @endif

    <div class="table-card">
        <table class="custom-table" id="productsTable">
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
                    <tr class="product-row" data-id="{{ $product->id }}" data-name="{{ strtolower($product->name) }}" data-color="{{ strtolower($product->color ?? '') }}" data-cat="{{ strtolower($product->category) }}" data-sizes="{{ strtolower($product->sizes ?? '') }}" data-price="{{ $product->price }}">
                        <td style="font-family:monospace; font-weight:800; font-size:0.82rem;">
                            <span style="background:#eef2ff; border:1px solid #c7d2fe; color:#4338ca; padding:3px 8px; border-radius:6px; display:inline-block;">
                                #{{ $product->id }}
                            </span>
                        </td>
                        <td>
                            <div style="display:flex; align-items:center; gap:12px;">
                                <img src="{{ asset($product->image) }}" alt="" style="width:46px; height:46px; border-radius:8px; object-fit:cover; background:#f8fafc; border:1px solid #e2e8f0;">
                                <div>
                                    <strong class="product-title" style="color:#0f172a; font-size:0.95rem; font-weight:800; display:block;">{{ $product->name }}</strong>
                                    <div style="font-size:0.75rem; color:#64748b; font-weight:600; margin-top:2px;">★ {{ number_format($product->rating, 1) }} ({{ $product->review_count }} reviews)</div>
                                </div>
                            </div>
                        </td>
                        <td><span class="badge-status badge-blue">{{ $product->category }}</span></td>
                        <td>
                            <strong style="color:#0f172a; font-weight:850; font-size:0.98rem;">${{ number_format($product->price, 2) }}</strong>
                            @if ($product->original_price)
                                <div style="font-size:0.72rem; color:#94a3b8; text-decoration:line-through; font-weight:600;">${{ number_format($product->original_price, 2) }}</div>
                            @endif
                        </td>
                        <td>
                            <div style="font-size:0.88rem; font-weight:650; color:#1e293b;">{{ $product->color ?? 'Standard' }}</div>
                            <div style="font-size:0.72rem; color:#64748b; font-weight:600; margin-top:2px;">Sizes: {{ $product->sizes }}</div>
                        </td>
                        <td>
                            @if ($product->in_stock)
                                <span class="badge-status badge-green">In Stock</span>
                            @else
                                <span class="badge-status badge-red">Out of Stock</span>
                            @endif
                        </td>
                        <td>
                            @if ($product->is_featured)
                                <span style="display:inline-flex; align-items:center; gap:4px; background:#fef3c7; color:#b45309; border:1px solid #fde68a; padding:2px 8px; border-radius:9999px; font-size:0.78rem; font-weight:800;">★ Featured</span>
                            @else
                                <span style="color:#64748b; font-size:0.82rem; font-weight:600;">Standard</span>
                            @endif
                        </td>
                        <td style="text-align:right;">
                            <div style="display:flex; justify-content:flex-end; gap:8px;">
                                <a href="{{ route('admin.products.edit', $product->id) }}" class="btn-outline" style="padding:5px 12px; font-size:0.78rem;">Edit</a>
                                <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST"
                                      data-confirm="Are you sure you want to permanently delete this product? All size variants, inventory counts, and customer associations will be deleted from the catalog."
                                      data-confirm-title="Delete Product?"
                                      data-confirm-item="👕 {{ $product->name }}"
                                      data-confirm-badge="CATALOG DESTRUCTION"
                                      data-confirm-btn="Delete Product"
                                      data-confirm-type="danger"
                                      data-confirm-icon="🗑️">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-outline" style="padding:5px 12px; font-size:0.78rem; color:#f87171; border-color:rgba(239,68,68,0.3); transition:all 0.2s;">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" style="text-align:center; padding:54px 20px;">
                            <div style="font-size:2.4rem; margin-bottom:10px;">🔍</div>
                            <h4 style="font-size:1.15rem; color:#ffffff; font-weight:800; margin-bottom:6px;">No Products Found</h4>
                            <p style="color:var(--text-muted); font-size:0.88rem; max-width:420px; margin:0 auto 18px;">
                                @if (request('search'))
                                    No products matching <strong>"{{ request('search') }}"</strong> were found in {{ request('category') ?: 'any category' }}.
                                @else
                                    No products found in this category.
                                @endif
                            </p>
                            <a href="{{ route('admin.products.index') }}" class="btn-primary" style="font-size:0.84rem; padding:8px 20px;">
                                Clear Filters & View All
                            </a>
                        </td>
                    </tr>
                @endforelse

                <!-- Live Client-Side Empty Row -->
                <tr id="liveEmptyRow" style="display:none;">
                    <td colspan="8" style="text-align:center; padding:40px 20px;">
                        <div style="font-size:1.8rem; margin-bottom:8px;">🔎</div>
                        <h4 style="font-size:1.05rem; color:#ffffff; font-weight:700; margin-bottom:4px;">No products match "<span id="liveQuerySpan" style="color:#a5b4fc;"></span>"</h4>
                        <p style="color:var(--text-muted); font-size:0.82rem; margin-bottom:12px;">
                            Press <strong>Enter</strong> or click <strong>Search</strong> to query the entire database.
                        </p>
                        <button type="button" onclick="clearAdminSearch()" class="btn-outline" style="font-size:0.78rem; padding:5px 14px;">
                            Clear Filter
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <div style="margin-top:20px;" id="paginationWrap">
        {{ $products->links() }}
    </div>
@endsection

@section('styles')
<style>
    .category-pill {
        padding: 5px 13px !important;
        font-size: 0.8rem !important;
        border-radius: var(--radius-full) !important;
        transition: all 0.2s ease !important;
    }
    .category-pill:hover {
        background: rgba(255, 255, 255, 0.08) !important;
        color: #ffffff !important;
    }
    .category-pill.active {
        box-shadow: 0 0 12px rgba(99, 102, 241, 0.4);
    }
    #adminSearchInput:focus {
        border-color: #6366f1 !important;
        width: 300px !important;
        box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.25) !important;
    }
</style>
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
