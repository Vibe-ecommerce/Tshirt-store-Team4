@extends('layouts.store')

@section('title', 'THREADCRAFT — Architectural Heavyweight Streetwear & Graphic T-Shirts')

@section('styles')
<style>
    /* -------------------------------------------------------------
       HERO SECTION (High-Fashion Dynamic Split Showcase - Light Luxury)
    ------------------------------------------------------------- */
    .hero-split {
        position: relative;
        max-width: 1320px;
        margin: 0 auto;
        padding: 60px 24px 80px;
        display: grid;
        grid-template-columns: 1.15fr 0.85fr;
        gap: 50px;
        align-items: center;
        overflow: visible;
    }

    /* Ambient Background Aura Lights */
    .hero-glow-1 {
        position: absolute;
        top: -60px;
        left: 10%;
        width: 600px;
        height: 450px;
        background: radial-gradient(circle, rgba(59, 130, 246, 0.06) 0%, rgba(99, 102, 241, 0.02) 50%, transparent 70%);
        filter: blur(80px);
        pointer-events: none;
        z-index: 0;
        animation: pulse-slow 8s infinite alternate ease-in-out;
    }

    .hero-glow-2 {
        position: absolute;
        top: 20%;
        right: 5%;
        width: 500px;
        height: 450px;
        background: radial-gradient(circle, rgba(139, 92, 246, 0.04) 0%, transparent 65%);
        filter: blur(90px);
        pointer-events: none;
        z-index: 0;
    }

    @keyframes pulse-slow {
        0% { transform: scale(1) translateY(0); opacity: 0.8; }
        100% { transform: scale(1.1) translateY(-20px); opacity: 1; }
    }

    .hero-content {
        position: relative;
        z-index: 2;
    }

    .hero-badge-live {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        background: #f1f5f9;
        border: 1px solid #e2e8f0;
        color: #0f172a;
        padding: 7px 18px;
        border-radius: var(--radius-full);
        font-size: 0.78rem;
        font-weight: 700;
        letter-spacing: 0.8px;
        margin-bottom: 22px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.03);
    }

    .pulse-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: #10b981;
        box-shadow: 0 0 10px #10b981;
        animation: pulse-green 2s infinite ease-in-out;
    }

    @keyframes pulse-green {
        0%, 100% { transform: scale(1); opacity: 1; }
        50% { transform: scale(1.4); opacity: 0.6; }
    }

    .hero-headline {
        font-size: clamp(2.6rem, 5.2vw, 4.4rem);
        font-weight: 850;
        line-height: 1.1;
        letter-spacing: -1.8px;
        margin-bottom: 22px;
        color: #0f172a;
    }

    .hero-description {
        font-size: clamp(1.05rem, 1.8vw, 1.2rem);
        color: #475569;
        line-height: 1.65;
        max-width: 580px;
        margin-bottom: 34px;
    }

    .hero-actions {
        display: flex;
        align-items: center;
        gap: 16px;
        flex-wrap: wrap;
        margin-bottom: 40px;
    }

    .btn-hero-primary {
        background: #0f172a;
        color: #ffffff;
        font-weight: 800;
        font-size: 1.02rem;
        padding: 15px 34px;
        border-radius: var(--radius-full);
        display: inline-flex;
        align-items: center;
        gap: 10px;
        box-shadow: 0 10px 25px rgba(15, 23, 42, 0.15);
        transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
        border: none;
        cursor: pointer;
    }

    .btn-hero-primary:hover {
        transform: translateY(-3px) scale(1.02);
        box-shadow: 0 16px 35px rgba(15, 23, 42, 0.25);
        background: #000000;
        color: #ffffff;
    }

    .btn-hero-secondary {
        background: #ffffff;
        border: 1px solid #cbd5e1;
        color: #0f172a;
        font-weight: 700;
        font-size: 1.02rem;
        padding: 15px 28px;
        border-radius: var(--radius-full);
        display: inline-flex;
        align-items: center;
        gap: 8px;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.04);
        transition: all 0.25s ease;
    }

    .btn-hero-secondary:hover {
        background: #f8fafc;
        border-color: #94a3b8;
        transform: translateY(-2px);
        color: #0f172a;
    }

    /* Trust Proof Bar */
    .hero-trust-bar {
        display: flex;
        align-items: center;
        gap: 24px;
        flex-wrap: wrap;
        padding-top: 26px;
        border-top: 1px solid #e2e8f0;
    }

    .trust-avatars {
        display: flex;
        align-items: center;
    }

    .trust-avatar {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        border: 2px solid #ffffff;
        margin-left: -10px;
        object-fit: cover;
        background: #e2e8f0;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08);
    }

    .trust-avatar:first-child {
        margin-left: 0;
    }

    .trust-rating-info {
        display: flex;
        flex-direction: column;
        line-height: 1.25;
    }

    .trust-stars {
        color: #fbbf24;
        font-size: 0.88rem;
        letter-spacing: 1px;
    }

    .trust-text {
        font-size: 0.8rem;
        color: #64748b;
        font-weight: 600;
    }

    .trust-divider {
        width: 1px;
        height: 32px;
        background: #e2e8f0;
    }

    .trust-pills-wrap {
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
    }

    .trust-pill {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 0.78rem;
        color: #334155;
        font-weight: 600;
    }

    /* -------------------------------------------------------------
       HERO RIGHT: INTERACTIVE 3D PRODUCT SHOWCASE CARD (Light Luxury)
    ------------------------------------------------------------- */
    .hero-showcase {
        position: relative;
        z-index: 2;
        perspective: 1000px;
    }

    .showcase-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 28px;
        padding: 24px;
        box-shadow: 0 20px 45px -10px rgba(0, 0, 0, 0.08), 0 0 1px 1px rgba(0, 0, 0, 0.04);
        position: relative;
        transition: transform 0.4s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.4s ease;
    }

    .showcase-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 30px 60px -12px rgba(0, 0, 0, 0.12);
        border-color: #cbd5e1;
    }

    .showcase-badge-top {
        position: absolute;
        top: 20px;
        left: 20px;
        z-index: 5;
        background: #ffffff;
        border: 1px solid #e2e8f0;
        color: #0f172a;
        font-size: 0.72rem;
        font-weight: 800;
        padding: 6px 14px;
        border-radius: var(--radius-full);
        display: inline-flex;
        align-items: center;
        gap: 6px;
        letter-spacing: 0.5px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
    }

    .showcase-badge-rating {
        position: absolute;
        top: 20px;
        right: 20px;
        z-index: 5;
        background: #ffffff;
        border: 1px solid #e2e8f0;
        color: #b45309;
        font-size: 0.78rem;
        font-weight: 800;
        padding: 6px 12px;
        border-radius: var(--radius-full);
        display: inline-flex;
        align-items: center;
        gap: 4px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
    }

    .showcase-media {
        position: relative;
        width: 100%;
        aspect-ratio: 1/1;
        border-radius: 20px;
        overflow: hidden;
        background: #f8fafc;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 1px solid #f1f5f9;
    }

    .showcase-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.6s cubic-bezier(0.16, 1, 0.3, 1), opacity 0.3s ease;
    }

    .showcase-card:hover .showcase-img {
        transform: scale(1.05);
    }

    /* Floating Micro-Card 1: 240 GSM Luxury Cotton */
    .floating-card-gsm {
        position: absolute;
        top: 240px;
        left: -18px;
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        padding: 9px 14px;
        display: flex;
        align-items: center;
        gap: 10px;
        box-shadow: 0 12px 30px rgba(0, 0, 0, 0.08);
        z-index: 6;
        animation: float-slow 5s infinite alternate ease-in-out;
    }

    @keyframes float-slow {
        0% { transform: translateY(0); }
        100% { transform: translateY(-8px); }
    }

    .floating-icon-wrap {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        background: #eff6ff;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #2563eb;
    }

    /* Floating Micro-Card 2: Ready to Dispatch */
    .floating-card-dispatch {
        position: absolute;
        top: 75px;
        right: -18px;
        background: #ffffff;
        border: 1px solid rgba(16, 185, 129, 0.4);
        border-radius: 14px;
        padding: 8px 14px;
        display: flex;
        align-items: center;
        gap: 8px;
        box-shadow: 0 12px 30px rgba(0, 0, 0, 0.08);
        z-index: 6;
        animation: float-slow 6s 1s infinite alternate ease-in-out;
    }

    @media (max-width: 992px) {
        .floating-card-gsm, .floating-card-dispatch {
            display: none !important;
        }
    }

    /* Showcase Bottom Details */
    .showcase-info {
        display: flex;
        flex-direction: column;
        gap: 14px;
    }

    .showcase-title-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .showcase-product-name {
        font-size: 1.25rem;
        font-weight: 850;
        color: #0f172a;
        letter-spacing: -0.3px;
    }

    .showcase-price-tag {
        font-size: 1.45rem;
        font-weight: 850;
        color: #0f172a;
    }

    .showcase-price-original {
        font-size: 0.88rem;
        color: #94a3b8;
        text-decoration: line-through;
        margin-left: 6px;
    }

    /* Interactive Color Switcher Dots */
    .showcase-switcher {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding-top: 14px;
        border-top: 1px solid #f1f5f9;
    }

    .color-dots-list {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .color-dot-btn {
        width: 24px;
        height: 24px;
        border-radius: 50%;
        border: 2px solid #cbd5e1;
        cursor: pointer;
        padding: 2px;
        background-clip: content-box;
        transition: all 0.2s ease;
    }

    .color-dot-btn.active {
        border-color: #0f172a;
        transform: scale(1.15);
        box-shadow: 0 0 0 2px rgba(15, 23, 42, 0.2);
    }

    /* -------------------------------------------------------------
       INFINITE BRAND MARQUEE TICKER (Light Theme)
    ------------------------------------------------------------- */
    .marquee-strip {
        background: #f8fafc;
        border-top: 1px solid #e2e8f0;
        border-bottom: 1px solid #e2e8f0;
        padding: 16px 0;
        overflow: hidden;
        white-space: nowrap;
        position: relative;
    }

    .marquee-track {
        display: inline-flex;
        align-items: center;
        gap: 36px;
        animation: marquee-scroll 28s linear infinite;
    }

    @keyframes marquee-scroll {
        0% { transform: translateX(0); }
        100% { transform: translateX(-50%); }
    }

    .marquee-item {
        font-size: 0.84rem;
        font-weight: 750;
        letter-spacing: 1.4px;
        text-transform: uppercase;
        color: #334155;
        display: inline-flex;
        align-items: center;
        gap: 12px;
    }

    .marquee-item span.star {
        color: #f59e0b;
        font-size: 0.95rem;
    }

    /* -------------------------------------------------------------
       CURATED CATEGORIES BENTO GRID (Light Theme)
    ------------------------------------------------------------- */
    .section-wrap-premium {
        max-width: 1320px;
        margin: 0 auto;
        padding: 70px 24px;
    }

    .section-header-modern {
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        margin-bottom: 34px;
        flex-wrap: wrap;
        gap: 18px;
    }

    .header-tag {
        font-size: 0.78rem;
        font-weight: 800;
        letter-spacing: 1.2px;
        color: #2563eb;
        text-transform: uppercase;
        margin-bottom: 6px;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .header-title-lg {
        font-size: clamp(1.8rem, 3.2vw, 2.5rem);
        font-weight: 850;
        color: #0f172a;
        letter-spacing: -0.8px;
    }

    .header-sub-text {
        font-size: 0.95rem;
        color: #64748b;
        margin-top: 4px;
    }

    /* Bento Grid */
    .bento-categories {
        display: grid;
        grid-template-columns: repeat(12, 1fr);
        grid-auto-rows: 240px;
        gap: 20px;
        margin-bottom: 30px;
    }

    .bento-card {
        position: relative;
        border-radius: 20px;
        overflow: hidden;
        border: 1px solid #e2e8f0;
        background: #0f172a;
        display: flex;
        flex-direction: column;
        justify-content: flex-end;
        padding: 26px;
        transition: all 0.35s cubic-bezier(0.16, 1, 0.3, 1);
        text-decoration: none;
        box-shadow: 0 4px 20px rgba(15, 23, 42, 0.05);
    }

    .bento-card:hover {
        transform: translateY(-5px);
        border-color: #cbd5e1;
        box-shadow: 0 16px 34px rgba(15, 23, 42, 0.12);
    }

    .bento-bg {
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        opacity: 0.88;
        transition: transform 0.6s cubic-bezier(0.16, 1, 0.3, 1), opacity 0.3s ease;
    }

    .bento-card:hover .bento-bg {
        transform: scale(1.07);
        opacity: 0.96;
    }

    .bento-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(180deg, rgba(15, 23, 42, 0.02) 20%, rgba(15, 23, 42, 0.65) 65%, rgba(15, 23, 42, 0.92) 100%);
    }

    .bento-content {
        position: relative;
        z-index: 2;
    }

    .bento-badge {
        display: inline-block;
        background: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(8px);
        font-size: 0.68rem;
        font-weight: 800;
        padding: 3px 10px;
        border-radius: var(--radius-full);
        color: #ffffff;
        margin-bottom: 8px;
        letter-spacing: 0.5px;
    }

    .bento-title {
        font-size: 1.35rem;
        font-weight: 800;
        color: #ffffff;
        margin-bottom: 4px;
    }

    .bento-desc {
        font-size: 0.82rem;
        color: #f1f5f9;
        line-height: 1.4;
    }

    /* Bento Sizes */
    .bento-col-8 { grid-column: span 8; grid-row: span 2; }
    .bento-col-4 { grid-column: span 4; }
    .bento-col-6 { grid-column: span 6; }

    @media (max-width: 992px) {
        .hero-split {
            grid-template-columns: 1fr;
            padding-top: 30px;
            gap: 40px;
        }
        .bento-categories {
            grid-template-columns: 1fr;
            grid-auto-rows: 240px;
        }
        .bento-col-8, .bento-col-4, .bento-col-6 {
            grid-column: span 1;
            grid-row: span 1;
        }
    }

    /* -------------------------------------------------------------
       FEATURED PRODUCTS CARDS WITH INTERACTIVE SIZES & QUICK CART
    ------------------------------------------------------------- */
    .products-grid-modern {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(290px, 1fr));
        gap: 26px;
    }

    .product-card-modern {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: var(--radius-lg);
        overflow: hidden;
        display: flex;
        flex-direction: column;
        transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        position: relative;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.04);
    }

    .product-card-modern:hover {
        transform: translateY(-6px);
        border-color: #cbd5e1;
        box-shadow: 0 16px 32px rgba(0, 0, 0, 0.08);
        background: #ffffff;
    }

    .product-media-wrap {
        position: relative;
        width: 100%;
        aspect-ratio: 1/1;
        overflow: hidden;
        background: #f8fafc;
    }

    .product-card-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s cubic-bezier(0.16, 1, 0.3, 1);
    }

    .product-card-modern:hover .product-card-img {
        transform: scale(1.07);
    }

    .product-top-tag {
        position: absolute;
        top: 12px;
        left: 12px;
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(8px);
        border: 1px solid #e2e8f0;
        color: #0f172a;
        font-size: 0.7rem;
        font-weight: 800;
        padding: 4px 10px;
        border-radius: var(--radius-full);
        text-transform: uppercase;
        letter-spacing: 0.5px;
        z-index: 2;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
    }

    .product-top-rating {
        position: absolute;
        top: 12px;
        right: 12px;
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(8px);
        border: 1px solid #e2e8f0;
        color: #b45309;
        font-size: 0.75rem;
        font-weight: 800;
        padding: 4px 9px;
        border-radius: var(--radius-full);
        display: flex;
        align-items: center;
        gap: 3px;
        z-index: 2;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
    }

    .product-discount-badge {
        position: absolute;
        bottom: 12px;
        right: 12px;
        background: #ef4444;
        color: #ffffff;
        font-size: 0.7rem;
        font-weight: 800;
        padding: 3px 8px;
        border-radius: var(--radius-full);
        z-index: 2;
        letter-spacing: 0.4px;
        box-shadow: 0 2px 6px rgba(239, 68, 68, 0.3);
    }

    .product-body-modern {
        padding: 20px;
        display: flex;
        flex-direction: column;
        flex: 1;
    }

    .product-title-modern {
        font-size: 1.1rem;
        font-weight: 800;
        color: #0f172a;
        margin-bottom: 6px;
        line-height: 1.35;
        transition: color 0.2s ease;
    }

    .product-card-modern:hover .product-title-modern {
        color: #2563eb;
    }

    .product-desc-modern {
        font-size: 0.84rem;
        color: #64748b;
        line-height: 1.5;
        margin-bottom: 16px;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    /* Size Selector Pills */
    .size-selector-row {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 6px;
        margin-bottom: 16px;
    }

    .size-label-tag {
        font-size: 0.72rem;
        color: #64748b;
        font-weight: 800;
        letter-spacing: 0.05em;
        margin-right: 4px;
    }

    .size-pill-btn {
        min-width: 32px;
        width: auto;
        padding: 0 10px;
        height: 28px;
        border-radius: 6px;
        border: 1px solid #e2e8f0;
        background: #f8fafc;
        color: #475569;
        font-size: 0.72rem;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.15s ease;
        white-space: nowrap;
        box-sizing: border-box;
    }

    .size-pill-btn:hover, .size-pill-btn.active {
        background: #0f172a;
        border-color: #0f172a;
        color: #ffffff;
        box-shadow: 0 2px 6px rgba(15, 23, 42, 0.18);
    }

    .product-footer-modern {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-top: auto;
        padding-top: 14px;
        border-top: 1px solid #f1f5f9;
        gap: 10px;
    }

    .product-price-current {
        font-size: 1.25rem;
        font-weight: 850;
        color: #0f172a;
        letter-spacing: -0.02em;
    }

    .product-price-prev {
        font-size: 0.85rem;
        color: #94a3b8;
        text-decoration: line-through;
        margin-left: 6px;
    }

    .btn-quick-cart {
        background: #0f172a;
        color: #ffffff;
        border: none;
        padding: 9px 15px;
        border-radius: var(--radius-full);
        font-size: 0.82rem;
        font-weight: 800;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        box-shadow: 0 4px 12px rgba(15, 23, 42, 0.12);
        transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
        white-space: nowrap;
    }

    .btn-quick-cart:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(15, 23, 42, 0.22);
        background: #000000;
        color: #ffffff;
    }

    .btn-quick-buynow {
        background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
        color: #ffffff;
        border: none;
        padding: 9px 15px;
        border-radius: var(--radius-full);
        font-size: 0.82rem;
        font-weight: 800;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        box-shadow: 0 4px 12px rgba(37, 99, 235, 0.28);
        transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
        white-space: nowrap;
    }

    .btn-quick-buynow:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(37, 99, 235, 0.42);
        background: linear-gradient(135deg, #1d4ed8 0%, #1e40af 100%);
        color: #ffffff;
    }

    .btn-quick-buynow:active {
        transform: translateY(0);
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

    .badge-bestseller {
        background: #0f172a !important;
        color: #ffffff !important;
        border: 1px solid #1e293b !important;
        letter-spacing: 0.08em;
        box-shadow: 0 2px 8px rgba(15, 23, 42, 0.2) !important;
    }

    /* -------------------------------------------------------------
       CRAFTSMANSHIP & ENGINEERING BENTO GRID (Light Theme)
    ------------------------------------------------------------- */
    .craftsmanship-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 20px;
        margin-top: 20px;
    }

    .craft-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: var(--radius-lg);
        padding: 30px 24px;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.03);
    }

    .craft-card:hover {
        transform: translateY(-5px);
        border-color: #cbd5e1;
        box-shadow: 0 16px 32px rgba(0, 0, 0, 0.08);
    }

    .craft-icon-box {
        width: 52px;
        height: 52px;
        border-radius: 14px;
        background: #eff6ff;
        border: 1px solid #bfdbfe;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #2563eb;
        margin-bottom: 20px;
    }

    .craft-title {
        font-size: 1.2rem;
        font-weight: 800;
        color: #0f172a;
        margin-bottom: 10px;
    }

    .craft-desc {
        font-size: 0.88rem;
        color: #475569;
        line-height: 1.6;
    }

    /* -------------------------------------------------------------
       CINEMATIC LOOKBOOK BANNER SPOTLIGHT
    ------------------------------------------------------------- */
    .lookbook-banner {
        position: relative;
        border-radius: 28px;
        overflow: hidden;
        border: 1px solid #e2e8f0;
        margin: 40px 0;
        box-shadow: 0 20px 45px rgba(0, 0, 0, 0.08);
    }

    .lookbook-img {
        width: 100%;
        height: 480px;
        object-fit: cover;
        display: block;
        transition: transform 0.8s ease;
    }

    .lookbook-banner:hover .lookbook-img {
        transform: scale(1.03);
    }

    .lookbook-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(90deg, rgba(15, 23, 42, 0.95) 0%, rgba(15, 23, 42, 0.7) 50%, rgba(15, 23, 42, 0.2) 100%);
        display: flex;
        align-items: center;
        padding: 50px 60px;
    }

    .lookbook-content {
        max-width: 600px;
    }

    /* -------------------------------------------------------------
       VERIFIED REVIEWS / SOCIAL PROOF GRID (Light Theme)
    ------------------------------------------------------------- */
    .reviews-grid-home {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
        gap: 24px;
        margin-top: 24px;
    }

    .review-card-modern {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 20px;
        padding: 30px 26px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        box-shadow: 0 4px 18px rgba(15, 23, 42, 0.03);
    }

    .review-card-modern:hover {
        transform: translateY(-4px);
        border-color: #cbd5e1;
        box-shadow: 0 16px 36px rgba(15, 23, 42, 0.08);
    }

    .review-stars {
        color: #f59e0b;
        font-size: 1rem;
        margin-bottom: 14px;
        letter-spacing: 3px;
    }

    .review-quote {
        font-size: 0.95rem;
        color: #334155;
        line-height: 1.65;
        font-style: italic;
        margin-bottom: 22px;
    }

    .review-user-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding-top: 16px;
        border-top: 1px solid #f1f5f9;
    }

    .review-user-name {
        font-weight: 850;
        font-size: 0.92rem;
        color: #0f172a;
    }

    .review-user-sub {
        font-size: 0.78rem;
        color: #64748b;
        margin-top: 2px;
    }

    .verified-chip {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        color: #15803d;
        font-size: 0.74rem;
        font-weight: 750;
        background: #f0fdf4;
        border: 1px solid #bbf7d0;
        padding: 4px 10px;
        border-radius: 9999px;
    }
</style>
@endsection

@section('content')

    <!-- 1. HIGH-FASHION DYNAMIC SPLIT HERO -->
    <section class="hero-split">
        <div class="hero-glow-1"></div>
        <div class="hero-glow-2"></div>

        <!-- Left Content -->
        <div class="hero-content">
            <div class="hero-badge-live">
                <span class="pulse-dot"></span>
                <span>SPRING / SUMMER 2026 ARCHIVE • 240 GSM HEAVYWEIGHT</span>
            </div>

            <h1 class="hero-headline">
                Architectural Streetwear.<br>
                <span class="gradient-text">Engineered for Life.</span>
            </h1>

            <p class="hero-description">
                Crafted from 240 GSM GOTS-certified organic combed cotton, relaxed tailored cuts, and archival screen prints designed for everyday modern street luxury.
            </p>

            <div class="hero-actions">
                <a href="{{ route('shop.index') }}" class="btn-hero-primary">
                    <span>Explore Collection</span>
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
                </a>
                <a href="#featuredSection" class="btn-hero-secondary">
                    <span>Discover Craftsmanship ✦</span>
                </a>
            </div>

            <!-- Social Proof & Trust Bar -->
            <div class="hero-trust-bar">
                <div class="trust-avatars">
                    <img src="{{ asset('/images/products/tee-cyberpunk.jpg') }}" alt="Buyer" class="trust-avatar">
                    <img src="{{ asset('/images/products/tee-cream.jpg') }}" alt="Buyer" class="trust-avatar">
                    <img src="{{ asset('/images/products/tee-sage.jpg') }}" alt="Buyer" class="trust-avatar">
                    <img src="{{ asset('/images/products/tee-black.jpg') }}" alt="Buyer" class="trust-avatar">
                </div>
                <div class="trust-rating-info">
                    <div class="trust-stars">★★★★★</div>
                    <div class="trust-text">4.9 / 5 from 1,850+ verified buyers</div>
                </div>
                <div class="trust-divider"></div>
                <div class="trust-pills-wrap">
                    <span class="trust-pill">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#818cf8" stroke-width="2.2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>
                        100% Organic Cotton
                    </span>
                    <span class="trust-pill">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#34d399" stroke-width="2.2"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 14 14"></polyline></svg>
                        24h Express Dispatch
                    </span>
                </div>
            </div>
        </div>

        <!-- Right: Interactive 3D Showcase Card -->
        <div class="hero-showcase">
            <div class="showcase-card">
                <div class="showcase-badge-top">
                    <span>🔥 #1 BESTSELLER</span>
                </div>
                <div class="showcase-badge-rating">
                    <span>★ 5.0 (56 Reviews)</span>
                </div>

                <div class="showcase-media">
                    <img id="heroShowcaseImg" src="{{ asset('/images/products/tee-cyberpunk.jpg') }}" alt="Neo Cybernetics Tee" class="showcase-img">
                </div>

                <!-- Floating Micro-Card: 240 GSM -->
                <div class="floating-card-gsm">
                    <div class="floating-icon-wrap">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><rect x="3" y="3" width="18" height="18" rx="2"></rect><line x1="3" y1="9" x2="21" y2="9"></line><line x1="9" y1="21" x2="9" y2="9"></line></svg>
                    </div>
                    <div>
                        <div style="font-size:0.8rem; font-weight:800; color:#0f172a;">240 GSM Luxury</div>
                        <div style="font-size:0.7rem; color:var(--text-muted);">Combed Organic Weave</div>
                    </div>
                </div>

                <!-- Floating Micro-Card: Fast Shipping -->
                <div class="floating-card-dispatch">
                    <span style="font-size:0.9rem;">⚡</span>
                    <div>
                        <div style="font-size:0.78rem; font-weight:800; color:#059669;">In Stock & Ready</div>
                        <div style="font-size:0.68rem; color:var(--text-muted);">Ships Tomorrow</div>
                    </div>
                </div>

                <div class="showcase-info">
                    <div class="showcase-title-row">
                        <div>
                            <div class="showcase-product-name" id="heroProductName">Neo Cybernetics Futuristic Tee</div>
                            <div style="font-size:0.78rem; color:var(--text-muted); margin-top:2px;" id="heroProductColor">Onyx Black • Drop-Shoulder Fit</div>
                        </div>
                        <div style="text-align:right;">
                            <div class="showcase-price-tag">
                                <span id="heroProductPrice">$38.00</span>
                                <span class="showcase-price-original" id="heroProductOrigPrice">$45.00</span>
                            </div>
                        </div>
                    </div>

                    <!-- Color Swatches & Quick Add -->
                    <div class="showcase-switcher">
                        <div style="display:flex; align-items:center; gap:8px;">
                            <span style="font-size:0.74rem; font-weight:700; color:var(--text-muted); text-transform:uppercase;">Color:</span>
                            <div class="color-dots-list">
                                <button type="button" class="color-dot-btn active" style="background:#0a0a0a;" onclick="switchHeroTee('/images/products/tee-cyberpunk.jpg', 'Neo Cybernetics Futuristic Tee', 'Onyx Black • Drop-Shoulder Fit', '$38.00', '$45.00', this)" title="Onyx Black"></button>
                                <button type="button" class="color-dot-btn" style="background:#f3eedf;" onclick="switchHeroTee('/images/products/tee-cream.jpg', 'Soul & Sea Vintage Graphic Tee', 'Vintage Coastal Cream • 240 GSM', '$34.50', '$42.00', this)" title="Coastal Cream"></button>
                                <button type="button" class="color-dot-btn" style="background:#6b8171;" onclick="switchHeroTee('/images/products/tee-sage.jpg', 'Forest Minimal Graphic Tee', 'Mineral Sage Green • Pre-Shrunk', '$32.00', '$39.00', this)" title="Mineral Sage"></button>
                                <button type="button" class="color-dot-btn" style="background:#262626;" onclick="switchHeroTee('/images/products/tee-black.jpg', 'Signature Heavyweight Minimal Tee', 'Pitch Black • Boxy Cut', '$29.99', '$36.00', this)" title="Pitch Black"></button>
                            </div>
                        </div>

                        <a href="{{ route('shop.index') }}" class="btn-quick-cart" style="font-size:0.82rem; padding:8px 18px;">
                            <span>Shop Drop →</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 2. INFINITE LUXURY MARQUEE TICKER -->
    <div class="marquee-strip">
        <div class="marquee-track">
            <div class="marquee-item"><span class="star">✦</span> 240 GSM COMBED ORGANIC COTTON</div>
            <div class="marquee-item"><span class="star">✦</span> GOTS SUSTAINABLY CERTIFIED</div>
            <div class="marquee-item"><span class="star">✦</span> WATER-BASED ZERO-CRACK SCREEN PRINT</div>
            <div class="marquee-item"><span class="star">✦</span> RELAXED TAILORED STREETWEAR DRAPE</div>
            <div class="marquee-item"><span class="star">✦</span> PRE-SHRUNK ENZYME SILK WASH</div>
            <div class="marquee-item"><span class="star">✦</span> TWIN-NEEDLE REINFORCED HEM</div>
            <div class="marquee-item"><span class="star">✦</span> WORLDWIDE EXPRESS DISPATCH IN 24H</div>
            <!-- Duplicate for seamless infinite loop -->
            <div class="marquee-item"><span class="star">✦</span> 240 GSM COMBED ORGANIC COTTON</div>
            <div class="marquee-item"><span class="star">✦</span> GOTS SUSTAINABLY CERTIFIED</div>
            <div class="marquee-item"><span class="star">✦</span> WATER-BASED ZERO-CRACK SCREEN PRINT</div>
            <div class="marquee-item"><span class="star">✦</span> RELAXED TAILORED STREETWEAR DRAPE</div>
            <div class="marquee-item"><span class="star">✦</span> PRE-SHRUNK ENZYME SILK WASH</div>
            <div class="marquee-item"><span class="star">✦</span> TWIN-NEEDLE REINFORCED HEM</div>
            <div class="marquee-item"><span class="star">✦</span> WORLDWIDE EXPRESS DISPATCH IN 24H</div>
        </div>
    </div>

    <!-- 3. CURATED COLLECTIONS & CATEGORIES BENTO GRID -->
    <section class="section-wrap-premium">
        <div class="section-header-modern">
            <div>
                <div class="header-tag">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                    <span>Curated Streetwear Silhouettes</span>
                </div>
                <h2 class="header-title-lg">Shop by Category</h2>
                <p class="header-sub-text">Handcrafted silhouettes engineered for your daily aesthetic rotation.</p>
            </div>
            <a href="{{ route('shop.index') }}" class="view-all-link" style="font-size:0.95rem; font-weight:700;">
                Browse Complete Catalog →
            </a>
        </div>

        <!-- Bento Grid Layout -->
        <div class="bento-categories">
            <!-- 1. Large Hero Bento: Graphic T-Shirts (Spans 8 columns, 2 rows) -->
            <a href="{{ route('shop.index', ['category' => 'Graphic T-Shirts']) }}" class="bento-card bento-col-8">
                <img src="{{ asset('/images/products/tee-cream.jpg') }}" alt="Graphic T-Shirts" class="bento-bg">
                <div class="bento-overlay"></div>
                <div class="bento-content">
                    <span class="bento-badge" style="background:rgba(99,102,241,0.3); border:1px solid #6366f1;">FLAGSHIP COLLECTION</span>
                    <h3 class="bento-title" style="font-size:1.8rem;">Graphic T-Shirts</h3>
                    <p class="bento-desc" style="max-width:480px; font-size:0.92rem;">Bold archival artwork, retro typography, and artisanal water-based screen prints on heavyweight cotton.</p>
                    <div style="margin-top:12px; font-size:0.84rem; font-weight:700; color:#a5b4fc; display:flex; align-items:center; gap:6px;">
                        <span>Explore Graphic Drops →</span>
                    </div>
                </div>
            </a>

            <!-- 2. Medium Bento: Plain Heavyweight Essentials (Spans 4 columns) -->
            <a href="{{ route('shop.index', ['category' => 'Plain T-Shirts']) }}" class="bento-card bento-col-4">
                <img src="{{ asset('/images/products/tee-white.jpg') }}" alt="Plain T-Shirts" class="bento-bg">
                <div class="bento-overlay"></div>
                <div class="bento-content">
                    <span class="bento-badge">EVERYDAY LUXURY</span>
                    <h3 class="bento-title">Plain T-Shirts</h3>
                    <p class="bento-desc">Heavyweight 240 GSM minimal everyday staples.</p>
                </div>
            </a>

            <!-- 3. Medium Bento: Oversized Streetwear (Spans 4 columns) -->
            <a href="{{ route('shop.index', ['category' => 'Oversized T-Shirts']) }}" class="bento-card bento-col-4">
                <img src="{{ asset('/images/products/tee-oversized.jpg') }}" alt="Oversized T-Shirts" class="bento-bg">
                <div class="bento-overlay"></div>
                <div class="bento-content">
                    <span class="bento-badge">RELAXED CUT</span>
                    <h3 class="bento-title">Oversized T-Shirts</h3>
                    <p class="bento-desc">Boxy drop-shoulder streetwear fit with mineral enzyme wash.</p>
                </div>
            </a>

            <!-- 4. Wide Bento: Streetwear Footwear & Shoes (Spans 6 columns) -->
            <a href="{{ route('shop.index', ['category' => 'Shoes']) }}" class="bento-card bento-col-6">
                <img src="{{ asset('/images/products/shoes-sneaker.jpg') }}" alt="Streetwear Shoes" class="bento-bg">
                <div class="bento-overlay"></div>
                <div class="bento-content">
                    <span class="bento-badge">FOOTWEAR DROP</span>
                    <h3 class="bento-title">Designer Sneakers & Kicks</h3>
                    <p class="bento-desc">Architectural chunky runners engineered with sculpted lightweight soles.</p>
                </div>
            </a>

            <!-- 5. Wide Bento: Tactical Bags & Accessories (Spans 6 columns) -->
            <a href="{{ route('shop.index', ['category' => 'Bags']) }}" class="bento-card bento-col-6">
                <img src="{{ asset('/images/products/bag-crossbody.jpg') }}" alt="Tactical Bags" class="bento-bg">
                <div class="bento-overlay"></div>
                <div class="bento-content">
                    <span class="bento-badge">UTILITY GEAR</span>
                    <h3 class="bento-title">Tactical Slings & Packs</h3>
                    <p class="bento-desc">Heavy-duty 1000D ballistic nylon bags with quick-adjust straps.</p>
                </div>
            </a>
        </div>

        <!-- Quick Category Slider Pills -->
        <div style="display:flex; gap:10px; flex-wrap:wrap; align-items:center; justify-content:center; padding:14px 22px; background:#ffffff; border:1px solid #e2e8f0; border-radius:9999px; box-shadow:0 2px 10px rgba(15, 23, 42, 0.03); margin-top:10px;">
            <span style="font-size:0.75rem; text-transform:uppercase; font-weight:800; color:#64748b; letter-spacing:0.06em; margin-right:4px;">Quick Access:</span>
            @foreach ($categories as $cat)
                <a href="{{ route('shop.index', ['category' => $cat['name']]) }}" 
                   style="background:#f8fafc; border:1px solid #e2e8f0; color:#334155; font-size:0.8rem; font-weight:700; padding:6px 15px; border-radius:9999px; transition:all 0.2s cubic-bezier(0.16, 1, 0.3, 1); text-decoration:none;"
                   onmouseover="this.style.background='#0f172a'; this.style.borderColor='#0f172a'; this.style.color='#ffffff'; this.style.transform='translateY(-1px)';"
                   onmouseout="this.style.background='#f8fafc'; this.style.borderColor='#e2e8f0'; this.style.color='#334155'; this.style.transform='none';">
                    {{ $cat['name'] }}
                </a>
            @endforeach
        </div>
    </section>

    <!-- 4. FEATURED PRODUCTS (WITH INTERACTIVE QUICK ADD) -->
    <section class="section-wrap-premium" id="featuredSection" style="padding-top:0;">
        <div class="section-header-modern">
            <div>
                <div class="header-tag">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                    <span>Handpicked Releases</span>
                </div>
                <h2 class="header-title-lg">Featured Drops</h2>
                <p class="header-sub-text">Our most coveted apparel pieces handcrafted for timeless wear.</p>
            </div>
            <a href="{{ route('shop.index', ['sort' => 'featured']) }}" class="view-all-link" style="font-size:0.95rem; font-weight:700;">
                See All Featured Drops →
            </a>
        </div>

        <div class="products-grid-modern">
            @foreach ($featuredProducts as $product)
                <div class="product-card-modern">
                    <a href="{{ route('product.detail', $product->id) }}" class="product-media-wrap">
                        <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" class="product-card-img {{ $product->isOutOfStock() ? 'is-stockout' : '' }}">
                        
                        @if ($product->isOutOfStock())
                            <span class="badge-stockout">STOCKOUT</span>
                        @else
                            <span class="product-top-tag">{{ $product->category }}</span>
                            @if ($product->isLowStock())
                                <span class="badge-lowstock">Only {{ $product->stock }} Left!</span>
                            @endif
                        @endif
                        
                        <span class="product-top-rating">★ {{ number_format($product->rating, 1) }}</span>

                        @if ($product->original_price && $product->original_price > $product->price)
                            @php
                                $pct = round((($product->original_price - $product->price) / $product->original_price) * 100);
                            @endphp
                            <span class="product-discount-badge">-{{ $pct }}%</span>
                        @endif
                    </a>

                    <div class="product-body-modern">
                        <a href="{{ route('product.detail', $product->id) }}">
                            <h3 class="product-title-modern">{{ $product->name }}</h3>
                        </a>
                        <p class="product-desc-modern">{{ $product->description }}</p>

                        <!-- Size selection helper pills -->
                        <div class="size-selector-row">
                            <span class="size-label-tag">SIZE:</span>
                            @php
                                $sizes = explode(',', $product->sizes ?: 'S,M,L,XL');
                            @endphp
                            @foreach ($sizes as $idx => $s)
                                <span class="size-pill-btn {{ $idx == 1 ? 'active' : '' }}" onclick="selectProductSize(this, '{{ $product->id }}')">{{ trim($s) }}</span>
                            @endforeach
                        </div>

                        <div class="product-footer-modern">
                            <div>
                                <span class="product-price-current">${{ number_format($product->price, 2) }}</span>
                                @if ($product->original_price)
                                    <span class="product-price-prev">${{ number_format($product->original_price, 2) }}</span>
                                @endif
                            </div>

                            @if ($product->isOutOfStock())
                                <button type="button" class="btn-stockout" disabled>
                                    Sold Out
                                </button>
                            @else
                                <div style="display: flex; gap: 6px; align-items: center;">
                                    <form action="{{ route('cart.add', $product->id) }}" method="POST" id="cartForm_{{ $product->id }}" style="margin: 0;">
                                        @csrf
                                        <input type="hidden" name="size" id="sizeInput_{{ $product->id }}" value="M">
                                        <button type="submit" class="btn-quick-cart" title="Add to Cart">
                                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 5v14M5 12h14"></path></svg>
                                            <span>Cart</span>
                                        </button>
                                    </form>
                                    <form action="{{ route('cart.buyNow', $product->id) }}" method="POST" id="buyNowForm_{{ $product->id }}" style="margin: 0;">
                                        @csrf
                                        <input type="hidden" name="size" id="buyNowSizeInput_{{ $product->id }}" value="M">
                                        <button type="submit" class="btn-quick-buynow" title="Buy Now & Proceed to Checkout">
                                            <svg width="13" height="13" viewBox="0 0 24 24" fill="currentColor"><path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"></path></svg>
                                            <span>Buy</span>
                                        </button>
                                    </form>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <!-- 5. CRAFTSMANSHIP & ENGINEERING BENTO SPOTLIGHT -->
    <section class="section-wrap-premium" style="padding-top:0;">
        <div style="background:#f8fafc; border:1px solid #e2e8f0; border-radius:28px; padding:45px 36px; box-shadow:0 4px 20px rgba(0,0,0,0.02);">
            <div style="text-align:center; max-width:640px; margin:0 auto 36px;">
                <div class="header-tag" style="justify-content:center;">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"></circle><path d="m4.93 4.93 4.24 4.24"></path><path d="m14.83 9.17 4.24-4.24"></path><path d="m14.83 14.83 4.24 4.24"></path><path d="m9.17 14.83-4.24 4.24"></path></svg>
                    <span>The Threadcraft Standard</span>
                </div>
                <h2 class="header-title-lg" style="margin-bottom:10px;">Engineered With Precision</h2>
                <p class="header-sub-text">Every fiber, cut, and print is designed to outlast fast fashion trends.</p>
            </div>

            <div class="craftsmanship-grid">
                <div class="craft-card">
                    <div class="craft-icon-box">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"></path><path d="M3 6h18"></path><path d="M16 10a4 4 0 0 1-8 0"></path></svg>
                    </div>
                    <h3 class="craft-title">240 GSM Heavy Cotton</h3>
                    <p class="craft-desc">Substantial heavyweight combed cotton offering exceptional structure, zero transparency, and a tailored drape that holds its shape all day long.</p>
                </div>

                <div class="craft-card">
                    <div class="craft-icon-box" style="background:rgba(16,185,129,0.15); border-color:rgba(16,185,129,0.3); color:#34d399;">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>
                    </div>
                    <h3 class="craft-title">GOTS Organic & Eco-Dyes</h3>
                    <p class="craft-desc">Certified 100% organic fibers dyed with non-toxic, eco-conscious water-based pigments. Gentle on sensitive skin, soft on the planet.</p>
                </div>

                <div class="craft-card">
                    <div class="craft-icon-box" style="background:rgba(245,158,11,0.15); border-color:rgba(245,158,11,0.3); color:#fbbf24;">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="m12 3-1.912 5.813a2 2 0 0 1-1.275 1.275L3 12l5.813 1.912a2 2 0 0 1 1.275 1.275L12 21l1.912-5.813a2 2 0 0 1 1.275-1.275L21 12l-5.813-1.912a2 2 0 0 1-1.275-1.275L12 3Z"></path></svg>
                    </div>
                    <h3 class="craft-title">Zero-Crack Screen Prints</h3>
                    <p class="craft-desc">Permeable inks infused directly into the yarn rather than sitting on top as rubber. Breathable and soft, aging into a vintage patina without peeling.</p>
                </div>

                <div class="craft-card">
                    <div class="craft-icon-box" style="background:rgba(236,72,153,0.15); border-color:rgba(236,72,153,0.3); color:#f472b6;">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><polygon points="12 2 2 7 12 12 22 7 12 2"></polygon><polyline points="2 17 12 22 22 17"></polyline><polyline points="2 12 12 17 22 12"></polyline></svg>
                    </div>
                    <h3 class="craft-title">Twin-Needle Lay-Flat Collar</h3>
                    <p class="craft-desc">Dense 1x1 ribbed collar reinforced with interior herringbone neck taping that never sags, bacon-collars, or stretches out over time.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- 6. CINEMATIC LOOKBOOK BANNER SPOTLIGHT -->
    <section class="section-wrap-premium" style="padding-top:0;">
        @php
            $lookbookImg = \App\Models\SiteSetting::get('lookbook_banner_image', '/images/hero-editorial.jpg');
            $lookbookBadge = \App\Models\SiteSetting::get('lookbook_badge', 'EDITORIAL CAMPAIGN / AW26');
            $lookbookTitle = \App\Models\SiteSetting::get('lookbook_title', 'The Concrete Canvas.');
            $lookbookSubtitle = \App\Models\SiteSetting::get('lookbook_subtitle', 'Subversive Streetwear.');
            $lookbookDesc = \App\Models\SiteSetting::get('lookbook_desc', 'Engineered in our studio for the high-density urban landscape. Oversized drop-shoulder silhouettes meet brutalist architectural aesthetics.');
            $lookbookBtnText = \App\Models\SiteSetting::get('lookbook_btn_text', 'Shop The Lookbook Collection →');
            $lookbookBtnUrl = \App\Models\SiteSetting::get('lookbook_btn_url', route('shop.index'));
        @endphp
        <div class="lookbook-banner">
            <img src="{{ str_starts_with($lookbookImg, 'http') ? $lookbookImg : asset($lookbookImg) }}" alt="Streetwear Lookbook Editorial" class="lookbook-img">
            <div class="lookbook-overlay">
                <div class="lookbook-content">
                    <span class="bento-badge" style="background:rgba(99,102,241,0.3); border:1px solid #6366f1; font-size:0.75rem;">
                        {{ $lookbookBadge }}
                    </span>
                    <h2 style="font-size:clamp(2rem, 3.8vw, 3rem); font-weight:850; color:#fff; line-height:1.15; margin-bottom:14px; letter-spacing:-1px;">
                        {{ $lookbookTitle }}<br>
                        <span class="gradient-text">{{ $lookbookSubtitle }}</span>
                    </h2>
                    <p style="color:#cbd5e1; font-size:1.05rem; line-height:1.6; margin-bottom:28px;">
                        {{ $lookbookDesc }}
                    </p>
                    <div style="display:flex; gap:16px; flex-wrap:wrap;">
                        <a href="{{ $lookbookBtnUrl }}" class="btn-hero-primary" style="padding:13px 30px; font-size:0.95rem;">
                            <span>{{ $lookbookBtnText }}</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 7. BEST SELLERS SECTION -->
    <section class="section-wrap-premium" style="padding-top:0;">
        <div class="section-header-modern">
            <div>
                <div class="header-tag">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                    <span>Community Favorites</span>
                </div>
                <h2 class="header-title-lg">Best Sellers</h2>
                <p class="header-sub-text">Designs with the highest repeat purchase and customer satisfaction rates.</p>
            </div>
            <a href="{{ route('shop.index', ['sort' => 'rating']) }}" class="view-all-link" style="font-size:0.95rem; font-weight:700;">
                View All Best Sellers →
            </a>
        </div>

        <div class="products-grid-modern">
            @foreach ($bestSellers as $product)
                <div class="product-card-modern">
                    <a href="{{ route('product.detail', $product->id) }}" class="product-media-wrap">
                        <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" class="product-card-img {{ $product->isOutOfStock() ? 'is-stockout' : '' }}">
                        <span class="product-top-tag badge-bestseller">★ BEST SELLER</span>
                        <span class="product-top-rating">★ {{ number_format($product->rating, 1) }}</span>
                    </a>

                    <div class="product-body-modern">
                        <a href="{{ route('product.detail', $product->id) }}">
                            <h3 class="product-title-modern">{{ $product->name }}</h3>
                        </a>
                        <p class="product-desc-modern">{{ $product->description }}</p>

                        <div class="product-footer-modern">
                            <div>
                                <span class="product-price-current">${{ number_format($product->price, 2) }}</span>
                                @if ($product->original_price)
                                    <span class="product-price-prev">${{ number_format($product->original_price, 2) }}</span>
                                @endif
                            </div>

                            @if ($product->isOutOfStock())
                                <button type="button" class="btn-stockout" disabled>
                                    Sold Out
                                </button>
                            @else
                                <div style="display: flex; gap: 6px; align-items: center;">
                                    <form action="{{ route('cart.add', $product->id) }}" method="POST" style="margin: 0;">
                                        @csrf
                                        <input type="hidden" name="size" value="L">
                                        <button type="submit" class="btn-quick-cart" title="Add to Cart">
                                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 5v14M5 12h14"></path></svg>
                                            <span>Cart</span>
                                        </button>
                                    </form>
                                    <form action="{{ route('cart.buyNow', $product->id) }}" method="POST" style="margin: 0;">
                                        @csrf
                                        <input type="hidden" name="size" value="L">
                                        <button type="submit" class="btn-quick-buynow" title="Buy Now & Proceed to Checkout">
                                            <svg width="13" height="13" viewBox="0 0 24 24" fill="currentColor"><path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"></path></svg>
                                            <span>Buy</span>
                                        </button>
                                    </form>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <!-- 8. VERIFIED COMMUNITY TESTIMONIALS / SOCIAL PROOF -->
    <section class="section-wrap-premium" style="padding-top:0;">
        <div class="section-header-modern">
            <div>
                <div class="header-tag">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                    <span>Real Customer Feedback</span>
                </div>
                <h2 class="header-title-lg">Worn By Creators Worldwide</h2>
                <p class="header-sub-text">Read authentic reviews from customers who live in Threadcraft daily.</p>
            </div>
            <div style="font-size:0.9rem; color:var(--text-muted); font-weight:700;">
                ★ 4.9 Average Rating (1,850+ Reviews)
            </div>
        </div>

        <div class="reviews-grid-home">
            <div class="review-card-modern">
                <div>
                    <div class="review-stars">★★★★★</div>
                    <p class="review-quote">
                        "The weight of this tee is unlike anything else on the market. 240 GSM holds its boxy silhouette without feeling stiff or scratchy. The drape on the shoulders is genuinely flawless."
                    </p>
                </div>
                <div class="review-user-row">
                    <div>
                        <div class="review-user-name">Marcus K.</div>
                        <div class="review-user-sub">Los Angeles • Size L (Oversized Cut)</div>
                    </div>
                    <span class="verified-chip">✓ Verified Buyer</span>
                </div>
            </div>

            <div class="review-card-modern">
                <div>
                    <div class="review-stars">★★★★★</div>
                    <p class="review-quote">
                        "Screen print quality is insane. I've washed my Cybernetics tee over 6 times now in cold water and there is zero cracking or peeling. Hands down the highest quality tee in my closet."
                    </p>
                </div>
                <div class="review-user-row">
                    <div>
                        <div class="review-user-name">Elena V.</div>
                        <div class="review-user-sub">Berlin • Size M (Vintage Cream)</div>
                    </div>
                    <span class="verified-chip">✓ Verified Buyer</span>
                </div>
            </div>

            <div class="review-card-modern">
                <div>
                    <div class="review-stars">★★★★★</div>
                    <p class="review-quote">
                        "Threadcraft is on par with luxury streetwear labels charging $150+ for basic graphic tees. The collar lays perfectly flat and the eco-packaging was a super nice touch."
                    </p>
                </div>
                <div class="review-user-row">
                    <div>
                        <div class="review-user-name">David R.</div>
                        <div class="review-user-sub">Tokyo • Size XL (Acid Wash Oversized)</div>
                    </div>
                    <span class="verified-chip">✓ Verified Buyer</span>
                </div>
            </div>
        </div>
    </section>

    <!-- 9. LIMITED TIME PROMO BANNER (If Active) -->
    @php
        $homePromo = \App\Models\Promotion::where('status', 'Active')
            ->where(function ($q) {
                $q->whereNull('expires_at')->orWhere('expires_at', '>', now());
            })
            ->orderBy('discount_percent', 'desc')
            ->first();
    @endphp

    @if ($homePromo)
        <section class="section-wrap-premium" style="padding-top:0;">
            <div class="promo-banner" style="background: radial-gradient(circle at 50% 0%, rgba(99, 102, 241, 0.25), transparent 70%), linear-gradient(135deg, #090d16 0%, #111827 50%, #0f172a 100%); border: 1px solid #1e293b; border-radius: 28px; padding: 60px 36px; text-align: center; position: relative; overflow: hidden; box-shadow: 0 24px 50px -12px rgba(15, 23, 42, 0.28);">
                <span class="promo-badge" style="background: rgba(99, 102, 241, 0.18); border: 1px solid rgba(99, 102, 241, 0.45); color: #818cf8; font-size: 0.76rem; font-weight: 800; letter-spacing: 0.14em; text-transform: uppercase; padding: 6px 16px; border-radius: 9999px; display: inline-flex; align-items: center; gap: 8px; margin-bottom: 20px;">
                    <span style="display:inline-block; width:6px; height:6px; border-radius:50%; background:#818cf8; box-shadow:0 0 8px #818cf8;"></span>
                    SPECIAL PROMOTIONAL DROP
                </span>
                <h2 style="font-size: clamp(2rem, 3.8vw, 3rem); font-weight: 900; color: #ffffff; margin-bottom: 14px; line-height: 1.18; letter-spacing: -0.03em;">
                    Upgrade Your Daily Rotation.<br>
                    <span style="background: linear-gradient(135deg, #ffffff 0%, #a5b4fc 60%, #38bdf8 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">Enjoy {{ $homePromo->discount_percent }}% Off Your Order.</span>
                </h2>
                <p style="color: #94a3b8; font-size: 1.05rem; max-width: 620px; margin: 0 auto 28px; line-height: 1.6;">
                    Use coupon code <strong style="color: #38bdf8; background: rgba(56, 189, 248, 0.12); padding: 5px 14px; border-radius: 8px; border: 1px dashed rgba(56, 189, 248, 0.45); font-family: 'JetBrains Mono', monospace; font-size: 1.15rem; letter-spacing: 0.05em; margin: 0 4px; display: inline-block;">{{ $homePromo->code }}</strong> at checkout to unlock instant savings on our heavyweight organic apparel.
                </p>
                <div style="display: flex; justify-content: center; gap: 16px; flex-wrap: wrap;">
                    <a href="{{ route('shop.index') }}" class="btn-hero-primary" style="background: #ffffff; color: #090d16; font-weight: 850; padding: 14px 36px; font-size: 0.95rem; border-radius: 9999px; box-shadow: 0 10px 25px rgba(255, 255, 255, 0.15); transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);">
                        Shop Sale Items Now →
                    </a>
                </div>
            </div>
        </section>
    @endif

@endsection

@section('scripts')
<script>
    // Interactive Hero Showcase Tee Switcher
    function switchHeroTee(imgSrc, title, subtitle, price, origPrice, btnEl) {
        const img = document.getElementById('heroShowcaseImg');
        const titleEl = document.getElementById('heroProductName');
        const subEl = document.getElementById('heroProductColor');
        const priceEl = document.getElementById('heroProductPrice');
        const origPriceEl = document.getElementById('heroProductOrigPrice');

        if (img) {
            img.style.opacity = '0.4';
            img.style.transform = 'scale(0.96)';
            setTimeout(() => {
                img.src = imgSrc;
                img.style.opacity = '1';
                img.style.transform = 'scale(1)';
            }, 180);
        }

        if (titleEl) titleEl.textContent = title;
        if (subEl) subEl.textContent = subtitle;
        if (priceEl) priceEl.textContent = price;
        if (origPriceEl) origPriceEl.textContent = origPrice;

        // Toggle active dot
        document.querySelectorAll('.color-dot-btn').forEach(btn => btn.classList.remove('active'));
        if (btnEl) btnEl.classList.add('active');
    }

    // Interactive Size Selection for Products
    function selectProductSize(pillEl, productId) {
        const parent = pillEl.parentElement;
        parent.querySelectorAll('.size-pill-btn').forEach(p => p.classList.remove('active'));
        pillEl.classList.add('active');

        const val = pillEl.textContent.trim();
        const hiddenInput = document.getElementById('sizeInput_' + productId);
        if (hiddenInput) {
            hiddenInput.value = val;
        }
        const buyNowSizeInput = document.getElementById('buyNowSizeInput_' + productId);
        if (buyNowSizeInput) {
            buyNowSizeInput.value = val;
        }
    }
</script>
@endsection
