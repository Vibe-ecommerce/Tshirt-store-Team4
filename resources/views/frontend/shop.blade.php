@extends('layouts.store')

@section('title', 'Shop All T-Shirts — T-Shirt Online')

@section('styles')
<style>
    .shop-header {
        background: radial-gradient(circle at 50% 0%, rgba(99, 102, 241, 0.08) 0%, transparent 70%);
        padding: 55px 24px 35px;
        text-align: center;
        border-bottom: 1px solid #e2e8f0;
    }

    .shop-title {
        font-size: clamp(2.2rem, 4vw, 3.2rem);
        font-weight: 900;
        letter-spacing: -0.03em;
        color: #0f172a;
        margin-bottom: 12px;
    }

    .shop-desc {
        color: #64748b;
        font-size: 1.08rem;
        max-width: 640px;
        margin: 0 auto;
        line-height: 1.6;
    }

    .shop-container {
        max-width: 1280px;
        margin: 40px auto 80px;
        padding: 0 24px;
    }

    /* Filter & Controls Bar */
    .controls-bar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
        flex-wrap: wrap;
        margin-bottom: 30px;
        background: #ffffff;
        padding: 20px 24px;
        border-radius: 20px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 4px 20px rgba(15, 23, 42, 0.04);
    }

    .category-pills {
        display: flex;
        align-items: center;
        gap: 8px;
        flex-wrap: wrap;
    }

    .cat-pill {
        padding: 8px 18px;
        border-radius: var(--radius-full);
        font-size: 0.86rem;
        font-weight: 750;
        border: 1px solid #cbd5e1;
        color: #334155;
        transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
        background: #ffffff;
        text-decoration: none;
        box-shadow: 0 2px 6px rgba(15, 23, 42, 0.02);
    }

    .cat-pill:hover {
        background: #f1f5f9;
        border-color: #94a3b8;
        color: #0f172a;
        transform: translateY(-1px);
    }

    .cat-pill.active {
        background: #0f172a;
        color: #ffffff;
        border-color: #0f172a;
        box-shadow: 0 4px 14px rgba(15, 23, 42, 0.22);
    }

    .search-sort-group {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
    }

    .search-box-wrap {
        position: relative;
        display: flex;
        align-items: center;
    }

    .search-icon-left {
        position: absolute;
        left: 14px;
        color: #64748b;
        pointer-events: none;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .search-input {
        background: #f8fafc;
        border: 1px solid #cbd5e1;
        color: #0f172a;
        padding: 10px 38px 10px 38px;
        border-radius: var(--radius-full);
        font-size: 0.88rem;
        font-weight: 600;
        outline: none;
        width: 240px;
        transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
    }

    .search-input:focus {
        width: 290px;
        border-color: #0f172a;
        box-shadow: 0 0 0 3px rgba(15, 23, 42, 0.08);
        background: #ffffff;
    }

    .search-clear-btn {
        position: absolute;
        right: 12px;
        background: rgba(0, 0, 0, 0.06);
        border: none;
        color: #64748b;
        width: 20px;
        height: 20px;
        border-radius: 50%;
        display: none;
        align-items: center;
        justify-content: center;
        font-size: 0.72rem;
        cursor: pointer;
        transition: all 0.2s;
    }

    .search-clear-btn:hover {
        background: rgba(239, 68, 68, 0.15);
        color: #ef4444;
    }

    .search-submit-btn {
        background: #0f172a;
        border: none;
        color: #ffffff;
        width: 38px;
        height: 38px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.2s;
        box-shadow: 0 2px 10px rgba(15, 23, 42, 0.15);
        flex-shrink: 0;
    }

    .search-submit-btn:hover {
        transform: scale(1.08);
        background: #000000;
        box-shadow: 0 4px 16px rgba(15, 23, 42, 0.25);
    }

    .sort-select {
        background: #f8fafc;
        border: 1px solid #cbd5e1;
        color: #0f172a;
        padding: 10px 18px;
        border-radius: var(--radius-full);
        font-size: 0.88rem;
        font-weight: 700;
        outline: none;
        cursor: pointer;
        transition: border-color 0.2s;
    }

    .sort-select:focus {
        border-color: #0f172a;
    }

    .active-search-bar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        background: #eff6ff;
        border: 1px solid #bfdbfe;
        border-radius: 16px;
        padding: 14px 22px;
        margin-bottom: 26px;
    }

    /* Product Grid */
    .products-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 28px;
    }

    .product-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 20px;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        position: relative;
        box-shadow: 0 4px 16px rgba(15, 23, 42, 0.04);
    }

    .product-card:hover {
        transform: translateY(-5px);
        border-color: #cbd5e1;
        box-shadow: 0 16px 36px rgba(15, 23, 42, 0.09);
        background: #ffffff;
    }

    .product-img-wrapper {
        position: relative;
        width: 100%;
        aspect-ratio: 1 / 1;
        overflow: hidden;
        background: #f8fafc;
    }

    .product-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.4s ease;
    }

    .product-card:hover .product-img {
        transform: scale(1.05);
    }

    .badge-tag {
        position: absolute;
        top: 12px;
        left: 12px;
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(8px);
        border: 1px solid #e2e8f0;
        color: #0f172a;
        font-size: 0.72rem;
        font-weight: 800;
        padding: 4px 10px;
        border-radius: var(--radius-full);
        text-transform: uppercase;
        letter-spacing: 0.5px;
        box-shadow: 0 2px 8px rgba(15, 23, 42, 0.06);
        z-index: 2;
    }

    .badge-stockout {
        position: absolute;
        bottom: 12px;
        left: 12px;
        background: #ef4444;
        color: #ffffff;
        font-size: 0.7rem;
        font-weight: 800;
        padding: 4px 10px;
        border-radius: var(--radius-full);
        text-transform: uppercase;
        letter-spacing: 0.8px;
        box-shadow: 0 4px 14px rgba(239, 68, 68, 0.35);
        z-index: 2;
    }

    .badge-lowstock {
        position: absolute;
        bottom: 12px;
        left: 12px;
        background: #ef4444;
        color: #ffffff;
        font-size: 0.68rem;
        font-weight: 800;
        padding: 4px 9px;
        border-radius: var(--radius-full);
        letter-spacing: 0.4px;
        z-index: 2;
        box-shadow: 0 2px 8px rgba(239, 68, 68, 0.3);
    }

    .wishlist-float-form {
        position: absolute;
        top: 12px;
        right: 12px;
        z-index: 3;
        margin: 0;
    }

    .wishlist-float-btn {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(8px);
        border: 1px solid #e2e8f0;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
        box-shadow: 0 4px 12px rgba(15, 23, 42, 0.08);
        padding: 0;
    }

    .wishlist-float-btn:hover {
        transform: scale(1.1);
        background: #ffffff;
        border-color: #fca5a5;
        box-shadow: 0 6px 16px rgba(239, 68, 68, 0.2);
    }

    .wishlist-float-btn:hover svg {
        stroke: #ef4444;
        fill: rgba(239, 68, 68, 0.15);
    }

    .product-body {
        padding: 20px 22px 22px;
        display: flex;
        flex-direction: column;
        flex: 1;
    }

    .product-cat-label {
        font-size: 0.72rem;
        font-weight: 700;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        color: #64748b;
        margin-bottom: 6px;
        display: block;
    }

    .product-title-link {
        text-decoration: none;
        color: inherit;
    }

    .product-title {
        font-size: 1.05rem;
        font-weight: 700;
        color: #0f172a;
        line-height: 1.38;
        height: 2.76em;
        margin-bottom: 8px;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        transition: color 0.2s ease;
        text-transform: capitalize;
        letter-spacing: -0.015em;
    }

    .product-card:hover .product-title {
        color: #2563eb;
    }

    .product-rating-row {
        display: flex;
        align-items: center;
        gap: 5px;
        font-size: 0.8rem;
        margin-bottom: 12px;
    }

    .star-rating-icon {
        color: #f59e0b;
        font-size: 0.95rem;
    }

    .star-rating-val {
        font-weight: 700;
        color: #0f172a;
    }

    .rating-dot {
        color: #cbd5e1;
        font-size: 0.7rem;
    }

    .rating-reviews-count {
        color: #94a3b8;
        font-size: 0.76rem;
        font-weight: 500;
    }

    .product-price-row {
        display: flex;
        align-items: baseline;
        gap: 8px;
        margin-bottom: 16px;
        margin-top: auto;
    }

    .product-price {
        font-size: 1.32rem;
        font-weight: 800;
        color: #0f172a;
        letter-spacing: -0.02em;
    }

    .product-original-price {
        font-size: 0.9rem;
        color: #94a3b8;
        text-decoration: line-through;
    }

    .product-discount-pill {
        font-size: 0.72rem;
        font-weight: 800;
        color: #ef4444;
        background: #fef2f2;
        border: 1px solid #fee2e2;
        padding: 2px 8px;
        border-radius: var(--radius-full);
        letter-spacing: 0.02em;
    }

    .product-action-wrap {
        width: 100%;
    }

    .card-action-dual {
        display: flex;
        gap: 8px;
        width: 100%;
        align-items: center;
    }

    .btn-shop-cart-dual {
        width: 100%;
        height: 42px;
        background: #0f172a;
        color: #ffffff;
        border: 1px solid rgba(15, 23, 42, 0.2);
        border-radius: var(--radius-full);
        font-size: 0.86rem;
        font-weight: 700;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
        box-shadow: 0 2px 8px rgba(15, 23, 42, 0.08);
        white-space: nowrap;
    }

    .btn-shop-cart-dual:hover {
        background: #1e293b;
        transform: translateY(-2px);
        box-shadow: 0 4px 14px rgba(15, 23, 42, 0.2);
        color: #ffffff;
    }

    .btn-shop-buynow-dual {
        width: 100%;
        height: 42px;
        background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
        color: #ffffff;
        border: none;
        border-radius: var(--radius-full);
        font-size: 0.86rem;
        font-weight: 800;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
        box-shadow: 0 4px 14px rgba(37, 99, 235, 0.28);
        white-space: nowrap;
    }

    .btn-shop-buynow-dual:hover {
        background: linear-gradient(135deg, #1d4ed8 0%, #1e40af 100%);
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(37, 99, 235, 0.4);
        color: #ffffff;
    }

    .btn-shop-cart-dual:active,
    .btn-shop-buynow-dual:active {
        transform: translateY(0);
    }

    .btn-shop-cart-full {
        width: 100%;
        height: 44px;
        background: #0f172a;
        color: #ffffff;
        border: none;
        border-radius: var(--radius-full);
        font-size: 0.92rem;
        font-weight: 700;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        transition: all 0.22s cubic-bezier(0.16, 1, 0.3, 1);
        box-shadow: 0 4px 14px rgba(15, 23, 42, 0.12);
        letter-spacing: 0.01em;
    }

    .btn-shop-cart-full:hover {
        background: #2563eb;
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(37, 99, 235, 0.3);
        color: #ffffff;
    }

    .btn-shop-cart-full:active {
        transform: translateY(0);
    }

    .btn-stockout-full {
        width: 100%;
        height: 44px;
        background: #f1f5f9;
        color: #94a3b8;
        border: 1px solid #e2e8f0;
        border-radius: var(--radius-full);
        font-size: 0.88rem;
        font-weight: 750;
        cursor: not-allowed;
        display: flex;
        align-items: center;
        justify-content: center;
        user-select: none;
    }

    .btn-stockout {
        background: #f1f5f9;
        color: #94a3b8;
        border: 1px solid #e2e8f0;
        border-radius: var(--radius-full);
        font-size: 0.82rem;
        font-weight: 750;
        padding: 9px 18px;
        cursor: not-allowed;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        user-select: none;
        white-space: nowrap;
    }

    .product-img.is-stockout {
        filter: grayscale(70%);
        opacity: 0.75;
    }

    .empty-state {
        text-align: center;
        padding: 80px 20px;
        background: #ffffff;
        border-radius: var(--radius-lg);
        border: 1px solid #e2e8f0;
    }
</style>
@endsection

@section('content')

    <div class="shop-header">
        <h1 class="shop-title">Shop Our Collection</h1>
        <p class="shop-desc">
            Explore curated heavyweight combed tees, retro graphics, designer streetwear shoes, and luxury minimalist essentials.
        </p>
    </div>

    <div class="shop-container">
        <!-- Filter Bar -->
        <div class="controls-bar">
            <div class="category-pills">
                @foreach ($categories as $cat)
                    @php
                        $isAll = ($cat == 'All Products' || $cat == 'All T-Shirts');
                        $isActive = ($category == $cat) || (!$category && $isAll);
                    @endphp
                    <a href="{{ route('shop.index', ['category' => ($isAll ? null : $cat), 'sort' => request('sort'), 'search' => request('search')]) }}" 
                       class="cat-pill {{ $isActive ? 'active' : '' }}">
                        {{ $cat }}
                    </a>
                @endforeach
            </div>

            <form action="{{ route('shop.index') }}" method="GET" class="search-sort-group" id="shopSearchForm">
                @if (request('category'))
                    <input type="hidden" name="category" value="{{ request('category') }}">
                @endif
                
                <!-- Search Box with Icon & Instant Search -->
                <div class="search-box-wrap">
                    <span class="search-icon-left">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="11" cy="11" r="8"></circle>
                            <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                        </svg>
                    </span>
                    <input type="text" name="search" id="shopSearchInput" class="search-input" 
                           placeholder="Search tees, trousers, shoes, bags, hats, watches..." 
                           value="{{ request('search') }}"
                           autocomplete="off">
                    <button type="button" id="searchClearBtn" class="search-clear-btn" onclick="clearShopSearch()" title="Clear search">✕</button>
                </div>

                <button type="submit" class="search-submit-btn" title="Search products">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="11" cy="11" r="8"></circle>
                        <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                    </svg>
                </button>
                
                <select name="sort" class="sort-select" onchange="this.form.submit()">
                    <option value="featured" {{ request('sort') == 'featured' ? 'selected' : '' }}>Featured</option>
                    <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Latest</option>
                    <option value="rating" {{ request('sort') == 'rating' ? 'selected' : '' }}>Top Rated</option>
                    <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                    <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                </select>
            </form>
        </div>

        <!-- Active Search Banner -->
        @if (request('search'))
            <div class="active-search-bar" id="activeSearchBar">
                <div style="display:flex; align-items:center; gap:10px;">
                    <span style="color:#2563eb; display:flex;">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="11" cy="11" r="8"></circle>
                            <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                        </svg>
                    </span>
                    <div>
                        <span style="font-size:0.92rem; color:#0f172a; font-weight:700;">
                            Showing search results for: <strong style="color:#2563eb;">"{{ request('search') }}"</strong>
                        </span>
                        <span style="color:#64748b; font-size:0.84rem; margin-left:8px;">
                            ({{ $products->total() }} items found)
                        </span>
                    </div>
                </div>
                <a href="{{ route('shop.index', ['category' => request('category'), 'sort' => request('sort')]) }}" 
                   class="btn-outline" style="padding:6px 14px; font-size:0.8rem; border-radius:var(--radius-full); gap:6px; background:#ffffff; border:1px solid #cbd5e1; color:#0f172a; font-weight:700;">
                    <span>✕</span> Clear Search
                </a>
            </div>
        @endif

        <!-- Live Instant Search Counter (Dynamic via JS) -->
        <div id="liveSearchInfo" style="display:none; margin-bottom:20px; font-size:0.88rem; color:#1e40af; background:#eff6ff; border:1px solid #bfdbfe; padding:10px 18px; border-radius:var(--radius-md); font-weight:600;">
        </div>

        <!-- Products -->
        @if ($products->count() > 0)
            <div class="products-grid" id="shopProductsGrid">
                @foreach ($products as $product)
                    <div class="product-card"
                         data-name="{{ strtolower($product->name) }}"
                         data-category="{{ strtolower($product->category) }}"
                         data-desc="{{ strtolower($product->description) }}"
                         data-color="{{ strtolower($product->color) }}">
                        
                        <div class="product-img-wrapper">
                            <a href="{{ route('product.detail', $product->id) }}" style="display:block; width:100%; height:100%;">
                                <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" class="product-img {{ $product->isOutOfStock() ? 'is-stockout' : '' }}">
                            </a>

                            @if ($product->isOutOfStock())
                                <span class="badge-stockout">Sold Out</span>
                            @elseif ($product->isLowStock())
                                <span class="badge-lowstock">Only {{ $product->stock }} left</span>
                            @endif

                            <!-- Floating Wishlist Button -->
                            <form action="{{ route('wishlist.toggle', $product->id) }}" method="POST" class="wishlist-float-form">
                                @csrf
                                @php $isWishlisted = in_array($product->id, session('wishlist', [])); @endphp
                                <button type="submit" class="wishlist-float-btn {{ $isWishlisted ? 'active' : '' }}" title="{{ $isWishlisted ? 'Remove from Wishlist' : 'Add to Wishlist' }}" aria-label="Toggle Wishlist">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="{{ $isWishlisted ? '#ef4444' : 'none' }}" stroke="{{ $isWishlisted ? '#ef4444' : '#64748b' }}" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
                                    </svg>
                                </button>
                            </form>
                        </div>

                        <div class="product-body">
                            <span class="product-cat-label">{{ $product->category }}</span>
                            <a href="{{ route('product.detail', $product->id) }}" class="product-title-link">
                                <h3 class="product-title">{{ $product->name }}</h3>
                            </a>
                            <div class="product-rating-row">
                                <span class="star-rating-icon">★</span>
                                <span class="star-rating-val">{{ number_format($product->rating, 1) }}</span>
                                <span class="rating-dot">•</span>
                                <span class="rating-reviews-count">Top Rated</span>
                            </div>
                            <div class="product-price-row" style="flex-direction:column; align-items:flex-start; gap:2px;">
                                <div style="display:flex; align-items:baseline; gap:8px; flex-wrap:wrap;">
                                    <span class="product-price">${{ number_format($product->price, 2) }}</span>
                                    @if ($product->original_price && $product->original_price > $product->price)
                                        @php $pct = round((($product->original_price - $product->price) / $product->original_price) * 100); @endphp
                                        <span class="product-original-price">${{ number_format($product->original_price, 2) }}</span>
                                        <span class="product-discount-pill">-{{ $pct }}%</span>
                                    @endif
                                </div>
                                <div style="font-size:0.75rem; color:#64748b; font-weight:700;">≈ @khr($product->price)</div>
                            </div>
                            <div class="product-action-wrap">
                                @if ($product->isOutOfStock())
                                    <button type="button" class="btn-stockout-full" disabled>
                                        <span>Sold Out</span>
                                    </button>
                                @else
                                    <div class="card-action-dual">
                                        <form action="{{ route('cart.add', $product->id) }}" method="POST" style="flex: 1; margin: 0;">
                                            @csrf
                                            <input type="hidden" name="size" value="L">
                                            <button type="submit" class="btn-shop-cart-dual" title="Add to Cart">
                                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                                    <path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"></path>
                                                    <path d="M3 6h18"></path>
                                                    <path d="M16 10a4 4 0 0 1-8 0"></path>
                                                </svg>
                                                <span>Cart</span>
                                            </button>
                                        </form>
                                        <form action="{{ route('cart.buyNow', $product->id) }}" method="POST" style="flex: 1.1; margin: 0;">
                                            @csrf
                                            <input type="hidden" name="size" value="L">
                                            <button type="submit" class="btn-shop-buynow-dual" title="Buy Now & Proceed to Checkout">
                                                <svg width="13" height="13" viewBox="0 0 24 24" fill="currentColor">
                                                    <path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"></path>
                                                </svg>
                                                <span>Buy Now</span>
                                            </button>
                                        </form>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Client-side No Results (hidden by default) -->
            <div id="noMatchCard" class="empty-state" style="display:none; margin-top:10px;">
                <div style="font-size: 3rem; margin-bottom: 12px;">🔍</div>
                <h3 style="font-size: 1.5rem; margin-bottom: 8px;">No matching products on this page</h3>
                <p style="color: var(--text-muted); margin-bottom: 20px;" id="noMatchText">Try searching with a different term.</p>
                <button type="button" onclick="clearShopSearch()" class="btn-primary" style="padding: 10px 24px;">Clear Search</button>
            </div>

            <div style="margin-top: 40px; display: flex; justify-content: center;" id="paginationWrap">
                {{ $products->links('vendor.pagination.custom') }}
            </div>
        @else
            <div class="empty-state">
                <div style="font-size: 3rem; margin-bottom: 12px;">🔍</div>
                <h3 style="font-size: 1.5rem; margin-bottom: 8px;">No products match your search</h3>
                <p style="color: var(--text-muted); margin-bottom: 24px;">
                    We couldn't find anything matching <strong>"{{ request('search') }}"</strong>.
                </p>
                <a href="{{ route('shop.index') }}" class="btn-primary" style="padding: 10px 24px;">View All Products</a>
            </div>
        @endif
    </div>

@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('shopSearchInput');
        const clearBtn = document.getElementById('searchClearBtn');
        const liveSearchInfo = document.getElementById('liveSearchInfo');
        const productCards = document.querySelectorAll('#shopProductsGrid .product-card');
        const noMatchCard = document.getElementById('noMatchCard');
        const noMatchText = document.getElementById('noMatchText');
        const paginationWrap = document.getElementById('paginationWrap');

        function toggleClearBtn() {
            if (searchInput && clearBtn) {
                clearBtn.style.display = searchInput.value.trim().length > 0 ? 'flex' : 'none';
            }
        }

        window.clearShopSearch = function() {
            if (searchInput) {
                searchInput.value = '';
                toggleClearBtn();
                if (new URLSearchParams(window.location.search).has('search')) {
                    const url = new URL(window.location.href);
                    url.searchParams.delete('search');
                    window.location.href = url.toString();
                } else {
                    filterCardsLocally('');
                }
            }
        };

        function filterCardsLocally(query) {
            query = query.toLowerCase().trim();
            let visibleCount = 0;

            productCards.forEach(card => {
                const name = card.dataset.name || '';
                const cat = card.dataset.category || '';
                const desc = card.dataset.desc || '';
                const color = card.dataset.color || '';

                if (!query || name.includes(query) || cat.includes(query) || desc.includes(query) || color.includes(query)) {
                    card.style.display = '';
                    visibleCount++;
                } else {
                    card.style.display = 'none';
                }
            });

            if (query.length > 0) {
                if (paginationWrap) paginationWrap.style.display = 'none';
                if (visibleCount === 0) {
                    if (noMatchCard) {
                        noMatchCard.style.display = 'block';
                        if (noMatchText) noMatchText.textContent = `No t-shirts match "${query}". Press Enter to search all pages or clear filter.`;
                    }
                    if (liveSearchInfo) liveSearchInfo.style.display = 'none';
                } else {
                    if (noMatchCard) noMatchCard.style.display = 'none';
                    if (liveSearchInfo) {
                        liveSearchInfo.style.display = 'block';
                        liveSearchInfo.innerHTML = `⚡ Live filter: <strong>${visibleCount}</strong> t-shirt(s) found matching "<em>${escapeHtml(query)}</em>" &nbsp;•&nbsp; <small style="color:var(--text-muted);">Press Enter for full database search</small>`;
                    }
                }
            } else {
                if (noMatchCard) noMatchCard.style.display = 'none';
                if (liveSearchInfo) liveSearchInfo.style.display = 'none';
                if (paginationWrap) paginationWrap.style.display = 'flex';
            }
        }

        function escapeHtml(text) {
            const div = document.createElement('div');
            div.textContent = text;
            return div.innerHTML;
        }

        if (searchInput) {
            toggleClearBtn();
            searchInput.addEventListener('input', function() {
                toggleClearBtn();
                filterCardsLocally(this.value);
            });
        }
    });
</script>
@endsection
