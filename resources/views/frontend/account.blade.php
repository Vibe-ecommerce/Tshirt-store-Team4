@extends('layouts.store')

@section('title', 'Customer Account — THREADCRAFT')

@section('styles')
<style>
    /* -------------------------------------------------------------
       DASHBOARD NO-SCROLL LAYOUT (Desktop Viewport Fit)
    ------------------------------------------------------------- */
    @media (min-width: 901px) {
        html, body.account-page-body {
            height: 100vh !important;
            max-height: 100vh !important;
            overflow: hidden !important;
        }

        body.account-page-body {
            display: flex;
            flex-direction: column;
        }

        body.account-page-body .main-wrapper {
            flex: 1;
            display: flex;
            flex-direction: column;
            overflow: hidden;
            min-height: 0;
        }        .account-page-wrap {
            max-width: 1360px;
            width: 100%;
            margin: 0 auto;
            padding: 10px 24px 12px;
            flex: 1;
            display: flex;
            flex-direction: column;
            overflow: hidden;
            min-height: 0;
            box-sizing: border-box;
        }

        .account-grid-layout {
            display: grid;
            grid-template-columns: 290px 1fr;
            gap: 20px;
            flex: 1;
            min-height: 0;
            height: 100%;
            align-items: stretch;
        }

        .account-sidebar {
            background: #ffffff;
            backdrop-filter: blur(16px);
            border: 1px solid var(--border-subtle);
            border-radius: var(--radius-lg);
            padding: 18px 18px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04);
            display: flex;
            flex-direction: column;
            height: 100%;
            max-height: 100%;
            overflow-y: auto;
            position: static;
        }

        .tab-content-card {
            background: #ffffff;
            backdrop-filter: blur(16px);
            border: 1px solid var(--border-subtle);
            border-radius: var(--radius-lg);
            padding: 18px 24px 16px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04);
            position: relative;
            display: flex;
            flex-direction: column;
            height: 100%;
            max-height: 100%;
            overflow-y: auto;
            min-height: 0;
        }
    }

    @media (max-width: 900px) {
        .account-page-wrap {
            max-width: 100%;
            margin: 20px auto 40px;
            padding: 0 16px;
        }

        .account-grid-layout {
            grid-template-columns: 1fr;
            gap: 20px;
        }

        .account-sidebar {
            background: #ffffff;
            backdrop-filter: blur(16px);
            border: 1px solid var(--border-subtle);
            border-radius: var(--radius-lg);
            padding: 20px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04);
            position: static;
            height: auto;
        }

        .tab-content-card {
            background: #ffffff;
            backdrop-filter: blur(16px);
            border: 1px solid var(--border-subtle);
            border-radius: var(--radius-lg);
            padding: 24px 20px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04);
            position: relative;
            height: auto;
            max-height: none;
            overflow-y: visible;
        }
    }

    /* Custom Sleek Scrollbar for Account Sidebar & Content */
    .account-sidebar::-webkit-scrollbar,
    .tab-content-card::-webkit-scrollbar {
        width: 6px;
    }
    .account-sidebar::-webkit-scrollbar-track,
    .tab-content-card::-webkit-scrollbar-track {
        background: transparent;
    }
    .account-sidebar::-webkit-scrollbar-thumb,
    .tab-content-card::-webkit-scrollbar-thumb {
        background: rgba(99, 102, 241, 0.25);
        border-radius: 9999px;
    }
    .account-sidebar::-webkit-scrollbar-thumb:hover,
    .tab-content-card::-webkit-scrollbar-thumb:hover {
        background: rgba(99, 102, 241, 0.5);
    }

    .user-profile-badge {
        display: flex;
        align-items: center;
        gap: 14px;
        padding-bottom: 20px;
        border-bottom: 1px solid var(--border-subtle);
        margin-bottom: 18px;
    }

    .avatar-wrapper {
        position: relative;
        flex-shrink: 0;
    }

    .avatar-circle {
        width: 50px;
        height: 50px;
        border-radius: var(--radius-full);
        background: var(--accent-gradient);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
        font-weight: 850;
        color: #ffffff;
        box-shadow: 0 4px 16px rgba(99, 102, 241, 0.45);
        border: 2px solid rgba(255, 255, 255, 0.15);
    }

    .avatar-online-dot {
        width: 12px;
        height: 12px;
        border-radius: 50%;
        background: #10b981;
        border: 2px solid #0f1624;
        position: absolute;
        bottom: 0;
        right: 0;
        box-shadow: 0 0 8px rgba(16, 185, 129, 0.7);
    }

    .user-meta-info {
        min-width: 0;
        flex: 1;
    }

    .user-meta-name {
        font-weight: 800;
        color: #0f172a;
        font-size: 1.05rem;
        letter-spacing: -0.3px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        line-height: 1.25;
    }

    .user-meta-email {
        font-size: 0.78rem;
        color: var(--text-muted);
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        margin-top: 2px;
    }

    .user-meta-badge {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        font-size: 0.68rem;
        font-weight: 800;
        letter-spacing: 0.5px;
        color: #4f46e5;
        background: #eef2ff;
        border: 1px solid #c7d2fe;
        padding: 2px 8px;
        border-radius: var(--radius-full);
        margin-top: 5px;
    }

    /* Menu Links */
    .sidebar-menu {
        list-style: none;
        display: flex;
        flex-direction: column;
        gap: 5px;
        margin: 0;
        padding: 0;
        flex: 1;
    }

    .sidebar-menu-logout-item {
        margin-top: auto;
        padding-top: 14px;
        border-top: 1px solid var(--border-subtle);
    }

    .menu-item-link {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 11px 14px;
        border-radius: var(--radius-md);
        font-weight: 650;
        font-size: 0.9rem;
        color: var(--text-sub);
        transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
        text-decoration: none;
        border: 1px solid transparent;
    }

    .menu-link-inner {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .menu-icon-box {
        width: 32px;
        height: 32px;
        border-radius: 9px;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #64748b;
        transition: all 0.2s ease;
        flex-shrink: 0;
    }

    .menu-icon-box svg {
        width: 17px;
        height: 17px;
        stroke: currentColor;
        stroke-width: 2;
    }

    .menu-item-link:hover {
        background: #f1f5f9;
        color: #0f172a;
        transform: translateX(3px);
    }

    .menu-item-link:hover .menu-icon-box {
        color: #0f172a;
        border-color: #cbd5e1;
        background: #ffffff;
    }

    .menu-item-link.active {
        background: #0f172a;
        color: #ffffff;
        border: 1px solid #0f172a;
        box-shadow: 0 4px 14px rgba(15, 23, 42, 0.18);
    }

    .menu-item-link.active .menu-icon-box {
        background: #1e293b;
        border-color: transparent;
        color: #ffffff;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
    }

    .menu-count-badge {
        font-size: 0.72rem;
        font-weight: 800;
        padding: 2px 8px;
        border-radius: var(--radius-full);
        background: #f1f5f9;
        border: 1px solid #e2e8f0;
        color: var(--text-muted);
    }

    .menu-count-badge.has-items {
        background: #eef2ff;
        border-color: #c7d2fe;
        color: #4f46e5;
    }

    .menu-item-link.active .menu-count-badge.has-items {
        background: #ffffff;
        border-color: #ffffff;
        color: #0f172a;
    }

    .menu-item-logout {
        width: 100%;
        border: none;
        background: transparent;
        cursor: pointer;
        color: #f87171;
    }

    .menu-item-logout:hover {
        background: rgba(239, 68, 68, 0.12);
        color: #fca5a5;
    }

    .menu-item-logout:hover .menu-icon-box {
        background: rgba(239, 68, 68, 0.2);
        border-color: rgba(239, 68, 68, 0.4);
        color: #f87171;
    }

    /* Main Tab Content Card (Base styles handled in media queries) */
    .tab-header-banner {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        margin-bottom: 28px;
        padding-bottom: 20px;
        border-bottom: 1px solid var(--border-subtle);
        flex-wrap: wrap;
        gap: 14px;
    }

    .tab-header-left {
        display: flex;
        align-items: center;
        gap: 14px;
    }

    .tab-header-icon-wrap {
        width: 46px;
        height: 46px;
        border-radius: 14px;
        background: rgba(99, 102, 241, 0.12);
        border: 1px solid rgba(99, 102, 241, 0.3);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #818cf8;
        flex-shrink: 0;
    }

    .tab-header-icon-wrap.pink {
        background: linear-gradient(135deg, #f43f5e 0%, #e11d48 100%);
        border: none;
        color: #ffffff;
        box-shadow: 0 6px 18px rgba(244, 63, 94, 0.35);
    }

    .tab-header-icon-wrap svg {
        width: 24px;
        height: 24px;
        stroke: currentColor;
    }

    .tab-title {
        font-size: 1.55rem;
        font-weight: 850;
        color: #0f172a;
        letter-spacing: -0.4px;
        line-height: 1.2;
    }

    .tab-subtitle {
        color: var(--text-muted);
        font-size: 0.9rem;
        margin-top: 3px;
    }

    /* Empty State Hero */
    .empty-tab-state {
        text-align: center;
        padding: 44px 24px 40px;
        position: relative;
        overflow: hidden;
        border-radius: var(--radius-lg);
        background: #f8fafc;
        border: 1px dashed #cbd5e1;
        margin-bottom: 24px;
    }

    .empty-state-glow {
        position: absolute;
        top: -40px;
        left: 50%;
        transform: translateX(-50%);
        width: 220px;
        height: 220px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(236, 72, 153, 0.15) 0%, transparent 70%);
        pointer-events: none;
    }

    .empty-state-icon-orbit {
        width: 76px;
        height: 76px;
        border-radius: 24px;
        background: rgba(236, 72, 153, 0.1);
        border: 1px solid rgba(236, 72, 153, 0.25);
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
        color: #db2777;
        position: relative;
        animation: emptyFloat 3s ease-in-out infinite;
    }

    .empty-state-icon-orbit::after {
        content: '';
        position: absolute;
        inset: -6px;
        border-radius: 28px;
        border: 2px solid rgba(236, 72, 153, 0.2);
        animation: emptyPulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
    }

    @keyframes emptyFloat {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-4px); }
    }

    @keyframes emptyPulse {
        0%, 100% { transform: scale(1); opacity: 0.8; }
        50% { transform: scale(1.15); opacity: 0.1; }
    }

    .empty-state-badge {
        display: inline-block;
        padding: 3px 12px;
        border-radius: 9999px;
        font-size: 0.72rem;
        font-weight: 800;
        letter-spacing: 0.8px;
        text-transform: uppercase;
        background: rgba(236, 72, 153, 0.1);
        color: #be185d;
        border: 1px solid rgba(236, 72, 153, 0.25);
        margin-bottom: 12px;
    }

    .empty-state-title {
        font-size: 1.45rem;
        font-weight: 850;
        color: #0f172a;
        margin-bottom: 8px;
        letter-spacing: -0.3px;
    }

    .empty-state-desc {
        color: var(--text-muted);
        font-size: 0.92rem;
        max-width: 440px;
        margin: 0 auto 24px;
        line-height: 1.55;
    }

    /* Wishlist Active Grid */
    .wishlist-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 320px));
        gap: 26px;
        margin-bottom: 40px;
    }

    .wishlist-item-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 20px;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        position: relative;
        box-shadow: 0 4px 18px rgba(15, 23, 42, 0.04);
    }

    .wishlist-item-card:hover {
        transform: translateY(-5px);
        border-color: #cbd5e1;
        box-shadow: 0 16px 36px rgba(15, 23, 42, 0.09);
    }

    .wishlist-media {
        width: 100%;
        aspect-ratio: 1/1;
        position: relative;
        background: #f8fafc;
        overflow: hidden;
    }

    .wishlist-media-link {
        display: block;
        width: 100%;
        height: 100%;
    }

    .wishlist-media img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.4s ease;
    }

    .wishlist-item-card:hover .wishlist-media img {
        transform: scale(1.06);
    }

    /* Floating badges & buttons on media */
    .wishlist-float-badge {
        position: absolute;
        top: 12px;
        left: 12px;
        z-index: 2;
        padding: 5px 12px;
        border-radius: 9999px;
        font-size: 0.72rem;
        font-weight: 800;
        letter-spacing: 0.05em;
        text-transform: uppercase;
        box-shadow: 0 2px 8px rgba(15, 23, 42, 0.1);
    }

    .wishlist-float-badge.discount {
        background: #0f172a;
        color: #ffffff;
        border: 1px solid rgba(255, 255, 255, 0.15);
    }

    .wishlist-float-badge.category {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(8px);
        color: #0f172a;
        border: 1px solid #e2e8f0;
    }

    .wishlist-float-remove-form {
        position: absolute;
        top: 12px;
        right: 12px;
        z-index: 3;
        margin: 0;
    }

    .wishlist-float-remove-btn {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(8px);
        border: 1px solid #e2e8f0;
        color: #64748b;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
        box-shadow: 0 4px 12px rgba(15, 23, 42, 0.08);
        padding: 0;
    }

    .wishlist-float-remove-btn:hover {
        background: #fee2e2;
        border-color: #fca5a5;
        color: #ef4444;
        transform: scale(1.12);
        box-shadow: 0 6px 16px rgba(239, 68, 68, 0.22);
    }

    .wishlist-body {
        padding: 20px 22px 22px;
        display: flex;
        flex-direction: column;
        flex: 1;
        justify-content: space-between;
    }

    .wishlist-cat-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 6px;
    }

    .wishlist-cat-label {
        font-size: 0.72rem;
        font-weight: 750;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        color: #64748b;
    }

    .wishlist-stock-tag {
        font-size: 0.72rem;
        font-weight: 750;
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }

    .wishlist-stock-tag.in-stock {
        color: #059669;
    }

    .wishlist-stock-tag.out-of-stock {
        color: #dc2626;
    }

    .stock-pulse-dot {
        width: 7px;
        height: 7px;
        border-radius: 50%;
        background: #10b981;
        display: inline-block;
        box-shadow: 0 0 0 2px rgba(16, 185, 129, 0.25);
    }

    .wishlist-item-title-link {
        text-decoration: none;
        color: inherit;
        display: block;
    }

    .wishlist-item-title {
        font-size: 1.05rem;
        font-weight: 750;
        color: #0f172a;
        line-height: 1.35;
        margin: 0 0 8px;
        text-transform: capitalize;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        transition: color 0.2s ease;
    }

    .wishlist-item-title-link:hover .wishlist-item-title {
        color: #2563eb;
    }

    .wishlist-rating-row {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 12px;
    }

    .rating-stars-inline {
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }

    .stars-gold {
        color: #f59e0b;
        font-size: 0.82rem;
        letter-spacing: 1px;
    }

    .rating-val {
        font-size: 0.8rem;
        font-weight: 800;
        color: #0f172a;
    }

    .rating-reviews-count {
        font-size: 0.76rem;
        color: #64748b;
    }

    .wishlist-price-block {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 18px;
        padding-top: 6px;
    }

    .price-main-wrap {
        display: flex;
        align-items: baseline;
        gap: 8px;
    }

    .wishlist-price {
        font-size: 1.25rem;
        font-weight: 850;
        color: #0f172a;
        letter-spacing: -0.02em;
    }

    .wishlist-original-price {
        font-size: 0.88rem;
        color: #94a3b8;
        text-decoration: line-through;
        font-weight: 500;
    }

    .wishlist-savings-pill {
        font-size: 0.72rem;
        font-weight: 800;
        color: #047857;
        background: #ecfdf5;
        border: 1px solid #a7f3d0;
        padding: 3px 8px;
        border-radius: 9999px;
    }

    .wishlist-actions-wrap {
        margin-top: auto;
    }

    .btn-wishlist-cart-full {
        width: 100%;
        height: 46px;
        border-radius: 9999px;
        background: #0f172a;
        border: 1px solid #0f172a;
        color: #ffffff;
        font-size: 0.88rem;
        font-weight: 750;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        box-shadow: 0 4px 14px rgba(15, 23, 42, 0.12);
        transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
    }

    .btn-wishlist-cart-full:hover:not(:disabled) {
        background: #2563eb;
        border-color: #2563eb;
        box-shadow: 0 6px 20px rgba(37, 99, 235, 0.3);
        transform: translateY(-2px);
    }

    .btn-wishlist-cart-full:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }

    .wishlist-counter-pill {
        background: #fff1f2;
        color: #e11d48;
        border: 1px solid #fecdd3;
        padding: 6px 14px;
        border-radius: 9999px;
        font-size: 0.76rem;
        font-weight: 800;
        letter-spacing: 0.05em;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    /* Wishlist Recommendations Section */
    .wishlist-recs-wrap {
        margin-top: 36px;
        padding-top: 32px;
        border-top: 1px solid #e2e8f0;
    }

    .recs-header {
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        margin-bottom: 22px;
        flex-wrap: wrap;
        gap: 14px;
    }

    .recs-sparkle-badge {
        display: inline-block;
        font-size: 0.72rem;
        font-weight: 800;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        color: #2563eb;
        background: #eff6ff;
        border: 1px solid #bfdbfe;
        padding: 3px 10px;
        border-radius: 9999px;
        margin-bottom: 6px;
    }

    .recs-heading {
        font-size: 1.28rem;
        font-weight: 850;
        color: #0f172a;
        letter-spacing: -0.02em;
        margin: 0 0 4px;
    }

    .recs-subheading {
        font-size: 0.88rem;
        color: #64748b;
        margin: 0;
    }

    .btn-recs-viewall {
        font-size: 0.84rem;
        font-weight: 750;
        color: #2563eb;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 8px 16px;
        border-radius: 9999px;
        background: #f1f5f9;
        transition: all 0.2s;
    }

    .btn-recs-viewall:hover {
        background: #2563eb;
        color: #ffffff;
    }

    .recs-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
    }

    .rec-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 18px;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        box-shadow: 0 2px 10px rgba(15, 23, 42, 0.03);
        position: relative;
    }

    .rec-card:hover {
        transform: translateY(-4px);
        border-color: #cbd5e1;
        box-shadow: 0 12px 28px rgba(15, 23, 42, 0.08);
    }

    .rec-media {
        position: relative;
        width: 100%;
        aspect-ratio: 1/1;
        background: #f8fafc;
        overflow: hidden;
    }

    .rec-media img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.4s ease;
    }

    .rec-card:hover .rec-media img {
        transform: scale(1.06);
    }

    .rec-float-wishlist-btn {
        position: absolute;
        top: 10px;
        right: 10px;
        width: 34px;
        height: 34px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(8px);
        border: 1px solid #e2e8f0;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        color: #64748b;
        box-shadow: 0 2px 8px rgba(15, 23, 42, 0.08);
        transition: all 0.2s;
        padding: 0;
    }

    .rec-float-wishlist-btn:hover {
        background: #fee2e2;
        border-color: #fca5a5;
        color: #ef4444;
        transform: scale(1.1);
    }

    .rec-body {
        padding: 14px 16px 16px;
        display: flex;
        flex-direction: column;
        flex: 1;
        justify-content: space-between;
    }

    .rec-cat {
        font-size: 0.68rem;
        font-weight: 750;
        letter-spacing: 0.06em;
        text-transform: uppercase;
        color: #64748b;
        margin-bottom: 4px;
    }

    .rec-title {
        font-size: 0.92rem;
        font-weight: 750;
        color: #0f172a;
        line-height: 1.35;
        text-transform: capitalize;
        margin: 0 0 8px;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        transition: color 0.2s;
    }

    .rec-card:hover .rec-title {
        color: #2563eb;
    }

    .rec-price-row {
        display: flex;
        align-items: baseline;
        gap: 6px;
        margin-bottom: 12px;
    }

    .rec-price {
        font-size: 1.05rem;
        font-weight: 850;
        color: #0f172a;
    }

    .rec-original-price {
        font-size: 0.8rem;
        color: #94a3b8;
        text-decoration: line-through;
    }

    .btn-rec-action {
        width: 100%;
        padding: 8px 12px;
        border-radius: 9999px;
        background: #f8fafc;
        border: 1px solid #cbd5e1;
        color: #0f172a;
        font-size: 0.8rem;
        font-weight: 750;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        cursor: pointer;
        text-decoration: none;
        transition: all 0.2s;
    }

    .btn-rec-action:hover {
        background: #0f172a;
        border-color: #0f172a;
        color: #ffffff;
    }

    @media (max-width: 1024px) {
        .recs-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 580px) {
        .wishlist-grid {
            grid-template-columns: 1fr;
        }
        .recs-grid {
            grid-template-columns: 1fr;
        }
    }

    /* Order Row Items */
    .order-row-item {
        border: 1px solid var(--border-subtle);
        background: #ffffff;
        border-radius: var(--radius-md);
        padding: 22px;
        margin-bottom: 16px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.02);
        transition: border-color 0.2s;
    }

    .order-row-item:hover {
        border-color: #cbd5e1;
    }

    /* Forms */
    .form-group {
        display: flex;
        flex-direction: column;
        gap: 6px;
        margin-bottom: 11px;
    }

    .form-label {
        font-size: 0.76rem;
        font-weight: 750;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #475569;
    }

    .form-control {
        background: #ffffff;
        border: 1px solid #cbd5e1;
        color: #0f172a;
        padding: 9px 13px;
        border-radius: var(--radius-md);
        font-size: 0.88rem;
        outline: none;
        transition: border-color 0.2s;
    }

    .form-control:focus {
        border-color: #0f172a;
        box-shadow: 0 0 0 2px rgba(15, 23, 42, 0.1);
    }

    /* Profile Hero Banner */
    .profile-hero-banner {
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        border: 1px solid #e2e8f0;
        border-radius: var(--radius-lg);
        padding: 12px 18px 11px;
        margin-bottom: 12px;
        position: relative;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        gap: 9px;
        flex-shrink: 0;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.03);
    }

    .profile-hero-banner::before {
        content: '';
        position: absolute;
        top: -60px;
        right: -60px;
        width: 240px;
        height: 240px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(139, 92, 246, 0.2) 0%, transparent 70%);
        pointer-events: none;
    }

    .profile-hero-banner::after {
        content: '';
        position: absolute;
        bottom: -60px;
        left: 25%;
        width: 220px;
        height: 140px;
        background: radial-gradient(circle, rgba(99, 102, 241, 0.12) 0%, transparent 70%);
        pointer-events: none;
    }

    .profile-hero-top-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        flex-wrap: wrap;
        position: relative;
        z-index: 1;
    }

    .hero-identity-group {
        display: flex;
        align-items: center;
        gap: 14px;
        min-width: 0;
    }

    .profile-avatar-large {
        position: relative;
        flex-shrink: 0;
    }

    .avatar-ring-glow {
        width: 52px;
        height: 52px;
        border-radius: 50%;
        background: linear-gradient(135deg, #6366f1 0%, #a855f7 50%, #ec4899 100%);
        padding: 2px;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 16px rgba(99, 102, 241, 0.45);
    }

    .avatar-letter {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        background: #0b1120;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
        font-weight: 850;
        color: #ffffff;
    }

    .avatar-camera-btn {
        position: absolute;
        bottom: -2px;
        right: -2px;
        width: 22px;
        height: 22px;
        border-radius: 50%;
        background: #090e1a;
        border: 2px solid #818cf8;
        color: #c7d2fe;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.7);
        transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
        z-index: 2;
    }

    .avatar-camera-btn:hover {
        background: #6366f1;
        color: #ffffff;
        border-color: #ffffff;
        transform: scale(1.15);
        box-shadow: 0 0 14px rgba(99, 102, 241, 0.8);
    }

    .profile-hero-meta {
        display: flex;
        flex-direction: column;
        gap: 2px;
        min-width: 0;
    }

    .hero-name-row {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
    }

    .hero-user-name {
        font-size: 1.22rem;
        font-weight: 850;
        color: #0f172a;
        letter-spacing: -0.3px;
        line-height: 1.2;
    }

    .hero-role-pill {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 2px 8px;
        border-radius: 9999px;
        font-size: 0.65rem;
        font-weight: 800;
        letter-spacing: 0.5px;
        text-transform: uppercase;
        background: #eef2ff;
        color: #4f46e5;
        border: 1px solid #c7d2fe;
    }

    .hero-role-dot {
        width: 5px;
        height: 5px;
        border-radius: 50%;
        background: #4f46e5;
        box-shadow: 0 0 6px rgba(79, 70, 229, 0.4);
    }

    .hero-email-row {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 0.75rem;
        color: #64748b;
        flex-wrap: wrap;
    }

    .hero-meta-item {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        color: #475569;
    }

    .hero-sep {
        color: #cbd5e1;
    }

    /* VIP Status Badge on Hero Right */
    .hero-vip-badge {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 5px 12px;
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.03);
    }

    .hero-vip-icon {
        width: 28px;
        height: 28px;
        border-radius: 8px;
        background: rgba(236, 72, 153, 0.1);
        border: 1px solid rgba(236, 72, 153, 0.25);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #db2777;
        flex-shrink: 0;
    }

    .hero-vip-title {
        font-size: 0.74rem;
        font-weight: 850;
        color: #0f172a;
        letter-spacing: 0.5px;
    }

    .hero-vip-sub {
        font-size: 0.64rem;
        color: #059669;
        font-weight: 650;
    }

    /* Hero Divider */
    .hero-banner-divider {
        width: 100%;
        height: 1px;
        background: #e2e8f0;
        position: relative;
        z-index: 1;
    }

    /* 4-Column Balanced Hero Stats Grid */
    .hero-stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 10px;
        width: 100%;
        position: relative;
        z-index: 1;
    }

    @media (max-width: 900px) {
        .hero-stats-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    .hero-stat-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 8px 14px;
        display: flex;
        align-items: center;
        gap: 10px;
        transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
        box-shadow: 0 2px 8px rgba(15, 23, 42, 0.03);
    }

    .hero-stat-card:hover {
        background: #ffffff;
        border-color: #cbd5e1;
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(15, 23, 42, 0.07);
    }

    .hero-stat-icon {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .stat-icon-orders {
        background: #eff6ff;
        color: #2563eb;
        border: 1px solid #bfdbfe;
    }

    .stat-icon-spent {
        background: #ecfdf5;
        color: #059669;
        border: 1px solid #a7f3d0;
    }

    .stat-icon-wishlist {
        background: #fdf2f8;
        color: #db2777;
        border: 1px solid #fbcfe8;
    }

    .stat-icon-security {
        background: #eff6ff;
        color: #0284c7;
        border: 1px solid #bae6fd;
    }

    .hero-stat-info {
        display: flex;
        flex-direction: column;
        line-height: 1.2;
        min-width: 0;
    }

    .hero-stat-val {
        font-weight: 850;
        color: #0f172a;
        font-size: 1.05rem;
        letter-spacing: -0.2px;
    }

    .hero-stat-lbl {
        font-size: 0.68rem;
        color: #475569;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        font-weight: 750;
        margin-top: 1px;
    }

    /* 2-Column Balanced Dashboard Content */
    .profile-grid-container {
        display: grid;
        grid-template-columns: 1.35fr 1fr;
        gap: 16px;
        align-items: start;
        flex-shrink: 0;
    }

    @media (max-width: 1100px) {
        .profile-grid-container {
            grid-template-columns: 1fr;
        }
    }

    /* Section Card */
    .profile-section-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: var(--radius-md);
        padding: 18px 20px;
        box-shadow: 0 2px 8px rgba(15, 23, 42, 0.03);
        transition: border-color 0.2s;
    }

    .profile-section-card:hover {
        border-color: #cbd5e1;
    }

    .section-card-header {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        margin-bottom: 14px;
        padding-bottom: 11px;
        border-bottom: 1px solid #e2e8f0;
    }

    .section-card-icon-wrap {
        width: 32px;
        height: 32px;
        border-radius: 9px;
        background: #eff6ff;
        border: 1px solid #bfdbfe;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #2563eb;
        flex-shrink: 0;
    }

    .section-card-title {
        font-size: 1.05rem;
        font-weight: 850;
        color: #0f172a;
        letter-spacing: -0.2px;
    }

    .section-card-sub {
        font-size: 0.82rem;
        color: #475569;
        margin-top: 2px;
        font-weight: 500;
    }

    /* Input with inside icons */
    .input-with-icon-wrap {
        position: relative;
        display: flex;
        align-items: center;
    }

    .input-lead-icon {
        position: absolute;
        left: 14px;
        color: #64748b;
        display: flex;
        align-items: center;
        pointer-events: none;
        transition: color 0.2s;
    }

    .form-control.with-icon {
        padding-left: 42px;
        background: #f8fafc;
        border: 1px solid #cbd5e1;
        color: #0f172a;
        font-weight: 600;
        font-size: 0.92rem;
    }

    .form-control.with-icon:focus {
        background: #ffffff;
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.12);
    }

    .input-with-icon-wrap:focus-within .input-lead-icon {
        color: #2563eb;
    }

    .label-verified-chip {
        float: right;
        font-size: 0.68rem;
        font-weight: 800;
        letter-spacing: 0.05em;
        color: #047857;
        background: #ecfdf5;
        border: 1px solid #a7f3d0;
        padding: 2px 7px;
        border-radius: 4px;
        display: inline-flex;
        align-items: center;
        gap: 3px;
        text-transform: uppercase;
    }

    /* Luxury Submit Button */
    .btn-primary-luxury {
        background: #0f172a;
        color: #ffffff;
        border: none;
        font-size: 0.90rem;
        font-weight: 750;
        padding: 11px 24px;
        border-radius: var(--radius-full);
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        box-shadow: 0 4px 14px rgba(15, 23, 42, 0.16);
        transition: all 0.22s cubic-bezier(0.16, 1, 0.3, 1);
        letter-spacing: 0.01em;
    }

    .btn-primary-luxury:hover {
        background: #2563eb;
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(37, 99, 235, 0.32);
        color: #ffffff;
    }

    /* Side Widgets Stack */
    .profile-side-widgets {
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    .widget-card {
        background: #ffffff;
        border: 1px solid var(--border-subtle);
        border-radius: var(--radius-md);
        padding: 18px 20px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.02);
        transition: border-color 0.2s;
    }

    .widget-card:hover {
        border-color: #cbd5e1;
    }

    .widget-card-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 12px;
        gap: 8px;
    }

    .widget-card-title-wrap {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .widget-card-title {
        font-size: 0.86rem;
        font-weight: 800;
        color: #0f172a;
        letter-spacing: -0.2px;
    }

    .widget-badge-dot {
        width: 7px;
        height: 7px;
        border-radius: 50%;
        background: #4f46e5;
        box-shadow: 0 0 8px rgba(79, 70, 229, 0.4);
    }

    .widget-view-all-link {
        font-size: 0.75rem;
        font-weight: 700;
        color: #4f46e5;
        text-decoration: none;
        transition: color 0.15s;
    }

    .widget-view-all-link:hover {
        color: #3730a3;
        text-decoration: underline;
    }

    .latest-order-item {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 12px 14px;
    }

    .latest-order-top {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 10px;
    }

    .latest-order-num {
        font-weight: 800;
        font-size: 0.88rem;
        color: #0f172a;
    }

    .latest-order-date {
        font-size: 0.74rem;
        color: var(--text-muted);
        margin-top: 2px;
    }

    .latest-order-total {
        font-weight: 850;
        font-size: 0.98rem;
        color: #0f172a;
    }

    .latest-order-status-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding-top: 8px;
        border-top: 1px solid rgba(255, 255, 255, 0.06);
    }

    .order-status-tag {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 0.72rem;
        font-weight: 800;
        padding: 4px 10px;
        border-radius: 9999px;
        letter-spacing: 0.04em;
        line-height: 1.3;
    }

    .order-status-tag.status-delivered,
    .order-status-tag.status-completed {
        background: #ecfdf5;
        color: #047857;
        border: 1px solid #a7f3d0;
    }

    .order-status-tag.status-processing {
        background: #eff6ff;
        color: #1d4ed8;
        border: 1px solid #bfdbfe;
    }

    .order-status-tag.status-pending {
        background: #fffbeb;
        color: #b45309;
        border: 1px solid #fde68a;
    }

    .order-status-tag.status-shipped {
        background: #f0f9ff;
        color: #0369a1;
        border: 1px solid #bae6fd;
    }

    .order-status-tag.status-cancelled,
    .order-status-tag.status-cancel,
    .order-status-tag.status-canceled {
        background: #fef2f2;
        color: #b91c1c;
        border: 1px solid #fecaca;
    }

    .status-pulse-dot {
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: currentColor;
        display: inline-block;
    }

    .order-track-mini-btn {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        font-size: 0.75rem;
        font-weight: 750;
        color: #ffffff;
        padding: 5px 12px;
        border-radius: var(--radius-full);
        background: #0f172a;
        border: none;
        transition: all 0.18s ease;
        text-decoration: none;
    }

    .order-track-mini-btn:hover {
        background: #2563eb;
        color: #ffffff;
        transform: translateY(-1px);
    }

    .empty-order-mini {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 10px 12px;
        background: #f8fafc;
        border-radius: 10px;
        border: 1px solid #e2e8f0;
    }

    .empty-mini-icon {
        font-size: 1.4rem;
    }

    .security-safe-badge {
        font-size: 0.68rem;
        font-weight: 800;
        color: #047857;
        background: #ecfdf5;
        border: 1px solid #a7f3d0;
        padding: 2px 8px;
        border-radius: 4px;
        letter-spacing: 0.05em;
    }

    .quick-links-stack {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .quick-link-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 9px 12px;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        color: #0f172a;
        text-decoration: none;
        transition: all 0.15s;
    }

    .quick-link-row:hover {
        background: #f1f5f9;
        border-color: #cbd5e1;
        transform: translateX(3px);
    }

    .quick-link-left {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .quick-link-icon {
        width: 28px;
        height: 28px;
        border-radius: 8px;
        background: #ffffff;
        border: 1px solid #e2e8f0;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #4f46e5;
    }

    .quick-link-title {
        font-size: 0.82rem;
        font-weight: 750;
        color: #0f172a;
    }

    .quick-link-sub {
        font-size: 0.72rem;
        color: var(--text-muted);
    }

    /* VIP Perks Mini Card in Sidebar */
    .sidebar-tier-card {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: var(--radius-md);
        padding: 13px 14px;
        margin-top: auto;
        margin-bottom: 12px;
        position: relative;
        overflow: hidden;
    }

    .tier-card-header {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 9px;
    }

    .tier-icon-wrap {
        width: 30px;
        height: 30px;
        border-radius: 8px;
        background: #0f172a;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #ffffff;
        box-shadow: 0 2px 8px rgba(15, 23, 42, 0.15);
        flex-shrink: 0;
    }

    .tier-title {
        font-size: 0.78rem;
        font-weight: 850;
        color: #0f172a;
        letter-spacing: 0.4px;
    }

    .tier-badge {
        font-size: 0.68rem;
        color: #2563eb;
        font-weight: 750;
    }

    .tier-progress-wrap {
        height: 6px;
        background: #e2e8f0;
        border-radius: 9999px;
        overflow: hidden;
        margin-bottom: 6px;
    }

    .tier-progress-bar {
        height: 100%;
        background: #2563eb;
        border-radius: 9999px;
    }

    .tier-footer-text {
        display: flex;
        justify-content: space-between;
        font-size: 0.70rem;
        color: #475569;
        font-weight: 600;
    }

    /* Avatar Upload & Interactive Photo Styles */
    .avatar-clickable {
        position: relative;
        cursor: pointer;
        overflow: hidden;
        transition: transform 0.2s, box-shadow 0.2s;
    }

    .avatar-clickable:hover {
        transform: scale(1.04);
        box-shadow: 0 0 25px rgba(99, 102, 241, 0.6);
    }

    .avatar-inner-wrap {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #0f172a;
    }

    .avatar-img-round {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        object-fit: cover;
        display: block;
    }

    .avatar-camera-overlay {
        position: absolute;
        inset: 2px;
        border-radius: 50%;
        background: rgba(15, 23, 42, 0.75);
        backdrop-filter: blur(3px);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #ffffff;
        opacity: 0;
        transition: opacity 0.2s ease;
        pointer-events: none;
    }

    .avatar-clickable:hover .avatar-camera-overlay {
        opacity: 1;
    }


    .avatar-form-row {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 8px 12px;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        margin-bottom: 11px;
        transition: border-color 0.2s;
    }

    .avatar-form-row:hover {
        border-color: #cbd5e1;
    }

    .avatar-form-preview {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        background: #0f172a;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 850;
        color: #ffffff;
        font-size: 1.05rem;
        overflow: hidden;
        border: 2px solid #e2e8f0;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        flex-shrink: 0;
    }

    .avatar-form-preview img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 50%;
    }

    .avatar-form-actions-top {
        display: flex;
        align-items: center;
        gap: 8px;
        flex-wrap: wrap;
    }

    .btn-avatar-upload {
        background: #0f172a;
        border: 1px solid #0f172a;
        color: #ffffff;
        font-size: 0.8rem;
        font-weight: 750;
        padding: 6px 14px;
        border-radius: var(--radius-full);
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: all 0.2s;
    }

    .btn-avatar-upload:hover {
        opacity: 0.88;
        transform: translateY(-1px);
    }

    .btn-avatar-remove {
        background: rgba(239, 68, 68, 0.12);
        border: 1px solid rgba(239, 68, 68, 0.3);
        color: #fca5a5;
        font-size: 0.8rem;
        font-weight: 700;
        padding: 6px 12px;
        border-radius: var(--radius-full);
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        transition: all 0.2s;
    }

    .btn-avatar-remove:hover {
        background: rgba(239, 68, 68, 0.25);
        color: #ffffff;
    }

    .avatar-form-hint {
        font-size: 0.72rem;
        color: var(--text-muted);
        margin-top: 3px;
        display: block;
    }

    /* Live Upload Toast */
    .avatar-toast {
        position: fixed;
        bottom: 24px;
        right: 24px;
        background: rgba(15, 23, 42, 0.95);
        backdrop-filter: blur(16px);
        border: 1px solid #10b981;
        color: #ffffff;
        padding: 12px 20px;
        border-radius: 12px;
        font-size: 0.88rem;
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 10px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.6), 0 0 20px rgba(16, 185, 129, 0.25);
        z-index: 999999;
        transform: translateY(20px);
        opacity: 0;
        transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
        pointer-events: none;
    }

    .avatar-toast.show {
        transform: translateY(0);
        opacity: 1;
        pointer-events: auto;
    }
</style>
@endsection

@section('content')
<div class="account-page-wrap">
    <div class="account-grid-layout">
        
        <!-- ============================================================
             1. LEFT SIDEBAR WITH VECTOR SVG ICONS
             ============================================================ -->
        <aside class="account-sidebar">
            <div class="user-profile-badge">
                <div class="avatar-wrapper">
                    <div class="avatar-circle" style="overflow:hidden;" id="sidebarAvatarContainer">
                        @if ($user->avatar)
                            <img src="{{ asset($user->avatar) }}" alt="{{ $user->name }}" style="width:100%; height:100%; border-radius:50%; object-fit:cover;">
                        @else
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        @endif
                    </div>
                    <div class="avatar-online-dot" title="Active Account"></div>
                </div>
                <div class="user-meta-info">
                    <div class="user-meta-name" title="{{ $user->name }}">{{ $user->name }}</div>
                    <div class="user-meta-email" title="{{ $user->email }}">{{ $user->email }}</div>
                    <span class="user-meta-badge">
                        <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"></polyline></svg>
                        <span>{{ strtoupper($user->role ?? 'MEMBER') }}</span>
                    </span>
                </div>
            </div>

            <ul class="sidebar-menu">
                <!-- 1. Profile -->
                <li>
                    <a href="{{ route('account.index', ['tab' => 'profile']) }}" class="menu-item-link {{ $tab == 'profile' ? 'active' : '' }}">
                        <div class="menu-link-inner">
                            <div class="menu-icon-box">
                                <svg viewBox="0 0 24 24" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="12" cy="7" r="4"></circle>
                                </svg>
                            </div>
                            <span>Profile</span>
                        </div>
                    </a>
                </li>

                <!-- 2. My Orders -->
                <li>
                    <a href="{{ route('account.index', ['tab' => 'orders']) }}" class="menu-item-link {{ $tab == 'orders' ? 'active' : '' }}">
                        <div class="menu-link-inner">
                            <div class="menu-icon-box">
                                <svg viewBox="0 0 24 24" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path>
                                    <line x1="3" y1="6" x2="21" y2="6"></line>
                                    <path d="M16 10a4 4 0 0 1-8 0"></path>
                                </svg>
                            </div>
                            <span>My Orders</span>
                        </div>
                        <span class="menu-count-badge {{ count($orders) > 0 ? 'has-items' : '' }}">{{ count($orders) }}</span>
                    </a>
                </li>

                <!-- 3. Wishlist -->
                <li>
                    <a href="{{ route('account.index', ['tab' => 'wishlist']) }}" class="menu-item-link {{ $tab == 'wishlist' ? 'active' : '' }}">
                        <div class="menu-link-inner">
                            <div class="menu-icon-box">
                                <svg viewBox="0 0 24 24" fill="{{ $tab == 'wishlist' ? 'currentColor' : 'none' }}" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
                                </svg>
                            </div>
                            <span>Wishlist</span>
                        </div>
                        <span class="menu-count-badge {{ count($wishlistProducts) > 0 ? 'has-items' : '' }}">{{ count($wishlistProducts) }}</span>
                    </a>
                </li>

                <!-- 4. Addresses -->
                <li>
                    <a href="{{ route('account.index', ['tab' => 'addresses']) }}" class="menu-item-link {{ $tab == 'addresses' ? 'active' : '' }}">
                        <div class="menu-link-inner">
                            <div class="menu-icon-box">
                                <svg viewBox="0 0 24 24" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                                    <circle cx="12" cy="10" r="3"></circle>
                                </svg>
                            </div>
                            <span>Addresses</span>
                        </div>
                    </a>
                </li>

                <!-- 5. Setting -->
                <li>
                    <a href="{{ route('account.index', ['tab' => 'setting']) }}" class="menu-item-link {{ $tab == 'setting' ? 'active' : '' }}">
                        <div class="menu-link-inner">
                            <div class="menu-icon-box">
                                <svg viewBox="0 0 24 24" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="12" cy="12" r="3"></circle>
                                    <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path>
                                </svg>
                            </div>
                            <span>Settings</span>
                        </div>
                    </a>
                </li>

                <!-- VIP Perks Mini Card in Sidebar -->
                <div class="sidebar-tier-card">
                    <div class="tier-card-header">
                        <div class="tier-icon-wrap">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                        </div>
                        <div>
                            <div class="tier-title">THREADCRAFT VIP</div>
                            <div class="tier-badge">{{ strtoupper($user->role === 'admin' ? 'Founding Admin' : 'Black Member') }}</div>
                        </div>
                    </div>
                    <div class="tier-progress-wrap">
                        <div class="tier-progress-bar" style="width: 78%;"></div>
                    </div>
                    <div class="tier-footer-text">
                        <span>Tier 2 Collector</span>
                        <span style="color:#0f172a; font-weight:800;">780 / 1,000 XP</span>
                    </div>
                </div>

                <!-- 6. Logout -->
                <li class="sidebar-menu-logout-item">
                    <form action="{{ route('logout') }}" method="POST" id="accountSidebarLogoutForm">
                        @csrf
                        <button type="button" class="menu-item-link menu-item-logout" id="accountSidebarLogoutBtn">
                            <div class="menu-link-inner">
                                <div class="menu-icon-box" style="color:#f87171;">
                                    <svg viewBox="0 0 24 24" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                                        <polyline points="16 17 21 12 16 7"></polyline>
                                        <line x1="21" y1="12" x2="9" y2="12"></line>
                                    </svg>
                                </div>
                                <span>Logout</span>
                            </div>
                        </button>
                    </form>
                </li>
            </ul>
        </aside>

        <!-- ============================================================
             2. MAIN TAB DISPLAY
             ============================================================ -->
        <main class="tab-content-card">
            
            @if ($tab == 'profile')
                <!-- 1. PROFILE DASHBOARD TAB -->
                <div class="profile-hero-banner">
                    <!-- Top Identity Row -->
                    <div class="profile-hero-top-row">
                        <div class="hero-identity-group">
                            <div class="profile-avatar-large">
                                <div class="avatar-ring-glow avatar-clickable" onclick="document.getElementById('avatarFileInput').click()" title="Click to upload or change profile photo">
                                    <div class="avatar-inner-wrap" id="heroAvatarInner">
                                        @if ($user->avatar)
                                            <img src="{{ asset($user->avatar) }}" alt="{{ $user->name }}" id="heroAvatarImg" class="avatar-img-round">
                                        @else
                                            <span class="avatar-letter" id="heroAvatarLetter">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                                        @endif
                                    </div>
                                    <div class="avatar-camera-overlay">
                                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"></path><circle cx="12" cy="13" r="4"></circle></svg>
                                    </div>
                                </div>
                                <button type="button" class="avatar-camera-btn" onclick="document.getElementById('avatarFileInput').click()" title="Change profile photo">
                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"></path><circle cx="12" cy="13" r="4"></circle></svg>
                                </button>
                            </div>
                            <div class="profile-hero-meta">
                                <div class="hero-name-row">
                                    <h2 class="hero-user-name">{{ $user->name }}</h2>
                                    <span class="hero-role-pill">
                                        <span class="hero-role-dot"></span>
                                        <span>{{ strtoupper($user->role === 'admin' ? 'Store Administrator' : 'VIP Member') }}</span>
                                    </span>
                                </div>
                                <div class="hero-email-row">
                                    <span class="hero-meta-item">
                                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
                                        <span>{{ $user->email }}</span>
                                    </span>
                                    <span class="hero-sep">•</span>
                                    <span class="hero-meta-item">
                                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                                        <span>Joined {{ $user->created_at ? $user->created_at->format('M Y') : '2024' }}</span>
                                    </span>
                                    <span class="hero-sep">•</span>
                                    <span class="hero-meta-item" style="color:#2563eb; font-weight:800;">Customer #TC-{{ str_pad($user->id, 4, '0', STR_PAD_LEFT) }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- VIP Right Badge -->
                        <div class="hero-vip-badge">
                            <div class="hero-vip-icon">
                                <svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                            </div>
                            <div>
                                <div class="hero-vip-title">THREADCRAFT VIP</div>
                                <div class="hero-vip-sub">Tier 2 Collector • Active</div>
                            </div>
                        </div>
                    </div>

                    <!-- Glass Gradient Divider -->
                    <div class="hero-banner-divider"></div>

                    <!-- 4-Column Balanced Hero Stats Grid -->
                    <div class="hero-stats-grid">
                        <div class="hero-stat-card">
                            <div class="hero-stat-icon stat-icon-orders">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path><line x1="3" y1="6" x2="21" y2="6"></line><path d="M16 10a4 4 0 0 1-8 0"></path></svg>
                            </div>
                            <div class="hero-stat-info">
                                <span class="hero-stat-val">{{ $orders->count() }}</span>
                                <span class="hero-stat-lbl">Orders Placed</span>
                            </div>
                        </div>

                        <div class="hero-stat-card">
                            <div class="hero-stat-icon stat-icon-spent">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="1" x2="12" y2="23"></line><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path></svg>
                            </div>
                            <div class="hero-stat-info">
                                <span class="hero-stat-val">${{ number_format($orders->sum('total'), 2) }}</span>
                                <span class="hero-stat-lbl">Total Spent</span>
                            </div>
                        </div>

                        <div class="hero-stat-card">
                            <div class="hero-stat-icon stat-icon-wishlist">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path></svg>
                            </div>
                            <div class="hero-stat-info">
                                <span class="hero-stat-val">{{ count($wishlistProducts) }}</span>
                                <span class="hero-stat-lbl">Wishlist Items</span>
                            </div>
                        </div>

                        <div class="hero-stat-card">
                            <div class="hero-stat-icon stat-icon-security">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>
                            </div>
                            <div class="hero-stat-info">
                                <span class="hero-stat-val" style="color:#10b981;">100%</span>
                                <span class="hero-stat-lbl">Account Safe</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 2-Column Balanced Dashboard Content -->
                <div class="profile-grid-container">
                    
                    <!-- Left: Personal Details Form -->
                    <div class="profile-section-card">
                        <div class="section-card-header">
                            <div class="section-card-icon-wrap">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                            </div>
                            <div>
                                <h3 class="section-card-title">Personal Contact Details</h3>
                                <p class="section-card-sub">Your personal identity, shipping receipts, and delivery contact info.</p>
                            </div>
                        </div>

                        <form action="{{ route('account.profile') }}" method="POST" enctype="multipart/form-data" id="profileForm">
                            @csrf
                            <input type="file" name="avatar" id="avatarFileInput" accept="image/jpeg,image/png,image/jpg,image/webp,image/gif" style="display:none;" onchange="handleAvatarSelected(event)">
                            <input type="hidden" name="remove_avatar" id="removeAvatarInput" value="0">

                            <!-- Profile Photo Upload Row in Form -->
                            <div class="avatar-form-row">
                                <div class="avatar-form-preview" id="formAvatarPreview">
                                    @if ($user->avatar)
                                        <img src="{{ asset($user->avatar) }}" alt="{{ $user->name }}">
                                    @else
                                        <span>{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                                    @endif
                                </div>
                                <div style="flex:1; min-width:0;">
                                    <div class="avatar-form-actions-top">
                                        <button type="button" class="btn-avatar-upload" onclick="document.getElementById('avatarFileInput').click()">
                                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="17 8 12 3 7 8"></polyline><line x1="12" y1="3" x2="12" y2="15"></line></svg>
                                            <span>Upload Photo</span>
                                        </button>
                                        @if ($user->avatar)
                                            <button type="button" class="btn-avatar-remove" id="btnRemoveAvatar" onclick="removeAvatarPhoto()">
                                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                                                <span>Remove</span>
                                            </button>
                                        @endif
                                    </div>
                                    <span class="avatar-form-hint">Supports JPG, PNG, WEBP, or GIF up to 5MB</span>
                                </div>
                            </div>
                            <div class="grid-2-cols" style="margin-bottom: 14px;">
                                <div class="form-group" style="margin-bottom:0;">
                                    <label class="form-label">
                                        <span>Full Legal Name</span>
                                    </label>
                                    <div class="input-with-icon-wrap">
                                        <div class="input-lead-icon">
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                                        </div>
                                        <input type="text" name="name" class="form-control with-icon" value="{{ old('name', $user->name) }}" required placeholder="e.g. John Doe">
                                    </div>
                                </div>

                                <div class="form-group" style="margin-bottom:0;">
                                    <label class="form-label">
                                        <span>Email Address</span>
                                        <span class="label-verified-chip">
                                            <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"></polyline></svg>
                                            VERIFIED
                                        </span>
                                    </label>
                                    <div class="input-with-icon-wrap">
                                        <div class="input-lead-icon">
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
                                        </div>
                                        <input type="email" name="email" class="form-control with-icon" value="{{ old('email', $user->email) }}" required placeholder="your.email@domain.com">
                                    </div>
                                </div>
                            </div>

                            <div class="grid-2-cols" style="margin-bottom: 18px;">
                                <div class="form-group" style="margin-bottom:0;">
                                    <label class="form-label">Contact Phone</label>
                                    <div class="input-with-icon-wrap">
                                        <div class="input-lead-icon">
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
                                        </div>
                                        <input type="text" name="phone" class="form-control with-icon" value="{{ old('phone', $user->phone ?: '+1 (555) 234-5678') }}" placeholder="+1 (555) 000-0000">
                                    </div>
                                </div>

                                <div class="form-group" style="margin-bottom:0;">
                                    <label class="form-label">Access Level</label>
                                    <div class="input-with-icon-wrap">
                                        <div class="input-lead-icon">
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>
                                        </div>
                                        <input type="text" class="form-control with-icon" value="{{ ucfirst($user->role ?? 'Customer') }} Member" readonly style="opacity: 0.75; cursor:not-allowed;">
                                    </div>
                                </div>
                            </div>

                            <div style="display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:12px; padding-top:6px;">
                                <button type="submit" class="btn-primary-luxury">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
                                    <span>Save Profile Changes</span>
                                </button>
                                <span style="font-size:0.82rem; color:#047857; font-weight:600; display:inline-flex; align-items:center; gap:6px;">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#047857" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
                                    Changes save instantaneously
                                </span>
                            </div>
                        </form>
                    </div>

                    <!-- Right: Widgets & Live Activity Card -->
                    <div class="profile-side-widgets">
                        
                        <!-- Widget 1: Recent Order Snippet -->
                        <div class="widget-card widget-latest-order">
                            <div class="widget-card-header">
                                <div class="widget-card-title-wrap">
                                    <span class="widget-badge-dot"></span>
                                    <span class="widget-card-title">Recent Drop Activity</span>
                                </div>
                                <a href="{{ route('account.index', ['tab' => 'orders']) }}" class="widget-view-all-link">All Orders ({{ $orders->count() }}) →</a>
                            </div>

                            @if ($orders->count() > 0)
                                @php $latest = $orders->first(); @endphp
                                <div class="latest-order-item">
                                    <div class="latest-order-top">
                                        <div>
                                            <div class="latest-order-num">Order #{{ $latest->order_number }}</div>
                                            <div class="latest-order-date">{{ $latest->created_at->format('M d, Y') }} • {{ $latest->items->count() }} {{ $latest->items->count() === 1 ? 'item' : 'items' }}</div>
                                        </div>
                                        <div class="latest-order-total">${{ number_format($latest->total, 2) }}</div>
                                    </div>
                                    <div class="latest-order-status-row">
                                        <span class="order-status-tag status-{{ strtolower($latest->status) }}">
                                            <span class="status-pulse-dot"></span>
                                            <span>{{ strtoupper($latest->status) }}</span>
                                        </span>
                                        <a href="{{ route('order.track', ['code' => $latest->tracking_code]) }}" class="order-track-mini-btn">
                                            <span>Track Live</span>
                                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"></polyline></svg>
                                        </a>
                                    </div>
                                </div>
                            @else
                                @php
                                    $activeWelcomePromo = \App\Models\Promotion::where('status', 'Active')
                                        ->where(function ($q) {
                                            $q->whereNull('expires_at')->orWhere('expires_at', '>', now());
                                        })
                                        ->latest()
                                        ->first();
                                @endphp
                                @if ($activeWelcomePromo)
                                    <div class="empty-order-mini">
                                        <div class="empty-mini-icon">🎁</div>
                                        <div>
                                            <div style="font-size:0.86rem; font-weight:750; color:#0f172a;">Welcome Discount Unlocked!</div>
                                            <div style="font-size:0.76rem; color:var(--text-muted); margin-top:2px;">Use code <strong style="color:#4f46e5;">{{ $activeWelcomePromo->code }}</strong> for {{ $activeWelcomePromo->discount_percent }}% off your first streetwear drop.</div>
                                        </div>
                                    </div>
                                @endif
                            @endif
                        </div>

                        <!-- Widget 2: Security & Fast Quick-Links -->
                        <div class="widget-card">
                            <div class="widget-card-header">
                                <div class="widget-card-title-wrap">
                                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#10b981" stroke-width="2.2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>
                                    <span class="widget-card-title">Security & Credentials</span>
                                </div>
                                <span class="security-safe-badge">ENCRYPTED</span>
                            </div>

                            <div class="quick-links-stack">
                                <a href="{{ route('account.index', ['tab' => 'setting']) }}" class="quick-link-row">
                                    <div class="quick-link-left">
                                        <div class="quick-link-icon">
                                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" radius="2" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                                        </div>
                                        <div>
                                            <div class="quick-link-title">Account Password</div>
                                            <div class="quick-link-sub">Last updated recently</div>
                                        </div>
                                    </div>
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#94a3b8" stroke-width="2"><polyline points="9 18 15 12 9 6"></polyline></svg>
                                </a>

                                <a href="{{ route('account.index', ['tab' => 'addresses']) }}" class="quick-link-row">
                                    <div class="quick-link-left">
                                        <div class="quick-link-icon">
                                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                                        </div>
                                        <div>
                                            <div class="quick-link-title">Saved Shipping Address</div>
                                            <div class="quick-link-sub">{{ $user->city ? $user->city . ', ' . ($user->country ?: 'US') : 'Manage 1-click delivery address' }}</div>
                                        </div>
                                    </div>
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#94a3b8" stroke-width="2"><polyline points="9 18 15 12 9 6"></polyline></svg>
                                </a>
                            </div>
                        </div>

                    </div>

                </div>

            @elseif ($tab == 'orders')
                <!-- 2. MY ORDERS TAB -->
                <div class="tab-header-banner">
                    <div class="tab-header-left">
                        <div class="tab-header-icon-wrap">
                            <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path>
                                <line x1="3" y1="6" x2="21" y2="6"></line>
                                <path d="M16 10a4 4 0 0 1-8 0"></path>
                            </svg>
                        </div>
                        <div>
                            <h2 class="tab-title">My Orders</h2>
                            <p class="tab-subtitle">Track, view invoices, and manage past drop orders.</p>
                        </div>
                    </div>
                </div>

                @if ($orders->count() > 0)
                    @foreach ($orders as $order)
                        @php
                            $stLower = strtolower(trim($order->status));
                            $badgeClass = 'status-processing';
                            if (in_array($stLower, ['cancelled', 'cancel', 'canceled'])) {
                                $badgeClass = 'status-cancelled';
                            } elseif (in_array($stLower, ['delivered', 'completed'])) {
                                $badgeClass = 'status-delivered';
                            } elseif (in_array($stLower, ['shipped'])) {
                                $badgeClass = 'status-shipped';
                            } elseif (in_array($stLower, ['pending'])) {
                                $badgeClass = 'status-pending';
                            }
                        @endphp
                        <div class="order-row-item">
                            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px; flex-wrap: wrap; gap: 8px;">
                                <div>
                                    <span style="font-weight: 850; color: #0f172a; font-size: 0.96rem;">Order #{{ $order->order_number }}</span>
                                    <span style="color: var(--text-muted); font-size: 0.85rem; margin-left: 10px;">{{ $order->created_at->format('M d, Y') }}</span>
                                </div>
                                <div style="display:flex; align-items:center; gap: 12px;">
                                    <span class="order-status-tag {{ $badgeClass }}" style="padding: 4px 11px; font-size: 0.78rem;">
                                        <span class="status-pulse-dot"></span>
                                        <span>{{ $order->status }}</span>
                                    </span>
                                    <span style="font-weight: 900; color: #0f172a; font-size: 1.05rem;">${{ number_format($order->total, 2) }}</span>
                                </div>
                            </div>

                            <div style="font-size: 0.88rem; color: #475569; margin-bottom: 12px;">
                                Tracking Code: <code style="color: #2563eb; font-weight:750; background:#eff6ff; padding:2px 7px; border-radius:4px; border:1px solid #bfdbfe;">{{ $order->tracking_code }}</code> &bull; Items: {{ $order->items->count() }}
                            </div>

                            <div style="display:flex; gap: 10px;">
                                <a href="{{ route('order.track', ['code' => $order->tracking_code]) }}" class="btn-primary" style="padding: 6px 14px; font-size: 0.82rem;">
                                    Track Order Live
                                </a>
                                <a href="{{ route('order.confirmation', $order->order_number) }}" class="btn-outline" style="padding: 6px 14px; font-size: 0.82rem;">
                                    View Invoice
                                </a>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="empty-tab-state">
                        <div class="empty-state-icon-orbit" style="background: rgba(99, 102, 241, 0.12); border-color: rgba(99, 102, 241, 0.35); color: #818cf8;">
                            <svg width="34" height="34" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path>
                                <line x1="3" y1="6" x2="21" y2="6"></line>
                                <path d="M16 10a4 4 0 0 1-8 0"></path>
                            </svg>
                        </div>
                        <h4 class="empty-state-title">No orders placed yet</h4>
                        <p class="empty-state-desc">Browse our seasonal drops and pick your first essential heavyweight tee.</p>
                        <a href="{{ route('shop.index') }}" class="btn-primary" style="padding: 11px 26px;">Browse Catalog →</a>
                    </div>
                @endif

            @elseif ($tab == 'wishlist')
                <!-- 3. WISHLIST TAB -->
                <div class="tab-header-banner">
                    <div class="tab-header-left">
                        <div class="tab-header-icon-wrap pink">
                            <svg viewBox="0 0 24 24" fill="currentColor" stroke="none">
                                <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
                            </svg>
                        </div>
                        <div>
                            <h2 class="tab-title">Saved Wishlist</h2>
                            <p class="tab-subtitle">Your curated favorites ready to add to your bag whenever you want.</p>
                        </div>
                    </div>
                    @if ($wishlistProducts->count() > 0)
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <span class="wishlist-counter-pill">
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="currentColor" stroke="none">
                                    <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
                                </svg>
                                <span>{{ $wishlistProducts->count() }} {{ $wishlistProducts->count() === 1 ? 'SAVED ITEM' : 'SAVED ITEMS' }}</span>
                            </span>
                            <a href="{{ route('shop.index') }}" class="btn-outline" style="padding: 7px 16px; font-size: 0.8rem; border-radius: 9999px; text-decoration: none; display: inline-flex; align-items: center; gap: 6px;">
                                <span>Explore Catalog</span> →
                            </a>
                        </div>
                    @endif
                </div>

                @if ($wishlistProducts->count() > 0)
                    <div class="wishlist-grid">
                        @foreach ($wishlistProducts as $product)
                            <div class="wishlist-item-card">
                                <div class="wishlist-media">
                                    <a href="{{ route('product.detail', $product->id) }}" class="wishlist-media-link">
                                        <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" onerror="this.src='https://placehold.co/400x400/f1f5f9/0f172a?text={{ urlencode($product->name) }}'">
                                    </a>

                                    {{-- Floating Discount or Category Tag --}}
                                    @if ($product->original_price && $product->original_price > $product->price)
                                        @php $discount = round((($product->original_price - $product->price) / $product->original_price) * 100); @endphp
                                        <span class="wishlist-float-badge discount">-{{ $discount }}% OFF</span>
                                    @else
                                        <span class="wishlist-float-badge category">{{ strtoupper($product->category ?? 'COLLECTION') }}</span>
                                    @endif

                                    {{-- Floating Remove Button on Top Right --}}
                                    <form action="{{ route('wishlist.toggle', $product->id) }}" method="POST" class="wishlist-float-remove-form">
                                        @csrf
                                        <button type="submit" class="wishlist-float-remove-btn" title="Remove from Wishlist">
                                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                                <line x1="18" y1="6" x2="6" y2="18"></line>
                                                <line x1="6" y1="6" x2="18" y2="18"></line>
                                            </svg>
                                        </button>
                                    </form>
                                </div>

                                <div class="wishlist-body">
                                    <div>
                                        <div class="wishlist-cat-row">
                                            <span class="wishlist-cat-label">{{ strtoupper($product->category ?? 'STREETWEAR') }}</span>
                                            @if ($product->in_stock && $product->stock > 0)
                                                <span class="wishlist-stock-tag in-stock">
                                                    <span class="stock-pulse-dot"></span> In Stock
                                                </span>
                                            @else
                                                <span class="wishlist-stock-tag out-of-stock">Sold Out</span>
                                            @endif
                                        </div>

                                        <a href="{{ route('product.detail', $product->id) }}" class="wishlist-item-title-link">
                                            <h4 class="wishlist-item-title">{{ ucwords($product->name) }}</h4>
                                        </a>

                                        <div class="wishlist-rating-row">
                                            <div class="rating-stars-inline">
                                                <span class="stars-gold">★★★★★</span>
                                                <span class="rating-val">{{ number_format($product->rating ?? 4.9, 1) }}</span>
                                            </div>
                                            <span class="rating-reviews-count">({{ $product->review_count ?? 128 }} reviews)</span>
                                        </div>

                                        <div class="wishlist-price-block">
                                            <div class="price-main-wrap">
                                                <span class="wishlist-price">${{ number_format($product->price, 2) }}</span>
                                                @if ($product->original_price && $product->original_price > $product->price)
                                                    <span class="wishlist-original-price">${{ number_format($product->original_price, 2) }}</span>
                                                @endif
                                            </div>
                                            @if ($product->original_price && $product->original_price > $product->price)
                                                <span class="wishlist-savings-pill">Save ${{ number_format($product->original_price - $product->price, 2) }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="wishlist-actions-wrap">
                                        <form action="{{ route('cart.add', $product->id) }}" method="POST" style="width: 100%;">
                                            @csrf
                                            <input type="hidden" name="size" value="L">
                                            <button type="submit" class="btn-wishlist-cart-full" {{ (!$product->in_stock || $product->stock <= 0) ? 'disabled' : '' }}>
                                                <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                                    <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path>
                                                    <line x1="3" y1="6" x2="21" y2="6"></line>
                                                    <path d="M16 10a4 4 0 0 1-8 0"></path>
                                                </svg>
                                                <span>Add to Bag — ${{ number_format($product->price, 2) }}</span>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <!-- Ultra Luxury Empty State -->
                    <div class="empty-tab-state">
                        <div class="empty-state-glow"></div>
                        <div class="empty-state-icon-orbit">
                            <svg width="34" height="34" viewBox="0 0 24 24" fill="currentColor" stroke="none">
                                <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
                            </svg>
                        </div>
                        <span class="empty-state-badge">WISHLIST VAULT</span>
                        <h3 class="empty-state-title">Your wishlist is empty</h3>
                        <p class="empty-state-desc">
                            Click the heart icon on any t-shirt, sneaker, or accessory across the store to curate your private wardrobe drops here.
                        </p>
                        <a href="{{ route('shop.index') }}" class="btn-primary" style="padding: 12px 28px; font-size: 0.92rem;">
                            <span>Explore Catalog Drops →</span>
                        </a>
                    </div>
                @endif

                <!-- Recommended Trending Streetwear Drops (Always visible to keep layout rich & inspiring) -->
                @if (isset($recommendedProducts) && count($recommendedProducts) > 0)
                    <div class="wishlist-recs-wrap">
                        <div class="recs-header">
                            <div>
                                <span class="recs-sparkle-badge">🔥 TRENDING PICKS</span>
                                <h3 class="recs-heading">Recommended Streetwear Drops</h3>
                                <p class="recs-subheading">Complete your fit with heavyweight graphic tees and luxury accessories.</p>
                            </div>
                            <a href="{{ route('shop.index') }}" class="btn-recs-viewall">Explore Catalog →</a>
                        </div>

                        <div class="recs-grid">
                            @foreach ($recommendedProducts as $rec)
                                <div class="rec-card">
                                    <div class="rec-media">
                                        <a href="{{ route('product.detail', $rec->id) }}">
                                            <img src="{{ asset($rec->image) }}" alt="{{ $rec->name }}" onerror="this.src='https://placehold.co/300x300/f1f5f9/0f172a?text={{ urlencode($rec->name) }}'">
                                        </a>

                                        {{-- Quick Add/Remove Wishlist Float Button --}}
                                        <form action="{{ route('wishlist.toggle', $rec->id) }}" method="POST" style="margin: 0;">
                                            @csrf
                                            <button type="submit" class="rec-float-wishlist-btn" title="Add to Wishlist">
                                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                                    <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>

                                    <div class="rec-body">
                                        <div>
                                            <span class="rec-cat">{{ strtoupper($rec->category ?? 'STREETWEAR') }}</span>
                                            <a href="{{ route('product.detail', $rec->id) }}" style="text-decoration:none;">
                                                <h5 class="rec-title">{{ ucwords($rec->name) }}</h5>
                                            </a>
                                            <div class="rec-price-row">
                                                <span class="rec-price">${{ number_format($rec->price, 2) }}</span>
                                                @if ($rec->original_price && $rec->original_price > $rec->price)
                                                    <span class="rec-original-price">${{ number_format($rec->original_price, 2) }}</span>
                                                @endif
                                            </div>
                                        </div>

                                        <form action="{{ route('cart.add', $rec->id) }}" method="POST" style="margin-top:auto;">
                                            @csrf
                                            <input type="hidden" name="size" value="L">
                                            <button type="submit" class="btn-rec-action">
                                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2">
                                                    <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path>
                                                    <line x1="3" y1="6" x2="21" y2="6"></line>
                                                    <path d="M16 10a4 4 0 0 1-8 0"></path>
                                                </svg>
                                                <span>+ Add to Bag</span>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

            @elseif ($tab == 'addresses')
                <!-- 4. ADDRESSES TAB -->
                <div class="tab-header-banner">
                    <div class="tab-header-left">
                        <div class="tab-header-icon-wrap">
                            <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                                <circle cx="12" cy="10" r="3"></circle>
                            </svg>
                        </div>
                        <div>
                            <h2 class="tab-title">Saved Shipping Addresses</h2>
                            <p class="tab-subtitle">Manage delivery locations for faster 1-click express checkout.</p>
                        </div>
                    </div>
                </div>

                <!-- Saved Address Card Display -->
                <div id="addressDisplayCard" style="background:#ffffff; border:1px solid #e2e8f0; border-radius:var(--radius-md); padding:24px; max-width:540px; margin-bottom:24px; box-shadow:0 2px 10px rgba(15,23,42,0.03);">
                    <div style="display:flex; justify-content:space-between; margin-bottom:14px;">
                        <div style="display:flex; align-items:center; gap:8px;">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#2563eb" stroke-width="2.2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                            <strong style="color:#0f172a; font-weight:800;">Default Shipping Destination</strong>
                        </div>
                        <span style="color:#047857; font-size:0.72rem; font-weight:800; background:#ecfdf5; border:1px solid #a7f3d0; padding:2px 8px; border-radius:9999px;">PRIMARY</span>
                    </div>
                    <div style="color:#334155; font-size:0.92rem; line-height:1.6; margin-bottom:18px;">
                        <div style="font-weight:800; color:#0f172a; font-size:1.05rem; margin-bottom:4px;">{{ $user->name }}</div>
                        <div>{{ $user->address ?: '742 Evergreen Blvd, Apt 4B' }}</div>
                        <div>{{ $user->city ?: 'Los Angeles' }}{{ $user->postal_code ? ', ' . $user->postal_code : ', CA 90014' }}</div>
                        <div>{{ $user->country ?: 'United States' }}</div>
                        @if ($user->phone)
                            <div style="margin-top:6px; color:#64748b; font-size:0.85rem; display:flex; align-items:center; gap:6px;">
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
                                <span>{{ $user->phone }}</span>
                            </div>
                        @endif
                    </div>
                    <div>
                        <button type="button" class="btn-outline" style="padding:8px 18px; font-size:0.85rem; font-weight:700; display:inline-flex; align-items:center; gap:6px; border:1px solid #cbd5e1; background:#ffffff; color:#0f172a;" onclick="toggleEditAddress(true)">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                            <span>Edit Address</span>
                        </button>
                    </div>
                </div>

                <!-- Interactive Edit Address Form -->
                <div id="addressEditCard" style="display:none; background:#ffffff; border:1px solid #cbd5e1; border-radius:var(--radius-md); padding:28px; max-width:540px; margin-bottom:24px; box-shadow:0 4px 20px rgba(15,23,42,0.06);">
                    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:18px;">
                        <h3 style="font-size:1.15rem; font-weight:800; color:#0f172a; display:flex; align-items:center; gap:8px;">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#2563eb" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                            <span>Edit Shipping Address</span>
                        </h3>
                        <button type="button" onclick="toggleEditAddress(false)" style="background:none; border:none; color:var(--text-muted); font-size:1.1rem; cursor:pointer;">✕</button>
                    </div>

                    <form action="{{ route('account.address') }}" method="POST">
                        @csrf

                        <div class="form-group">
                            <label class="form-label">Street Address *</label>
                            <input type="text" name="address" class="form-control" value="{{ old('address', $user->address ?: '742 Evergreen Blvd, Apt 4B') }}" required placeholder="e.g. 742 Evergreen Blvd, Apt 4B">
                        </div>

                        <div class="grid-2-cols" style="margin-bottom:16px;">
                            <div class="form-group" style="margin-bottom:0;">
                                <label class="form-label">City *</label>
                                <input type="text" name="city" class="form-control" value="{{ old('city', $user->city ?: 'Los Angeles') }}" required placeholder="e.g. Los Angeles">
                            </div>

                            <div class="form-group" style="margin-bottom:0;">
                                <label class="form-label">Postal / ZIP Code</label>
                                <input type="text" name="postal_code" class="form-control" value="{{ old('postal_code', $user->postal_code ?: '90014') }}" placeholder="e.g. 90014">
                            </div>
                        </div>

                        <div class="grid-2-cols" style="margin-bottom:22px;">
                            <div class="form-group" style="margin-bottom:0;">
                                <label class="form-label">Country</label>
                                <input type="text" name="country" class="form-control" value="{{ old('country', $user->country ?: 'United States') }}" placeholder="United States">
                            </div>

                            <div class="form-group" style="margin-bottom:0;">
                                <label class="form-label">Contact Phone</label>
                                <input type="text" name="phone" class="form-control" value="{{ old('phone', $user->phone ?: '+1 (800) 555-TEES') }}" placeholder="+1 (555) 000-0000">
                            </div>
                        </div>

                        <div style="display:flex; gap:12px; justify-content:flex-end;">
                            <button type="button" class="btn-outline" onclick="toggleEditAddress(false)">Cancel</button>
                            <button type="submit" class="btn-primary" style="padding:10px 22px;">Save Shipping Address →</button>
                        </div>
                    </form>
                </div>

                <script>
                    function toggleEditAddress(show) {
                        const displayCard = document.getElementById('addressDisplayCard');
                        const editCard = document.getElementById('addressEditCard');
                        if (!displayCard || !editCard) return;
                        if (show) {
                            displayCard.style.display = 'none';
                            editCard.style.display = 'block';
                            const input = editCard.querySelector('input[name="address"]');
                            if (input) input.focus();
                        } else {
                            displayCard.style.display = 'block';
                            editCard.style.display = 'none';
                        }
                    }

                    if (window.location.search.includes('edit=1') || window.location.hash === '#edit') {
                        setTimeout(function() {
                            toggleEditAddress(true);
                        }, 50);
                    }
                </script>

            @elseif ($tab == 'setting')
                <!-- 5. SETTING TAB -->
                <div class="tab-header-banner">
                    <div class="tab-header-left">
                        <div class="tab-header-icon-wrap">
                            <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="3"></circle>
                                <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path>
                            </svg>
                        </div>
                        <div>
                            <h2 class="tab-title">Settings & Order Tracking</h2>
                            <p class="tab-subtitle">Manage your account security credentials and look up real-time shipment dispatch details.</p>
                        </div>
                    </div>
                </div>

                <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(360px, 1fr)); gap: 20px; align-items: start;">
                    <!-- 1. Track Order Section Card -->
                    <div style="background:#ffffff; border:1px solid #e2e8f0; border-radius:var(--radius-md); padding:24px; box-shadow:0 2px 10px rgba(15,23,42,0.03);">
                        <div style="display:flex; align-items:center; gap:10px; margin-bottom:14px; padding-bottom:12px; border-bottom:1px solid #e2e8f0;">
                            <div style="width:34px; height:34px; border-radius:10px; background:#eff6ff; border:1px solid #bfdbfe; display:flex; align-items:center; justify-content:center; color:#2563eb;">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="1" y="3" width="15" height="13"></rect><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon><circle cx="5.5" cy="18.5" r="2.5"></circle><circle cx="18.5" cy="18.5" r="2.5"></circle></svg>
                            </div>
                            <div>
                                <h3 style="font-size:1.1rem; font-weight:850; color:#0f172a; margin:0;">Track Order & Shipment</h3>
                                <p style="font-size:0.80rem; color:#64748b; margin-top:2px; margin-bottom:0;">Live tracking via order code or tracking number</p>
                            </div>
                        </div>

                        <p style="font-size:0.86rem; color:#475569; line-height:1.55; margin-bottom:16px;">
                            Enter any order number (e.g. <strong style="color:#2563eb;">TC-0007</strong>) or courier tracking code to monitor live status and arrival updates.
                        </p>

                        <form action="{{ route('order.track') }}" method="GET" style="margin-bottom:18px;">
                            <div class="input-with-icon-wrap" style="position:relative; margin-bottom:12px;">
                                <span class="input-lead-icon" style="position:absolute; left:14px; top:50%; transform:translateY(-50%); color:#64748b;">
                                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                                </span>
                                <input type="text" name="code" class="form-control with-icon" placeholder="e.g. TC-0007 or Tracking Code" required style="padding-left:42px; font-weight:600; font-size:0.9rem;">
                            </div>
                            <div style="display:flex; gap:10px; align-items:center;">
                                <button type="submit" class="btn-primary" style="padding:10px 22px; font-size:0.86rem; font-weight:750;">
                                    <span>Track Shipment</span>
                                    <span>→</span>
                                </button>
                                <a href="{{ route('order.track') }}" class="btn-outline" style="padding:10px 18px; font-size:0.86rem; font-weight:650; border:1px solid #cbd5e1; background:#ffffff; color:#0f172a;">
                                    <span>Full Tracker Page</span>
                                </a>
                            </div>
                        </form>

                        @if ($orders->isNotEmpty())
                            <div style="padding-top:14px; border-top:1px solid #e2e8f0;">
                                <span style="font-size:0.72rem; text-transform:uppercase; letter-spacing:0.6px; color:#475569; font-weight:800; display:block; margin-bottom:8px;">Your Recent Drops:</span>
                                <div style="display:flex; flex-direction:column; gap:6px;">
                                    @foreach ($orders->take(3) as $recentOrd)
                                        <div style="display:flex; align-items:center; justify-content:space-between; background:#f8fafc; border:1px solid #e2e8f0; border-radius:8px; padding:8px 12px;">
                                            <div style="display:flex; align-items:center; gap:8px;">
                                                <span style="font-weight:800; color:#0f172a; font-size:0.84rem;">#{{ $recentOrd->order_number }}</span>
                                                <span style="font-size:0.72rem; color:#64748b;">{{ $recentOrd->created_at->format('M d') }}</span>
                                            </div>
                                            <a href="{{ route('order.track', ['code' => $recentOrd->order_number]) }}" style="font-size:0.75rem; font-weight:750; color:#ffffff; display:inline-flex; align-items:center; gap:4px; text-decoration:none; padding:4px 10px; border-radius:var(--radius-full); background:#0f172a;">
                                                <span>Track</span>
                                                <span>→</span>
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- 2. Security & Password Update Card -->
                    <div style="background:#ffffff; border:1px solid #e2e8f0; border-radius:var(--radius-md); padding:24px; box-shadow:0 2px 10px rgba(15,23,42,0.03);">
                        <div style="display:flex; align-items:center; gap:10px; margin-bottom:14px; padding-bottom:12px; border-bottom:1px solid #e2e8f0;">
                            <div style="width:34px; height:34px; border-radius:10px; background:#ecfdf5; border:1px solid #a7f3d0; display:flex; align-items:center; justify-content:center; color:#047857;">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                            </div>
                            <div>
                                <h3 style="font-size:1.1rem; font-weight:850; color:#0f172a; margin:0;">Account Security Credentials</h3>
                                <p style="font-size:0.80rem; color:#64748b; margin-top:2px; margin-bottom:0;">Update and protect your login password</p>
                            </div>
                        </div>

                        <form action="{{ route('account.password') }}" method="POST">
                            @csrf
                            <div class="form-group" style="margin-bottom:13px;">
                                <label class="form-label">Current Password</label>
                                <input type="password" name="current_password" class="form-control" required placeholder="Enter your current password">
                            </div>

                            <div class="form-group" style="margin-bottom:13px;">
                                <label class="form-label">New Password</label>
                                <input type="password" name="new_password" class="form-control" required placeholder="Minimum 8 characters">
                            </div>

                            <div class="form-group" style="margin-bottom:16px;">
                                <label class="form-label">Confirm New Password</label>
                                <input type="password" name="new_password_confirmation" class="form-control" required placeholder="Repeat new password">
                            </div>

                            <button type="submit" class="btn-primary" style="padding:10px 24px; font-size:0.86rem; font-weight:750;">
                                Update Security Password →
                            </button>
                        </form>
                    </div>
                </div>
            @endif

        </main>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const logoutBtn = document.getElementById('accountSidebarLogoutBtn');
    const logoutForm = document.getElementById('accountSidebarLogoutForm');
    
    if (logoutBtn && logoutForm) {
        logoutBtn.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            if (typeof window.openCoolConfirm === 'function') {
                window.openCoolConfirm({
                    title: 'Log Out of Your Account?',
                    message: 'Are you sure you want to end your current session? You will need to log back in to access your profile, saved wishlist, and order history.',
                    type: 'logout',
                    icon: 'logout',
                    badge: 'SESSION SECURITY',
                    confirmText: 'Yes, Log Out',
                    cancelText: 'Stay Logged In',
                    onConfirm: function() {
                        logoutForm.submit();
                    }
                });
            } else {
                logoutForm.submit();
            }
        });
    }
});

// Toast notification helper
function showAvatarToast(message, isSuccess = true) {
    let toast = document.getElementById('avatarToast');
    if (!toast) {
        toast = document.createElement('div');
        toast.id = 'avatarToast';
        toast.className = 'avatar-toast';
        document.body.appendChild(toast);
    }
    toast.innerHTML = (isSuccess ? '<span style="color:#10b981; font-size:1.1rem;">✓</span>' : '<span style="color:#f87171; font-size:1.1rem;">✕</span>') + ' <span>' + message + '</span>';
    toast.classList.add('show');
    setTimeout(() => {
        toast.classList.remove('show');
    }, 3500);
}

// Interactive Live Avatar Preview & Direct AJAX Upload
function handleAvatarSelected(event) {
    const file = event.target.files[0];
    if (!file) return;

    if (file.size > 5 * 1024 * 1024) {
        showAvatarToast('File is too large. Maximum size is 5MB.', false);
        return;
    }

    // 1. Live Client-Side Preview across all page avatars
    const reader = new FileReader();
    reader.onload = function(e) {
        const dataUrl = e.target.result;

        // Preview in Form Preview Circle
        const formPreview = document.getElementById('formAvatarPreview');
        if (formPreview) {
            formPreview.innerHTML = '<img src="' + dataUrl + '" alt="Preview" style="width:100%; height:100%; object-fit:cover; border-radius:50%;">';
        }

        // Preview in Hero Banner Avatar
        const heroInner = document.getElementById('heroAvatarInner');
        if (heroInner) {
            heroInner.innerHTML = '<img src="' + dataUrl + '" alt="Preview" class="avatar-img-round">';
        }

        // Preview in Sidebar Avatar
        const sidebarAvatar = document.getElementById('sidebarAvatarContainer');
        if (sidebarAvatar) {
            sidebarAvatar.innerHTML = '<img src="' + dataUrl + '" alt="Preview" style="width:100%; height:100%; border-radius:50%; object-fit:cover;">';
        }

        // Preview in Top Navbar Avatar & Dropdown
        document.querySelectorAll('.user-avatar').forEach(avatarEl => {
            avatarEl.innerHTML = '<img src="' + dataUrl + '" alt="Avatar" style="width:100%; height:100%; border-radius:50%; object-fit:cover;">';
        });
    };
    reader.readAsDataURL(file);

    // 2. Direct Instant AJAX Upload for seamless luxury experience
    const formData = new FormData();
    formData.append('avatar', file);
    formData.append('_token', '{{ csrf_token() }}');

    showAvatarToast('Uploading profile photo...', true);

    fetch('{{ route('account.avatar') }}', {
        method: 'POST',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            if (data.avatar_url) {
                document.querySelectorAll('.user-avatar').forEach(avatarEl => {
                    avatarEl.innerHTML = '<img src="' + data.avatar_url + '" alt="Avatar" style="width:100%; height:100%; border-radius:50%; object-fit:cover;">';
                });
            }
            showAvatarToast('Profile photo updated successfully! ✓', true);
        } else {
            showAvatarToast(data.message || 'Error updating photo', false);
        }
    })
    .catch(err => {
        console.warn('AJAX upload background fallback, photo is staged for form save.', err);
        showAvatarToast('Photo selected! Click "Save Profile Changes" to persist.', true);
    });
}

function removeAvatarPhoto() {
    if (typeof window.openCoolConfirm === 'function') {
        window.openCoolConfirm({
            title: 'Remove Profile Photo?',
            message: 'Are you sure you want to remove your profile photo? Your account will revert to your default initials avatar badge.',
            item: '📷 Current Avatar Photo',
            badge: 'AVATAR REMOVAL',
            type: 'danger',
            icon: 'danger',
            confirmText: 'Yes, Remove Photo',
            cancelText: 'Keep My Photo',
            onConfirm: function() {
                const removeInput = document.getElementById('removeAvatarInput');
                if (removeInput) {
                    removeInput.value = '1';
                }
                const profileForm = document.getElementById('profileForm');
                if (profileForm) {
                    profileForm.submit();
                }
            }
        });
    } else {
        const removeInput = document.getElementById('removeAvatarInput');
        if (removeInput) {
            removeInput.value = '1';
        }
        const profileForm = document.getElementById('profileForm');
        if (profileForm) {
            profileForm.submit();
        }
    }
}
</script>
@endsection
