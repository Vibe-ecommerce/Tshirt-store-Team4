@extends('layouts.store')

@section('title', 'Contact Us — T-Shirt Online')

@section('styles')
<style>
    /* Contact Page Master Styles */
    .contact-hero {
        background: radial-gradient(circle at 50% 0%, rgba(37, 99, 235, 0.08) 0%, transparent 70%);
        padding: 55px 24px 35px;
        text-align: center;
        border-bottom: 1px solid #e2e8f0;
    }

    .contact-eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: #eff6ff;
        border: 1px solid #bfdbfe;
        color: #2563eb;
        font-size: 0.78rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        padding: 4px 14px;
        border-radius: var(--radius-full);
        margin-bottom: 14px;
    }

    .contact-title {
        font-size: clamp(2.2rem, 4.5vw, 3.2rem);
        font-weight: 850;
        color: #0f172a;
        letter-spacing: -0.03em;
        line-height: 1.15;
        margin-bottom: 12px;
    }

    .contact-subtitle {
        color: #64748b;
        font-size: 1.08rem;
        max-width: 620px;
        margin: 0 auto 20px;
        line-height: 1.6;
    }

    .status-pill-wrap {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: #ffffff;
        border: 1px solid #e2e8f0;
        padding: 6px 16px;
        border-radius: var(--radius-full);
        font-size: 0.82rem;
        font-weight: 600;
        color: #334155;
        box-shadow: 0 2px 8px rgba(15, 23, 42, 0.04);
    }

    .status-dot-pulse {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: #10b981;
        box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7);
        animation: pulseDot 2s infinite;
    }

    @keyframes pulseDot {
        0% {
            transform: scale(0.95);
            box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7);
        }
        70% {
            transform: scale(1);
            box-shadow: 0 0 0 6px rgba(16, 185, 129, 0);
        }
        100% {
            transform: scale(0.95);
            box-shadow: 0 0 0 0 rgba(16, 185, 129, 0);
        }
    }

    .contact-wrapper {
        max-width: 1200px;
        margin: 0 auto;
        padding: 40px 24px 80px;
    }

    /* 3 Channel Cards */
    .channels-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 24px;
        margin-bottom: 45px;
    }

    @media (max-width: 900px) {
        .channels-grid {
            grid-template-columns: 1fr;
        }
    }

    .channel-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 20px;
        padding: 26px 24px;
        display: flex;
        align-items: flex-start;
        gap: 18px;
        transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
        box-shadow: 0 4px 16px rgba(15, 23, 42, 0.03);
    }

    .channel-card:hover {
        transform: translateY(-4px);
        border-color: #cbd5e1;
        box-shadow: 0 12px 28px rgba(15, 23, 42, 0.08);
    }

    .channel-icon-wrap {
        width: 50px;
        height: 50px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        transition: transform 0.2s ease;
    }

    .channel-card:hover .channel-icon-wrap {
        transform: scale(1.08);
    }

    .icon-blue {
        background: #eff6ff;
        color: #2563eb;
        border: 1px solid #dbeafe;
    }

    .icon-emerald {
        background: #ecfdf5;
        color: #059669;
        border: 1px solid #a7f3d0;
    }

    .icon-purple {
        background: #f5f3ff;
        color: #7c3aed;
        border: 1px solid #ddd6fe;
    }

    .channel-info h4 {
        font-size: 0.78rem;
        font-weight: 750;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        color: #64748b;
        margin-bottom: 4px;
    }

    .channel-link {
        font-size: 1.05rem;
        font-weight: 750;
        color: #0f172a;
        text-decoration: none;
        display: block;
        margin-bottom: 4px;
        transition: color 0.15s ease;
    }

    .channel-link:hover {
        color: #2563eb;
    }

    .channel-meta {
        font-size: 0.82rem;
        color: #64748b;
        line-height: 1.4;
    }

    /* Main Form & Info Grid */
    .contact-main-grid {
        display: grid;
        grid-template-columns: 1fr 1.5fr;
        gap: 36px;
        align-items: start;
    }

    @media (max-width: 950px) {
        .contact-main-grid {
            grid-template-columns: 1fr;
        }
    }

    /* Left Side: Info & Perks */
    .side-info-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 24px;
        padding: 32px 28px;
        box-shadow: 0 4px 18px rgba(15, 23, 42, 0.03);
    }

    .side-heading {
        font-size: 1.15rem;
        font-weight: 800;
        color: #0f172a;
        margin-bottom: 8px;
        letter-spacing: -0.01em;
    }

    .side-desc {
        font-size: 0.9rem;
        color: #64748b;
        line-height: 1.5;
        margin-bottom: 22px;
    }

    .quick-topics-label {
        font-size: 0.75rem;
        font-weight: 750;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        color: #475569;
        margin-bottom: 10px;
        display: block;
    }

    .topic-chips {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        margin-bottom: 28px;
    }

    .topic-chip {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        color: #334155;
        padding: 8px 14px;
        border-radius: var(--radius-full);
        font-size: 0.84rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;
        user-select: none;
    }

    .topic-chip:hover {
        background: #eff6ff;
        border-color: #bfdbfe;
        color: #2563eb;
    }

    .topic-chip.active {
        background: #0f172a;
        border-color: #0f172a;
        color: #ffffff;
    }

    .perks-list {
        display: flex;
        flex-direction: column;
        gap: 16px;
        padding-top: 24px;
        border-top: 1px solid #e2e8f0;
    }

    .perk-item {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .perk-check {
        width: 24px;
        height: 24px;
        border-radius: 50%;
        background: #ecfdf5;
        color: #059669;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .perk-text {
        font-size: 0.88rem;
        color: #334155;
        font-weight: 600;
    }

    /* Right Side: Form Card */
    .form-card-luxury {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 24px;
        padding: 38px 36px;
        box-shadow: 0 6px 24px rgba(15, 23, 42, 0.04);
    }

    @media (max-width: 600px) {
        .form-card-luxury {
            padding: 26px 20px;
        }
    }

    .form-header-wrap {
        margin-bottom: 28px;
    }

    .form-title {
        font-size: 1.45rem;
        font-weight: 850;
        color: #0f172a;
        letter-spacing: -0.02em;
        margin-bottom: 6px;
    }

    .form-subtitle {
        color: #64748b;
        font-size: 0.92rem;
        line-height: 1.5;
    }

    /* Success / Error Notifications */
    .alert-success-lux {
        background: #ecfdf5;
        border: 1px solid #a7f3d0;
        color: #065f46;
        padding: 16px 20px;
        border-radius: 14px;
        margin-bottom: 24px;
        display: flex;
        align-items: flex-start;
        gap: 12px;
        font-size: 0.92rem;
        font-weight: 600;
    }

    .alert-error-lux {
        background: #fef2f2;
        border: 1px solid #fecaca;
        color: #991b1b;
        padding: 16px 20px;
        border-radius: 14px;
        margin-bottom: 24px;
        font-size: 0.9rem;
    }

    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 18px;
        margin-bottom: 20px;
    }

    @media (max-width: 640px) {
        .form-row {
            grid-template-columns: 1fr;
        }
    }

    .form-group-lux {
        display: flex;
        flex-direction: column;
        gap: 7px;
        margin-bottom: 20px;
    }

    .form-label-lux {
        font-size: 0.8rem;
        font-weight: 750;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        color: #475569;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .form-label-lux span.req {
        color: #ef4444;
        margin-left: 2px;
    }

    .form-control-lux {
        width: 100%;
        background: #f8fafc;
        border: 1px solid #cbd5e1;
        color: #0f172a;
        padding: 13px 18px;
        border-radius: 14px;
        font-size: 0.96rem;
        font-family: inherit;
        outline: none;
        transition: all 0.2s ease;
    }

    .form-control-lux:focus {
        background: #ffffff;
        border-color: #2563eb;
        box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.1);
    }

    .form-control-lux::placeholder {
        color: #94a3b8;
    }

    textarea.form-control-lux {
        resize: vertical;
        min-height: 120px;
        line-height: 1.5;
    }

    .submit-btn-lux {
        width: 100%;
        height: 52px;
        background: #0f172a;
        color: #ffffff;
        border: none;
        border-radius: var(--radius-full);
        font-size: 1rem;
        font-weight: 750;
        letter-spacing: 0.01em;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
        box-shadow: 0 6px 20px rgba(15, 23, 42, 0.16);
        margin-top: 8px;
    }

    .submit-btn-lux:hover {
        background: #2563eb;
        transform: translateY(-2px);
        box-shadow: 0 10px 28px rgba(37, 99, 235, 0.32);
        color: #ffffff;
    }

    .submit-btn-lux:active {
        transform: translateY(0);
    }

    /* FAQ Section */
    .faq-section {
        margin-top: 75px;
        padding-top: 50px;
        border-top: 1px solid #e2e8f0;
    }

    .faq-header {
        text-align: center;
        margin-bottom: 40px;
    }

    .faq-title {
        font-size: 1.8rem;
        font-weight: 850;
        color: #0f172a;
        letter-spacing: -0.02em;
        margin-bottom: 8px;
    }

    .faq-subtitle {
        color: #64748b;
        font-size: 0.96rem;
    }

    .faq-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }

    @media (max-width: 768px) {
        .faq-grid {
            grid-template-columns: 1fr;
        }
    }

    .faq-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 18px;
        padding: 24px 26px;
        transition: all 0.2s ease;
    }

    .faq-card:hover {
        border-color: #cbd5e1;
        box-shadow: 0 8px 24px rgba(15, 23, 42, 0.05);
    }

    .faq-q {
        font-size: 1.02rem;
        font-weight: 750;
        color: #0f172a;
        margin-bottom: 8px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .faq-q-icon {
        color: #2563eb;
        font-size: 1.1rem;
    }

    .faq-a {
        font-size: 0.9rem;
        color: #64748b;
        line-height: 1.6;
    }
</style>
@endsection

@section('content')

    <!-- Hero Header -->
    <div class="contact-hero">
        <span class="contact-eyebrow">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
            </svg>
            24/7 Concierge Support
        </span>
        <h1 class="contact-title">Let’s Start a Conversation</h1>
        <p class="contact-subtitle">
            Have questions about custom screen prints, sizing recommendations, bulk orders, or tracking an existing delivery? Our dedicated apparel specialists are here for you.
        </p>
        <div class="status-pill-wrap">
            <span class="status-dot-pulse"></span>
            <span>Concierge Online • Mon–Sat 9AM–6PM PST • Avg Response &lt; 15 mins</span>
        </div>
    </div>

    <div class="contact-wrapper">
        <!-- 3 Direct Channel Cards -->
        <div class="channels-grid">
            <!-- Channel 1: Phone -->
            <div class="channel-card">
                <div class="channel-icon-wrap icon-blue">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                    </svg>
                </div>
                <div class="channel-info">
                    <h4>Direct Support Line</h4>
                    <a href="tel:+18005558337" class="channel-link">+1 (800) 555-TEES</a>
                    <div class="channel-meta">Toll-free customer line &bull; Mon–Fri 9am–6pm PST</div>
                </div>
            </div>

            <!-- Channel 2: Email -->
            <div class="channel-card">
                <div class="channel-icon-wrap icon-emerald">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                        <polyline points="22,6 12,13 2,6"></polyline>
                    </svg>
                </div>
                <div class="channel-info">
                    <h4>Email Concierge</h4>
                    <a href="mailto:support@threadcraft.store" class="channel-link">support@threadcraft.store</a>
                    <div class="channel-meta">Priority inbox &bull; Guaranteed reply within 4 hours</div>
                </div>
            </div>

            <!-- Channel 3: Flagship Studio -->
            <div class="channel-card">
                <div class="channel-icon-wrap icon-purple">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                        <circle cx="12" cy="10" r="3"></circle>
                    </svg>
                </div>
                <div class="channel-info">
                    <h4>Studio & Warehouse</h4>
                    <span class="channel-link" style="cursor: default;">Studio 4A, Street 123, BKK1</span>
                    <div class="channel-meta">Khan Boeung Keng Kang, Phnom Penh, Cambodia</div>
                </div>
            </div>
        </div>

        <!-- Main Form & Quick Assistance Grid -->
        <div class="contact-main-grid">
            <!-- Left Column: Quick Selector & Guarantees -->
            <div class="side-info-card">
                <h3 class="side-heading">How Can We Assist You?</h3>
                <p class="side-desc">Select a topic below to quickly set your inquiry subject, or write us directly.</p>

                <span class="quick-topics-label">Quick Topic Select:</span>
                <div class="topic-chips">
                    <button type="button" class="topic-chip" onclick="selectTopic(this, '📦 Order Tracking & Delivery Inquiry')">
                        📦 Order Tracking
                    </button>
                    <button type="button" class="topic-chip" onclick="selectTopic(this, '👕 Sizing & Fit Consultation')">
                        👕 Sizing Advice
                    </button>
                    <button type="button" class="topic-chip" onclick="selectTopic(this, '🎨 Bespoke Print & Bulk Order (10+ pcs)')">
                        🎨 Custom Prints
                    </button>
                    <button type="button" class="topic-chip" onclick="selectTopic(this, '🔄 Returns, Exchanges & Refunds')">
                        🔄 Returns & Exchanges
                    </button>
                    <button type="button" class="topic-chip" onclick="selectTopic(this, '💼 Wholesale, Distribution & Press')">
                        💼 Wholesale & Press
                    </button>
                </div>

                <div class="perks-list">
                    <div class="perk-item">
                        <div class="perk-check">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="20 6 9 17 4 12"></polyline>
                            </svg>
                        </div>
                        <span class="perk-text">Lightning fast response within 4 business hours</span>
                    </div>

                    <div class="perk-item">
                        <div class="perk-check">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="20 6 9 17 4 12"></polyline>
                            </svg>
                        </div>
                        <span class="perk-text">Dedicated personal apparel specialist for your order</span>
                    </div>

                    <div class="perk-item">
                        <div class="perk-check">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="20 6 9 17 4 12"></polyline>
                            </svg>
                        </div>
                        <span class="perk-text">100% data privacy & SSL-secured communications</span>
                    </div>

                    <div class="perk-item">
                        <div class="perk-check">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="20 6 9 17 4 12"></polyline>
                            </svg>
                        </div>
                        <span class="perk-text">30-day hassle-free return and exchange guarantee</span>
                    </div>
                </div>
            </div>

            <!-- Right Column: Luxury Form -->
            <div class="form-card-luxury">
                <div class="form-header-wrap">
                    <h2 class="form-title">Send Us a Direct Message</h2>
                    <p class="form-subtitle">Complete the fields below and our concierge team will reach out with personalized guidance.</p>
                </div>

                <!-- Session Flash Messages -->
                @if (session('success'))
                    <div class="alert-success-lux">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink:0;">
                            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                            <polyline points="22 4 12 14.01 9 11.01"></polyline>
                        </svg>
                        <div>
                            <strong>Message Delivered!</strong>
                            <p style="margin-top: 2px;">{{ session('success') }}</p>
                        </div>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert-error-lux">
                        <strong>Please resolve the following:</strong>
                        <ul style="margin-top:6px; padding-left:18px;">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('contact.submit') }}" method="POST" id="contactForm">
                    @csrf

                    <div class="form-row">
                        <div class="form-group-lux">
                            <label class="form-label-lux" for="contact_name">
                                Your Full Name <span class="req">*</span>
                            </label>
                            <input type="text"
                                   id="contact_name"
                                   name="name"
                                   class="form-control-lux"
                                   placeholder="e.g. Alexander Vance"
                                   required
                                   value="{{ old('name') }}">
                        </div>

                        <div class="form-group-lux">
                            <label class="form-label-lux" for="contact_email">
                                Email Address <span class="req">*</span>
                            </label>
                            <input type="email"
                                   id="contact_email"
                                   name="email"
                                   class="form-control-lux"
                                   placeholder="e.g. alexander@example.com"
                                   required
                                   value="{{ old('email') }}">
                        </div>
                    </div>

                    <div class="form-group-lux">
                        <label class="form-label-lux" for="contact_subject">
                            Subject / Inquiry Type <span class="req">*</span>
                        </label>
                        <input type="text"
                               id="contact_subject"
                               name="subject"
                               class="form-control-lux"
                               placeholder="e.g. Sizing Advice / Custom Print Inquiry"
                               required
                               value="{{ old('subject') }}">
                    </div>

                    <div class="form-group-lux">
                        <label class="form-label-lux" for="contact_message">
                            Your Message <span class="req">*</span>
                        </label>
                        <textarea id="contact_message"
                                  name="message"
                                  class="form-control-lux"
                                  rows="5"
                                  placeholder="Describe how we can help you with your order, sizing, or custom apparel project..."
                                  required>{{ old('message') }}</textarea>
                    </div>

                    <button type="submit" class="submit-btn-lux">
                        <span>Send Message</span>
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="5" y1="12" x2="19" y2="12"></line>
                            <polyline points="12 5 19 12 12 19"></polyline>
                        </svg>
                    </button>
                </form>
            </div>
        </div>

        <!-- FAQ Section -->
        <div class="faq-section">
            <div class="faq-header">
                <h3 class="faq-title">Frequently Asked Questions</h3>
                <p class="faq-subtitle">Get immediate answers to the questions our customers ask most frequently.</p>
            </div>

            <div class="faq-grid">
                <div class="faq-card">
                    <h4 class="faq-q">
                        <span class="faq-q-icon">✦</span>
                        How long does worldwide shipping take?
                    </h4>
                    <p class="faq-a">
                        Orders are carefully processed within 24 hours. Domestic shipments arrive within 2–3 business days. Worldwide express delivery via DHL Express takes approximately 3–5 business days with full real-time tracking.
                    </p>
                </div>

                <div class="faq-card">
                    <h4 class="faq-q">
                        <span class="faq-q-icon">✦</span>
                        Can I order bespoke custom prints or embroidery?
                    </h4>
                    <p class="faq-a">
                        Absolutely! We engineer bespoke luxury heavyweight tees with high-density screen printing and embroidery for brands, studios, and corporate teams (minimum order starts from 10 pieces).
                    </p>
                </div>

                <div class="faq-card">
                    <h4 class="faq-q">
                        <span class="faq-q-icon">✦</span>
                        What is your return & exchange policy?
                    </h4>
                    <p class="faq-a">
                        We offer a 30-day return and exchange window on all unworn items with original tags intact. If the size doesn't fit exactly right, we’ll happily exchange it with prepaid return postage.
                    </p>
                </div>

                <div class="faq-card">
                    <h4 class="faq-q">
                        <span class="faq-q-icon">✦</span>
                        How do I choose the right oversize fit?
                    </h4>
                    <p class="faq-a">
                        Our oversized tees feature a tailored streetwear drop-shoulder cut. We recommend selecting your standard true-to-size for the intended relaxed streetwear drape, or sizing down one size for a fitted look.
                    </p>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
<script>
    function selectTopic(button, topicText) {
        // Update subject input
        const subjectInput = document.getElementById('contact_subject');
        if (subjectInput) {
            subjectInput.value = topicText;
            subjectInput.focus();
        }

        // Toggle active chip style
        document.querySelectorAll('.topic-chip').forEach(chip => chip.classList.remove('active'));
        button.classList.add('active');
    }
</script>
@endsection
