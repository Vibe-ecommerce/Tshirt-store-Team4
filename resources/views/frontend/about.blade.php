@extends('layouts.store')

@section('title', 'About Us — The Architectural Apparel Atelier | T-Shirt Online')

@section('styles')
<style>
    /* ==========================================================================
       ABOUT PAGE - MODERN HIGH-FASHION ATELIER DESIGN SYSTEM (LIGHT THEME)
       ========================================================================== */

    .about-page-wrapper {
        position: relative;
        overflow: hidden;
        padding-bottom: 100px;
    }

    /* Ambient Atmosphere Glow Orbs */
    .ambient-glow-orb {
        position: absolute;
        border-radius: 50%;
        pointer-events: none;
        z-index: 0;
        filter: blur(100px);
        opacity: 0.6;
    }

    .orb-1 {
        top: 20px;
        left: 5%;
        width: 550px;
        height: 550px;
        background: radial-gradient(circle, rgba(99, 102, 241, 0.08) 0%, rgba(139, 92, 246, 0.04) 70%, transparent 100%);
        animation: floatOrb 12s ease-in-out infinite alternate;
    }

    .orb-2 {
        top: 40%;
        right: 2%;
        width: 600px;
        height: 600px;
        background: radial-gradient(circle, rgba(56, 189, 248, 0.08) 0%, rgba(99, 102, 241, 0.03) 65%, transparent 100%);
        animation: floatOrb 15s ease-in-out infinite alternate-reverse;
    }

    .orb-3 {
        bottom: 10%;
        left: 15%;
        width: 500px;
        height: 500px;
        background: radial-gradient(circle, rgba(16, 185, 129, 0.06) 0%, transparent 70%);
    }

    @keyframes floatOrb {
        0% { transform: translate(0, 0) scale(1); }
        50% { transform: translate(25px, -30px) scale(1.08); }
        100% { transform: translate(-20px, 20px) scale(0.95); }
    }

    /* Container Standard */
    .about-container {
        max-width: 1240px;
        margin: 0 auto;
        padding: 0 24px;
        position: relative;
        z-index: 2;
    }

    /* --------------------------------------------------------------------------
       1. HERO SECTION
       -------------------------------------------------------------------------- */
    .about-hero {
        padding: 70px 24px 50px;
        text-align: center;
        position: relative;
        z-index: 2;
    }

    .atelier-pill-badge {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        background: #eff6ff;
        border: 1px solid #bfdbfe;
        color: #1e40af;
        padding: 8px 22px;
        border-radius: var(--radius-full);
        font-size: 0.8rem;
        font-weight: 800;
        letter-spacing: 1px;
        text-transform: uppercase;
        margin-bottom: 26px;
        box-shadow: 0 2px 8px rgba(37, 99, 235, 0.08);
    }

    .pulse-dot-indigo {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: #2563eb;
        box-shadow: 0 0 10px rgba(37, 99, 235, 0.6);
        animation: pulseIndigo 2s infinite ease-in-out;
    }

    @keyframes pulseIndigo {
        0%, 100% { transform: scale(1); opacity: 1; }
        50% { transform: scale(1.4); opacity: 0.5; }
    }

    .hero-title {
        font-size: clamp(2.8rem, 6vw, 4.4rem);
        font-weight: 900;
        line-height: 1.15;
        letter-spacing: -1.6px;
        margin-bottom: 22px;
        color: #0f172a;
    }

    .hero-lead-text {
        color: #475569;
        font-size: clamp(1.05rem, 1.8vw, 1.2rem);
        max-width: 780px;
        margin: 0 auto 38px;
        line-height: 1.75;
    }

    .hero-action-buttons {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 16px;
        flex-wrap: wrap;
        margin-bottom: 60px;
    }

    .btn-gradient-glow {
        background: #0f172a;
        color: #ffffff;
        font-weight: 750;
        font-size: 0.96rem;
        padding: 14px 32px;
        border-radius: var(--radius-full);
        display: inline-flex;
        align-items: center;
        gap: 10px;
        box-shadow: 0 8px 22px rgba(15, 23, 42, 0.16);
        transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
        border: none;
        cursor: pointer;
        text-decoration: none;
    }

    .btn-gradient-glow:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 28px rgba(15, 23, 42, 0.25);
        background: #000000;
        color: #ffffff;
    }

    .btn-glass-subtle {
        background: #ffffff;
        border: 1px solid #cbd5e1;
        color: #0f172a;
        font-weight: 700;
        font-size: 0.96rem;
        padding: 14px 28px;
        border-radius: var(--radius-full);
        display: inline-flex;
        align-items: center;
        gap: 8px;
        box-shadow: 0 2px 8px rgba(15, 23, 42, 0.04);
        transition: all 0.25s ease;
        text-decoration: none;
    }

    .btn-glass-subtle:hover {
        background: #f8fafc;
        border-color: #94a3b8;
        transform: translateY(-2px);
        color: #0f172a;
    }

    /* --------------------------------------------------------------------------
       2. METRICS STRIP
       -------------------------------------------------------------------------- */
    .metrics-bar-wrap {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 24px;
        padding: 34px 28px;
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
        box-shadow: 0 10px 30px -10px rgba(15, 23, 42, 0.06);
        margin-bottom: 90px;
    }

    @media (max-width: 900px) {
        .metrics-bar-wrap {
            grid-template-columns: repeat(2, 1fr);
            gap: 24px;
        }
    }

    @media (max-width: 520px) {
        .metrics-bar-wrap {
            grid-template-columns: 1fr;
            padding: 24px 20px;
        }
    }

    .metric-card-item {
        text-align: center;
        padding: 10px 16px;
        position: relative;
    }

    .metric-card-item:not(:last-child)::after {
        content: '';
        position: absolute;
        right: 0;
        top: 20%;
        height: 60%;
        width: 1px;
        background: #e2e8f0;
    }

    @media (max-width: 900px) {
        .metric-card-item:nth-child(2)::after {
            display: none;
        }
    }

    @media (max-width: 520px) {
        .metric-card-item::after {
            display: none !important;
        }
    }

    .metric-number {
        font-size: clamp(2rem, 3.5vw, 2.8rem);
        font-weight: 900;
        line-height: 1.1;
        margin-bottom: 6px;
        color: #0f172a;
        letter-spacing: -0.03em;
    }

    .metric-label {
        font-size: 0.95rem;
        font-weight: 800;
        color: #1e293b;
        margin-bottom: 4px;
    }

    .metric-sub {
        font-size: 0.82rem;
        color: #64748b;
    }

    /* --------------------------------------------------------------------------
       3. EDITORIAL SPLIT: STORY & ATELIER
       -------------------------------------------------------------------------- */
    .story-split-section {
        display: grid;
        grid-template-columns: 1.05fr 0.95fr;
        gap: 60px;
        align-items: center;
        margin-bottom: 120px;
    }

    @media (max-width: 960px) {
        .story-split-section {
            grid-template-columns: 1fr;
            gap: 40px;
        }
    }

    .editorial-media-wrapper {
        position: relative;
        border-radius: 24px;
        overflow: hidden;
        border: 1px solid #e2e8f0;
        box-shadow: 0 20px 45px -12px rgba(15, 23, 42, 0.1);
    }

    .editorial-media-wrapper img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
        transition: transform 0.6s cubic-bezier(0.16, 1, 0.3, 1);
    }

    .editorial-media-wrapper:hover img {
        transform: scale(1.04);
    }

    .media-badge-floating {
        position: absolute;
        bottom: 24px;
        left: 24px;
        background: rgba(15, 23, 42, 0.9);
        border: 1px solid rgba(255, 255, 255, 0.18);
        backdrop-filter: blur(12px);
        border-radius: 14px;
        padding: 14px 20px;
        display: flex;
        align-items: center;
        gap: 14px;
        max-width: calc(100% - 48px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.4);
    }

    .media-badge-icon {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        background: rgba(99, 102, 241, 0.25);
        color: #a5b4fc;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        flex-shrink: 0;
    }

    .media-badge-text h4 {
        font-size: 0.92rem;
        font-weight: 750;
        color: #ffffff;
        margin-bottom: 2px;
    }

    .media-badge-text p {
        font-size: 0.78rem;
        color: #cbd5e1;
        margin: 0;
    }

    .section-eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        font-size: 0.8rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 1.2px;
        color: #2563eb;
        margin-bottom: 14px;
    }

    .section-headline {
        font-size: clamp(2rem, 3.8vw, 3rem);
        font-weight: 850;
        line-height: 1.2;
        letter-spacing: -1px;
        color: #0f172a;
        margin-bottom: 24px;
    }

    .story-paragraph {
        font-size: 1.05rem;
        line-height: 1.75;
        color: #475569;
        margin-bottom: 20px;
    }

    .quote-callout-card {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-left: 4px solid #2563eb;
        border-radius: 0 16px 16px 0;
        padding: 24px;
        margin: 28px 0;
    }

    .quote-callout-card p {
        font-style: italic;
        color: #1e293b;
        font-size: 1.02rem;
        line-height: 1.6;
        margin-bottom: 12px;
    }

    .quote-author {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .quote-author-info h5 {
        font-size: 0.92rem;
        font-weight: 800;
        color: #0f172a;
    }

    .quote-author-info span {
        font-size: 0.78rem;
        color: #64748b;
    }

    /* --------------------------------------------------------------------------
       4. MATERIAL MASTERY: THE 240 GSM DEEP-DIVE
       -------------------------------------------------------------------------- */
    .mastery-section {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 32px;
        padding: 70px 50px;
        margin-bottom: 120px;
        position: relative;
        overflow: hidden;
        box-shadow: 0 4px 20px rgba(15, 23, 42, 0.02);
    }

    @media (max-width: 768px) {
        .mastery-section {
            padding: 40px 24px;
        }
    }

    .mastery-header {
        text-align: center;
        max-width: 700px;
        margin: 0 auto 50px;
    }

    .mastery-grid {
        display: grid;
        grid-template-columns: 1fr 1.1fr;
        gap: 50px;
        align-items: center;
    }

    @media (max-width: 960px) {
        .mastery-grid {
            grid-template-columns: 1fr;
            gap: 40px;
        }
    }

    .spec-points-list {
        display: flex;
        flex-direction: column;
        gap: 22px;
    }

    .spec-point-item {
        display: flex;
        align-items: flex-start;
        gap: 18px;
        background: #ffffff;
        border: 1px solid #e2e8f0;
        padding: 20px;
        border-radius: 16px;
        transition: all 0.25s ease;
        box-shadow: 0 2px 8px rgba(15, 23, 42, 0.02);
    }

    .spec-point-item:hover {
        background: #ffffff;
        border-color: #cbd5e1;
        transform: translateX(4px);
        box-shadow: 0 8px 24px rgba(15, 23, 42, 0.06);
    }

    .spec-icon-box {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        background: #eff6ff;
        border: 1px solid #bfdbfe;
        color: #2563eb;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
        flex-shrink: 0;
    }

    .spec-point-content h4 {
        font-size: 1.05rem;
        font-weight: 800;
        color: #0f172a;
        margin-bottom: 4px;
    }

    .spec-point-content p {
        font-size: 0.9rem;
        color: #64748b;
        line-height: 1.55;
        margin: 0;
    }

    .fabric-visual-card {
        position: relative;
        border-radius: 24px;
        overflow: hidden;
        border: 1px solid #e2e8f0;
        box-shadow: 0 16px 36px rgba(15, 23, 42, 0.08);
    }

    .fabric-visual-card img {
        width: 100%;
        height: auto;
        display: block;
        transition: transform 0.6s ease;
    }

    .fabric-visual-card:hover img {
        transform: scale(1.05);
    }

    .fabric-specs-overlay {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        background: linear-gradient(180deg, transparent 0%, rgba(10, 14, 23, 0.92) 80%);
        padding: 30px 24px 24px;
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 12px;
        text-align: center;
    }

    .overlay-spec-tag {
        background: rgba(255, 255, 255, 0.12);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: var(--radius-sm);
        padding: 8px 10px;
    }

    .overlay-spec-tag span {
        display: block;
        font-size: 0.68rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #cbd5e1;
        margin-bottom: 2px;
    }

    .overlay-spec-tag strong {
        font-size: 0.88rem;
        color: #ffffff;
    }

    /* --------------------------------------------------------------------------
       5. FOUR PILLARS OF RESPONSIBLE CRAFT
       -------------------------------------------------------------------------- */
    .pillars-section {
        margin-bottom: 120px;
    }

    .section-center-header {
        text-align: center;
        max-width: 680px;
        margin: 0 auto 55px;
    }

    .pillars-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(270px, 1fr));
        gap: 24px;
    }

    .pillar-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 20px;
        padding: 34px 28px;
        position: relative;
        transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        box-shadow: 0 4px 18px rgba(15, 23, 42, 0.03);
    }

    .pillar-card:hover {
        transform: translateY(-6px);
        border-color: #cbd5e1;
        box-shadow: 0 16px 36px rgba(15, 23, 42, 0.08);
    }

    .pillar-icon-badge {
        width: 58px;
        height: 58px;
        border-radius: 16px;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.7rem;
        margin-bottom: 22px;
        box-shadow: 0 2px 8px rgba(15, 23, 42, 0.04);
    }

    .pillar-card h3 {
        font-size: 1.22rem;
        font-weight: 800;
        color: #0f172a;
        margin-bottom: 12px;
    }

    .pillar-card p {
        font-size: 0.94rem;
        color: #64748b;
        line-height: 1.65;
        margin-bottom: 16px;
    }

    .pillar-tag {
        display: inline-block;
        font-size: 0.74rem;
        font-weight: 750;
        color: #2563eb;
        background: #eff6ff;
        border: 1px solid #bfdbfe;
        padding: 4px 10px;
        border-radius: var(--radius-full);
    }

    /* --------------------------------------------------------------------------
       6. CRAFT PROCESS: FROM THREAD TO SILHOUETTE
       -------------------------------------------------------------------------- */
    .process-section {
        margin-bottom: 120px;
    }

    .process-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
        position: relative;
    }

    @media (max-width: 1024px) {
        .process-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 24px;
        }
    }

    @media (max-width: 600px) {
        .process-grid {
            grid-template-columns: 1fr;
        }
    }

    .process-step-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 20px;
        padding: 30px 24px;
        position: relative;
        transition: all 0.25s ease;
        box-shadow: 0 4px 16px rgba(15, 23, 42, 0.03);
    }

    .process-step-card:hover {
        background: #ffffff;
        border-color: #cbd5e1;
        transform: translateY(-4px);
        box-shadow: 0 14px 32px rgba(15, 23, 42, 0.08);
    }

    .step-number {
        font-size: 2.2rem;
        font-weight: 900;
        color: #cbd5e1;
        line-height: 1;
        margin-bottom: 16px;
        font-family: monospace;
    }

    .process-step-card:hover .step-number {
        color: #2563eb;
    }

    .process-step-card h4 {
        font-size: 1.15rem;
        font-weight: 800;
        color: #0f172a;
        margin-bottom: 10px;
    }

    .process-step-card p {
        font-size: 0.9rem;
        color: #64748b;
        line-height: 1.6;
    }

    /* --------------------------------------------------------------------------
       7. SCREENPRINTING STUDIO INSET
       -------------------------------------------------------------------------- */
    .studio-inset-banner {
        position: relative;
        border-radius: 28px;
        overflow: hidden;
        border: 1px solid #e2e8f0;
        margin-bottom: 120px;
        box-shadow: 0 20px 45px rgba(15, 23, 42, 0.08);
        display: grid;
        grid-template-columns: 1.1fr 0.9fr;
        background: #0f172a;
    }

    @media (max-width: 900px) {
        .studio-inset-banner {
            grid-template-columns: 1fr;
        }
    }

    .studio-inset-img {
        position: relative;
        min-height: 380px;
    }

    .studio-inset-img img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }

    .studio-inset-content {
        padding: 50px 44px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        background: #0f172a;
    }

    @media (max-width: 600px) {
        .studio-inset-content {
            padding: 32px 24px;
        }
    }

    /* --------------------------------------------------------------------------
       8. TEAM / CREATIVE ATELIER
       -------------------------------------------------------------------------- */
    .team-section {
        margin-bottom: 120px;
    }

    .team-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 28px;
    }

    @media (max-width: 860px) {
        .team-grid {
            grid-template-columns: 1fr;
            max-width: 480px;
            margin: 0 auto;
        }
    }

    .team-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 20px;
        padding: 34px 24px;
        text-align: center;
        transition: all 0.3s ease;
        box-shadow: 0 4px 18px rgba(15, 23, 42, 0.03);
    }

    .team-card:hover {
        border-color: #cbd5e1;
        transform: translateY(-6px);
        box-shadow: 0 16px 36px rgba(15, 23, 42, 0.08);
    }

    .team-avatar-box {
        width: 90px;
        height: 90px;
        border-radius: 50%;
        margin: 0 auto 18px;
        background: linear-gradient(135deg, #2563eb 0%, #7c3aed 100%);
        padding: 3px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .team-avatar-inner {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        background: #f8fafc;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
    }

    .team-card h4 {
        font-size: 1.2rem;
        font-weight: 850;
        color: #0f172a;
        margin-bottom: 4px;
    }

    .team-role {
        font-size: 0.84rem;
        font-weight: 800;
        color: #2563eb;
        text-transform: uppercase;
        letter-spacing: 0.6px;
        margin-bottom: 14px;
    }

    .team-card p {
        font-size: 0.9rem;
        color: #64748b;
        line-height: 1.6;
    }

    /* --------------------------------------------------------------------------
       9. IRONCLAD QUALITY GUARANTEE STRIP
       -------------------------------------------------------------------------- */
    .guarantee-box {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 26px;
        padding: 45px 36px;
        margin-bottom: 90px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 36px;
        flex-wrap: wrap;
        box-shadow: 0 4px 20px rgba(15, 23, 42, 0.03);
    }

    .guarantee-left {
        max-width: 620px;
    }

    .guarantee-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        font-size: 0.78rem;
        font-weight: 800;
        letter-spacing: 1px;
        text-transform: uppercase;
        color: #1e40af;
        background: #eff6ff;
        border: 1px solid #bfdbfe;
        padding: 6px 14px;
        border-radius: var(--radius-full);
        margin-bottom: 12px;
    }

    .guarantee-left h3 {
        font-size: 1.7rem;
        font-weight: 850;
        color: #0f172a;
        margin-bottom: 10px;
    }

    .guarantee-left p {
        font-size: 0.96rem;
        color: #475569;
        line-height: 1.65;
        margin: 0;
    }

    .guarantee-features {
        display: flex;
        gap: 16px;
        flex-wrap: wrap;
    }

    .guarantee-feat-tag {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        padding: 12px 18px;
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 0.88rem;
        font-weight: 750;
        color: #0f172a;
        box-shadow: 0 2px 6px rgba(15, 23, 42, 0.03);
    }

    /* --------------------------------------------------------------------------
       10. FINALE CALL TO ACTION BANNER
       -------------------------------------------------------------------------- */
    .about-cta-banner {
        position: relative;
        background: radial-gradient(circle at 50% 0%, rgba(99, 102, 241, 0.25), transparent 70%), linear-gradient(135deg, #090d16 0%, #111827 50%, #0f172a 100%);
        border: 1px solid #1e293b;
        border-radius: 28px;
        padding: 70px 30px;
        text-align: center;
        overflow: hidden;
        box-shadow: 0 24px 50px -12px rgba(15, 23, 42, 0.25);
    }

    .about-cta-banner::before {
        content: '';
        position: absolute;
        top: 0;
        left: 20%;
        right: 20%;
        height: 1px;
        background: linear-gradient(90deg, transparent, #818cf8, transparent);
    }

    .cta-headline {
        font-size: clamp(2.2rem, 4.5vw, 3.2rem);
        font-weight: 900;
        letter-spacing: -1px;
        color: #ffffff;
        margin-bottom: 16px;
    }

    .cta-subtext {
        font-size: 1.1rem;
        color: #94a3b8;
        max-width: 620px;
        margin: 0 auto 34px;
        line-height: 1.65;
    }

    .cta-actions {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 16px;
        flex-wrap: wrap;
    }
</style>
@endsection

@section('content')

<div class="about-page-wrapper">
    <!-- Ambient Backdrop Aura Glows -->
    <div class="ambient-glow-orb orb-1"></div>
    <div class="ambient-glow-orb orb-2"></div>
    <div class="ambient-glow-orb orb-3"></div>

    <!-- 1. HERO SECTION -->
    <div class="about-hero">
        <div class="about-container">
            <div class="atelier-pill-badge">
                <span class="pulse-dot-indigo"></span>
                <span>The Architectural Apparel Atelier • Est. 2024</span>
            </div>

            <h1 class="hero-title">
                Crafted for Comfort.<br>
                <span class="gradient-text">Engineered to Last.</span>
            </h1>

            <p class="hero-lead-text">
                We founded T-Shirt Online with a singular obsession: dismantle disposable fast-fashion. By engineering 240 GSM organic combed jersey, architectural street drape, and eco-certified artisanal screenprinting, we build garments that look sharper, feel heavier, and outlast trends.
            </p>

            <div class="hero-action-buttons">
                <a href="#story" class="btn-gradient-glow">
                    <span>Discover Our Story</span>
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M7 13l5 5 5-5M7 6l5 5 5-5"/>
                    </svg>
                </a>
                <a href="{{ route('shop.index') }}" class="btn-glass-subtle">
                    <span>Browse Collection</span>
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M5 12h14M12 5l7 7-7 7"/>
                    </svg>
                </a>
            </div>

            <!-- METRICS BAR -->
            <div class="metrics-bar-wrap">
                <div class="metric-card-item">
                    <div class="metric-number">240 GSM</div>
                    <div class="metric-label">Heavyweight Fabric</div>
                    <div class="metric-sub">1.6x denser than fast-fashion</div>
                </div>

                <div class="metric-card-item">
                    <div class="metric-number">100% GOTS</div>
                    <div class="metric-label">Organic Combed Cotton</div>
                    <div class="metric-sub">Zero pesticides or synthetics</div>
                </div>

                <div class="metric-card-item">
                    <div class="metric-number">50,000+</div>
                    <div class="metric-label">Garments Delivered</div>
                    <div class="metric-sub">Trusted across 40+ countries</div>
                </div>

                <div class="metric-card-item">
                    <div class="metric-number">365 Days</div>
                    <div class="metric-label">Ironclad Guarantee</div>
                    <div class="metric-sub">Anti-bacon collar warranty</div>
                </div>
            </div>
        </div>
    </div>

    <!-- MAIN CONTAINER WRAPPER -->
    <div class="about-container">

        <!-- 2. ORIGIN & EDITORIAL SPLIT -->
        <section id="story" class="story-split-section">
            <div class="editorial-media-wrapper">
                <img src="/images/about/studio.jpg" alt="T-Shirt Online Design Atelier & Garment Workshop" loading="lazy">
                <div class="media-badge-floating">
                    <div class="media-badge-icon">✂️</div>
                    <div class="media-badge-text">
                        <h4>Atelier R&D Lab</h4>
                        <p>18 Months of Textile Testing • 24 Fabric Calibrations</p>
                    </div>
                </div>
            </div>

            <div class="story-content-side">
                <div class="section-eyebrow">
                    <span>— The T-Shirt Online Origin</span>
                </div>
                <h2 class="section-headline">
                    A Rebellion Against Paper-Thin, Disposable T-Shirts.
                </h2>

                <p class="story-paragraph">
                    Founded in 2024, T-Shirt Online was born out of frustration with modern fast-fashion. We were tired of paper-thin 130 GSM shirts that warped, shrank, and turned see-through after two laundry cycles. Synthetic polyester blends felt suffocating, and mass-market rubbery prints peeled into microplastics.
                </p>

                <p class="story-paragraph">
                    We believed the humble T-shirt deserved the same obsessive tailoring and architectural dignity as a luxury coat. We set out to build garments with substantial weight, structural drape, and lifelong durability.
                </p>

                <div class="quote-callout-card">
                    <p>
                        "A great t-shirt is not disposable merch. It's the daily armor and personal canvas you wear closest to your skin. We obsess over every single yarn count so you never have to think twice."
                    </p>
                    <div class="quote-author">
                        <div class="quote-author-info">
                            <h5>Alex Chen</h5>
                            <span>Founder & Head of Silhouette</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- 3. MATERIAL MASTERY: THE 240 GSM DEEP-DIVE -->
        <section class="mastery-section">
            <div class="mastery-header">
                <div class="section-eyebrow" style="justify-content:center;">
                    <span>— Material Mastery</span>
                </div>
                <h2 class="section-headline" style="margin-bottom:14px;">
                    The Anatomy of Our Signature 240 GSM Jersey
                </h2>
                <p style="color:var(--text-muted); font-size:1.05rem; line-height:1.65;">
                    Engineered from combed long-staple organic cotton fibers, pre-shrunk with natural cold-enzymes for an unmatched hand-feel.
                </p>
            </div>

            <div class="mastery-grid">
                <div class="spec-points-list">
                    <div class="spec-point-item">
                        <div class="spec-icon-box">🧵</div>
                        <div class="spec-point-content">
                            <h4>240 GSM Substantial Weight</h4>
                            <p>Dense single-jersey knit that holds its boxy architectural streetwear drape without clinging to the body or showing sweat outlines.</p>
                        </div>
                    </div>

                    <div class="spec-point-item">
                        <div class="spec-icon-box">🛡️</div>
                        <div class="spec-point-content">
                            <h4>Reinforced Anti-Bacon Ribbed Collar</h4>
                            <p>1x1 dense elastane-bonded rib collar with interior herringbone taping. Remains crisp and flat wash after wash.</p>
                        </div>
                    </div>

                    <div class="spec-point-item">
                        <div class="spec-icon-box">❄️</div>
                        <div class="spec-point-content">
                            <h4>Cold-Enzyme Pre-Shrunk Finish</h4>
                            <p>Treated with natural organic bio-enzymes to eliminate post-purchase shrinkage and give a vintage peach-skin softness.</p>
                        </div>
                    </div>

                    <div class="spec-point-item">
                        <div class="spec-icon-box">⚡</div>
                        <div class="spec-point-content">
                            <h4>Twin-Needle Bound Construction</h4>
                            <p>Double-needle topstitching across shoulders, armholes, and bottom hem for indestructible durability.</p>
                        </div>
                    </div>
                </div>

                <div class="fabric-visual-card">
                    <img src="/images/about/fabric.jpg" alt="Macro Texture of 240 GSM Organic Combed Cotton" loading="lazy">
                    <div class="fabric-specs-overlay">
                        <div class="overlay-spec-tag">
                            <span>Density</span>
                            <strong>240 GSM</strong>
                        </div>
                        <div class="overlay-spec-tag">
                            <span>Knit Type</span>
                            <strong>28-Gauge Combed</strong>
                        </div>
                        <div class="overlay-spec-tag">
                            <span>Yarn Purity</span>
                            <strong>100% GOTS Organic</strong>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- 4. FOUR PILLARS OF RESPONSIBLE CRAFT -->
        <section class="pillars-section">
            <div class="section-center-header">
                <div class="section-eyebrow" style="justify-content:center;">
                    <span>— Conscious Ethos</span>
                </div>
                <h2 class="section-headline">
                    Our 4 Pillars of Responsible Production
                </h2>
                <p style="color:var(--text-muted); font-size:1.05rem;">
                    Luxury streetwear shouldn't come at the expense of human craftspeople or the planet.
                </p>
            </div>

            <div class="pillars-grid">
                <div class="pillar-card">
                    <div class="pillar-icon-badge">🌱</div>
                    <h3>100% Organic & Clean</h3>
                    <p>
                        Cultivated strictly from non-GMO seeds without toxic synthetic pesticides, formaldehyde baths, or chemical brighteners. Safe for sensitive skin and gentle on topsoil ecosystems.
                    </p>
                    <span class="pillar-tag">GOTS Certified Organic</span>
                </div>

                <div class="pillar-card">
                    <div class="pillar-icon-badge">🎨</div>
                    <h3>Water-Based Screen Inks</h3>
                    <p>
                        We reject stiff, sweaty plastisol prints. Our eco-friendly water-based inks bond directly into the cotton fibers, yielding an ultra-soft breathable hand-feel that won't crack or peel.
                    </p>
                    <span class="pillar-tag">Zero Plastisol • Hypoallergenic</span>
                </div>

                <div class="pillar-card">
                    <div class="pillar-icon-badge">✂️</div>
                    <h3>Tailored Streetwear Drape</h3>
                    <p>
                        Custom architectural silhouettes featuring relaxed drop shoulders, structured chest width, and a proportional boxy hem that pairs seamlessly with trousers, cargo pants, or denim.
                    </p>
                    <span class="pillar-tag">Custom Drop Silhouette</span>
                </div>

                <div class="pillar-card">
                    <div class="pillar-icon-badge">📦</div>
                    <h3>Zero Plastic Packaging</h3>
                    <p>
                        Every garment is folded in 100% biodegradable cassava & cornstarch mailers that decompose naturally in home compost, sealed with recyclable FSC paper shipping labels.
                    </p>
                    <span class="pillar-tag">100% Compostable Packaging</span>
                </div>
            </div>
        </section>

        <!-- 5. CRAFT PROCESS TIMELINE -->
        <section class="process-section">
            <div class="section-center-header">
                <div class="section-eyebrow" style="justify-content:center;">
                    <span>— From Fiber to Garment</span>
                </div>
                <h2 class="section-headline">
                    How We Build Every T-Shirt Online Shirt
                </h2>
                <p style="color:var(--text-muted); font-size:1.05rem;">
                    A meticulous, slow-fashion journey engineered to deliver generational quality.
                </p>
            </div>

            <div class="process-grid">
                <div class="process-step-card">
                    <div class="step-number">01</div>
                    <h4>Long-Staple Sourcing</h4>
                    <p>We source certified combed organic cotton from ethical family-run farms, selecting only long-staple fibers that resist pilling and fraying.</p>
                </div>

                <div class="process-step-card">
                    <div class="step-number">02</div>
                    <h4>Precision Pattern Drafting</h4>
                    <p>Laser-guided pattern cuts calibrated for the modern unisex streetwear drape, engineered with reinforced seam tolerances.</p>
                </div>

                <div class="process-step-card">
                    <div class="step-number">03</div>
                    <h4>Hand-Pulled Printing</h4>
                    <p>Each graphic run is hand-pulled through fine silk-mesh screens in limited editions using non-toxic waterborne pigments.</p>
                </div>

                <div class="process-step-card">
                    <div class="step-number">04</div>
                    <h4>Rigorous Wash Testing</h4>
                    <p>Sample units from every production batch undergo 5 consecutive hot-wash and dry cycles to guarantee dimensional stability.</p>
                </div>
            </div>
        </section>

        <!-- 6. STUDIO INSET BANNER (PRINTMAKING ATELIER) -->
        <section class="studio-inset-banner">
            <div class="studio-inset-img">
                <img src="/images/about/printing.jpg" alt="Artisanal Screen Printing Workshop at T-Shirt Online" loading="lazy">
            </div>
            <div class="studio-inset-content">
                <div class="section-eyebrow">
                    <span>— Artisanal Print Lab</span>
                </div>
                <h3 style="font-size: clamp(1.8rem, 3vw, 2.4rem); font-weight:800; color:#ffffff; margin-bottom:16px;">
                    Slow Craft in a World of Fast Trends.
                </h3>
                <p style="color:var(--text-sub); font-size:1rem; line-height:1.7; margin-bottom:24px;">
                    We deliberately produce in controlled, numbered small runs. Doing so allows us to maintain direct hands-on control over ink viscosity, mesh tension, and seam finishes. When you wear T-Shirt Online, you wear a tangible piece of contemporary art.
                </p>
                <div>
                    <a href="{{ route('shop.index') }}" class="btn-gradient-glow" style="padding:12px 28px; font-size:0.95rem;">
                        <span>Explore Current Drops</span>
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                            <path d="M5 12h14M12 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>
            </div>
        </section>

        <!-- 7. CREATIVE ATELIER TEAM -->
        <section class="team-section">
            <div class="section-center-header">
                <div class="section-eyebrow" style="justify-content:center;">
                    <span>— Creative Collective</span>
                </div>
                <h2 class="section-headline">
                    The Minds Behind the Seams
                </h2>
                <p style="color:var(--text-muted); font-size:1.05rem;">
                    Designers, textile engineers, and print artisans dedicated to perfected everyday uniforms.
                </p>
            </div>

            <div class="team-grid">
                <div class="team-card">
                    <div class="team-avatar-box">
                        <div class="team-avatar-inner">📐</div>
                    </div>
                    <h4>Alex Chen</h4>
                    <div class="team-role">Founder & Creative Director</div>
                    <p>"Streetwear should have architectural structure. If a shirt doesn't hold its line, it doesn't leave our drawing board."</p>
                </div>

                <div class="team-card">
                    <div class="team-avatar-box">
                        <div class="team-avatar-inner">🔬</div>
                    </div>
                    <h4>Elena Rostova</h4>
                    <div class="team-role">Lead Textile Engineer</div>
                    <p>"We tested 24 cotton weights before formulating our 240 GSM combed jersey. It's the golden ratio of drape, softness, and longevity."</p>
                </div>

                <div class="team-card">
                    <div class="team-avatar-box">
                        <div class="team-avatar-inner">🎨</div>
                    </div>
                    <h4>Marcus Vance</h4>
                    <div class="team-role">Master Printmaker</div>
                    <p>"Our water-based inks cure directly inside the yarn. No plastic feeling, no flaking, just silky breathable graphic art."</p>
                </div>
            </div>
        </section>

        <!-- 8. IRONCLAD QUALITY GUARANTEE -->
        <section class="guarantee-box">
            <div class="guarantee-left">
                <div class="guarantee-badge">
                    <span>🛡️ Our 365-Day Promise</span>
                </div>
                <h3>The THREADCRAFT Quality Guarantee</h3>
                <p>
                    We stand behind every stitch. If any seam unravels, collar ripples, or graphic flakes within 365 days of regular wear, we'll replace your shirt immediately with no questions asked.
                </p>
            </div>

            <div class="guarantee-features">
                <div class="guarantee-feat-tag">
                    <span style="font-size:1.2rem;">🛡️</span>
                    <span>365-Day Seam Warranty</span>
                </div>
                <div class="guarantee-feat-tag">
                    <span style="font-size:1.2rem;">🔄</span>
                    <span>30-Day Hassle-Free Returns</span>
                </div>
                <div class="guarantee-feat-tag">
                    <span style="font-size:1.2rem;">🌍</span>
                    <span>Carbon-Neutral Shipping</span>
                </div>
            </div>
        </section>

        <!-- 9. FINALE CALL TO ACTION -->
        <section class="about-cta-banner">
            <h2 class="cta-headline">
                Ready to Feel the <span class="gradient-text">240 GSM Difference?</span>
            </h2>
            <p class="cta-subtext">
                Join over 50,000 discerning wearers worldwide who have upgraded from flimsy fast-fashion to substantial, architectural streetwear staples.
            </p>
            <div class="cta-actions">
                <a href="{{ route('shop.index') }}" class="btn-gradient-glow" style="padding: 16px 36px; font-size: 1.05rem;">
                    <span>Shop The Entire Collection</span>
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M5 12h14M12 5l7 7-7 7"/>
                    </svg>
                </a>
                <a href="{{ route('contact') }}" class="btn-glass-subtle" style="padding: 16px 30px; font-size: 1.05rem;">
                    <span>Get in Touch With Us</span>
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
                    </svg>
                </a>
            </div>
        </section>

    </div>
</div>

@endsection
