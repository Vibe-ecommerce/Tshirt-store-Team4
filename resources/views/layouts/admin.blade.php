<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin Portal') — THREADCRAFT Manager</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kantumruy+Pro:ital,wght@0,300..700;1,300..700&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --bg-body: #f8fafc;
            --bg-sidebar: #ffffff;
            --bg-card: #ffffff;
            --bg-card-hover: #f1f5f9;
            --bg-input: #ffffff;
            --accent-primary: #4f46e5;
            --accent-gradient: linear-gradient(135deg, #4f46e5 0%, #7c3aed 50%, #c026d3 100%);
            --text-main: #0f172a;
            --text-muted: #64748b;
            --text-sub: #334155;
            --border-subtle: #e2e8f0;
            --border-active: rgba(79, 70, 229, 0.4);
            --radius-sm: 8px;
            --radius-md: 12px;
            --radius-lg: 16px;
            --radius-full: 9999px;
            --shadow-card: 0 1px 3px rgba(0, 0, 0, 0.05), 0 6px 16px rgba(0, 0, 0, 0.03);
            --shadow-card-hover: 0 4px 6px -1px rgba(0, 0, 0, 0.06), 0 20px 25px -5px rgba(0, 0, 0, 0.05);
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Plus Jakarta Sans', 'Kantumruy Pro', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }

        body {
            background-color: var(--bg-body);
            color: var(--text-main);
            min-height: 100vh;
            display: flex;
            overflow-x: hidden;
        }

        h1, h2, h3, h4, h5, h6 {
            color: #0f172a;
            font-family: 'Plus Jakarta Sans', 'Kantumruy Pro', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            letter-spacing: -0.3px;
        }

        a {
            color: inherit;
            text-decoration: none;
        }

        /* Layout Grid */
        .admin-layout {
            display: flex;
            width: 100%;
            min-height: 100vh;
            background-color: var(--bg-body);
        }

        /* Sidebar */
        .admin-sidebar {
            width: 270px;
            background: var(--bg-sidebar);
            border-right: 1px solid var(--border-subtle);
            display: flex;
            flex-direction: column;
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            z-index: 50;
            overflow: hidden !important;
            box-shadow: 1px 0 3px rgba(0, 0, 0, 0.02);
            scrollbar-width: none !important;
            -ms-overflow-style: none !important;
        }

        .admin-sidebar::-webkit-scrollbar {
            display: none !important;
            width: 0 !important;
            height: 0 !important;
        }

        .sidebar-brand {
            padding: 13px 18px;
            display: flex;
            align-items: center;
            gap: 10px;
            border-bottom: 1px solid var(--border-subtle);
            background: #ffffff;
            flex-shrink: 0;
        }

        .brand-badge {
            width: 34px;
            height: 34px;
            border-radius: 10px;
            background: var(--accent-gradient);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #ffffff;
            box-shadow: 0 3px 10px rgba(79, 70, 229, 0.3);
            flex-shrink: 0;
            transition: transform 0.25s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.25s;
        }

        .sidebar-brand:hover .brand-badge {
            transform: scale(1.05) rotate(-2deg);
            box-shadow: 0 6px 20px rgba(79, 70, 229, 0.5);
        }

        .brand-badge svg {
            width: 18px;
            height: 18px;
            stroke-width: 2.2;
        }

        .brand-info {
            display: flex;
            flex-direction: column;
            line-height: 1.15;
        }

        .brand-name {
            font-size: 1.05rem;
            font-weight: 800;
            letter-spacing: -0.3px;
            color: var(--text-main);
        }

        .brand-subtitle {
            font-size: 0.62rem;
            font-weight: 800;
            letter-spacing: 1px;
            color: var(--accent-primary);
            text-transform: uppercase;
            margin-top: 1px;
        }

        .sidebar-nav {
            padding: 6px 10px;
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 1.5px;
            flex: 1;
            overflow-y: auto;
            overflow-x: hidden;
            scrollbar-width: none !important;
            -ms-overflow-style: none !important;
        }

        .sidebar-nav::-webkit-scrollbar {
            display: none !important;
            width: 0 !important;
            height: 0 !important;
        }

        .nav-label {
            font-size: 0.62rem;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            color: #94a3b8;
            padding: 7px 10px 2px;
            font-weight: 800;
            user-select: none;
        }

        .sidebar-link {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 5.5px 10px;
            border-radius: var(--radius-sm);
            font-size: 0.82rem;
            font-weight: 600;
            color: #475569;
            transition: all 0.18s cubic-bezier(0.16, 1, 0.3, 1);
            position: relative;
        }

        .sidebar-link:hover {
            background: #f1f5f9;
            color: var(--text-main);
            transform: translateX(2px);
        }

        .sidebar-link.active {
            background: #eef2ff;
            color: var(--accent-primary);
            border-left: 3px solid var(--accent-primary);
            font-weight: 750;
            box-shadow: none;
        }

        .link-left {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        /* Modern Crisp Vector Nav Icons */
        .nav-icon {
            width: 20px;
            height: 20px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: #64748b;
            transition: all 0.18s ease;
            flex-shrink: 0;
        }

        .nav-icon svg {
            width: 19px;
            height: 19px;
            stroke: currentColor;
            fill: none;
            stroke-width: 1.9;
            stroke-linecap: round;
            stroke-linejoin: round;
            transition: all 0.18s ease;
        }

        .sidebar-link:hover .nav-icon {
            color: var(--text-main);
            transform: scale(1.08);
        }

        .sidebar-link.active .nav-icon {
            color: var(--accent-primary);
            filter: none;
            transform: scale(1.08);
        }

        /* Sidebar Footer Executive Profile Card */
        .sidebar-footer {
            padding: 8px 10px;
            border-top: 1px solid var(--border-subtle);
            background: #ffffff;
            margin-top: auto;
            flex-shrink: 0;
        }

        .sidebar-profile-card {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            padding: 7px 9px;
            display: flex;
            flex-direction: column;
            gap: 6px;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.02);
            transition: all 0.2s ease;
        }

        .sidebar-profile-card:hover {
            border-color: #cbd5e1;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.03);
        }

        .profile-card-header {
            display: flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
            color: inherit;
        }

        .profile-avatar-wrap {
            position: relative;
            width: 32px;
            height: 32px;
            flex-shrink: 0;
        }

        .profile-avatar-img {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            object-fit: cover;
            border: 1.5px solid #ffffff;
            box-shadow: 0 1px 4px rgba(0, 0, 0, 0.1);
            display: block;
        }

        .profile-avatar-fallback {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: var(--accent-gradient);
            color: #ffffff;
            font-weight: 800;
            font-size: 0.82rem;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 1px 4px rgba(79, 70, 229, 0.3);
            border: 1.5px solid #ffffff;
        }

        .profile-online-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: #10b981;
            border: 1.5px solid #ffffff;
            position: absolute;
            bottom: -1px;
            right: -1px;
            box-shadow: 0 0 4px rgba(16, 185, 129, 0.6);
            animation: pulse-dot 2.2s infinite ease-in-out;
        }

        .profile-meta {
            display: flex;
            flex-direction: column;
            line-height: 1.15;
            overflow: hidden;
            flex: 1;
        }

        .profile-name {
            font-size: 0.80rem;
            font-weight: 850;
            color: #0f172a;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .profile-email {
            font-size: 0.67rem;
            color: #64748b;
            font-weight: 600;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            margin-top: 1px;
        }

        .profile-card-actions {
            display: flex;
            align-items: center;
            gap: 6px;
            padding-top: 6px;
            border-top: 1px solid #e2e8f0;
        }

        .profile-action-btn {
            flex: 1;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 4px;
            padding: 4.5px 8px;
            border-radius: 6px;
            background: #ffffff;
            border: 1px solid #cbd5e1;
            color: #334155;
            font-size: 0.72rem;
            font-weight: 750;
            text-decoration: none;
            transition: all 0.2s ease;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.02);
        }

        .profile-action-btn:hover {
            background: #f1f5f9;
            color: #0f172a;
            border-color: #94a3b8;
        }

        .profile-logout-btn {
            width: 100%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 4px;
            padding: 4.5px 8px;
            border-radius: 6px;
            background: #fff1f2;
            border: 1px solid #fecdd3;
            color: #e11d48;
            font-size: 0.72rem;
            font-weight: 750;
            cursor: pointer;
            transition: all 0.2s ease;
            box-shadow: 0 1px 2px rgba(225, 29, 72, 0.05);
        }

        .profile-logout-btn:hover {
            background: #ffe4e6;
            color: #be123c;
            border-color: #fda4af;
            transform: translateY(-1px);
        }

        /* Main Workspace */
        .admin-main {
            margin-left: 270px;
            flex: 1;
            display: flex;
            flex-direction: column;
            min-width: 0;
            background-color: var(--bg-body);
        }

        @media (max-width: 900px) {
            .admin-sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s ease;
            }
            .admin-main {
                margin-left: 0;
            }
        }

        /* Top Header */
        .admin-header {
            height: 70px;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(16px);
            border-bottom: 1px solid var(--border-subtle);
            padding: 0 32px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 40;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.03);
        }

        .header-title {
            font-size: 1.25rem;
            font-weight: 800;
            color: var(--text-main);
            letter-spacing: -0.3px;
        }

        .header-actions {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .store-pill {
            display: flex;
            align-items: center;
            gap: 8px;
            background: #ffffff;
            border: 1px solid var(--border-subtle);
            padding: 7px 14px;
            border-radius: var(--radius-full);
            font-size: 0.82rem;
            font-weight: 600;
            color: var(--text-sub);
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.03);
            transition: all 0.2s;
        }

        .store-pill:hover {
            background: #f8fafc;
            color: var(--accent-primary);
            border-color: #cbd5e1;
        }

        .user-dropdown-btn {
            display: flex;
            align-items: center;
            gap: 10px;
            background: transparent;
            border: none;
            color: var(--text-main);
            cursor: pointer;
            font-weight: 700;
            font-size: 0.88rem;
        }

        .avatar-sm {
            width: 34px;
            height: 34px;
            border-radius: var(--radius-full);
            background: var(--accent-gradient);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.85rem;
            font-weight: 800;
            color: #ffffff !important;
        }

        /* Workspace Content */
        .admin-content {
            padding: 32px;
            flex: 1;
        }

        /* Alerts */
        .flash-box {
            padding: 12px 18px;
            border-radius: var(--radius-md);
            margin-bottom: 24px;
            font-size: 0.9rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .flash-success {
            background: #ecfdf5;
            border: 1px solid #a7f3d0;
            color: #065f46;
        }

        .flash-error {
            background: #fef2f2;
            border: 1px solid #fecaca;
            color: #991b1b;
        }

        /* Common Elements */
        .btn-primary {
            background: var(--accent-gradient);
            color: #ffffff !important;
            padding: 9px 20px;
            border-radius: var(--radius-full);
            font-size: 0.88rem;
            font-weight: 700;
            border: none;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            box-shadow: 0 2px 8px rgba(79, 70, 229, 0.35);
            transition: all 0.2s ease;
        }

        .btn-primary:hover {
            opacity: 0.95;
            transform: translateY(-1px);
            box-shadow: 0 4px 14px rgba(79, 70, 229, 0.45);
        }

        .btn-outline {
            border: 1px solid var(--border-subtle);
            color: var(--text-main);
            padding: 8px 16px;
            border-radius: var(--radius-full);
            font-size: 0.88rem;
            font-weight: 600;
            background: #ffffff;
            cursor: pointer;
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.04);
        }

        .btn-outline:hover {
            background: #f8fafc;
            border-color: #cbd5e1;
            color: var(--accent-primary);
        }

        .badge-status {
            padding: 4px 10px;
            border-radius: var(--radius-full);
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.4px;
        }

        .badge-green { background: #dcfce7; color: #15803d; border: 1px solid #bbf7d0; }
        .badge-yellow { background: #fef9c3; color: #a16207; border: 1px solid #fef08a; }
        .badge-blue { background: #e0e7ff; color: #4338ca; border: 1px solid #c7d2fe; }
        .badge-red { background: #fee2e2; color: #b91c1c; border: 1px solid #fecaca; }

        /* Data Tables */
        .table-card {
            background: var(--bg-card);
            border: 1px solid var(--border-subtle);
            border-radius: var(--radius-lg);
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        }

        .custom-table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
            font-size: 0.9rem;
        }

        .custom-table th {
            background: #f8fafc;
            padding: 15px 20px;
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 0.6px;
            color: #334155;
            border-bottom: 1.5px solid var(--border-subtle);
            font-weight: 800;
        }

        .custom-table td {
            padding: 16px 20px;
            border-bottom: 1px solid #f1f5f9;
            color: #1e293b;
            font-size: 0.92rem;
        }

        .custom-table tr:hover td {
            background: #f8fafc;
            color: #0f172a;
        }

        .custom-table tr:last-child td {
            border-bottom: none;
        }

        /* Cool Modal in Light Mode */
        .cool-modal-backdrop {
            position: fixed;
            inset: 0;
            background: rgba(15, 23, 42, 0.6);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
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
            border: 1px solid var(--border-subtle);
            border-radius: 24px;
            padding: 36px 32px 32px;
            max-width: 480px;
            width: 100%;
            position: relative;
            overflow: hidden;
            text-align: center;
            transform: scale(0.88) translateY(24px);
            transition: transform 0.32s cubic-bezier(0.34, 1.56, 0.64, 1);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
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
            color: var(--text-muted);
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s;
        }

        .cool-modal-close:hover {
            background: #e2e8f0;
            color: var(--text-main);
            transform: rotate(90deg);
        }

        .cool-modal-glow {
            position: absolute;
            top: -60px;
            left: 50%;
            transform: translateX(-50%);
            width: 220px;
            height: 220px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(239, 68, 68, 0.15) 0%, rgba(239, 68, 68, 0) 70%);
            pointer-events: none;
        }

        .cool-modal-card.type-warning .cool-modal-glow {
            background: radial-gradient(circle, rgba(245, 158, 11, 0.15) 0%, rgba(245, 158, 11, 0) 70%);
        }

        .cool-modal-card.type-info .cool-modal-glow {
            background: radial-gradient(circle, rgba(99, 102, 241, 0.15) 0%, rgba(99, 102, 241, 0) 70%);
        }

        .cool-modal-icon-wrap {
            width: 76px;
            height: 76px;
            border-radius: 24px;
            margin: 0 auto 20px;
            background: #fee2e2;
            border: 1px solid #fecaca;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.2rem;
            position: relative;
            animation: coolIconFloat 3s ease-in-out infinite;
        }

        .cool-modal-card.type-warning .cool-modal-icon-wrap {
            background: #fef3c7;
            border-color: #fde68a;
        }

        .cool-modal-card.type-info .cool-modal-icon-wrap {
            background: #e0e7ff;
            border-color: #c7d2fe;
        }

        .cool-modal-badge {
            display: inline-block;
            padding: 4px 14px;
            border-radius: 9999px;
            font-size: 0.72rem;
            font-weight: 800;
            letter-spacing: 0.8px;
            text-transform: uppercase;
            background: #fee2e2;
            color: #dc2626;
            border: 1px solid #fecaca;
            margin-bottom: 12px;
        }

        .cool-modal-card.type-warning .cool-modal-badge {
            background: #fef3c7;
            color: #d97706;
            border-color: #fde68a;
        }

        .cool-modal-card.type-info .cool-modal-badge {
            background: #e0e7ff;
            color: #4f46e5;
            border-color: #c7d2fe;
        }

        .cool-modal-title {
            font-size: 1.45rem;
            font-weight: 800;
            color: var(--text-main) !important;
            letter-spacing: -0.4px;
            margin-bottom: 8px;
        }

        .cool-modal-target {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            max-width: 90%;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            padding: 7px 16px;
            border-radius: 9999px;
            font-weight: 700;
            font-size: 0.85rem;
            color: var(--text-main) !important;
            margin: 4px auto 14px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .cool-modal-desc {
            font-size: 0.92rem;
            color: var(--text-muted) !important;
            line-height: 1.55;
            margin-bottom: 26px;
            padding: 0 8px;
        }

        .cool-modal-actions {
            display: flex;
            gap: 12px;
            justify-content: center;
        }

        .cool-modal-btn-cancel {
            flex: 1;
            padding: 13px 20px;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 14px;
            color: var(--text-sub);
            font-size: 0.92rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .cool-modal-btn-cancel:hover {
            background: #f1f5f9;
            color: var(--text-main);
            border-color: #cbd5e1;
            transform: translateY(-1px);
        }

        .cool-modal-btn-confirm {
            flex: 1.25;
            padding: 13px 22px;
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 50%, #b91c1c 100%);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 14px;
            color: #ffffff !important;
            font-size: 0.92rem;
            font-weight: 800;
            cursor: pointer;
            box-shadow: 0 4px 14px rgba(239, 68, 68, 0.35);
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .cool-modal-btn-confirm:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(239, 68, 68, 0.5);
            filter: brightness(1.05);
        }

        /* Global Headings & Typography */
        h1, h2, h3, h4, h5, h6 {
            color: var(--text-main);
        }

        /* Light Mode High-Contrast Overrides */
        .admin-main strong,
        .admin-main b {
            color: var(--text-main);
        }

        /* Override residual white text on light cards */
        .admin-content [style*="color:#ffffff"],
        .admin-content [style*="color: #ffffff"],
        .admin-content [style*="color:#fff"],
        .admin-content [style*="color: #fff"] {
            color: var(--text-main) !important;
        }

        /* Elements that must remain crisp white text */
        .btn-primary,
        .btn-primary *,
        .avatar-sm,
        .avatar-sm *,
        .brand-badge,
        .brand-badge *,
        .cool-modal-btn-confirm,
        .cool-modal-btn-confirm *,
        .badge-solid,
        .btn-executive-save-settings,
        .btn-executive-save-settings *,
        .settings-hero-banner,
        .settings-hero-banner * {
            color: #ffffff !important;
        }

        /* Standard Form Inputs in Light Mode */
        input:not([type="checkbox"]):not([type="radio"]):not([type="submit"]):not([type="button"]),
        select,
        textarea {
            background-color: #ffffff !important;
            border: 1px solid #cbd5e1 !important;
            color: #0f172a !important;
        }

        input:not([type="checkbox"]):not([type="radio"]):not([type="submit"]):not([type="button"]):focus,
        select:focus,
        textarea:focus {
            border-color: #6366f1 !important;
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.15) !important;
            outline: none;
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
<body>

    <div class="admin-layout">
        <!-- Sidebar with all 11 Sitemap Modules -->
        <aside class="admin-sidebar">
            <div class="sidebar-brand">
                <div class="brand-badge">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 2L3 7v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V7l-9-5z"/>
                        <path d="M9 12l2 2 4-4"/>
                    </svg>
                </div>
                <div class="brand-info">
                    <span class="brand-name">THREADCRAFT</span>
                    <span class="brand-subtitle">STORE STUDIO</span>
                </div>
            </div>

            <ul class="sidebar-nav">
                <!-- 1. DASHBOARD -->
                <li>
                    <a href="{{ route('admin.dashboard') }}" class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <span class="link-left">
                            <span class="nav-icon">
                                <svg viewBox="0 0 24 24">
                                    <rect x="3" y="3" width="7" height="9" rx="1.5"></rect>
                                    <rect x="14" y="3" width="7" height="5" rx="1.5"></rect>
                                    <rect x="14" y="12" width="7" height="9" rx="1.5"></rect>
                                    <rect x="3" y="16" width="7" height="5" rx="1.5"></rect>
                                </svg>
                            </span>
                            <span>Dashboard</span>
                        </span>
                    </a>
                </li>

                <!-- 2. PRODUCT MANAGEMENT -->
                <li class="nav-label">Catalog & Inventory</li>
                <li>
                    <a href="{{ route('admin.products.index') }}" class="sidebar-link {{ request()->routeIs('admin.products.index') ? 'active' : '' }}">
                        <span class="link-left">
                            <span class="nav-icon">
                                <svg viewBox="0 0 24 24">
                                    <path d="M20.38 3.46L16 2a4 4 0 0 1-8 0L3.62 3.46a2 2 0 0 0-1.34 2.23l.58 3.47a1 1 0 0 0 .99.84H6v10c0 1.1.9 2 2 2h8a2 2 0 0 0 2-2V10h2.15a1 1 0 0 0 .99-.84l.58-3.47a2 2 0 0 0-1.34-2.23z"></path>
                                </svg>
                            </span>
                            <span>All Products</span>
                        </span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.products.create') }}" class="sidebar-link {{ request()->routeIs('admin.products.create') ? 'active' : '' }}">
                        <span class="link-left">
                            <span class="nav-icon">
                                <svg viewBox="0 0 24 24">
                                    <circle cx="12" cy="12" r="9"></circle>
                                    <line x1="12" y1="8" x2="12" y2="16"></line>
                                    <line x1="8" y1="12" x2="16" y2="12"></line>
                                </svg>
                            </span>
                            <span>Add Product</span>
                        </span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.products.inventory') }}" class="sidebar-link {{ request()->routeIs('admin.products.inventory') ? 'active' : '' }}">
                        <span class="link-left">
                            <span class="nav-icon">
                                <svg viewBox="0 0 24 24">
                                    <path d="M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16Z"></path>
                                    <path d="m3.3 7 8.7 5 8.7-5"></path>
                                    <path d="M12 22V12"></path>
                                </svg>
                            </span>
                            <span>Inventory / Stock</span>
                        </span>
                    </a>
                </li>

                <!-- 3. ORDER MANAGEMENT -->
                <li class="nav-label">Fulfillment</li>
                <li>
                    <a href="{{ route('admin.orders.index') }}" class="sidebar-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                        <span class="link-left">
                            <span class="nav-icon">
                                <svg viewBox="0 0 24 24">
                                    <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path>
                                    <line x1="3" y1="6" x2="21" y2="6"></line>
                                    <path d="M16 10a4 4 0 0 1-8 0"></path>
                                </svg>
                            </span>
                            <span>Order Management</span>
                        </span>
                    </a>
                </li>

                <!-- 4. CUSTOMER MANAGEMENT -->
                <li>
                    <a href="{{ route('admin.customers.index') }}" class="sidebar-link {{ request()->routeIs('admin.customers.*') ? 'active' : '' }}">
                        <span class="link-left">
                            <span class="nav-icon">
                                <svg viewBox="0 0 24 24">
                                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="9" cy="7" r="4"></circle>
                                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                                    <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                                </svg>
                            </span>
                            <span>Customer Management</span>
                        </span>
                    </a>
                </li>

                <!-- 5. PAYMENT MANAGEMENT -->
                <li>
                    <a href="{{ route('admin.payments.index') }}" class="sidebar-link {{ request()->routeIs('admin.payments.*') ? 'active' : '' }}">
                        <span class="link-left">
                            <span class="nav-icon">
                                <svg viewBox="0 0 24 24">
                                    <rect x="2" y="5" width="20" height="14" rx="2"></rect>
                                    <line x1="2" y1="10" x2="22" y2="10"></line>
                                    <circle cx="7" cy="15" r="1.2" fill="currentColor"></circle>
                                    <line x1="12" y1="15" x2="16" y2="15"></line>
                                </svg>
                            </span>
                            <span>Payment Management</span>
                        </span>
                    </a>
                </li>

                <!-- 6. PROMOTION / DISCOUNT -->
                <li class="nav-label">Marketing</li>
                <li>
                    <a href="{{ route('admin.promotions.index') }}" class="sidebar-link {{ request()->routeIs('admin.promotions.*') ? 'active' : '' }}">
                        <span class="link-left">
                            <span class="nav-icon">
                                <svg viewBox="0 0 24 24">
                                    <path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"></path>
                                    <line x1="7" y1="7" x2="7.01" y2="7"></line>
                                </svg>
                            </span>
                            <span>Promotion / Discount</span>
                        </span>
                    </a>
                </li>

                <!-- 7. REVIEW MANAGEMENT -->
                <li>
                    <a href="{{ route('admin.reviews.index') }}" class="sidebar-link {{ request()->routeIs('admin.reviews.*') ? 'active' : '' }}">
                        <span class="link-left">
                            <span class="nav-icon">
                                <svg viewBox="0 0 24 24">
                                    <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                                </svg>
                            </span>
                            <span>Review Management</span>
                        </span>
                    </a>
                </li>

                <!-- 8. CONTENT MANAGEMENT -->
                <li>
                    <a href="{{ route('admin.content.index') }}" class="sidebar-link {{ request()->routeIs('admin.content.*') ? 'active' : '' }}">
                        <span class="link-left">
                            <span class="nav-icon">
                                <svg viewBox="0 0 24 24">
                                    <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                                    <circle cx="8.5" cy="8.5" r="1.5"></circle>
                                    <polyline points="21 15 16 10 5 21"></polyline>
                                </svg>
                            </span>
                            <span>Content Management</span>
                        </span>
                    </a>
                </li>

                <!-- 9. REPORTS -->
                <li class="nav-label">Analytics</li>
                <li>
                    <a href="{{ route('admin.reports.index') }}" class="sidebar-link {{ request()->routeIs('admin.reports.*') ? 'active' : '' }}">
                        <span class="link-left">
                            <span class="nav-icon">
                                <svg viewBox="0 0 24 24">
                                    <line x1="18" y1="20" x2="18" y2="10"></line>
                                    <line x1="12" y1="20" x2="12" y2="4"></line>
                                    <line x1="6" y1="20" x2="6" y2="14"></line>
                                    <line x1="2" y1="20" x2="22" y2="20"></line>
                                </svg>
                            </span>
                            <span>Reports & Sales</span>
                        </span>
                    </a>
                </li>

                <!-- 10. ADMIN ACCOUNT & 11. SETTINGS -->
                <li class="nav-label">System</li>
                <li>
                    <a href="{{ route('admin.account.profile') }}" class="sidebar-link {{ request()->routeIs('admin.account.*') ? 'active' : '' }}">
                        <span class="link-left">
                            <span class="nav-icon">
                                <svg viewBox="0 0 24 24">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="12" cy="7" r="4"></circle>
                                </svg>
                            </span>
                            <span>Admin Account</span>
                        </span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.settings.index') }}" class="sidebar-link {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
                        <span class="link-left">
                            <span class="nav-icon">
                                <svg viewBox="0 0 24 24">
                                    <circle cx="12" cy="12" r="3"></circle>
                                    <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path>
                                </svg>
                            </span>
                            <span>Settings</span>
                        </span>
                    </a>
                </li>
            </ul>

            <div class="sidebar-footer">
                <div class="sidebar-profile-card">
                    <a href="{{ route('admin.account.profile') }}" class="profile-card-header" title="Manage Profile & Account">
                        <div class="profile-avatar-wrap">
                            @if (Auth::user() && Auth::user()->avatar)
                                <img src="{{ asset(Auth::user()->avatar) }}" alt="{{ Auth::user()->name }}" class="profile-avatar-img">
                            @else
                                <div class="profile-avatar-fallback">{{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}</div>
                            @endif
                            <span class="profile-online-dot" title="Active Administrator Session"></span>
                        </div>
                        <div class="profile-meta">
                            <span class="profile-name">{{ Auth::user()->name ?? 'Admin Manager' }}</span>
                            <span class="profile-email">{{ Auth::user()->email ?? 'admin@tshirtstore.com' }}</span>
                        </div>
                    </a>

                    <div class="profile-card-actions">
                        <a href="{{ route('admin.account.profile') }}" class="profile-action-btn" title="Admin Account Settings">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                            <span>Profile</span>
                        </a>

                        <form action="{{ route('logout') }}" method="POST"
                            style="margin:0; flex:1;"
                            data-confirm="Are you sure you want to end your administrator session? Any unsaved edits in store management will be lost."
                            data-confirm-title="Log Out of Admin Panel?"
                            data-confirm-badge="ADMIN SESSION"
                            data-confirm-btn="Yes, Log Out"
                            data-confirm-type="warning"
                            data-confirm-icon="log-out">
                            @csrf
                            <button type="submit" class="profile-logout-btn" title="Sign out of Admin Panel">
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2">
                                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                                    <polyline points="16 17 21 12 16 7"></polyline>
                                    <line x1="21" y1="12" x2="9" y2="12"></line>
                                </svg>
                                <span>Logout</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Main Workspace -->
        <main class="admin-main">
            <!-- Top Header -->
            <header class="admin-header">
                <div class="header-title">@yield('page-title', 'Overview')</div>

                <div class="header-actions">
                    <a href="{{ route('home') }}" target="_blank" class="store-pill" title="Open storefront in new tab">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10"></circle>
                            <line x1="2" y1="12" x2="22" y2="12"></line>
                            <path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path>
                        </svg>
                        <span>View Storefront</span>
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="7" y1="17" x2="17" y2="7"></line>
                            <polyline points="7 7 17 7 17 17"></polyline>
                        </svg>
                    </a>

                    <a href="{{ route('admin.account.profile') }}" style="display:flex; align-items:center; gap:10px; text-decoration:none; color:inherit; padding:5px 12px; border-radius:var(--radius-md); background:#ffffff; border:1px solid var(--border-subtle); box-shadow:0 1px 2px rgba(0,0,0,0.03); transition:all 0.2s;" title="Manage Admin Profile & Account">
                        <div class="avatar-sm" style="overflow:hidden; padding:1.5px; background:var(--accent-gradient);">
                            @if (Auth::user() && Auth::user()->avatar)
                                <img src="{{ asset(Auth::user()->avatar) }}" alt="{{ Auth::user()->name }}" style="width:100%; height:100%; border-radius:50%; object-fit:cover; display:block;">
                            @else
                                <span style="color:#ffffff;">{{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}</span>
                            @endif
                        </div>
                        <div style="display:flex; flex-direction:column; line-height:1.2;">
                            <span style="font-weight:750; font-size:0.88rem; color:var(--text-main);">{{ Auth::user()->name ?? 'Admin' }}</span>
                            <span style="font-size:0.75rem; color:var(--accent-primary); font-family:'JetBrains Mono', monospace;">{{ Auth::user()->email ?? '' }}</span>
                        </div>
                    </a>
                </div>
            </header>

            <!-- Content Area -->
            <div class="admin-content">
                @if (session('success'))
                    <div class="flash-box flash-success">
                        <span>✓ {{ session('success') }}</span>
                        <button type="button" onclick="this.parentElement.remove()" style="background:none; border:none; color:inherit; cursor:pointer;">✕</button>
                    </div>
                @endif

                @if (session('error'))
                    <div class="flash-box flash-error">
                        <span>✕ {{ session('error') }}</span>
                        <button type="button" onclick="this.parentElement.remove()" style="background:none; border:none; color:inherit; cursor:pointer;">✕</button>
                    </div>
                @endif

                @yield('content')
            </div>
        </main>
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
                <span id="coolModalIcon">
                    <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M3 6h18"></path>
                        <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"></path>
                        <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"></path>
                    </svg>
                </span>
            </div>

            <!-- Action Badge -->
            <div class="cool-modal-badge" id="coolModalBadge">SECURITY ACTION</div>

            <!-- Title -->
            <h3 class="cool-modal-title" id="coolModalTitle">Are you sure?</h3>

            <!-- Highlighted Target Item (e.g. Product Name) -->
            <div>
                <div class="cool-modal-target" id="coolModalTarget" style="display:none;"></div>
            </div>

            <!-- Detailed Message -->
            <p class="cool-modal-desc" id="coolModalMessage">This action cannot be undone and will permanently modify store data.</p>

            <!-- Action Buttons -->
            <div class="cool-modal-actions">
                <button type="button" class="cool-modal-btn-cancel" id="coolModalCancelBtn" onclick="closeCoolConfirm()">
                    Keep / Cancel
                </button>
                <button type="button" class="cool-modal-btn-confirm" id="coolModalConfirmBtn">
                    <span id="coolModalConfirmIcon">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="20 6 9 17 4 12"></polyline>
                        </svg>
                    </span>
                    <span id="coolModalConfirmText">Confirm</span>
                </button>
            </div>
        </div>
    </div>

    <script>
        let currentConfirmCallback = null;

        window.openCoolConfirm = function(options) {
            const modal = document.getElementById('coolConfirmModal');
            if (!modal) return;

            const card = modal.querySelector('.cool-modal-card');
            const titleEl = document.getElementById('coolModalTitle');
            const messageEl = document.getElementById('coolModalMessage');
            const targetEl = document.getElementById('coolModalTarget');
            const badgeEl = document.getElementById('coolModalBadge');
            const iconEl = document.getElementById('coolModalIcon');
            const confirmBtn = document.getElementById('coolModalConfirmBtn');
            const confirmTextEl = document.getElementById('coolModalConfirmText');
            const confirmIconEl = document.getElementById('coolModalConfirmIcon');

            // Reset type modifiers
            card.classList.remove('type-danger', 'type-warning', 'type-info');
            const type = options.type || 'danger';
            card.classList.add('type-' + type);

            titleEl.textContent = options.title || 'Are you sure?';
            messageEl.textContent = options.message || 'This action cannot be undone and will permanently alter store data.';
            badgeEl.textContent = options.badge || (type === 'danger' ? 'DESTRUCTIVE ACTION' : 'ACTION REQUIRED');

            // Crisp SVG Modal Icons
            const trashSvg = `<svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"></path><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"></path><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>`;
            const warnSvg = `<svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3Z"></path><line x1="12" y1="9" x2="12" y2="13"></line><line x1="12" y1="17" x2="12.01" y2="17"></line></svg>`;
            const logoutSvg = `<svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>`;
            const infoSvg = `<svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg>`;

            if (options.icon === 'log-out' || options.icon === '🚪') {
                iconEl.innerHTML = logoutSvg;
            } else if (options.icon === 'trash' || options.icon === '🗑️' || type === 'danger') {
                iconEl.innerHTML = trashSvg;
            } else if (options.icon && options.icon.includes('<svg')) {
                iconEl.innerHTML = options.icon;
            } else if (type === 'warning') {
                iconEl.innerHTML = warnSvg;
            } else {
                iconEl.innerHTML = infoSvg;
            }

            if (options.item) {
                targetEl.textContent = options.item;
                targetEl.style.display = 'inline-flex';
            } else {
                targetEl.style.display = 'none';
            }

            confirmTextEl.textContent = options.confirmText || 'Yes, Proceed';
            confirmIconEl.textContent = options.confirmIcon || (type === 'danger' ? '🗑️' : '✓');
            const cancelBtn = document.getElementById('coolModalCancelBtn');
            if (cancelBtn) {
                cancelBtn.textContent = options.cancelText || 'Keep / Cancel';
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

            // Universal Auto-Upgrade for any form with confirm(...) or data-confirm
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
                                         form.action.includes('destroy') ||
                                         form.action.includes('delete') ||
                                         form.querySelector('input[name="_method"][value="DELETE"]');

                        const isRefund = form.action.includes('refund');

                        let title = 'Confirm Action';
                        let type = 'danger';
                        let icon = '🗑️';
                        let badge = 'IRREVERSIBLE ACTION';
                        let confirmText = 'Yes, Confirm';
                        let cancelText = 'Keep / Cancel';
                        let defaultMessage = 'Are you sure you want to perform this action?';

                        if (isLogout) {
                            title = 'Log Out of Admin Panel?';
                            type = 'warning';
                            icon = '🚪';
                            badge = 'ADMIN SESSION';
                            confirmText = 'Yes, Log Out';
                            cancelText = 'Stay Logged In';
                            defaultMessage = 'Are you sure you want to end your administrator session? Unsaved store modifications will not be saved.';
                        } else if (isDelete) {
                            title = 'Delete Permanently?';
                            type = 'danger';
                            icon = '🗑️';
                            badge = 'CATALOG DELETION';
                            confirmText = 'Yes, Delete Now';
                            cancelText = 'Keep / Cancel';
                            defaultMessage = 'This action cannot be undone and will permanently remove this record.';
                        } else if (isRefund) {
                            title = 'Issue Customer Refund?';
                            type = 'warning';
                            icon = '💸';
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
        });
    </script>

    @yield('scripts')
</body>
</html>
