<!DOCTYPE html>
<html lang="km">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>លេខកូដសម្ងាត់ OTP សម្រាប់ Reset Password — T-Shirt Online</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #f8fafc;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            color: #334155;
            -webkit-font-smoothing: antialiased;
        }
        .email-wrapper {
            width: 100%;
            background-color: #f8fafc;
            padding: 40px 16px;
        }
        .email-container {
            max-width: 540px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 18px;
            border: 1px solid #e2e8f0;
            overflow: hidden;
            box-shadow: 0 10px 30px -5px rgba(15, 23, 42, 0.05);
        }
        .email-header {
            background: linear-gradient(135deg, #4f46e5 0%, #3b82f6 100%);
            padding: 32px 30px;
            text-align: center;
        }
        .brand-logo-badge {
            display: inline-block;
            background: rgba(255, 255, 255, 0.18);
            backdrop-filter: blur(6px);
            padding: 8px 16px;
            border-radius: 12px;
            border: 1px solid rgba(255, 255, 255, 0.25);
            margin-bottom: 12px;
        }
        .brand-name {
            color: #ffffff;
            font-size: 20px;
            font-weight: 800;
            letter-spacing: -0.5px;
            margin: 0;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        .header-title {
            color: #ffffff;
            font-size: 22px;
            font-weight: 700;
            margin: 0;
            letter-spacing: -0.3px;
        }
        .header-subtitle {
            color: rgba(255, 255, 255, 0.88);
            font-size: 13px;
            margin-top: 6px;
        }
        .email-body {
            padding: 36px 32px;
        }
        .greeting {
            font-size: 16px;
            font-weight: 600;
            color: #0f172a;
            margin-bottom: 12px;
        }
        .lead-text {
            font-size: 14px;
            line-height: 1.6;
            color: #475569;
            margin-bottom: 24px;
        }
        .otp-container {
            background: #f0f7ff;
            border: 2px dashed #93c5fd;
            border-radius: 14px;
            padding: 24px 20px;
            text-align: center;
            margin: 28px 0;
        }
        .otp-label {
            font-size: 11px;
            text-transform: uppercase;
            font-weight: 700;
            letter-spacing: 1.2px;
            color: #2563eb;
            margin-bottom: 8px;
        }
        .otp-code {
            font-size: 38px;
            font-weight: 850;
            letter-spacing: 10px;
            color: #1e3a8a;
            font-family: 'SF Mono', Consolas, 'Liberation Mono', Menlo, monospace;
            padding-left: 10px;
            display: inline-block;
        }
        .otp-validity {
            font-size: 12px;
            color: #64748b;
            margin-top: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 4px;
        }
        .security-alert {
            background-color: #fffbeb;
            border-left: 4px solid #f59e0b;
            padding: 14px 16px;
            border-radius: 0 10px 10px 0;
            margin-bottom: 24px;
        }
        .security-alert p {
            margin: 0;
            font-size: 12.5px;
            line-height: 1.5;
            color: #92400e;
        }
        .security-alert strong {
            color: #78350f;
        }
        .email-footer {
            background-color: #f8fafc;
            border-top: 1px solid #e2e8f0;
            padding: 24px 32px;
            text-align: center;
            font-size: 12px;
            color: #94a3b8;
            line-height: 1.6;
        }
        .email-footer a {
            color: #4f46e5;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="email-wrapper">
        <div class="email-container">
            <!-- Header -->
            <div class="email-header">
                <div class="brand-logo-badge">
                    <span class="brand-name">👕 T-Shirt Online</span>
                </div>
                <h1 class="header-title">លេខកូដផ្ទៀងផ្ទាត់ OTP</h1>
                <p class="header-subtitle">Password Reset Verification Code</p>
            </div>

            <!-- Body -->
            <div class="email-body">
                <p class="greeting">សួស្តី {{ $userName }},</p>
                
                <p class="lead-text">
                    យើងបានទទួលសំណើសុំផ្លាស់ប្តូរលេខសម្ងាត់ (Reset Password) សម្រាប់គណនីរបស់អ្នក។ សូមយកលេខកូដសម្ងាត់ ៦ខ្ទង់ ខាងក្រោមនេះទៅបំពេញនៅក្នុងផ្ទាំង Reset Password នៅលើគេហទំព័រ៖
                </p>

                <!-- OTP Code Display -->
                <div class="otp-container">
                    <div class="otp-label">YOUR ONE-TIME PASSWORD</div>
                    <div class="otp-code">{{ $otp }}</div>
                    <div class="otp-validity">
                        ⏱️ លេខកូដនេះមានសុពលភាពត្រឹមតែ <strong>15 នាទី</strong> ប៉ុណ្ណោះ
                    </div>
                </div>

                <!-- Security Notice -->
                <div class="security-alert">
                    <p>
                        <strong>🔒 ការការពារសុវត្ថិភាព៖</strong> សូមកុំចែករំលែកលេខកូដ OTP នេះទៅកាន់បុគ្គលណាផ្សេងដាច់ខាត។ បុគ្គលិករបស់យើងនឹងមិនដែលទាក់ទងសួររកលេខកូដសម្ងាត់នេះឡើយ។ ប្រសិនបើអ្នកមិនបានធ្វើការស្នើសុំទេ សូមកុំខ្វល់ពីអ៊ីមែលនេះ។
                    </p>
                </div>

                <p style="font-size: 13px; color: #64748b; margin-top: 24px; line-height: 1.5;">
                    ប្រសិនបើអ្នកមានចម្ងល់ ឬត្រូវការជំនួយបន្ថែម សូមទាក់ទងមកកាន់ក្រុមការងារយើងខ្ញុំតាមរយៈអ៊ីមែល <a href="mailto:support@tshirtonline.store" style="color: #4f46e5; font-weight: 600;">support@tshirtonline.store</a>។
                </p>
            </div>

            <!-- Footer -->
            <div class="email-footer">
                <p style="margin: 0 0 6px;">
                    © {{ date('Y') }} <strong>T-Shirt Online Store</strong>. រក្សាសិទ្ធិគ្រប់យ៉ាង។
                </p>
                <p style="margin: 0;">
                    Phnom Penh, Cambodia &bull; <a href="{{ url('/') }}">ទស្សនាគេហទំព័រ Storefront</a>
                </p>
            </div>
        </div>
    </div>
</body>
</html>
