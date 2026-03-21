<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Your {{ $appName }} Verification Code</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto;">
    <div style="padding: 20px;">
        <h2 style="color: #2c3e50;">Hello {{ $userName }},</h2>
        
        <p>Thank you for registering at <strong>{{ $appName }}</strong>.</p>
        
        <p>To verify your email address, use the one-time verification code below:</p>
        
        <div style="background: #3498db; color: white; text-align: center; padding: 30px; border-radius: 10px; font-size: 32px; font-weight: bold; letter-spacing: 10px; margin: 30px 0;">
            {{ $otp }}
        </div>
        
        <p style="background: #ecf0f1; padding: 15px; border-radius: 5px; font-size: 14px;">
            <strong>This code expires in {{ $expiryMinutes }} minutes.</strong><br>
            If you did not request this code, please ignore this email.
        </p>
        
        <p>Need help? Contact us at <a href="mailto:{{ $supportEmail }}">{{ $supportEmail }}</a></p>
        
        <hr style="border: none; border-top: 1px solid #eee; margin: 30px 0;">
        <p style="font-size: 12px; color: #7f8c8d;">
            Best regards,<br>
            The {{ $appName }} Team
        </p>
    </div>
</body>
</html>
