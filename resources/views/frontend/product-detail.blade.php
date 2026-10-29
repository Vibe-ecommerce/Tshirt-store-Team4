@extends('layouts.store')

@section('title', $product->name . ' — T-Shirt Online')

@section('styles')
<style>
    .breadcrumb-nav {
        max-width: 1280px;
        margin: 24px auto 0;
        padding: 0 24px;
        font-size: 0.88rem;
        color: var(--text-muted);
    }

    .breadcrumb-nav a:hover {
        color: #0f172a;
    }

    .detail-container {
        max-width: 1280px;
        margin: 30px auto 80px;
        padding: 0 24px;
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 60px;
        align-items: start;
    }

    @media (max-width: 900px) {
        .detail-container {
            grid-template-columns: 1fr;
            gap: 40px;
        }
    }

    /* Product Gallery - Draggable & Clickable Carousel */
    .gallery-wrap {
        display: flex;
        flex-direction: column;
        gap: 16px;
        position: sticky;
        top: 90px;
    }

    .main-image-box {
        width: 100%;
        aspect-ratio: 1 / 1;
        background: #f8fafc;
        border-radius: var(--radius-lg);
        overflow: hidden;
        border: 1px solid var(--border-subtle);
        position: relative;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
    }

    .main-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: opacity 0.22s cubic-bezier(0.16, 1, 0.3, 1), transform 0.3s ease;
    }

    .main-image.is-switching {
        opacity: 0.3;
        transform: scale(0.98);
    }

    .main-counter-badge {
        position: absolute;
        top: 14px;
        right: 14px;
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        border: 1px solid #e2e8f0;
        color: #0f172a;
        font-size: 0.76rem;
        font-weight: 700;
        padding: 5px 12px;
        border-radius: var(--radius-full);
        pointer-events: none;
        letter-spacing: 0.5px;
        z-index: 5;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
    }

    /* Main image arrow navigation */
    .main-nav-btn {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        width: 42px;
        height: 42px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        border: 1px solid #e2e8f0;
        color: #0f172a;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        opacity: 0;
        transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
        z-index: 6;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    }

    .main-image-box:hover .main-nav-btn {
        opacity: 1;
    }

    .main-nav-btn:hover {
        background: #0f172a;
        color: #ffffff;
        border-color: #0f172a;
        transform: translateY(-50%) scale(1.08);
        box-shadow: 0 4px 16px rgba(15, 23, 42, 0.25);
    }

    .main-nav-btn.prev {
        left: 14px;
    }

    .main-nav-btn.next {
        right: 14px;
    }

    /* Horizontal Draggable & Scrollable Thumbnails Slider */
    .gallery-slider-wrap {
        position: relative;
        width: 100%;
        display: flex;
        align-items: center;
    }

    .slider-scroll-btn {
        position: absolute;
        top: calc(50% - 10px);
        transform: translateY(-50%);
        width: 30px;
        height: 30px;
        border-radius: 50%;
        background: #ffffff;
        border: 1px solid #cbd5e1;
        color: #0f172a;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        z-index: 10;
        transition: all 0.2s ease;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    }

    .slider-scroll-btn:hover {
        background: #0f172a;
        color: #ffffff;
        border-color: #0f172a;
        transform: translateY(-50%) scale(1.1);
    }

    .slider-scroll-btn.prev {
        left: -6px;
    }

    .slider-scroll-btn.next {
        right: -6px;
    }

    .thumbnails-track {
        display: flex;
        gap: 12px;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
        scroll-behavior: smooth;
        padding: 4px 4px 8px 4px;
        cursor: grab;
        user-select: none;
        -webkit-user-select: none;
        scrollbar-width: thin;
        scrollbar-color: #cbd5e1 transparent;
        width: 100%;
    }

    .thumbnails-track.is-dragging {
        cursor: grabbing;
        scroll-behavior: auto;
    }

    .thumbnails-track::-webkit-scrollbar {
        height: 4px;
    }

    .thumbnails-track::-webkit-scrollbar-track {
        background: #f1f5f9;
        border-radius: 4px;
    }

    .thumbnails-track::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 4px;
    }

    .thumbnail-card {
        flex: 0 0 auto;
        width: 82px;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 6px;
        cursor: pointer;
        transition: transform 0.2s cubic-bezier(0.16, 1, 0.3, 1);
    }

    .thumbnail-card:hover {
        transform: translateY(-3px);
    }

    .thumbnail-box {
        width: 82px;
        height: 82px;
        border-radius: var(--radius-sm);
        border: 2px solid var(--border-subtle);
        overflow: hidden;
        background: #f8fafc;
        transition: all 0.2s ease;
        position: relative;
    }

    .thumbnail-box img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        pointer-events: none;
    }

    .thumbnail-card.active .thumbnail-box {
        border-color: #0f172a;
        box-shadow: 0 0 0 2px rgba(15, 23, 42, 0.15);
    }

    .thumbnail-label {
        font-size: 0.74rem;
        font-weight: 600;
        color: var(--text-muted);
        text-align: center;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 82px;
        transition: color 0.2s;
    }

    .thumbnail-card.active .thumbnail-label {
        color: #0f172a;
        font-weight: 700;
    }

    .thumbnail-card:hover .thumbnail-label {
        color: #0f172a;
    }

    /* Info Column */
    .info-column {
        display: flex;
        flex-direction: column;
    }

    .product-category-tag {
        color: #2563eb;
        font-weight: 700;
        font-size: 0.82rem;
        text-transform: uppercase;
        letter-spacing: 0.6px;
        margin-bottom: 8px;
    }

    .product-name-title {
        font-size: clamp(2rem, 3.5vw, 2.6rem);
        font-weight: 800;
        line-height: 1.2;
        margin-bottom: 14px;
        color: #0f172a;
    }

    .rating-review-row {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 20px;
        font-size: 0.92rem;
    }

    .star-badge {
        color: #f59e0b;
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .review-count-text {
        color: var(--text-muted);
    }

    .price-box {
        display: flex;
        align-items: baseline;
        gap: 14px;
        margin-bottom: 24px;
        padding-bottom: 20px;
        border-bottom: 1px solid var(--border-subtle);
    }

    .main-price {
        font-size: 2.2rem;
        font-weight: 800;
        color: #0f172a;
    }

    .original-price {
        font-size: 1.2rem;
        color: var(--text-muted);
        text-decoration: line-through;
    }

    .save-pill {
        background: #ecfdf5;
        border: 1px solid #a7f3d0;
        color: #059669;
        padding: 4px 10px;
        border-radius: var(--radius-full);
        font-size: 0.82rem;
        font-weight: 700;
    }

    .product-description-text {
        color: var(--text-sub);
        font-size: 0.98rem;
        line-height: 1.7;
        margin-bottom: 30px;
    }

    /* Form Selectors */
    .selection-group {
        margin-bottom: 24px;
    }

    .selection-label {
        font-size: 0.88rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: var(--text-muted);
        margin-bottom: 10px;
        display: flex;
        justify-content: space-between;
    }

    .size-chips {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
        align-items: center;
    }

    .size-chip-label {
        position: relative;
        cursor: pointer;
        display: inline-flex;
    }

    .size-chip-label input {
        position: absolute;
        opacity: 0;
        pointer-events: none;
    }

    .size-chip-box {
        min-width: 52px;
        height: 44px;
        padding: 0 20px;
        border-radius: 12px;
        border: 1px solid var(--border-subtle);
        background: var(--bg-card);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 0.92rem;
        transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
        color: var(--text-main);
        white-space: nowrap;
        user-select: none;
        letter-spacing: 0.3px;
    }

    .size-chip-label:hover .size-chip-box {
        border-color: #0f172a;
        background: #f8fafc;
        transform: translateY(-2px);
    }

    .size-chip-label input:checked + .size-chip-box {
        background: #0f172a;
        border-color: #0f172a;
        color: #ffffff;
        box-shadow: 0 4px 14px rgba(15, 23, 42, 0.2);
        transform: translateY(-1px);
    }

    /* Size Guide Modal */
    .size-modal-overlay {
        position: fixed;
        inset: 0;
        background: rgba(15, 23, 42, 0.6);
        backdrop-filter: blur(12px);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 100000;
        padding: 20px;
        animation: fadeIn 0.2s ease;
    }

    .size-modal-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: var(--radius-lg);
        max-width: 580px;
        width: 100%;
        padding: 28px;
        box-shadow: 0 25px 60px rgba(0, 0, 0, 0.15);
        position: relative;
    }

    .size-modal-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 20px;
        padding-bottom: 12px;
        border-bottom: 1px solid #f1f5f9;
    }

    .size-modal-title {
        font-size: 1.25rem;
        font-weight: 800;
        color: #0f172a;
    }

    .size-table {
        width: 100%;
        border-collapse: collapse;
        margin: 16px 0;
        font-size: 0.88rem;
    }

    .size-table th {
        background: #f8fafc;
        color: #64748b;
        padding: 10px 14px;
        text-align: left;
        font-weight: 700;
        text-transform: uppercase;
        font-size: 0.76rem;
        letter-spacing: 0.5px;
    }

    .size-table td {
        padding: 12px 14px;
        border-bottom: 1px solid #f1f5f9;
        color: #0f172a;
    }

    .size-table tr:hover td {
        background: #f8fafc;
    }

    .color-swatch-box {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        background: var(--bg-card);
        padding: 8px 16px;
        border-radius: var(--radius-full);
        border: 1px solid var(--border-subtle);
        font-size: 0.9rem;
        font-weight: 600;
    }

    .color-dot {
        width: 16px;
        height: 16px;
        border-radius: var(--radius-full);
        background: #475569;
        display: inline-block;
    }

    .qty-stepper {
        display: flex;
        align-items: center;
        border: 1px solid var(--border-subtle);
        background: #ffffff;
        border-radius: var(--radius-full);
        width: 130px;
        overflow: hidden;
    }

    .stepper-btn {
        width: 40px;
        height: 42px;
        background: transparent;
        border: none;
        color: #0f172a;
        font-size: 1.1rem;
        font-weight: 700;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: background 0.2s ease;
    }

    .stepper-btn:hover {
        background: #f1f5f9;
    }

    .stepper-input {
        width: 50px;
        border: none;
        background: transparent;
        color: #0f172a;
        text-align: center;
        font-weight: 700;
        font-size: 1rem;
        outline: none;
    }

    .action-row {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-top: 10px;
        flex-wrap: wrap;
    }

    .add-to-cart-large {
        flex: 1;
        min-width: 150px;
        background: #0f172a;
        color: #ffffff;
        border: 1.5px solid #1e293b;
        padding: 14px 22px;
        border-radius: var(--radius-full);
        font-size: 1rem;
        font-weight: 750;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        box-shadow: 0 4px 18px rgba(15, 23, 42, 0.15);
        transition: all 0.22s cubic-bezier(0.16, 1, 0.3, 1);
        white-space: nowrap;
    }

    .add-to-cart-large:hover {
        background: #1e293b;
        border-color: #334155;
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(15, 23, 42, 0.25);
    }

    .add-to-cart-large:active {
        transform: translateY(0);
    }

    .buy-now-large {
        flex: 1.1;
        min-width: 160px;
        background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
        color: #ffffff;
        border: none;
        padding: 14px 24px;
        border-radius: var(--radius-full);
        font-size: 1rem;
        font-weight: 800;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        box-shadow: 0 4px 20px rgba(37, 99, 235, 0.35);
        transition: all 0.22s cubic-bezier(0.16, 1, 0.3, 1);
        white-space: nowrap;
        position: relative;
        overflow: hidden;
    }

    .buy-now-large::after {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 60%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.25), transparent);
        transform: skewX(-20deg);
        transition: left 0.6s ease;
    }

    .buy-now-large:hover {
        background: linear-gradient(135deg, #1d4ed8 0%, #1e40af 100%);
        transform: translateY(-2px);
        box-shadow: 0 8px 28px rgba(37, 99, 235, 0.45);
    }

    .buy-now-large:hover::after {
        left: 140%;
    }

    .buy-now-large:active {
        transform: translateY(0);
    }

    /* Product Highlights */
    .product-highlights {
        margin-top: 36px;
        padding-top: 24px;
        border-top: 1px solid var(--border-subtle);
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 14px;
    }

    .highlight-item {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 0.88rem;
        color: var(--text-sub);
    }

    /* Reviews Section */
    .reviews-section {
        max-width: 1280px;
        margin: 40px auto 80px;
        padding: 0 24px;
        border-top: 1px solid var(--border-subtle);
        padding-top: 60px;
    }

    .reviews-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 30px;
        flex-wrap: wrap;
        gap: 16px;
    }

    .reviews-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
        gap: 24px;
    }

    .review-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: var(--radius-md);
        padding: 24px;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.03);
    }

    .reviewer-info {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 12px;
    }

    .reviewer-name {
        font-weight: 700;
        font-size: 0.95rem;
        color: #0f172a;
    }

    .review-text {
        color: var(--text-sub);
        font-size: 0.9rem;
        line-height: 1.6;
    }
</style>
@endsection

@section('content')

    <!-- Breadcrumb -->
    <div class="breadcrumb-nav">
        <a href="{{ route('home') }}">Home</a> &nbsp;/&nbsp; 
        <a href="{{ route('shop.index', ['category' => $product->category]) }}">{{ $product->category }}</a> &nbsp;/&nbsp; 
        <span style="color: #0f172a; font-weight:600;">{{ $product->name }}</span>
    </div>

    <!-- Product Detail Container -->
    <div class="detail-container">
        <!-- 1. Product Images Gallery (Interactive Draggable & Clickable) -->
        <div class="gallery-wrap">
            <div class="main-image-box" id="mainImageBox">
                @if (count($product->gallery_items) > 1)
                    <span class="main-counter-badge" id="galleryCounter">1 / {{ count($product->gallery_items) }}</span>

                    <button type="button" class="main-nav-btn prev" onclick="stepGallery(-1)" title="Previous photo" aria-label="Previous photo">
                        <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"></polyline></svg>
                    </button>
                @endif

                <img src="{{ $product->gallery_items[0]['image'] ?? asset($product->image) }}" 
                     alt="{{ $product->name }}" 
                     class="main-image" 
                     id="mainImg">

                @if (count($product->gallery_items) > 1)
                    <button type="button" class="main-nav-btn next" onclick="stepGallery(1)" title="Next photo" aria-label="Next photo">
                        <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"></polyline></svg>
                    </button>
                @endif
            </div>

            <!-- Horizontal Draggable & Scrollable Thumbnails Slider -->
            @if (count($product->gallery_items) > 1)
            <div class="gallery-slider-wrap">
                <button type="button" class="slider-scroll-btn prev" onclick="scrollThumbnails(-1)" title="Scroll left" aria-label="Scroll left">
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"></polyline></svg>
                </button>

                <div class="thumbnails-track" id="thumbnailsTrack">
                    @foreach ($product->gallery_items as $index => $item)
                        <div class="thumbnail-card {{ $index === 0 ? 'active' : '' }}" 
                             data-index="{{ $index }}"
                             data-src="{{ $item['image'] }}"
                             onclick="selectGalleryImage({{ $index }})"
                             title="{{ $item['title'] ?? $item['label'] }}">
                            <div class="thumbnail-box">
                                <img src="{{ $item['image'] }}" alt="{{ $item['label'] }}" loading="lazy">
                            </div>
                            <span class="thumbnail-label">{{ $item['label'] }}</span>
                        </div>
                    @endforeach
                </div>

                <button type="button" class="slider-scroll-btn next" onclick="scrollThumbnails(1)" title="Scroll right" aria-label="Scroll right">
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"></polyline></svg>
                </button>
            </div>
            @endif
        </div>

        <!-- 2. Product Information -->
        <div class="info-column">
            <span class="product-category-tag">{{ $product->category }}</span>
            <h1 class="product-name-title">{{ $product->name }}</h1>

            <div class="rating-review-row">
                <div class="star-badge">
                    ★★★★★ &nbsp;<span>{{ number_format($product->rating, 1) }}</span>
                </div>
                <span class="review-count-text">({{ $product->review_count ?? 48 }} verified reviews)</span>
                @if ($product->isOutOfStock())
                    <span style="color: #f87171; font-weight: 700; background: rgba(239,68,68,0.12); padding: 3px 10px; border-radius: var(--radius-full); border: 1px solid rgba(239,68,68,0.3);">✕ Stockout (Out of Stock)</span>
                @elseif ($product->isLowStock())
                    <span style="color: #fbbf24; font-weight: 700; background: rgba(251,191,36,0.12); padding: 3px 10px; border-radius: var(--radius-full); border: 1px solid rgba(251,191,36,0.3);">⚠️ Low Stock (Only {{ $product->stock }} units left!)</span>
                @else
                    <span style="color: #4ade80; font-weight: 600; background: rgba(74,222,128,0.12); padding: 3px 10px; border-radius: var(--radius-full); border: 1px solid rgba(74,222,128,0.3);">✓ In Stock ({{ $product->stock }} units available)</span>
                @endif
            </div>

            <!-- Price -->
            <div class="price-box" style="align-items:baseline; gap:12px; flex-wrap:wrap;">
                <span class="main-price">${{ number_format($product->price, 2) }}</span>
                <span style="font-size:1.05rem; font-weight:850; color:#059669; background:#ecfdf5; border:1.5px solid #a7f3d0; padding:3px 10px; border-radius:8px;">≈ @khr($product->price)</span>
                @if ($product->original_price)
                    <span class="original-price">${{ number_format($product->original_price, 2) }}</span>
                    @php
                        $saveAmount = $product->original_price - $product->price;
                        $savePercent = round(($saveAmount / $product->original_price) * 100);
                    @endphp
                    <span class="save-pill">Save {{ $savePercent }}%</span>
                @endif
            </div>

            <!-- Description -->
            <p class="product-description-text">
                {{ $product->description }}
            </p>

            <form action="{{ route('cart.add', $product->id) }}" method="POST">
                @csrf

                <!-- Color Option -->
                <div class="selection-group">
                    <div class="selection-label">
                        <span>Color</span>
                        <span style="color: #ffffff;">{{ $product->color ?? 'Standard Edition' }}</span>
                    </div>
                    @php
                        $colorLower = strtolower($product->color ?? '');
                        $dotColor = '#64748b';
                        if (str_contains($colorLower, 'black') || str_contains($colorLower, 'charcoal') || str_contains($colorLower, 'obsidian') || str_contains($colorLower, 'onyx') || str_contains($colorLower, 'pitch')) {
                            $dotColor = '#1e293b';
                        } elseif (str_contains($colorLower, 'white') || str_contains($colorLower, 'cream')) {
                            $dotColor = '#f8fafc';
                        } elseif (str_contains($colorLower, 'sage') || str_contains($colorLower, 'green')) {
                            $dotColor = '#5a7360';
                        } elseif (str_contains($colorLower, 'chrome') || str_contains($colorLower, 'titanium') || str_contains($colorLower, 'slate') || str_contains($colorLower, 'gunmetal')) {
                            $dotColor = '#64748b';
                        } elseif (str_contains($colorLower, 'navy') || str_contains($colorLower, 'blue')) {
                            $dotColor = '#1e3a8a';
                        } elseif (str_contains($colorLower, 'brown') || str_contains($colorLower, 'caramel') || str_contains($colorLower, 'tan')) {
                            $dotColor = '#9a3412';
                        }
                    @endphp
                    <div class="color-swatch-box">
                        <span class="color-dot" style="background: {{ $dotColor }}; box-shadow: 0 0 0 1px rgba(255,255,255,0.25);"></span>
                        <span>{{ $product->color ?? 'Standard Edition' }}</span>
                    </div>
                    <input type="hidden" name="color" value="{{ $product->color ?? 'Standard' }}">
                </div>

                <!-- Size Selector -->
                @php
                    $sizes = $product->sizes_array;
                    $defaultSize = in_array('L', $sizes) ? 'L' : ($sizes[0] ?? 'Standard');
                @endphp
                <div class="selection-group">
                    <div class="selection-label">
                        <span>Select Size: <strong id="selectedSizeLabel" style="color: #ffffff; text-transform:none;">{{ $defaultSize }}</strong></span>
                        <a href="javascript:void(0)" onclick="openSizeGuideModal('{{ $product->category }}')" style="color: #a5b4fc; text-decoration: underline; font-weight: 600;">Size Guide</a>
                    </div>
                    <div class="size-chips">
                        @foreach ($sizes as $index => $size)
                            @php
                                $sizeVal = trim($size);
                                $isSelected = ($sizeVal === $defaultSize);
                            @endphp
                            <label class="size-chip-label">
                                <input type="radio" name="size" value="{{ $sizeVal }}" {{ $isSelected ? 'checked' : '' }} onchange="document.getElementById('selectedSizeLabel').textContent = this.value">
                                <div class="size-chip-box">{{ $sizeVal }}</div>
                            </label>
                        @endforeach
                    </div>
                </div>

                <!-- Quantity & Add to Cart -->
                <div class="selection-group">
                    <div class="selection-label">Quantity</div>
                    <div class="action-row">
                        @if ($product->isOutOfStock())
                            <div class="qty-stepper" style="opacity:0.5; pointer-events:none;">
                                <button type="button" class="stepper-btn" disabled>&minus;</button>
                                <input type="number" value="0" class="stepper-input" disabled>
                                <button type="button" class="stepper-btn" disabled>&plus;</button>
                            </div>

                            <button type="button" class="add-to-cart-large" style="background:rgba(239,68,68,0.15); border:1px solid rgba(239,68,68,0.4); color:#fca5a5; cursor:not-allowed; box-shadow:none;" disabled>
                                ✕ Sold Out (Stockout)
                            </button>
                        @else
                            <div class="qty-stepper">
                                <button type="button" class="stepper-btn" onclick="let inp = document.getElementById('qtyInput'); if(inp.value > 1) inp.value--;">&minus;</button>
                                <input type="number" id="qtyInput" name="quantity" value="1" min="1" max="{{ $product->stock }}" class="stepper-input">
                                <button type="button" class="stepper-btn" onclick="let inp = document.getElementById('qtyInput'); if(parseInt(inp.value) < {{ $product->stock }}) inp.value++;">&plus;</button>
                            </div>

                            <button type="submit" name="action" value="add" class="add-to-cart-large" title="Add to Cart">
                                <svg width="19" height="19" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><path d="M12 5v14M5 12h14"></path></svg>
                                <span>Add to Cart</span>
                            </button>

                            <button type="submit" name="action" value="buy_now" class="buy-now-large" title="Buy Now and proceed directly to checkout">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"></path></svg>
                                <span>Buy Now ⚡</span>
                            </button>
                        @endif
                    </div>
                </div>
            </form>

            <!-- Value Highlights -->
            <div class="product-highlights">
                <div class="highlight-item">
                    <span>🌿</span>
                    <span>100% Organic Heavy Combed Cotton</span>
                </div>
                <div class="highlight-item">
                    <span>⚡</span>
                    <span>Ships in 24 Hours with Tracking</span>
                </div>
                <div class="highlight-item">
                    <span>🔁</span>
                    <span>30-Day Hassle-Free Exchanges</span>
                </div>
                <div class="highlight-item">
                    <span>🛡️</span>
                    <span>Guaranteed Color Wash Fastness</span>
                </div>
            </div>
        </div>
    </div>

    <!-- 3. REVIEWS SECTION -->
    <section class="reviews-section">
        <div class="reviews-header">
            <div>
                <h2 style="font-size: 1.8rem; font-weight: 850; color:#0f172a;">Customer Reviews</h2>
                <p style="color: #64748b; font-size: 0.95rem;">Real feedback from verified purchasers of this item.</p>
            </div>
            <button type="button" class="btn-outline" onclick="openReviewModal()" style="padding:10px 22px; font-weight:750; border-radius:10px; cursor:pointer;">
                ✍️ Write a Review
            </button>
        </div>

        @php
            $approvedReviews = $product->reviews()->where('status', 'Approved')->latest()->get();
        @endphp

        <div class="reviews-grid">
            @forelse ($approvedReviews as $rev)
                <div class="review-card" style="border: 1.5px solid #e2e8f0; border-radius: 14px; padding: 22px; background: #ffffff; box-shadow: 0 4px 16px rgba(0,0,0,0.03);">
                    <div class="reviewer-info" style="display:flex; justify-content:space-between; align-items:center; margin-bottom:10px;">
                        <span class="reviewer-name" style="font-weight:800; font-size:1rem; color:#0f172a;">{{ $rev->reviewer_name }}</span>
                        <span style="color:#f59e0b; font-size:1.1rem; letter-spacing:1px;">{{ str_repeat('★', $rev->rating) }}{{ str_repeat('☆', max(0, 5 - $rev->rating)) }}</span>
                    </div>
                    <p class="review-text" style="color:#334155; font-size:0.92rem; line-height:1.6; margin-bottom:12px;">
                        "{{ $rev->comment }}"
                    </p>
                    <div style="font-size:0.78rem; color:#64748b; font-weight:600; display:flex; align-items:center; gap:6px;">
                        <span style="color:#059669; font-weight:700;">✓ Verified Buyer</span>
                        <span>•</span>
                        <span>{{ $rev->created_at ? $rev->created_at->format('M d, Y') : 'Recently' }}</span>
                    </div>
                </div>
            @empty
                <div style="grid-column: 1 / -1; text-align:center; padding:40px 20px; background:#f8fafc; border:1.5px dashed #cbd5e1; border-radius:14px;">
                    <div style="font-size:2rem; margin-bottom:10px;">💬</div>
                    <h3 style="font-size:1.1rem; font-weight:800; color:#0f172a; margin-bottom:6px;">No Reviews Yet</h3>
                    <p style="font-size:0.88rem; color:#64748b; margin-bottom:16px;">Be the first customer to share your thoughts on this product!</p>
                    <button type="button" class="btn-primary" onclick="openReviewModal()" style="padding:9px 20px; font-size:0.85rem; font-weight:750;">Leave a Review</button>
                </div>
            @endforelse
        </div>
    </section>

    <!-- Write a Review Modal -->
    <div id="reviewModal" class="size-modal-overlay" style="display:none;" onclick="if(event.target===this)closeReviewModal()">
        <div class="size-modal-card" style="max-width:520px; background:#ffffff; border:1.5px solid #e2e8f0; border-radius:18px; padding:28px; box-shadow:0 12px 40px rgba(0,0,0,0.15);">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px; padding-bottom:12px; border-bottom:1.5px solid #e2e8f0;">
                <div>
                    <div style="font-size:0.75rem; text-transform:uppercase; letter-spacing:0.8px; color:#4f46e5; font-weight:800;">SHARE YOUR EXPERIENCE</div>
                    <h3 style="font-size:1.25rem; font-weight:850; color:#0f172a; margin-top:2px;">Write a Review</h3>
                </div>
                <button type="button" onclick="closeReviewModal()" style="background:none; border:none; color:#64748b; font-size:1.4rem; cursor:pointer; padding:4px 8px;">✕</button>
            </div>

            <form action="{{ route('product.review.store', $product->id) }}" method="POST">
                @csrf
                <div style="margin-bottom:16px;">
                    <label style="display:block; font-size:0.80rem; font-weight:800; color:#1e293b; text-transform:uppercase; margin-bottom:6px;">Your Rating *</label>
                    <select name="rating" required style="width:100%; background:#ffffff; border:1.5px solid #cbd5e1; border-radius:10px; padding:10px 14px; font-weight:700; color:#0f172a; font-size:0.95rem; outline:none;">
                        <option value="5">★★★★★ (5 Stars - Outstanding)</option>
                        <option value="4">★★★★☆ (4 Stars - Very Good)</option>
                        <option value="3">★★★☆☆ (3 Stars - Average)</option>
                        <option value="2">★★☆☆☆ (2 Stars - Below Expectation)</option>
                        <option value="1">★☆☆☆☆ (1 Star - Poor)</option>
                    </select>
                </div>

                <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px; margin-bottom:16px;">
                    <div>
                        <label style="display:block; font-size:0.80rem; font-weight:800; color:#1e293b; text-transform:uppercase; margin-bottom:6px;">Your Name *</label>
                        <input type="text" name="reviewer_name" value="{{ auth()->user()->name ?? '' }}" required placeholder="e.g. John Doe" style="width:100%; background:#ffffff; border:1.5px solid #cbd5e1; border-radius:10px; padding:10px 14px; font-weight:600; color:#0f172a; font-size:0.90rem; outline:none;">
                    </div>
                    <div>
                        <label style="display:block; font-size:0.80rem; font-weight:800; color:#1e293b; text-transform:uppercase; margin-bottom:6px;">Your Email *</label>
                        <input type="email" name="reviewer_email" value="{{ auth()->user()->email ?? '' }}" required placeholder="e.g. john@example.com" style="width:100%; background:#ffffff; border:1.5px solid #cbd5e1; border-radius:10px; padding:10px 14px; font-weight:600; color:#0f172a; font-size:0.90rem; outline:none;">
                    </div>
                </div>

                <div style="margin-bottom:20px;">
                    <label style="display:block; font-size:0.80rem; font-weight:800; color:#1e293b; text-transform:uppercase; margin-bottom:6px;">Your Review / Comment *</label>
                    <textarea name="comment" rows="4" required placeholder="What did you like or dislike about the fit, fabric, screen print, or comfort?" style="width:100%; background:#ffffff; border:1.5px solid #cbd5e1; border-radius:10px; padding:10px 14px; font-weight:500; color:#0f172a; font-size:0.90rem; outline:none; resize:vertical;"></textarea>
                </div>

                <div style="display:flex; justify-content:flex-end; gap:10px;">
                    <button type="button" onclick="closeReviewModal()" style="padding:10px 18px; border:1.5px solid #cbd5e1; background:#ffffff; border-radius:10px; font-size:0.88rem; font-weight:750; color:#64748b; cursor:pointer;">Cancel</button>
                    <button type="submit" class="btn-primary" style="padding:10px 24px; border-radius:10px; font-size:0.92rem; font-weight:800;">Submit Review →</button>
                </div>
            </form>
        </div>
    </div>
    <!-- Size Guide Interactive Modal -->
    <div id="sizeGuideModal" class="size-modal-overlay" style="display:none;" onclick="if(event.target===this)closeSizeGuideModal()">
        <div class="size-modal-card">
            <div class="size-modal-header">
                <div>
                    <div style="font-size:0.75rem; text-transform:uppercase; letter-spacing:1px; color:#818cf8; font-weight:700;">FIT & MEASUREMENTS</div>
                    <div class="size-modal-title" id="sizeGuideTitle">Sizing Chart & Fit Guide</div>
                </div>
                <button type="button" onclick="closeSizeGuideModal()" style="background:none; border:none; color:#94a3b8; font-size:1.3rem; cursor:pointer; padding:4px 8px;">✕</button>
            </div>

            <div id="sizeGuideContent">
                <!-- Dynamically populated based on category -->
            </div>

            <div style="margin-top:20px; padding-top:14px; border-top:1px solid rgba(255,255,255,0.06); display:flex; justify-content:space-between; align-items:center;">
                <span style="font-size:0.8rem; color:#94a3b8;">Need personal fit advice? Contact our support team anytime.</span>
                <button type="button" class="btn-primary" onclick="closeSizeGuideModal()" style="padding:7px 18px; font-size:0.84rem;">Got it</button>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
<script>
    function openReviewModal() {
        const modal = document.getElementById('reviewModal');
        if (modal) modal.style.display = 'flex';
    }

    function closeReviewModal() {
        const modal = document.getElementById('reviewModal');
        if (modal) modal.style.display = 'none';
    }

    function openSizeGuideModal(category) {
        const modal = document.getElementById('sizeGuideModal');
        const title = document.getElementById('sizeGuideTitle');
        const content = document.getElementById('sizeGuideContent');
        if (!modal || !content) return;

        title.textContent = `${category} — Size & Fit Guide`;

        if (category === 'Hats') {
            content.innerHTML = `
                <p style="color:#cbd5e1; font-size:0.92rem; margin-bottom:14px;">Our caps are engineered with an adjustable antique brass sliding strap for a customized, all-day comfortable fit.</p>
                <table class="size-table">
                    <thead><tr><th>Size Option</th><th>Head Circumference (cm)</th><th>Head Circumference (in)</th><th>Closure Type</th></tr></thead>
                    <tbody>
                        <tr><td><strong>Adjustable (OSFA)</strong></td><td>54 – 62 cm</td><td>21.2 – 24.4 in</td><td>Sliding buckle strap with tuck-in arch</td></tr>
                    </tbody>
                </table>
                <div style="font-size:0.82rem; color:#94a3b8; margin-top:8px;">💡 Fits standard adult head sizes XS through XXL comfortably.</div>
            `;
        } else if (category === 'Shoes') {
            content.innerHTML = `
                <p style="color:#cbd5e1; font-size:0.92rem; margin-bottom:14px;">Runs true to standard European sizing. If you have wider feet or prefer extra room, we recommend sizing up one EU size.</p>
                <table class="size-table">
                    <thead><tr><th>EU Size</th><th>Foot Length (cm)</th><th>US Men</th><th>UK</th></tr></thead>
                    <tbody>
                        <tr><td><strong>40</strong></td><td>25.0 cm</td><td>7.5</td><td>6.5</td></tr>
                        <tr><td><strong>41</strong></td><td>25.5 cm</td><td>8.0</td><td>7.0</td></tr>
                        <tr><td><strong>42</strong></td><td>26.0 cm</td><td>8.5</td><td>7.5</td></tr>
                        <tr><td><strong>43</strong></td><td>26.5 cm</td><td>9.5</td><td>8.5</td></tr>
                        <tr><td><strong>44</strong></td><td>27.0 cm</td><td>10.0</td><td>9.0</td></tr>
                        <tr><td><strong>45</strong></td><td>27.5 cm</td><td>11.0</td><td>10.0</td></tr>
                    </tbody>
                </table>
            `;
        } else if (category === 'Trousers') {
            content.innerHTML = `
                <p style="color:#cbd5e1; font-size:0.92rem; margin-bottom:14px;">Tailored relaxed streetwear cut. Features built-in waist adjusters and hem drawstrings for customized styling.</p>
                <table class="size-table">
                    <thead><tr><th>Waist (in)</th><th>Waist (cm)</th><th>Hip (cm)</th><th>Inseam (cm)</th></tr></thead>
                    <tbody>
                        <tr><td><strong>30</strong></td><td>76 cm</td><td>104 cm</td><td>74 cm</td></tr>
                        <tr><td><strong>31</strong></td><td>79 cm</td><td>107 cm</td><td>75 cm</td></tr>
                        <tr><td><strong>32</strong></td><td>81 cm</td><td>110 cm</td><td>76 cm</td></tr>
                        <tr><td><strong>33</strong></td><td>84 cm</td><td>113 cm</td><td>76 cm</td></tr>
                        <tr><td><strong>34</strong></td><td>86 cm</td><td>116 cm</td><td>77 cm</td></tr>
                        <tr><td><strong>36</strong></td><td>91 cm</td><td>121 cm</td><td>78 cm</td></tr>
                    </tbody>
                </table>
            `;
        } else if (category === 'Bags') {
            content.innerHTML = `
                <p style="color:#cbd5e1; font-size:0.92rem; margin-bottom:14px;">Ergonomic crossbody pack engineered for daily tech essentials, EDC tools, and mobile devices.</p>
                <table class="size-table">
                    <thead><tr><th>Dimension</th><th>Measurement</th><th>Details</th></tr></thead>
                    <tbody>
                        <tr><td><strong>Main Compartment</strong></td><td>30 x 18 x 8 cm</td><td>Fits 11-inch iPad / tablets, wallets & phones</td></tr>
                        <tr><td><strong>Strap Length</strong></td><td>70 – 135 cm</td><td>Adjustable ballistic nylon with quick-release buckle</td></tr>
                        <tr><td><strong>Capacity</strong></td><td>4.5 Liters</td><td>Dual zippered compartments + key leash</td></tr>
                    </tbody>
                </table>
            `;
        } else if (category === 'Watches') {
            content.innerHTML = `
                <p style="color:#cbd5e1; font-size:0.92rem; margin-bottom:14px;">Crafted with high-strength sandblasted titanium and scratch-resistant sapphire crystal.</p>
                <table class="size-table">
                    <thead><tr><th>Specification</th><th>Measurement</th></tr></thead>
                    <tbody>
                        <tr><td><strong>Case Diameter</strong></td><td>42 mm</td></tr>
                        <tr><td><strong>Lug to Lug</strong></td><td>48 mm</td></tr>
                        <tr><td><strong>Case Thickness</strong></td><td>11.5 mm</td></tr>
                        <tr><td><strong>Strap Width</strong></td><td>20 mm (Interchangeable)</td></tr>
                        <tr><td><strong>Water Resistance</strong></td><td>50 Meters (5 ATM)</td></tr>
                    </tbody>
                </table>
            `;
        } else if (category === 'Headphones') {
            content.innerHTML = `
                <p style="color:#cbd5e1; font-size:0.92rem; margin-bottom:14px;">Ergonomically contoured over-ear architecture engineered for audiophile-grade acoustic isolation.</p>
                <table class="size-table">
                    <thead><tr><th>Specification</th><th>Details</th></tr></thead>
                    <tbody>
                        <tr><td><strong>Ear Cushion Size</strong></td><td>Over-ear (Circumaural) with memory foam</td></tr>
                        <tr><td><strong>Headband Adjustment</strong></td><td>12-step reinforced brushed aluminum sliders</td></tr>
                        <tr><td><strong>Weight</strong></td><td>245 grams (Ultra-lightweight)</td></tr>
                        <tr><td><strong>Foldable</strong></td><td>Yes, 90-degree swiveling earcups</td></tr>
                    </tbody>
                </table>
            `;
        } else {
            content.innerHTML = `
                <p style="color:#cbd5e1; font-size:0.92rem; margin-bottom:14px;">Our signature 240 GSM combed cotton tees feature a relaxed boxy drape. Fits true to size for a streetwear look; size down for a slimmer fit.</p>
                <table class="size-table">
                    <thead><tr><th>Size</th><th>Chest (in)</th><th>Length (in)</th><th>Shoulder (in)</th></tr></thead>
                    <tbody>
                        <tr><td><strong>S</strong></td><td>36 – 38</td><td>28.0</td><td>19.0</td></tr>
                        <tr><td><strong>M</strong></td><td>38 – 40</td><td>29.0</td><td>20.0</td></tr>
                        <tr><td><strong>L</strong></td><td>40 – 42</td><td>30.0</td><td>21.0</td></tr>
                        <tr><td><strong>XL</strong></td><td>42 – 44</td><td>31.0</td><td>22.0</td></tr>
                        <tr><td><strong>XXL</strong></td><td>44 – 46</td><td>32.0</td><td>23.0</td></tr>
                    </tbody>
                </table>
            `;
        }

        modal.style.display = 'flex';
    }

    function closeSizeGuideModal() {
        const modal = document.getElementById('sizeGuideModal');
        if (modal) modal.style.display = 'none';
    }

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') closeSizeGuideModal();
    });

    // Gallery State & Draggable / Clickable Engine
    let currentGalleryIndex = 0;
    const galleryItems = @json($product->gallery_items);
    const mainImg = document.getElementById('mainImg');
    const galleryCounter = document.getElementById('galleryCounter');
    const thumbnailsTrack = document.getElementById('thumbnailsTrack');

    function selectGalleryImage(index) {
        if (!galleryItems || index < 0 || index >= galleryItems.length) return;
        currentGalleryIndex = index;

        if (mainImg) {
            mainImg.classList.add('is-switching');
            setTimeout(() => {
                mainImg.src = galleryItems[index].image;
                mainImg.alt = galleryItems[index].label || '';
                mainImg.classList.remove('is-switching');
            }, 120);
        }

        if (galleryCounter) {
            galleryCounter.textContent = `${index + 1} / ${galleryItems.length}`;
        }

        if (thumbnailsTrack) {
            const cards = thumbnailsTrack.querySelectorAll('.thumbnail-card');
            cards.forEach((card, i) => {
                if (i === index) {
                    card.classList.add('active');
                    card.scrollIntoView({ behavior: 'smooth', block: 'nearest', inline: 'center' });
                } else {
                    card.classList.remove('active');
                }
            });
        }
    }

    function stepGallery(direction) {
        if (!galleryItems || galleryItems.length <= 1) return;
        let nextIndex = currentGalleryIndex + direction;
        if (nextIndex < 0) nextIndex = galleryItems.length - 1;
        if (nextIndex >= galleryItems.length) nextIndex = 0;
        selectGalleryImage(nextIndex);
    }

    function scrollThumbnails(direction) {
        if (!thumbnailsTrack) return;
        const scrollAmount = 180 * direction;
        thumbnailsTrack.scrollBy({ left: scrollAmount, behavior: 'smooth' });
    }

    // Draggable Mouse & Touch Handlers (អូសបាន)
    if (thumbnailsTrack) {
        let isDown = false;
        let startX = 0;
        let scrollLeft = 0;
        let hasDragged = false;

        thumbnailsTrack.addEventListener('mousedown', (e) => {
            isDown = true;
            hasDragged = false;
            thumbnailsTrack.classList.add('is-dragging');
            startX = e.pageX - thumbnailsTrack.offsetLeft;
            scrollLeft = thumbnailsTrack.scrollLeft;
        });

        thumbnailsTrack.addEventListener('mouseleave', () => {
            isDown = false;
            thumbnailsTrack.classList.remove('is-dragging');
        });

        thumbnailsTrack.addEventListener('mouseup', () => {
            isDown = false;
            thumbnailsTrack.classList.remove('is-dragging');
        });

        thumbnailsTrack.addEventListener('mousemove', (e) => {
            if (!isDown) return;
            e.preventDefault();
            const x = e.pageX - thumbnailsTrack.offsetLeft;
            const walk = (x - startX) * 1.6;
            if (Math.abs(walk) > 6) {
                hasDragged = true;
            }
            thumbnailsTrack.scrollLeft = scrollLeft - walk;
        });

        // Prevent accidental click when dragging
        thumbnailsTrack.addEventListener('click', (e) => {
            if (hasDragged) {
                e.stopPropagation();
                e.preventDefault();
            }
        }, true);
    }

    // Keyboard Arrow Keys navigation
    document.addEventListener('keydown', (e) => {
        if (document.activeElement && (document.activeElement.tagName === 'INPUT' || document.activeElement.tagName === 'TEXTAREA')) return;
        if (e.key === 'ArrowLeft') stepGallery(-1);
        if (e.key === 'ArrowRight') stepGallery(1);
    });
</script>
@endsection
