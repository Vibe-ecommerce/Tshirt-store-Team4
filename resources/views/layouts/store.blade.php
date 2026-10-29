<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'T-Shirt Online — Premium T-Shirt Store')</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --bg-primary: #ffffff;
            --bg-secondary: #f8fafc;
            --bg-card: #ffffff;
            --bg-card-hover: #ffffff;
            --accent-primary: #0f172a;
            --accent-gradient: linear-gradient(135deg, #0f172a 0%, #334155 100%);
            --accent-glow: rgba(15, 23, 42, 0.08);
            --text-main: #0f172a;
            --text-muted: #64748b;
            --text-sub: #334155;
            --border-subtle: #e2e8f0;
            --border-highlight: #cbd5e1;
            --radius-sm: 8px;
            --radius-md: 14px;
            --radius-lg: 22px;
            --radius-full: 9999px;
            --shadow-card: 0 4px 20px -2px rgba(0, 0, 0, 0.06), 0 2px 6px -1px rgba(0, 0, 0, 0.03);
            --shadow-hover: 0 16px 32px -4px rgba(0, 0, 0, 0.08), 0 6px 12px -2px rgba(0, 0, 0, 0.04);
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, sans-serif;
        }

        body {
            background-color: var(--bg-primary);
            color: var(--text-main);
            min-height: 100vh;
            line-height: 1.6;
            display: flex;
            flex-direction: column;
            overflow-x: hidden;
        }

        a {
            color: inherit;
            text-decoration: none;
        }

        /* -------------------------------------------------------------
           PREMIUM TOP ANNOUNCEMENT BAR
        ------------------------------------------------------------- */
        .top-banner {
            background: #0f172a;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
            color: #f8fafc;
            font-size: 0.82rem;
            font-weight: 500;
            letter-spacing: 0.35px;
            padding: 8px 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            z-index: 101;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .top-banner-content {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
            justify-content: center;
        }

        .top-banner-badge {
            background: rgba(245, 158, 11, 0.2);
            border: 1px solid rgba(245, 158, 11, 0.4);
            color: #fbbf24;
            padding: 2px 9px;
            border-radius: var(--radius-full);
            font-size: 0.68rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            box-shadow: 0 0 10px rgba(245, 158, 11, 0.2);
        }

        /* -------------------------------------------------------------
           PREMIUM LUXURY NAVBAR
        ------------------------------------------------------------- */
        .navbar {
            position: sticky;
            top: 0;
            z-index: 100;
            backdrop-filter: blur(24px) saturate(180%);
            -webkit-backdrop-filter: blur(24px) saturate(180%);
            background: rgba(255, 255, 255, 0.95);
            border-bottom: 1px solid #e2e8f0;
            padding: 0 28px;
            height: 72px;
            display: flex;
            align-items: center;
            transition: all 0.3s ease;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.03);
        }

        .nav-container {
            max-width: 1320px;
            width: 100%;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
        }

        /* Brand Logo */
        .brand-logo {
            display: flex;
            align-items: center;
            gap: 12px;
            color: #ffffff;
            flex-shrink: 0;
            text-decoration: none;
            transition: transform 0.2s ease;
        }

        .brand-logo:hover {
            transform: translateY(-1px);
        }

        .brand-icon-wrap {
            width: 40px;
            height: 40px;
            border-radius: 12px;
            background: linear-gradient(135deg, #3b82f6 0%, #6366f1 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #ffffff;
            box-shadow: 0 4px 18px rgba(59, 130, 246, 0.4), inset 0 1px 1px rgba(255, 255, 255, 0.4);
            position: relative;
            flex-shrink: 0;
        }

        .brand-text {
            font-weight: 850;
            color: #0f172a;
            font-size: 1.28rem;
            letter-spacing: -0.4px;
            display: inline-flex;
            align-items: center;
        }

        .brand-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: #2563eb;
            display: inline-block;
            margin-left: 3px;
            box-shadow: 0 0 8px rgba(37, 99, 235, 0.5);
        }

        /* Navigation Links */
        .nav-links {
            display: flex;
            align-items: center;
            gap: 6px;
            list-style: none;
            margin: 0;
            padding: 0;
        }

        .nav-link {
            color: #475569;
            font-size: 0.9rem;
            font-weight: 600;
            padding: 8px 16px;
            border-radius: var(--radius-full);
            transition: all 0.2s ease;
            position: relative;
            display: inline-flex;
            align-items: center;
            text-decoration: none;
        }

        .nav-link:hover {
            color: #0f172a;
            background: #f1f5f9;
        }

        .nav-link.active {
            color: #0f172a;
            background: #f1f5f9;
            border: 1px solid #e2e8f0;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
            font-weight: 700;
        }

        /* Nav Actions */
        .nav-actions {
            display: flex;
            align-items: center;
            gap: 12px;
            flex-shrink: 0;
        }

        /* Search Container & Input Bar */
        .nav-search-container {
            position: relative;
        }

        .nav-search-wrap {
            position: relative;
            display: flex;
            align-items: center;
        }

        .nav-search-submit-btn {
            position: absolute;
            left: 6px;
            background: none;
            border: none;
            color: #94a3b8;
            cursor: pointer;
            padding: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: var(--radius-full);
            transition: color 0.2s, transform 0.2s;
            z-index: 2;
        }

        .nav-search-submit-btn:hover {
            color: #818cf8;
            transform: scale(1.1);
        }

        .nav-search-input {
            background: #f1f5f9;
            border: 1px solid #e2e8f0;
            color: #0f172a;
            padding: 8px 32px 8px 36px;
            border-radius: var(--radius-full);
            font-size: 0.84rem;
            outline: none;
            width: 195px;
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .nav-search-input::placeholder {
            color: #94a3b8;
        }

        .nav-search-input:hover {
            background: #e2e8f0;
            border-color: #cbd5e1;
        }

        .nav-search-input:focus,
        .nav-search-container.is-active .nav-search-input {
            width: 275px;
            background: #ffffff;
            border-color: #0f172a;
            box-shadow: 0 0 0 3px rgba(15, 23, 42, 0.08), 0 8px 24px rgba(0, 0, 0, 0.06);
        }

        .nav-search-wrap:focus-within .nav-search-submit-btn {
            color: #818cf8;
        }

        .nav-search-clear-btn {
            position: absolute;
            right: 10px;
            background: rgba(255, 255, 255, 0.1);
            border: none;
            color: #94a3b8;
            cursor: pointer;
            width: 18px;
            height: 18px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 11px;
            line-height: 1;
            transition: all 0.2s;
            z-index: 2;
        }

        .nav-search-clear-btn:hover {
            background: rgba(239, 68, 68, 0.25);
            color: #f87171;
            transform: scale(1.15);
        }

        /* Instant Search Dropdown */
        .nav-search-dropdown {
            position: absolute;
            top: calc(100% + 10px);
            right: 0;
            width: 370px;
            max-width: 90vw;
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 18px;
            box-shadow: 0 20px 45px rgba(0, 0, 0, 0.12), 0 0 0 1px rgba(0, 0, 0, 0.04);
            overflow: hidden;
            z-index: 99999;
            animation: searchFadeIn 0.2s cubic-bezier(0.16, 1, 0.3, 1);
        }

        @keyframes searchFadeIn {
            from { opacity: 0; transform: translateY(-8px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .search-results-header {
            padding: 12px 16px 8px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid #f1f5f9;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            color: #64748b;
            font-weight: 700;
        }

        .search-results-list {
            list-style: none;
            padding: 6px 0;
            margin: 0;
            max-height: 350px;
            overflow-y: auto;
        }

        .search-result-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 16px;
            text-decoration: none;
            color: inherit;
            transition: background 0.15s ease;
            border-left: 3px solid transparent;
        }

        .search-result-item:hover,
        .search-result-item.selected {
            background: #f8fafc;
            border-left-color: #0f172a;
        }

        .search-result-img {
            width: 44px;
            height: 44px;
            border-radius: 10px;
            object-fit: cover;
            background: #f1f5f9;
            border: 1px solid #e2e8f0;
            flex-shrink: 0;
        }

        .search-result-info {
            flex: 1;
            min-width: 0;
        }

        .search-result-name {
            font-size: 0.88rem;
            font-weight: 600;
            color: #0f172a;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            line-height: 1.3;
        }

        .search-result-name mark {
            background: #fef08a;
            color: #854d0e;
            border-radius: 3px;
            padding: 0 2px;
        }

        .search-result-meta {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-top: 3px;
            font-size: 0.78rem;
        }

        .search-result-cat {
            color: #2563eb;
            font-weight: 600;
        }

        .search-result-price {
            color: #0f172a;
            font-weight: 700;
        }

        .search-result-oldprice {
            color: #94a3b8;
            text-decoration: line-through;
            font-size: 0.75rem;
        }

        .search-result-stockout {
            color: #ef4444;
            font-size: 0.72rem;
            font-weight: 700;
            text-transform: uppercase;
        }

        .search-results-footer {
            padding: 10px 16px;
            background: #f8fafc;
            border-top: 1px solid #e2e8f0;
            text-align: center;
        }

        .search-view-all-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            width: 100%;
            padding: 9px 14px;
            background: linear-gradient(135deg, rgba(99, 102, 241, 0.25) 0%, rgba(236, 72, 153, 0.25) 100%);
            border: 1px solid rgba(99, 102, 241, 0.4);
            border-radius: 10px;
            color: #ffffff;
            font-size: 0.84rem;
            font-weight: 700;
            text-decoration: none;
            transition: all 0.2s ease;
        }

        .search-view-all-btn:hover {
            background: linear-gradient(135deg, #6366f1 0%, #ec4899 100%);
            border-color: transparent;
            box-shadow: 0 4px 14px rgba(99, 102, 241, 0.4);
            transform: translateY(-1px);
        }

        .search-empty-state {
            padding: 26px 18px;
            text-align: center;
        }

        .search-empty-state .icon {
            font-size: 1.8rem;
            margin-bottom: 6px;
        }

        .search-empty-state .msg {
            color: #94a3b8;
            font-size: 0.85rem;
            margin-bottom: 12px;
        }

        .search-quick-tags {
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
            justify-content: center;
        }

        .search-quick-tag {
            background: rgba(255, 255, 255, 0.06);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: #cbd5e1;
            padding: 4px 10px;
            border-radius: var(--radius-full);
            font-size: 0.74rem;
            text-decoration: none;
            transition: all 0.15s ease;
        }

        .search-quick-tag:hover {
            background: rgba(99, 102, 241, 0.25);
            color: #ffffff;
            border-color: #6366f1;
        }

        /* Circular Action Buttons (Wishlist, etc) */
        .action-icon-btn {
            position: relative;
            width: 40px;
            height: 40px;
            border-radius: var(--radius-full);
            background: #f1f5f9;
            border: 1px solid #e2e8f0;
            color: #475569;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s ease;
            text-decoration: none;
        }

        .action-icon-btn:hover {
            background: #e2e8f0;
            border-color: #cbd5e1;
            color: #0f172a;
            transform: translateY(-1px);
        }

        /* Cart Pill Button */
        .cart-pill-btn {
            position: relative;
            background: #0f172a;
            border: 1px solid #0f172a;
            color: #ffffff;
            padding: 8px 14px;
            border-radius: var(--radius-full);
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-size: 0.86rem;
            font-weight: 600;
            transition: all 0.2s ease;
            text-decoration: none;
            box-shadow: 0 2px 8px rgba(15, 23, 42, 0.15);
        }

        .cart-pill-btn:hover {
            background: #000000;
            border-color: #000000;
            transform: translateY(-1px);
            box-shadow: 0 4px 14px rgba(15, 23, 42, 0.25);
        }

        .cart-count-badge {
            background: #2563eb;
            color: #ffffff;
            font-size: 0.72rem;
            min-width: 20px;
            height: 20px;
            padding: 0 6px;
            border-radius: var(--radius-full);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
        }

        .cart-count-badge.animate-bounce {
            animation: cartBadgePop 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        @keyframes cartBadgePop {
            0% { transform: scale(1); }
            35% { transform: scale(1.45) rotate(-6deg); }
            70% { transform: scale(1.15) rotate(3deg); }
            100% { transform: scale(1); }
        }

        /* Button Instant Feedback State */
        .btn-success-flash {
            background: #059669 !important;
            border-color: #059669 !important;
            color: #ffffff !important;
            box-shadow: 0 4px 18px rgba(5, 150, 105, 0.4) !important;
            pointer-events: none;
            transform: scale(1.02);
            transition: all 0.2s ease;
        }

        /* Floating Modern Toast Stack */
        .toast-stack-container {
            position: fixed;
            bottom: 28px;
            right: 28px;
            z-index: 999999;
            display: flex;
            flex-direction: column;
            gap: 12px;
            pointer-events: none;
            max-width: 440px;
            width: calc(100vw - 40px);
        }

        .cool-toast-card {
            pointer-events: auto;
            background: rgba(15, 23, 42, 0.95);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.16);
            border-radius: 20px;
            padding: 14px 18px;
            color: #ffffff;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.4), 0 0 0 1px rgba(255, 255, 255, 0.08);
            display: flex;
            align-items: center;
            gap: 14px;
            transform: translateY(30px) scale(0.94);
            opacity: 0;
            transition: all 0.35s cubic-bezier(0.16, 1, 0.3, 1);
            position: relative;
            overflow: hidden;
        }

        .cool-toast-card.is-visible {
            transform: translateY(0) scale(1);
            opacity: 1;
        }

        .cool-toast-card.is-leaving {
            transform: translateY(-20px) scale(0.92);
            opacity: 0;
        }

        .cool-toast-card.toast-error {
            border-color: rgba(239, 68, 68, 0.4);
            background: rgba(24, 15, 20, 0.96);
        }

        .cool-toast-thumb {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            background: #1e293b;
            border: 1px solid rgba(255, 255, 255, 0.14);
            object-fit: cover;
            flex-shrink: 0;
        }

        .cool-toast-icon-wrap {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            box-shadow: 0 4px 14px rgba(16, 185, 129, 0.35);
        }

        .cool-toast-card.toast-error .cool-toast-icon-wrap {
            background: linear-gradient(135deg, #ef4444 0%, #b91c1c 100%);
            box-shadow: 0 4px 14px rgba(239, 68, 68, 0.35);
        }

        .cool-toast-content {
            flex: 1;
            min-width: 0;
        }

        .cool-toast-header {
            font-size: 0.72rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.7px;
            color: #34d399;
            display: flex;
            align-items: center;
            gap: 6px;
            margin-bottom: 2px;
        }

        .cool-toast-card.toast-error .cool-toast-header {
            color: #f87171;
        }

        .cool-toast-name {
            font-size: 0.92rem;
            font-weight: 750;
            color: #f8fafc;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            line-height: 1.35;
        }

        .cool-toast-meta {
            font-size: 0.78rem;
            color: #94a3b8;
            margin-top: 2px;
        }

        .cool-toast-action-btn {
            background: rgba(255, 255, 255, 0.14);
            border: 1px solid rgba(255, 255, 255, 0.22);
            color: #ffffff;
            padding: 7px 14px;
            border-radius: var(--radius-full);
            font-size: 0.78rem;
            font-weight: 750;
            cursor: pointer;
            text-decoration: none;
            white-space: nowrap;
            transition: all 0.2s ease;
            flex-shrink: 0;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .cool-toast-action-btn:hover {
            background: #ffffff;
            color: #0f172a;
            transform: translateY(-1px);
            box-shadow: 0 4px 14px rgba(255, 255, 255, 0.25);
        }

        .cool-toast-close {
            background: none;
            border: none;
            color: #94a3b8;
            font-size: 1.1rem;
            cursor: pointer;
            padding: 2px 4px;
            line-height: 1;
            transition: color 0.15s;
            flex-shrink: 0;
        }

        .cool-toast-close:hover {
            color: #ffffff;
        }

        .cool-toast-progress {
            position: absolute;
            bottom: 0;
            left: 0;
            height: 3px;
            background: linear-gradient(90deg, #10b981, #3b82f6);
            width: 100%;
            animation: toastProgressAnim 3.8s linear forwards;
        }

        .cool-toast-card.toast-error .cool-toast-progress {
            background: linear-gradient(90deg, #ef4444, #f97316);
        }

        @keyframes toastProgressAnim {
            from { width: 100%; }
            to { width: 0%; }
        }

        /* ============================================================
           ULTRA-LUXURY EXECUTIVE USER PROFILE TRIGGER & DROPDOWN MENU
           ============================================================ */
        .user-menu-wrap {
            position: relative;
        }

        .user-menu-trigger {
            background: #f1f5f9;
            border: 1px solid #e2e8f0;
            color: #0f172a;
            padding: 4px 12px 4px 5px;
            border-radius: var(--radius-full);
            display: inline-flex;
            align-items: center;
            gap: 9px;
            cursor: pointer;
            transition: all 0.22s cubic-bezier(0.16, 1, 0.3, 1);
            outline: none;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
        }

        .user-menu-trigger:hover, .user-menu-wrap.open .user-menu-trigger {
            background: #e2e8f0;
            border-color: #cbd5e1;
            transform: translateY(-1px);
        }

        .user-avatar-wrap {
            position: relative;
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .user-avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: linear-gradient(135deg, #6366f1 0%, #a855f7 50%, #ec4899 100%);
            padding: 1.5px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 0 12px rgba(99, 102, 241, 0.45);
            flex-shrink: 0;
            overflow: hidden;
        }

        .user-avatar img {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            object-fit: cover;
            display: block;
        }

        .user-avatar span {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            background: #0b1120;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 850;
            font-size: 0.82rem;
            color: #ffffff;
            text-transform: uppercase;
        }

        .user-avatar-dot {
            position: absolute;
            bottom: -1px;
            right: -1px;
            width: 9px;
            height: 9px;
            border-radius: 50%;
            background: #10b981;
            border: 2px solid #0b1120;
            box-shadow: 0 0 6px #10b981;
        }

        .user-name-text {
            font-size: 0.86rem;
            font-weight: 750;
            color: #0f172a;
            max-width: 110px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            letter-spacing: -0.2px;
        }

        .user-admin-chip {
            background: linear-gradient(135deg, rgba(99, 102, 241, 0.3) 0%, rgba(236, 72, 153, 0.25) 100%);
            border: 1px solid rgba(168, 85, 247, 0.5);
            color: #f1f5f9;
            font-size: 0.62rem;
            font-weight: 850;
            padding: 2px 7px;
            border-radius: 9999px;
            letter-spacing: 0.6px;
            box-shadow: 0 0 8px rgba(168, 85, 247, 0.3);
            text-shadow: 0 0 8px rgba(168, 85, 247, 0.6);
        }

        .user-menu-caret {
            color: #94a3b8;
            transition: transform 0.25s cubic-bezier(0.16, 1, 0.3, 1), color 0.2s;
        }

        .user-menu-wrap.open .user-menu-caret {
            color: #c7d2fe;
            transform: rotate(180deg);
        }

        /* Dropdown Card - Solid White Luxury Card */
        .user-menu-dropdown {
            position: absolute;
            top: calc(100% + 10px);
            right: 0;
            width: 256px;
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.12), 0 0 0 1px rgba(0, 0, 0, 0.04);
            padding: 8px;
            z-index: 1000;
            opacity: 0;
            visibility: hidden;
            transform: translateY(8px) scale(0.97);
            transform-origin: top right;
            transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .user-menu-wrap.open .user-menu-dropdown {
            opacity: 1;
            visibility: visible;
            transform: translateY(0) scale(1);
        }

        /* Dropdown Header: Clean, Compact, Refined */
        .dropdown-user-header {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 8px 10px 10px;
            margin-bottom: 6px;
            border-bottom: 1px solid #f1f5f9;
        }

        .dropdown-avatar-wrap {
            position: relative;
            flex-shrink: 0;
        }

        .dropdown-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: linear-gradient(135deg, #6366f1, #ec4899);
            padding: 1.5px;
            box-shadow: 0 0 10px rgba(99, 102, 241, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .dropdown-avatar img {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            object-fit: cover;
            display: block;
        }

        .dropdown-avatar span {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #0f172a;
            color: #ffffff;
            font-weight: 850;
            font-size: 0.92rem;
        }

        .dropdown-avatar-badge {
            position: absolute;
            bottom: -1px;
            right: -1px;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: #10b981;
            border: 2px solid #ffffff;
            color: #ffffff;
            font-size: 7px;
            font-weight: 900;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .dropdown-user-meta {
            min-width: 0;
            flex: 1;
        }

        .dropdown-user-name {
            font-weight: 750;
            font-size: 0.88rem;
            color: #0f172a;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            line-height: 1.2;
        }

        .dropdown-user-email {
            font-size: 0.72rem;
            color: #64748b;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            margin-top: 1px;
        }

        .dropdown-user-tag {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            font-size: 0.63rem;
            font-weight: 750;
            color: #4f46e5;
            margin-top: 3px;
            letter-spacing: 0.3px;
        }

        .dropdown-tag-dot {
            width: 5px;
            height: 5px;
            border-radius: 50%;
            background: #10b981;
            box-shadow: 0 0 6px #10b981;
        }

        /* Dropdown Navigation Items: Sleek, Single-Line, Rapid Scanning */
        .dropdown-menu-list {
            display: flex;
            flex-direction: column;
            gap: 2px;
        }

        .dropdown-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 8px 10px;
            border-radius: 9px;
            color: #334155;
            text-decoration: none;
            transition: all 0.15s cubic-bezier(0.16, 1, 0.3, 1);
            cursor: pointer;
            border: 1px solid transparent;
            background: transparent;
            width: 100%;
            text-align: left;
            font-size: 0.84rem;
            font-weight: 600;
            box-sizing: border-box;
        }

        .dropdown-item:hover {
            background: #f1f5f9;
            color: #0f172a;
            transform: translateX(2px);
        }

        .dropdown-item svg {
            width: 15px;
            height: 15px;
            stroke: #64748b;
            flex-shrink: 0;
            transition: stroke 0.15s;
        }

        .dropdown-item:hover svg {
            stroke: #0f172a;
        }

        .dropdown-item-title {
            flex: 1;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        /* Admin Luxury Item */
        .dropdown-item.admin-highlight {
            background: #f5f3ff;
            border: 1px solid #ddd6fe;
            color: #6b21a8;
            margin-bottom: 3px;
        }

        .dropdown-item.admin-highlight svg {
            stroke: #7c3aed;
        }

        .dropdown-item.admin-highlight:hover {
            background: #ede9fe;
            border-color: #c4b5fd;
            color: #581c87;
            box-shadow: 0 2px 8px rgba(124, 58, 237, 0.15);
        }

        .dropdown-item.admin-highlight:hover svg {
            stroke: #6d28d9;
        }

        .dropdown-admin-chip {
            background: #7c3aed;
            border: 1px solid #6d28d9;
            color: #ffffff;
            font-size: 0.58rem;
            font-weight: 850;
            padding: 1px 6px;
            border-radius: 4px;
            letter-spacing: 0.5px;
            margin-left: auto;
        }

        .dropdown-divider {
            height: 1px;
            background: #f1f5f9;
            margin: 5px 4px;
        }

        .dropdown-item.danger-item {
            color: #dc2626;
            margin-top: 1px;
        }

        .dropdown-item.danger-item svg {
            stroke: #dc2626;
        }

        .dropdown-item.danger-item:hover {
            background: #fef2f2;
            color: #b91c1c;
        }

        .dropdown-item.danger-item:hover svg {
            stroke: #b91c1c;
        }

        /* Generic Action Buttons fallback */
        .action-btn {
            position: relative;
            background: var(--bg-card);
            border: 1px solid var(--border-subtle);
            color: var(--text-main);
            padding: 8px 14px;
            border-radius: var(--radius-full);
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 0.88rem;
            font-weight: 600;
            transition: all 0.2s ease;
        }

        .action-btn:hover {
            background: var(--bg-card-hover);
            border-color: var(--border-highlight);
            transform: translateY(-1px);
        }

        .badge-count {
            background: var(--accent-gradient);
            color: #ffffff;
            font-size: 0.72rem;
            padding: 2px 7px;
            border-radius: var(--radius-full);
            font-weight: 700;
        }

        .btn-outline {
            border: 1px solid var(--border-subtle);
            color: var(--text-main);
            padding: 8px 16px;
            border-radius: var(--radius-full);
            font-size: 0.88rem;
            font-weight: 600;
            transition: all 0.2s ease;
            background: transparent;
            cursor: pointer;
        }

        .btn-outline:hover {
            border-color: rgba(255, 255, 255, 0.3);
            background: rgba(255, 255, 255, 0.06);
        }

        .btn-primary {
            background: var(--accent-gradient);
            color: #ffffff;
            padding: 9px 20px;
            border-radius: var(--radius-full);
            font-size: 0.88rem;
            font-weight: 600;
            border: none;
            cursor: pointer;
            box-shadow: 0 4px 15px rgba(99, 102, 241, 0.35);
            transition: all 0.25s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
        }

        .btn-primary:hover {
            opacity: 0.95;
            transform: translateY(-1px);
            box-shadow: 0 8px 25px rgba(99, 102, 241, 0.5);
        }

        /* Flash Messages */
        .flash-container {
            max-width: 1280px;
            margin: 16px auto 0;
            padding: 0 24px;
            width: 100%;
        }

        .alert-box {
            padding: 12px 18px;
            border-radius: var(--radius-md);
            font-size: 0.9rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .alert-success {
            background: rgba(34, 197, 94, 0.15);
            border: 1px solid rgba(34, 197, 94, 0.4);
            color: #4ade80;
        }

        .alert-error {
            background: rgba(239, 68, 68, 0.15);
            border: 1px solid rgba(239, 68, 68, 0.4);
            color: #f87171;
        }

        .alert-info {
            background: rgba(59, 130, 246, 0.15);
            border: 1px solid rgba(59, 130, 246, 0.4);
            color: #60a5fa;
        }

        /* Main Content */
        .main-wrapper {
            flex: 1;
        }

        /* Universal Footer */
        .footer {
            background: #ffffff;
            border-top: 1px solid #e2e8f0;
            padding: 70px 24px 30px;
            margin-top: 80px;
        }

        .footer-container {
            max-width: 1280px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 2fr 1fr 1fr 1fr;
            gap: 40px;
            padding-bottom: 50px;
            border-bottom: 1px solid #e2e8f0;
        }

        @media (max-width: 900px) {
            .footer-container {
                grid-template-columns: 1fr 1fr;
            }
            .nav-links {
                display: none;
            }
            .nav-search-input {
                width: 130px;
            }
            .nav-search-input:focus {
                width: 170px;
            }
        }

        @media (max-width: 680px) {
            .nav-search-wrap {
                display: none;
            }
            .top-banner {
                font-size: 0.74rem;
                padding: 6px 12px;
            }
            .user-name-text {
                display: none;
            }
        }

        @media (max-width: 580px) {
            .footer-container {
                grid-template-columns: 1fr;
            }
        }

        .footer-brand p {
            color: #64748b;
            font-size: 0.9rem;
            margin-top: 14px;
            max-width: 360px;
            line-height: 1.7;
        }

        .footer-heading {
            font-size: 0.95rem;
            font-weight: 750;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            margin-bottom: 18px;
            color: #0f172a;
        }

        .footer-links {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .footer-links a {
            color: #64748b;
            font-size: 0.9rem;
            transition: all 0.2s ease;
        }

        .footer-links a:hover {
            color: #0f172a;
            transform: translateX(3px);
        }

        .footer-bottom {
            max-width: 1280px;
            margin: 24px auto 0;
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-size: 0.85rem;
            color: #64748b;
            flex-wrap: wrap;
            gap: 16px;
        }

        .gradient-text {
            background: linear-gradient(135deg, #0f172a 0%, #2563eb 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        /* ============================================================
           COOL FUTURISTIC CONFIRMATION ALERT MODAL
           ============================================================ */
        .cool-modal-backdrop {
            position: fixed;
            inset: 0;
            background: rgba(3, 7, 18, 0.78);
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 99999;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.24s cubic-bezier(0.16, 1, 0.3, 1), visibility 0.24s;
            padding: 24px;
        }

        .cool-modal-backdrop.is-open {
            opacity: 1;
            visibility: visible;
        }

        .cool-modal-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 24px;
            padding: 36px 32px 32px;
            max-width: 480px;
            width: 100%;
            position: relative;
            overflow: hidden;
            text-align: center;
            transform: scale(0.88) translateY(24px);
            transition: transform 0.32s cubic-bezier(0.34, 1.56, 0.64, 1);
            box-shadow: 0 30px 80px -10px rgba(0, 0, 0, 0.15);
        }

        .cool-modal-backdrop.is-open .cool-modal-card {
            transform: scale(1) translateY(0);
        }

        .cool-modal-close {
            position: absolute;
            top: 18px;
            right: 18px;
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: #f1f5f9;
            border: 1px solid #e2e8f0;
            color: #64748b;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s;
        }

        .cool-modal-close:hover {
            background: #e2e8f0;
            color: #0f172a;
            transform: rotate(90deg);
        }

        /* Ambient Glow Behind Icon */
        .cool-modal-glow {
            position: absolute;
            top: -60px;
            left: 50%;
            transform: translateX(-50%);
            width: 220px;
            height: 220px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(239, 68, 68, 0.35) 0%, rgba(239, 68, 68, 0) 70%);
            pointer-events: none;
            transition: background 0.3s ease;
        }

        .cool-modal-card.type-warning .cool-modal-glow {
            background: radial-gradient(circle, rgba(245, 158, 11, 0.35) 0%, rgba(245, 158, 11, 0) 70%);
        }

        .cool-modal-card.type-info .cool-modal-glow {
            background: radial-gradient(circle, rgba(99, 102, 241, 0.35) 0%, rgba(99, 102, 241, 0) 70%);
        }

        .cool-modal-card.type-logout .cool-modal-glow {
            background: radial-gradient(circle, rgba(244, 63, 94, 0.45) 0%, rgba(244, 63, 94, 0) 70%);
        }

        /* Pulsing Animated Icon Container */
        .cool-modal-icon-wrap {
            width: 76px;
            height: 76px;
            border-radius: 24px;
            margin: 0 auto 20px;
            background: rgba(239, 68, 68, 0.12);
            border: 1px solid rgba(239, 68, 68, 0.35);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.2rem;
            color: #f87171;
            position: relative;
            animation: coolIconFloat 3s ease-in-out infinite;
        }

        .cool-modal-card.type-warning .cool-modal-icon-wrap {
            background: rgba(245, 158, 11, 0.12);
            border-color: rgba(245, 158, 11, 0.35);
            color: #fbbf24;
        }

        .cool-modal-card.type-info .cool-modal-icon-wrap {
            background: rgba(99, 102, 241, 0.12);
            border-color: rgba(99, 102, 241, 0.35);
            color: #a5b4fc;
        }

        .cool-modal-card.type-logout .cool-modal-icon-wrap {
            background: rgba(244, 63, 94, 0.14);
            border-color: rgba(244, 63, 94, 0.4);
            color: #fb7185;
            box-shadow: 0 0 30px rgba(244, 63, 94, 0.25);
        }

        .cool-modal-icon-wrap::after {
            content: '';
            position: absolute;
            inset: -6px;
            border-radius: 28px;
            border: 2px solid rgba(239, 68, 68, 0.3);
            animation: coolRingPulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }

        .cool-modal-card.type-warning .cool-modal-icon-wrap::after {
            border-color: rgba(245, 158, 11, 0.3);
        }

        .cool-modal-card.type-info .cool-modal-icon-wrap::after {
            border-color: rgba(99, 102, 241, 0.3);
        }

        .cool-modal-card.type-logout .cool-modal-icon-wrap::after {
            border-color: rgba(244, 63, 94, 0.35);
        }

        @keyframes coolRingPulse {
            0%, 100% { transform: scale(1); opacity: 0.8; }
            50% { transform: scale(1.15); opacity: 0.1; }
        }

        @keyframes coolIconFloat {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-4px); }
        }

        /* Badge pill */
        .cool-modal-badge {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 5px 15px;
            border-radius: 9999px;
            font-size: 0.72rem;
            font-weight: 800;
            letter-spacing: 0.9px;
            text-transform: uppercase;
            background: rgba(239, 68, 68, 0.15);
            color: #f87171;
            border: 1px solid rgba(239, 68, 68, 0.3);
            margin-bottom: 12px;
        }

        .cool-modal-badge-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: currentColor;
            box-shadow: 0 0 8px currentColor;
            animation: coolRingPulse 2s ease-in-out infinite;
        }

        .cool-modal-card.type-warning .cool-modal-badge {
            background: rgba(245, 158, 11, 0.15);
            color: #fbbf24;
            border-color: rgba(245, 158, 11, 0.3);
        }

        .cool-modal-card.type-info .cool-modal-badge {
            background: rgba(99, 102, 241, 0.15);
            color: #a5b4fc;
            border-color: rgba(99, 102, 241, 0.3);
        }

        .cool-modal-card.type-logout .cool-modal-badge {
            background: rgba(244, 63, 94, 0.15);
            color: #fb7185;
            border-color: rgba(244, 63, 94, 0.35);
        }

        /* Modal Title */
        .cool-modal-title {
            font-size: 1.45rem;
            font-weight: 800;
            color: #0f172a;
            letter-spacing: -0.4px;
            margin-bottom: 8px;
        }

        /* Target item pill */
        .cool-modal-target {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            max-width: 90%;
            background: #f1f5f9;
            border: 1px solid #e2e8f0;
            padding: 7px 16px;
            border-radius: 9999px;
            font-weight: 700;
            font-size: 0.85rem;
            color: #0f172a;
            margin: 4px auto 14px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        /* Modal Description */
        .cool-modal-desc {
            font-size: 0.92rem;
            color: var(--text-muted);
            line-height: 1.55;
            margin-bottom: 26px;
            padding: 0 8px;
        }

        /* Actions */
        .cool-modal-actions {
            display: flex;
            gap: 12px;
            justify-content: center;
        }

        .cool-modal-btn-cancel {
            flex: 1;
            padding: 13px 20px;
            background: #f1f5f9;
            border: 1px solid #cbd5e1;
            border-radius: 14px;
            color: #334155;
            font-size: 0.92rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .cool-modal-btn-cancel:hover {
            background: #e2e8f0;
            color: #0f172a;
            border-color: #94a3b8;
            transform: translateY(-1px);
        }

        .cool-modal-btn-confirm {
            flex: 1.25;
            padding: 13px 22px;
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 50%, #b91c1c 100%);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 14px;
            color: #ffffff;
            font-size: 0.92rem;
            font-weight: 800;
            cursor: pointer;
            box-shadow: 0 4px 20px rgba(239, 68, 68, 0.45);
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .cool-modal-btn-confirm:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(239, 68, 68, 0.65);
            filter: brightness(1.1);
        }

        .cool-modal-btn-confirm:active {
            transform: translateY(0);
        }

        .cool-modal-card.type-warning .cool-modal-btn-confirm {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            box-shadow: 0 4px 20px rgba(245, 158, 11, 0.45);
        }

        .cool-modal-card.type-warning .cool-modal-btn-confirm:hover {
            box-shadow: 0 8px 25px rgba(245, 158, 11, 0.65);
        }

        .cool-modal-card.type-logout .cool-modal-btn-confirm {
            background: linear-gradient(135deg, #f43f5e 0%, #e11d48 50%, #be123c 100%);
            box-shadow: 0 6px 24px rgba(244, 63, 94, 0.5);
            border: 1px solid rgba(255, 255, 255, 0.22);
        }

        .cool-modal-card.type-logout .cool-modal-btn-confirm:hover {
            box-shadow: 0 8px 30px rgba(244, 63, 94, 0.75);
            filter: brightness(1.08);
        }

        .cool-modal-card.type-info .cool-modal-btn-confirm {
            background: var(--accent-gradient);
            box-shadow: 0 4px 20px rgba(99, 102, 241, 0.45);
        }

        .cool-modal-card.type-info .cool-modal-btn-confirm:hover {
            box-shadow: 0 8px 25px rgba(99, 102, 241, 0.65);
        }

        /* Global Pagination Reset */
        nav[role="navigation"] svg {
            width: 16px !important;
            height: 16px !important;
            max-width: 16px !important;
            max-height: 16px !important;
            display: inline-block !important;
            vertical-align: middle !important;
        }
    </style>
    @yield('styles')
</head>
<body class="{{ request()->routeIs('account.*') ? 'account-page-body' : '' }}">

    <!-- 1. Top Announcement Bar (Dynamic from Active Promotions) -->
    @php
        $activePromo = \App\Models\Promotion::where('status', 'Active')
            ->where(function ($q) {
                $q->whereNull('expires_at')->orWhere('expires_at', '>', now());
            })
            ->orderBy('discount_percent', 'desc')
            ->first();
    @endphp

    <div class="top-banner">
        <div class="top-banner-content">
            <span class="top-banner-badge">
                <svg width="11" height="11" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                Special Offer
            </span>
            <span>
                @if ($activePromo)
                    FLASH SALE: <strong style="color:#ffffff;">{{ $activePromo->discount_percent }}% OFF</strong> with code <strong style="color:#c7d2fe; text-decoration:underline;">{{ $activePromo->code }}</strong> • Free Worldwide Shipping over $50 • 30-Day Hassle-Free Returns
                @else
                    {!! \App\Models\SiteSetting::get('announcement_text', '✨ Free Worldwide Express Shipping on Orders Over $50 • 30-Day Hassle-Free Returns') !!}
                @endif
            </span>
        </div>
    </div>

    <!-- 2. Main Navigation -->
    <header class="navbar">
        <div class="nav-container">
            <a href="{{ route('home') }}" class="brand-logo">
                <span class="brand-icon-wrap">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M20.38 3.46L16 2a4 4 0 0 1-8 0L3.62 3.46a2 2 0 0 0-1.34 2.23l.58 3.47a1 1 0 0 0 .99.84H6v10a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V10h2.15a1 1 0 0 0 .99-.84l.58-3.47a2 2 0 0 0-1.34-2.23z" fill="rgba(255,255,255,0.2)"/>
                    </svg>
                </span>
                <span class="brand-text">T-Shirt Online<span class="brand-dot"></span></span>
            </a>

            <ul class="nav-links">
                <li><a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}">Home</a></li>
                <li><a href="{{ route('shop.index') }}" class="nav-link {{ request()->routeIs('shop.*') ? 'active' : '' }}">Shop</a></li>
                <li><a href="{{ route('about') }}" class="nav-link {{ request()->routeIs('about') ? 'active' : '' }}">About</a></li>
                <li><a href="{{ route('contact') }}" class="nav-link {{ request()->routeIs('contact') ? 'active' : '' }}">Contact</a></li>
            </ul>

            <div class="nav-actions">
                @php
                    $cartCount = array_sum(array_column(session('cart', []), 'quantity'));
                    $wishlistCount = count(session('wishlist', []));
                @endphp

                <!-- Global Search Form with Instant Autocomplete Dropdown -->
                <div class="nav-search-container" id="navSearchContainer">
                    <form action="{{ route('shop.index') }}" method="GET" class="nav-search-wrap" id="navSearchForm">
                        <button type="submit" class="nav-search-submit-btn" title="Search catalog">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="11" cy="11" r="8"></circle>
                                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                            </svg>
                        </button>
                        <input type="text" 
                               name="search" 
                               id="globalSearchInput" 
                               class="nav-search-input" 
                               placeholder="Search products, shoes, bags..." 
                               value="{{ request('search') }}" 
                               autocomplete="off"
                               aria-label="Search products"
                               aria-expanded="false">
                        <button type="button" id="globalSearchClear" class="nav-search-clear-btn" style="display:none;" title="Clear search">✕</button>
                    </form>

                    <!-- Instant Search Results Dropdown -->
                    <div id="globalSearchResults" class="nav-search-dropdown" style="display:none;"></div>
                </div>

                <!-- Wishlist Quick Link -->
                <a href="{{ Auth::check() ? route('account.index', ['tab' => 'wishlist']) : route('shop.index') }}" class="action-icon-btn" title="Saved Wishlist">
                    <svg width="18" height="18" fill="{{ $wishlistCount > 0 ? '#ec4899' : 'none' }}" stroke="{{ $wishlistCount > 0 ? '#ec4899' : 'currentColor' }}" stroke-width="2" viewBox="0 0 24 24"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path></svg>
                    @if ($wishlistCount > 0)
                        <span class="wishlist-count-badge">{{ $wishlistCount }}</span>
                    @endif
                </a>

                <!-- Cart Action -->
                <a href="{{ route('cart.index') }}" class="cart-pill-btn" title="View Cart">
                    <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path><line x1="3" y1="6" x2="21" y2="6"></line><path d="M16 10a4 4 0 0 1-8 0"></path></svg>
                    <span>Cart</span>
                    <span class="cart-count-badge">{{ $cartCount }}</span>
                </a>

                <!-- Auth / Customer Account -->
                @auth
                    <div class="user-menu-wrap" id="userMenuWrap">
                        <button type="button" class="user-menu-trigger" id="userMenuBtn" aria-expanded="false" onclick="toggleUserDropdown(event)">
                            <div class="user-avatar-wrap">
                                <span class="user-avatar">
                                    @if (Auth::user()->avatar)
                                        <img src="{{ asset(Auth::user()->avatar) }}" alt="{{ Auth::user()->name }}">
                                    @else
                                        <span>{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
                                    @endif
                                </span>
                                <span class="user-avatar-dot" title="Active"></span>
                            </div>
                            <span class="user-name-text">{{ Auth::user()->name }}</span>
                            @if (Auth::user()->role === 'admin')
                                <span class="user-admin-chip">ADMIN</span>
                            @endif
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="user-menu-caret" id="userMenuCaret"><polyline points="6 9 12 15 18 9"></polyline></svg>
                        </button>

                        <div class="user-menu-dropdown" id="userMenuDropdown">
                            <!-- Dropdown User Header Card -->
                            <div class="dropdown-user-header">
                                <div class="dropdown-avatar-wrap">
                                    <div class="dropdown-avatar">
                                        @if (Auth::user()->avatar)
                                            <img src="{{ asset(Auth::user()->avatar) }}" alt="{{ Auth::user()->name }}">
                                        @else
                                            <span>{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
                                        @endif
                                    </div>
                                    <span class="dropdown-avatar-badge" title="Verified Customer">✓</span>
                                </div>
                                <div class="dropdown-user-meta">
                                    <div class="dropdown-user-name">{{ Auth::user()->name }}</div>
                                    <div class="dropdown-user-email">{{ Auth::user()->email }}</div>
                                    <div class="dropdown-user-tag">
                                        <span class="dropdown-tag-dot"></span>
                                        <span>{{ strtoupper(Auth::user()->role === 'admin' ? 'Founding Admin' : 'VIP Member') }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="dropdown-menu-list">
                                @if (Auth::user()->role === 'admin')
                                    <a href="{{ route('admin.dashboard') }}" class="dropdown-item admin-highlight">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>
                                        <span class="dropdown-item-title">Admin Dashboard</span>
                                        <span class="dropdown-admin-chip">ADMIN</span>
                                    </a>
                                @endif

                                <a href="{{ route('account.index') }}" class="dropdown-item">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                                    <span class="dropdown-item-title">My Profile & Account</span>
                                </a>

                                <a href="{{ route('account.index', ['tab' => 'orders']) }}" class="dropdown-item">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path><line x1="3" y1="6" x2="21" y2="6"></line><path d="M16 10a4 4 0 0 1-8 0"></path></svg>
                                    <span class="dropdown-item-title">Order History</span>
                                </a>

                                <a href="{{ route('account.index', ['tab' => 'wishlist']) }}" class="dropdown-item">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path></svg>
                                    <span class="dropdown-item-title">Saved Wishlist</span>
                                </a>

                                <a href="{{ route('account.index', ['tab' => 'setting']) }}" class="dropdown-item">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="3"></circle><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path></svg>
                                    <span class="dropdown-item-title">Settings</span>
                                </a>

                                <a href="{{ route('order.track') }}" class="dropdown-item">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="1" y="3" width="15" height="13"></rect><polygon points="16 8 20 8 23 11 23 16 16 16 8"></polygon><circle cx="5.5" cy="18.5" r="2.5"></circle><circle cx="18.5" cy="18.5" r="2.5"></circle></svg>
                                    <span class="dropdown-item-title">Track Order</span>
                                </a>

                                <div class="dropdown-divider"></div>

                                <form action="{{ route('logout') }}" method="POST" id="navUserLogoutForm" style="margin:0;">
                                    @csrf
                                    <button type="button" class="dropdown-item danger-item" id="navUserLogoutBtn">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>
                                        <span class="dropdown-item-title">Log Out</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="btn-outline" style="border:none; padding:8px 14px;">Log in</a>
                    <a href="{{ route('register') }}" class="btn-primary" style="padding:8px 18px;">Register</a>
                @endauth
            </div>
        </div>
    </header>

    <!-- Flash Alerts -->
    @if (session('success') || session('error') || session('info'))
    <div class="flash-container">
        @if (session('success'))
            <div class="alert-box alert-success">
                <span>✓ {{ session('success') }}</span>
                <button type="button" onclick="this.parentElement.remove()" style="background:none; border:none; color:inherit; cursor:pointer; font-weight:bold;">✕</button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert-box alert-error">
                <span>✕ {{ session('error') }}</span>
                <button type="button" onclick="this.parentElement.remove()" style="background:none; border:none; color:inherit; cursor:pointer; font-weight:bold;">✕</button>
            </div>
        @endif

        @if (session('info'))
            <div class="alert-box alert-info">
                <span>ℹ {{ session('info') }}</span>
                <button type="button" onclick="this.parentElement.remove()" style="background:none; border:none; color:inherit; cursor:pointer; font-weight:bold;">✕</button>
            </div>
        @endif
    </div>
    @endif

    <!-- Main Content -->
    <main class="main-wrapper">
        @yield('content')
    </main>

    <!-- Universal Footer -->
    @if (!request()->routeIs('account.*'))
    <footer class="footer">
        <div class="footer-container">
            <div class="footer-brand">
                <a href="{{ route('home') }}" class="brand-logo">
                    <span class="brand-icon-wrap" style="width:36px; height:36px; border-radius:10px;">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M20.38 3.46L16 2a4 4 0 0 1-8 0L3.62 3.46a2 2 0 0 0-1.34 2.23l.58 3.47a1 1 0 0 0 .99.84H6v10a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V10h2.15a1 1 0 0 0 .99-.84l.58-3.47a2 2 0 0 0-1.34-2.23z" fill="rgba(255,255,255,0.2)"/>
                        </svg>
                    </span>
                    <span class="brand-text" style="font-size:1.2rem;">T-Shirt Online<span class="brand-dot"></span></span>
                </a>
                <p>
                    Premium organic & bespoke graphic t-shirts engineered for maximum everyday comfort, durability, and contemporary streetwear aesthetics.
                </p>
            </div>

            <div>
                <h5 class="footer-heading">Collections</h5>
                <ul class="footer-links">
                    <li><a href="{{ route('shop.index') }}">All Products</a></li>
                    <li><a href="{{ route('shop.index', ['category' => 'Graphic T-Shirts']) }}">Graphic T-Shirts</a></li>
                    <li><a href="{{ route('shop.index', ['category' => 'Plain T-Shirts']) }}">Plain T-Shirts</a></li>
                    <li><a href="{{ route('shop.index', ['category' => 'Oversized T-Shirts']) }}">Oversized T-Shirts</a></li>
                    <li><a href="{{ route('shop.index', ['category' => 'Custom T-Shirts']) }}">Custom T-Shirts</a></li>
                    <li><a href="{{ route('shop.index', ['category' => 'Shoes']) }}">Shoes & Sneakers</a></li>
                    <li><a href="{{ route('shop.index', ['category' => 'Bags']) }}">Bags & Packs</a></li>
                    <li><a href="{{ route('shop.index', ['category' => 'Hats']) }}">Hats & Caps</a></li>
                    <li><a href="{{ route('shop.index', ['category' => 'Headphones']) }}">Headphones</a></li>
                    <li><a href="{{ route('shop.index', ['category' => 'Watches']) }}">Luxury Watches</a></li>
                    <li><a href="{{ route('shop.index', ['category' => 'Trousers']) }}">Trousers & Pants</a></li>
                </ul>
            </div>

            <div>
                <h5 class="footer-heading">Customer Care</h5>
                <ul class="footer-links">
                    <li><a href="{{ route('order.track') }}">Track Your Order</a></li>
                    <li><a href="{{ route('cart.index') }}">Shopping Cart</a></li>
                    <li><a href="{{ route('checkout.index') }}">Checkout</a></li>
                    <li><a href="{{ route('account.index') }}">My Account</a></li>
                    <li><a href="{{ route('about') }}">Our Story & Mission</a></li>
                </ul>
            </div>

            <div>
                <h5 class="footer-heading">Contact</h5>
                <ul class="footer-links">
                    <li><a href="{{ route('contact') }}">Contact Us</a></li>
                    <li><a href="tel:+18005558337">+1 (800) 555-TEES</a></li>
                    <li><a href="mailto:support@threadcraft.store">support@threadcraft.store</a></li>
                    <li style="color: var(--text-muted); font-size: 0.88rem; margin-top: 4px;">Studio 4A, Street 123, Sangkat Boeung Keng Kang 1,<br>Khan Boeung Keng Kang, Phnom Penh, Cambodia</li>
                </ul>
            </div>
        </div>

        <div class="footer-bottom">
            <div>&copy; {{ date('Y') }} T-Shirt Online Apparel Co. All rights reserved.</div>
            <div style="display:flex; gap: 20px;">
                <a href="{{ route('about') }}" style="color:var(--text-muted);">Privacy Policy</a>
                <a href="{{ route('about') }}" style="color:var(--text-muted);">Terms of Service</a>
                <a href="{{ route('contact') }}" style="color:var(--text-muted);">Support</a>
            </div>
        </div>
    </footer>
    @endif

    <!-- ============================================================
         COOL CONFIRMATION ALERT MODAL (Universal)
         ============================================================ -->
    <div id="coolConfirmModal" class="cool-modal-backdrop" aria-hidden="true" role="dialog">
        <div class="cool-modal-card">
            <!-- Close 'X' Button -->
            <button type="button" class="cool-modal-close" onclick="closeCoolConfirm()" aria-label="Close dialog">✕</button>

            <!-- Ambient Glow Effect -->
            <div class="cool-modal-glow" id="coolModalGlow"></div>

            <!-- Pulsing Icon Container -->
            <div class="cool-modal-icon-wrap" id="coolModalIconWrap">
                <span id="coolModalIcon"></span>
            </div>

            <!-- Action Badge -->
            <div class="cool-modal-badge" id="coolModalBadge">
                <span class="cool-modal-badge-dot"></span>
                <span id="coolModalBadgeText">SESSION SECURITY</span>
            </div>

            <!-- Title -->
            <h3 class="cool-modal-title" id="coolModalTitle">Log Out of Your Account?</h3>

            <!-- Highlighted Target Item (Optional) -->
            <div>
                <div class="cool-modal-target" id="coolModalTarget" style="display:none;"></div>
            </div>

            <!-- Detailed Message -->
            <p class="cool-modal-desc" id="coolModalMessage">Are you sure you want to end your current session? You will need to log back in to access your profile, saved wishlist, and order history.</p>

            <!-- Action Buttons -->
            <div class="cool-modal-actions">
                <button type="button" class="cool-modal-btn-cancel" id="coolModalCancelBtn" onclick="closeCoolConfirm()">
                    Stay Logged In
                </button>
                <button type="button" class="cool-modal-btn-confirm" id="coolModalConfirmBtn">
                    <span id="coolModalConfirmIcon"></span>
                    <span id="coolModalConfirmText">Yes, Log Out</span>
                </button>
            </div>
        </div>
    </div>

    <script>
        let currentConfirmCallback = null;

        const COOL_MODAL_ICONS = {
            logout: '<svg width="34" height="34" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>',
            danger: '<svg width="34" height="34" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>',
            warning: '<svg width="34" height="34" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path><line x1="12" y1="9" x2="12" y2="13"></line><line x1="12" y1="17" x2="12.01" y2="17"></line></svg>',
            info: '<svg width="34" height="34" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg>'
        };

        const COOL_BTN_ICONS = {
            logout: '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block; vertical-align:middle; margin-right:4px;"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>',
            danger: '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block; vertical-align:middle; margin-right:4px;"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>',
            warning: '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block; vertical-align:middle; margin-right:4px;"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>',
            check: '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block; vertical-align:middle; margin-right:4px;"><polyline points="20 6 9 17 4 12"></polyline></svg>'
        };

        window.openCoolConfirm = function(options) {
            const modal = document.getElementById('coolConfirmModal');
            if (!modal) return;

            const card = modal.querySelector('.cool-modal-card');
            const titleEl = document.getElementById('coolModalTitle');
            const messageEl = document.getElementById('coolModalMessage');
            const targetEl = document.getElementById('coolModalTarget');
            const badgeTextEl = document.getElementById('coolModalBadgeText') || document.getElementById('coolModalBadge');
            const iconEl = document.getElementById('coolModalIcon');
            const confirmBtn = document.getElementById('coolModalConfirmBtn');
            const confirmTextEl = document.getElementById('coolModalConfirmText');
            const confirmIconEl = document.getElementById('coolModalConfirmIcon');
            const cancelBtn = document.getElementById('coolModalCancelBtn');

            // Reset type modifiers
            card.classList.remove('type-danger', 'type-warning', 'type-info', 'type-logout');
            let type = options.type || 'warning';
            if (type === 'logout' || options.icon === 'logout' || (options.title && options.title.toLowerCase().includes('log out'))) {
                type = 'logout';
            }
            card.classList.add('type-' + type);

            titleEl.textContent = options.title || 'Are you sure?';
            messageEl.textContent = options.message || 'Please confirm that you want to proceed with this action.';
            
            const badgeText = options.badge || (type === 'logout' ? 'SESSION SECURITY' : (type === 'danger' ? 'DESTRUCTIVE ACTION' : 'ACTION REQUIRED'));
            if (badgeTextEl) {
                badgeTextEl.textContent = badgeText;
            }

            // Set main icon
            let iconHtml = COOL_MODAL_ICONS[type] || COOL_MODAL_ICONS.warning;
            if (options.icon && COOL_MODAL_ICONS[options.icon]) {
                iconHtml = COOL_MODAL_ICONS[options.icon];
            } else if (options.iconSvg) {
                iconHtml = options.iconSvg;
            }
            iconEl.innerHTML = iconHtml;

            if (options.item) {
                targetEl.textContent = options.item;
                targetEl.style.display = 'inline-flex';
            } else {
                targetEl.style.display = 'none';
            }

            confirmTextEl.textContent = options.confirmText || 'Yes, Proceed';
            
            // Set button icon
            let btnIconHtml = COOL_BTN_ICONS[type] || COOL_BTN_ICONS.check;
            if (options.icon && COOL_BTN_ICONS[options.icon]) {
                btnIconHtml = COOL_BTN_ICONS[options.icon];
            }
            confirmIconEl.innerHTML = btnIconHtml;

            if (cancelBtn) {
                cancelBtn.textContent = options.cancelText || 'Cancel';
            }

            // Reset button appearance
            confirmBtn.style.opacity = '1';
            confirmBtn.style.pointerEvents = 'auto';

            currentConfirmCallback = options.onConfirm || null;

            modal.classList.add('is-open');
            modal.setAttribute('aria-hidden', 'false');
            confirmBtn.focus();
        };

        window.closeCoolConfirm = function() {
            const modal = document.getElementById('coolConfirmModal');
            if (!modal) return;
            modal.classList.remove('is-open');
            modal.setAttribute('aria-hidden', 'true');
            currentConfirmCallback = null;
        };

        document.addEventListener('DOMContentLoaded', function() {
            const confirmBtn = document.getElementById('coolModalConfirmBtn');
            if (confirmBtn) {
                confirmBtn.addEventListener('click', function() {
                    if (typeof currentConfirmCallback === 'function') {
                        const cb = currentConfirmCallback;
                        confirmBtn.innerHTML = '<span>⏳</span> Processing...';
                        confirmBtn.style.opacity = '0.7';
                        confirmBtn.style.pointerEvents = 'none';
                        setTimeout(() => {
                            cb();
                        }, 120);
                    } else {
                        closeCoolConfirm();
                    }
                });
            }

            // Close on Escape key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    closeCoolConfirm();
                }
            });

            // Close on Backdrop click
            const modal = document.getElementById('coolConfirmModal');
            if (modal) {
                modal.addEventListener('click', function(e) {
                    if (e.target === modal) {
                        closeCoolConfirm();
                    }
                });
            }

            // Universal Auto-Upgrade for any form with confirm(...) or data-confirm or logout
            function initFormConfirmInterceptors() {
                // Intercept any form with onsubmit*="confirm"
                document.querySelectorAll('form[onsubmit*="confirm"]').forEach(function(form) {
                    const rawAttr = form.getAttribute('onsubmit') || '';
                    form.removeAttribute('onsubmit'); // Remove default browser alert trigger!
                    
                    let promptText = 'Are you sure you want to proceed?';
                    const match = rawAttr.match(/confirm\(['"](.*?)['"]\)/);
                    if (match && match[1]) {
                        promptText = match[1];
                    }

                    form.dataset.coolPrompt = promptText;
                });

                // Intercept any button/link with inline native confirm(...)
                document.querySelectorAll('button[onclick], a[onclick]').forEach(function(el) {
                    const rawAttr = el.getAttribute('onclick') || '';
                    if (/confirm\s*\(/.test(rawAttr) && !rawAttr.includes('openCoolConfirm')) {
                        el.removeAttribute('onclick'); // Remove default browser alert trigger!
                        
                        let promptText = 'Are you sure you want to proceed?';
                        const match = rawAttr.match(/confirm\s*\(['"](.*?)['"]\)/);
                        if (match && match[1]) {
                            promptText = match[1];
                        }
                        const parentForm = el.closest('form');
                        if (parentForm) {
                            parentForm.dataset.coolPrompt = promptText;
                        }
                    }
                });

                // Global delegated submit interceptor
                document.addEventListener('submit', function(e) {
                    const form = e.target;
                    if (!form || form.dataset.confirmed === 'true') {
                        return; // Allow submission
                    }

                    const hasDataConfirm = form.hasAttribute('data-confirm');
                    const hasCoolPrompt = form.dataset.coolPrompt;
                    const isLogout = (form.action && form.action.includes('logout')) || 
                                     (form.querySelector('button[type="submit"]') && form.querySelector('button[type="submit"]').textContent.toLowerCase().includes('logout'));

                    if (hasDataConfirm || hasCoolPrompt || isLogout) {
                        e.preventDefault();

                        const isDelete = (form.querySelector('button[type="submit"]') && 
                                         form.querySelector('button[type="submit"]').textContent.toLowerCase().includes('delete')) ||
                                         (form.action && (form.action.includes('destroy') || form.action.includes('delete'))) ||
                                         form.querySelector('input[name="_method"][value="DELETE"]');

                        const isRefund = form.action && form.action.includes('refund');

                        let title = 'Confirm Action';
                        let type = 'danger';
                        let icon = 'danger';
                        let badge = 'ACTION REQUIRED';
                        let confirmText = 'Yes, Confirm';
                        let cancelText = 'Cancel';
                        let defaultMessage = 'Are you sure you want to perform this action?';

                        if (isLogout) {
                            title = 'Log Out of Your Account?';
                            type = 'logout';
                            icon = 'logout';
                            badge = 'SESSION SECURITY';
                            confirmText = 'Yes, Log Out';
                            cancelText = 'Stay Logged In';
                            defaultMessage = 'Are you sure you want to end your current session? You will need to log back in to access your profile, saved wishlist, and order history.';
                        } else if (isDelete) {
                            title = 'Delete Permanently?';
                            type = 'danger';
                            icon = 'danger';
                            badge = 'CATALOG DELETION';
                            confirmText = 'Yes, Delete Now';
                            cancelText = 'Keep / Cancel';
                            defaultMessage = 'This action cannot be undone and will permanently remove this record.';
                        } else if (isRefund) {
                            title = 'Issue Customer Refund?';
                            type = 'warning';
                            icon = 'warning';
                            badge = 'FINANCIAL LEDGER';
                            confirmText = 'Process Refund';
                            cancelText = 'Cancel';
                            defaultMessage = 'This will refund the customer order amount.';
                        }

                        // Try to find a nearby item name in the table row
                        let item = form.dataset.confirmItem || '';
                        if (!item) {
                            const tr = form.closest('tr');
                            if (tr) {
                                const titleEl = tr.querySelector('.product-name, strong, .title, td:nth-child(2), td:first-child');
                                if (titleEl) {
                                    item = titleEl.textContent.trim().split('\n')[0].trim();
                                }
                            }
                        }

                        window.openCoolConfirm({
                            title: form.dataset.confirmTitle || title,
                            message: form.dataset.confirmMessage || form.getAttribute('data-confirm') || form.dataset.coolPrompt || defaultMessage,
                            item: item,
                            badge: form.dataset.confirmBadge || badge,
                            type: form.dataset.confirmType || type,
                            icon: form.dataset.confirmIcon || icon,
                            confirmText: form.dataset.confirmBtn || confirmText,
                            cancelText: form.dataset.cancelBtn || cancelText,
                            onConfirm: () => {
                                form.dataset.confirmed = 'true';
                                form.submit();
                            }
                        });
                    }
                });
            }

            initFormConfirmInterceptors();

            // Dedicated listener for navbar dropdown logout button
            const navLogoutBtn = document.getElementById('navUserLogoutBtn');
            const navLogoutForm = document.getElementById('navUserLogoutForm');
            if (navLogoutBtn && navLogoutForm) {
                navLogoutBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    const wrap = document.getElementById('userMenuWrap');
                    const caret = document.getElementById('userMenuCaret');
                    if (wrap) wrap.classList.remove('open');
                    if (caret) caret.style.transform = 'rotate(0deg)';

                    window.openCoolConfirm({
                        title: 'Log Out of Your Account?',
                        message: 'Are you sure you want to end your current session? You will need to log back in to access your profile, saved wishlist, and order history.',
                        type: 'logout',
                        icon: 'logout',
                        badge: 'SESSION SECURITY',
                        confirmText: 'Yes, Log Out',
                        cancelText: 'Stay Logged In',
                        onConfirm: function() {
                            navLogoutForm.submit();
                        }
                    });
                });
            }
        });

        /* User Profile Dropdown Interactivity */
        function toggleUserDropdown(e) {
            e.stopPropagation();
            const wrap = document.getElementById('userMenuWrap');
            const caret = document.getElementById('userMenuCaret');
            if (wrap) {
                const isOpen = wrap.classList.toggle('open');
                if (caret) caret.style.transform = isOpen ? 'rotate(180deg)' : 'rotate(0deg)';
            }
        }

        document.addEventListener('click', function(e) {
            const wrap = document.getElementById('userMenuWrap');
            const caret = document.getElementById('userMenuCaret');
            if (wrap && wrap.classList.contains('open') && !wrap.contains(e.target)) {
                wrap.classList.remove('open');
                if (caret) caret.style.transform = 'rotate(0deg)';
            }
        });

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                const wrap = document.getElementById('userMenuWrap');
                const caret = document.getElementById('userMenuCaret');
                if (wrap && wrap.classList.contains('open')) {
                    wrap.classList.remove('open');
                    if (caret) caret.style.transform = 'rotate(0deg)';
                }
            }
        });

        /* -------------------------------------------------------------
           GLOBAL LIVE AUTOCOMPLETE SEARCH
        ------------------------------------------------------------- */
        (function() {
            const container = document.getElementById('navSearchContainer');
            const form = document.getElementById('navSearchForm');
            const input = document.getElementById('globalSearchInput');
            const clearBtn = document.getElementById('globalSearchClear');
            const dropdown = document.getElementById('globalSearchResults');

            if (!input || !dropdown) return;

            let debounceTimer = null;
            let currentSelectedIndex = -1;

            function escapeHtml(text) {
                const div = document.createElement('div');
                div.textContent = text;
                return div.innerHTML;
            }

            function highlightMatch(text, query) {
                if (!query) return escapeHtml(text);
                const safeText = escapeHtml(text);
                const safeQuery = query.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
                const regex = new RegExp(`(${safeQuery})`, 'gi');
                return safeText.replace(regex, '<mark>$1</mark>');
            }

            function updateClearBtnVisibility() {
                if (clearBtn) {
                    clearBtn.style.display = input.value.trim().length > 0 ? 'flex' : 'none';
                }
            }

            function closeDropdown() {
                dropdown.style.display = 'none';
                dropdown.innerHTML = '';
                currentSelectedIndex = -1;
                input.setAttribute('aria-expanded', 'false');
                if (container) container.classList.remove('is-active');
            }

            function openDropdown() {
                dropdown.style.display = 'block';
                input.setAttribute('aria-expanded', 'true');
                if (container) container.classList.add('is-active');
            }

            function fetchLiveResults(q) {
                if (!q || q.length < 1) {
                    closeDropdown();
                    return;
                }

                if (dropdown.style.display === 'none') {
                    dropdown.innerHTML = `
                        <div class="search-empty-state" style="padding: 20px;">
                            <div style="display:inline-block; width: 20px; height: 20px; border: 2px solid rgba(255,255,255,0.2); border-top-color: #6366f1; border-radius: 50%; animation: spin 0.6s linear infinite;"></div>
                            <div class="msg" style="margin-top: 8px; margin-bottom: 0;">Searching catalog...</div>
                        </div>
                    `;
                    openDropdown();
                }

                fetch(`{{ route('api.search') }}?q=${encodeURIComponent(q)}`)
                    .then(res => res.json())
                    .then(data => {
                        if (input.value.trim() !== q) return;

                        if (!data.products || data.products.length === 0) {
                            dropdown.innerHTML = `
                                <div class="search-results-header">
                                    <span>Search Results</span>
                                    <span>0 items</span>
                                </div>
                                <div class="search-empty-state">
                                    <div class="icon">🔍</div>
                                    <div class="msg">No products found matching <strong>"${escapeHtml(q)}"</strong></div>
                                    <div style="font-size: 0.74rem; color: #64748b; margin-bottom: 8px; font-weight: 700; letter-spacing: 0.5px;">POPULAR CATEGORIES:</div>
                                    <div class="search-quick-tags">
                                        <a href="{{ route('shop.index', ['category' => 'Shoes']) }}" class="search-quick-tag">Shoes</a>
                                        <a href="{{ route('shop.index', ['category' => 'Bags']) }}" class="search-quick-tag">Bags</a>
                                        <a href="{{ route('shop.index', ['category' => 'Trousers']) }}" class="search-quick-tag">Trousers</a>
                                        <a href="{{ route('shop.index', ['category' => 'Watches']) }}" class="search-quick-tag">Watches</a>
                                        <a href="{{ route('shop.index', ['category' => 'Graphic T-Shirts']) }}" class="search-quick-tag">Graphic Tees</a>
                                    </div>
                                </div>
                            `;
                            openDropdown();
                            return;
                        }

                        let html = `
                            <div class="search-results-header">
                                <span>Products (${data.products.length} of ${data.total})</span>
                                <span style="color:#818cf8; text-transform:none;">Press ↵ to view all</span>
                            </div>
                            <ul class="search-results-list" id="searchResultsList">
                        `;

                        data.products.forEach((p, index) => {
                            html += `
                                <li>
                                    <a href="${p.url}" class="search-result-item" data-index="${index}">
                                        <img src="${p.image}" alt="${escapeHtml(p.name)}" class="search-result-img" loading="lazy">
                                        <div class="search-result-info">
                                            <div class="search-result-name">${highlightMatch(p.name, q)}</div>
                                            <div class="search-result-meta">
                                                <span class="search-result-cat">${escapeHtml(p.category)}</span>
                                                <span class="search-result-price">${p.price}</span>
                                                ${p.original_price ? `<span class="search-result-oldprice">${p.original_price}</span>` : ''}
                                                ${!p.in_stock ? `<span class="search-result-stockout">• Out of Stock</span>` : ''}
                                            </div>
                                        </div>
                                        <span style="color:#64748b; font-size: 0.8rem; margin-left:auto;">→</span>
                                    </a>
                                </li>
                            `;
                        });

                        html += `</ul>`;

                        html += `
                            <div class="search-results-footer">
                                <a href="${data.view_all_url}" class="search-view-all-btn">
                                    <span>View All ${data.total} Results in Shop</span>
                                    <span>→</span>
                                </a>
                            </div>
                        `;

                        dropdown.innerHTML = html;
                        currentSelectedIndex = -1;
                        openDropdown();
                    })
                    .catch(() => {});
            }

            input.addEventListener('input', function() {
                const q = this.value.trim();
                updateClearBtnVisibility();
                clearTimeout(debounceTimer);
                if (q.length >= 1) {
                    debounceTimer = setTimeout(() => {
                        fetchLiveResults(q);
                    }, 180);
                } else {
                    closeDropdown();
                }
            });

            input.addEventListener('focus', function() {
                const q = this.value.trim();
                updateClearBtnVisibility();
                if (q.length >= 1) {
                    fetchLiveResults(q);
                }
            });

            if (clearBtn) {
                clearBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    input.value = '';
                    updateClearBtnVisibility();
                    closeDropdown();
                    input.focus();
                });
            }

            input.addEventListener('keydown', function(e) {
                const items = dropdown.querySelectorAll('.search-result-item');
                if (dropdown.style.display !== 'none' && items.length > 0) {
                    if (e.key === 'ArrowDown') {
                        e.preventDefault();
                        currentSelectedIndex = (currentSelectedIndex + 1) % items.length;
                        items.forEach((item, idx) => {
                            item.classList.toggle('selected', idx === currentSelectedIndex);
                            if (idx === currentSelectedIndex) item.scrollIntoView({ block: 'nearest' });
                        });
                        return;
                    }

                    if (e.key === 'ArrowUp') {
                        e.preventDefault();
                        currentSelectedIndex = (currentSelectedIndex - 1 + items.length) % items.length;
                        items.forEach((item, idx) => {
                            item.classList.toggle('selected', idx === currentSelectedIndex);
                            if (idx === currentSelectedIndex) item.scrollIntoView({ block: 'nearest' });
                        });
                        return;
                    }

                    if (e.key === 'Enter') {
                        if (currentSelectedIndex >= 0 && items[currentSelectedIndex]) {
                            e.preventDefault();
                            items[currentSelectedIndex].click();
                            return;
                        }
                    }

                    if (e.key === 'Escape') {
                        e.preventDefault();
                        closeDropdown();
                        return;
                    }
                }
            });

            document.addEventListener('click', function(e) {
                if (container && !container.contains(e.target)) {
                    closeDropdown();
                }
            });

            updateClearBtnVisibility();
        })();

        // Global Modern Toast Notification Dispatcher
        function showCartToast(options) {
            const container = document.getElementById('toastContainer');
            if (!container) return;

            const isError = options.isError || false;
            const card = document.createElement('div');
            card.className = 'cool-toast-card' + (isError ? ' toast-error' : '');

            const iconHtml = isError
                ? `<div class="cool-toast-icon-wrap"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></div>`
                : (options.image 
                    ? `<img src="${options.image}" alt="${options.name || 'Product'}" class="cool-toast-thumb" onerror="this.onerror=null;this.replaceWith(document.createElement('div'))">` 
                    : `<div class="cool-toast-icon-wrap"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg></div>`);

            const actionBtnHtml = !isError 
                ? `<a href="{{ route('cart.index') }}" class="cool-toast-action-btn">
                     <span>View Bag</span>
                     <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"></path></svg>
                   </a>` 
                : '';

            card.innerHTML = `
                ${iconHtml}
                <div class="cool-toast-content">
                    <div class="cool-toast-header">
                        <span>${isError ? '⚠️ Notice' : '✓ Added to Cart'}</span>
                    </div>
                    <div class="cool-toast-name">${options.name || ''}</div>
                    ${options.meta ? `<div class="cool-toast-meta">${options.meta}</div>` : ''}
                </div>
                ${actionBtnHtml}
                <button type="button" class="cool-toast-close" title="Close" onclick="dismissToast(this.parentElement)">✕</button>
                <div class="cool-toast-progress"></div>
            `;

            container.appendChild(card);

            // Animate in
            requestAnimationFrame(() => {
                card.classList.add('is-visible');
            });

            // Auto dismiss timer
            const dismissTimer = setTimeout(() => {
                dismissToast(card);
            }, 3800);

            card.dataset.timer = dismissTimer;
        }

        function dismissToast(card) {
            if (!card || card.classList.contains('is-leaving')) return;
            card.classList.remove('is-visible');
            card.classList.add('is-leaving');
            if (card.dataset.timer) clearTimeout(parseInt(card.dataset.timer));
            setTimeout(() => {
                if (card && card.parentElement) card.parentElement.removeChild(card);
            }, 350);
        }

        // Global AJAX Add-to-Cart Interceptor (prevents page jump/reload)
        (function() {
            document.addEventListener('submit', function(e) {
                const form = e.target;
                if (!form || !form.action) return;

                // Only intercept forms adding to cart (/cart/add/...)
                if (!form.action.includes('/cart/add/')) return;

                // Check if user clicked a "Buy Now" button (or buy_now action)
                const submitter = e.submitter;
                if (submitter) {
                    const submitVal = submitter.value || submitter.getAttribute('name');
                    if (submitVal === 'buy_now' || (submitter.getAttribute('name') === 'action' && submitter.value === 'buy_now')) {
                        // Allow normal submission to redirect directly to checkout!
                        return;
                    }
                }
                const actionInput = form.querySelector('input[name="action"]');
                if (actionInput && actionInput.value === 'buy_now') {
                    return;
                }

                // Prevent full-page reload and scrolling jump to top!
                e.preventDefault();

                const submitBtn = submitter || form.querySelector('button[type="submit"]');
                const origHtml = submitBtn ? submitBtn.innerHTML : null;

                if (submitBtn) {
                    submitBtn.disabled = true;
                    submitBtn.style.opacity = '0.85';
                }

                const formData = new FormData(form);
                const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || formData.get('_token');

                fetch(form.action, {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: formData
                })
                .then(async response => {
                    const data = await response.json().catch(() => ({}));
                    if (!response.ok) {
                        throw new Error(data.message || 'Sorry, could not add item to bag.');
                    }
                    return data;
                })
                .then(data => {
                    // 1. Update Cart Badges across the UI with bouncy pop animation
                    const badges = document.querySelectorAll('.cart-count-badge');
                    badges.forEach(b => {
                        b.textContent = data.cartCount;
                        b.classList.remove('animate-bounce');
                        void b.offsetWidth; // Reflow
                        b.classList.add('animate-bounce');
                    });

                    // 2. Micro-animation on the clicked button
                    if (submitBtn) {
                        submitBtn.classList.add('btn-success-flash');
                        submitBtn.innerHTML = `
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.8" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="20 6 9 17 4 12"></polyline>
                            </svg>
                            <span>Added!</span>
                        `;

                        setTimeout(() => {
                            submitBtn.classList.remove('btn-success-flash');
                            submitBtn.innerHTML = origHtml;
                            submitBtn.disabled = false;
                            submitBtn.style.opacity = '1';
                        }, 1400);
                    }

                    // 3. Trigger modern non-intrusive floating toast notification
                    showCartToast({
                        name: data.item?.name || 'Added to Bag',
                        meta: (data.item?.size ? `Size: ${data.item.size}` : '') + (data.item?.price ? ` • $${data.item.price}` : ''),
                        image: data.item?.image || null
                    });
                })
                .catch(err => {
                    if (submitBtn) {
                        submitBtn.disabled = false;
                        submitBtn.style.opacity = '1';
                        submitBtn.innerHTML = origHtml;
                    }
                    showCartToast({
                        isError: true,
                        name: err.message || 'Unable to add item to bag.'
                    });
                });
            });
        })();
    </script>

    <!-- Floating Notification Container -->
    <div id="toastContainer" class="toast-stack-container" aria-live="polite"></div>

    @yield('scripts')
</body>
</html>
