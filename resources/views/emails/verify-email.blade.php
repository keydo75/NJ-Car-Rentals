<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Your Email - NJ Car Rentals</title>
    <style>
        /* Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        /* Base styles */
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
            line-height: 1.6;
            color: #1a1a1a;
            background-color: #f0f2f5;
            -webkit-font-smoothing: antialiased;
        }
        
        /* Layout */
        .email-wrapper {
            width: 100%;
            background-color: #f0f2f5;
            padding: 40px 0;
        }
        
        .email-container {
            max-width: 520px;
            margin: 0 auto;
            background: #ffffff;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05), 0 1px 3px rgba(0,0,0,0.1);
        }
        
        /* Header */
        .email-header {
            background: linear-gradient(135deg, #0066cc 0%, #004999 50%, #003366 100%);
            padding: 48px 32px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        
        .email-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
            opacity: 0.8;
        }
        
        .logo {
            width: 80px;
            height: 80px;
            background: rgba(255,255,255,0.15);
            border-radius: 20px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 16px;
            position: relative;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255,255,255,0.2);
        }
        
        .logo svg {
            width: 48px;
            height: 48px;
            fill: white;
        }
        
        .email-header h1 {
            color: #ffffff;
            font-size: 28px;
            font-weight: 700;
            margin: 0;
            letter-spacing: -0.5px;
            position: relative;
        }
        
        .email-header .subtitle {
            color: rgba(255,255,255,0.9);
            font-size: 15px;
            margin-top: 8px;
            font-weight: 400;
            position: relative;
        }
        
        /* Body */
        .email-body {
            padding: 40px 32px;
        }
        
        .greeting {
            font-size: 24px;
            font-weight: 600;
            color: #1a1a1a;
            margin-bottom: 16px;
        }
        
        .content {
            font-size: 16px;
            color: #4a4a4a;
            margin-bottom: 32px;
        }
        
        .content p {
            margin-bottom: 12px;
        }
        
        /* Button */
        .button-container {
            text-align: center;
            margin: 40px 0;
        }
        
        .button {
            display: inline-block;
            background: linear-gradient(135deg, #0066cc 0%, #0052a3 100%);
            color: #ffffff !important;
            text-decoration: none;
            padding: 18px 56px;
            border-radius: 12px;
            font-weight: 600;
            font-size: 17px;
            box-shadow: 0 4px 14px rgba(0, 102, 204, 0.35), 0 2px 4px rgba(0,0,0,0.1);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }
        
        .button::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s ease;
        }
        
        .button:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 22px rgba(0, 102, 204, 0.45), 0 4px 8px rgba(0,0,0,0.15);
        }
        
        .button:hover::before {
            left: 100%;
        }
        
        .button:active {
            transform: translateY(0);
        }
        
        /* Info Box */
        .info-box {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-radius: 12px;
            padding: 24px;
            margin: 32px 0;
            border: 1px solid #e9ecef;
        }
        
        .info-box-title {
            font-size: 15px;
            font-weight: 600;
            color: #1a1a1a;
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .info-box-title svg {
            flex-shrink: 0;
        }
        
        .info-box-content {
            font-size: 14px;
            color: #555;
            line-height: 1.7;
        }
        
        .info-box-list {
            margin: 12px 0 0 8px;
            padding: 0;
        }
        
        .info-box-list li {
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .info-box-list li svg {
            width: 16px;
            height: 16px;
            flex-shrink: 0;
        }
        
        /* Security Note */
        .security-note {
            background: linear-gradient(135deg, #fff 0%, #f0f7ff 100%);
            border-radius: 12px;
            padding: 24px;
            margin: 24px 0;
            border: 1px solid #d6e4ff;
            display: flex;
            gap: 16px;
        }
        
        .security-icon {
            width: 44px;
            height: 44px;
            background: linear-gradient(135deg, #0066cc 0%, #0052a3 100%);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        
        .security-icon svg {
            width: 22px;
            height: 22px;
            fill: white;
        }
        
        .security-text h4 {
            font-size: 15px;
            font-weight: 600;
            color: #1a1a1a;
            margin-bottom: 6px;
        }
        
        .security-text p {
            font-size: 13px;
            color: #666;
            line-height: 1.6;
            margin: 0;
        }
        
        /* Expiry Notice */
        .expiry-notice {
            text-align: center;
            padding: 16px;
            background: #fffbf0;
            border-radius: 8px;
            margin: 24px 0;
            border: 1px solid #ffeeba;
        }
        
        .expiry-notice p {
            font-size: 13px;
            color: #856404;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
        }
        
        .expiry-notice svg {
            width: 16px;
            height: 16px;
            fill: #856404;
        }
        
        /* Footer */
        .email-footer {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            padding: 36px 32px;
            text-align: center;
            border-top: 1px solid #e9ecef;
        }
        
        .footer-logo {
            font-size: 20px;
            font-weight: 700;
            color: #1a1a1a;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }
        
        .footer-text {
            font-size: 14px;
            color: #6c757d;
            margin-bottom: 16px;
        }
        
        .footer-links {
            margin-top: 20px;
        }
        
        .footer-links a {
            color: #0066cc;
            text-decoration: none;
            margin: 0 14px;
            font-size: 13px;
            font-weight: 500;
            transition: color 0.2s ease;
        }
        
        .footer-links a:hover {
            color: #004999;
            text-decoration: underline;
        }
        
        .footer-divider {
            height: 1px;
            background: linear-gradient(90deg, transparent, #dee2e6, transparent);
            margin: 24px 0;
        }
        
        .footer-copyright {
            font-size: 12px;
            color: #adb5bd;
        }
        
        /* Disclaimer */
        .disclaimer {
            background: #f8f9fa;
            padding: 24px 32px;
            border-top: 1px solid #e9ecef;
        }
        
        .disclaimer p {
            font-size: 12px;
            color: #868e96;
            line-height: 1.6;
            margin: 0;
        }
        
        /* Responsive */
        @media only screen and (max-width: 600px) {
            .email-wrapper {
                padding: 20px 16px;
            }
            
            .email-container {
                border-radius: 12px;
            }
            
            .email-header {
                padding: 36px 24px;
            }
            
            .email-header h1 {
                font-size: 24px;
            }
            
            .email-body {
                padding: 32px 24px;
            }
            
            .greeting {
                font-size: 22px;
            }
            
            .button {
                display: block;
                width: 100%;
                text-align: center;
                padding: 16px 24px;
            }
            
            .security-note {
                flex-direction: column;
                text-align: center;
            }
            
            .security-note .security-icon {
                margin: 0 auto;
            }
            
            .footer-links a {
                display: block;
                margin: 10px 0;
            }
        }
    </style>
</head>
<body>
    <div class="email-wrapper">
        <div class="email-container">
            <!-- Header -->
            <div class="email-header">
                <div class="logo">
                    <img src="{{ asset('images/nj car rentals logo.png') }}" alt="NJ Car Rentals" style="width:80px;height:80px;object-fit:contain;">
                </div>
                <h1>NJ Car Rentals</h1>
                <p class="subtitle">Verify Your Email Address</p>
            </div>
            
            <!-- Body -->
            <div class="email-body">
                <p class="greeting">Hi {{ $userName }},</p>
                
                <div class="content">
                    <p>Welcome to <strong>NJ Car Rentals</strong>! 🎉</p>
                    <p>Thank you for creating an account. To get started with booking your perfect vehicle, we need to verify your email address.</p>
                </div>
                
                <div class="button-container">
                    <a href="{{ $verificationUrl }}" class="button">Verify Email Address</a>
                </div>
                
                <div class="expiry-notice">
                    <p>
                        <svg viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/></svg>
                        This link expires in {{ $expiryHours }} hours for security purposes
                    </p>
                </div>
                
                <div class="info-box">
                    <div class="info-box-title">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="#0066cc">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                        </svg>
                        What happens next?
                    </div>
                    <div class="info-box-content">
                        Once verified, you'll be able to:
                        <ul class="info-box-list">
                            <li>
                                <svg viewBox="0 0 24 24" fill="#28a745"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg>
                                Book vehicles online instantly
                            </li>
                            <li>
                                <svg viewBox="0 0 24 24" fill="#28a745"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg>
                                Track your rental history
                            </li>
                            <li>
                                <svg viewBox="0 0 24 24" fill="#28a745"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg>
                                Earn loyalty points on every rental
                            </li>
                            <li>
                                <svg viewBox="0 0 24 24" fill="#28a745"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg>
                                Receive exclusive member offers
                            </li>
                        </ul>
                    </div>
                </div>
                
                <div class="security-note">
                    <div class="security-icon">
                        <svg viewBox="0 0 24 24"><path d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4zm0 10.99h7c-.53 4.12-3.28 7.79-7 8.94V12H5V6.3l7-3.11v8.8z"/></svg>
                    </div>
                    <div class="security-text">
                        <h4>Security Notice</h4>
                        <p>If you didn't create an account with NJ Car Rentals, please ignore this email or contact our support team immediately.</p>
                    </div>
                </div>
            </div>
            
            <!-- Footer -->
            <div class="email-footer">
                <div class="footer-logo">
                    🚗 NJ Car Rentals
                </div>
                <p class="footer-text">Your Trusted Car Rental Partner</p>
                <div class="footer-links">
                    <a href="#">Privacy Policy</a>
                    <a href="#">Terms of Service</a>
                    <a href="{{ route('customer.login') }}">Unsubscribe</a>
                </div>
                <div class="footer-divider"></div>
                <p class="footer-copyright">© {{ date('Y') }} NJ Car Rentals. All rights reserved.</p>
            </div>
            
            <!-- Disclaimer -->
            <div class="disclaimer">
                <p>This email was sent to {{ $userName }} because you created an account at NJ Car Rentals. If you didn't create an account, please ignore this email or contact our support team.</p>
            </div>
        </div>
    </div>
</body>
</html>

