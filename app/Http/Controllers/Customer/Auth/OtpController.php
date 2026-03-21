<?php

namespace App\Http\Controllers\Customer\Auth;

use App\Http\Controllers\Controller;
use App\Mail\OtpMail;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class OtpController extends Controller
{
    const MAX_RESENDS_PER_HOUR = 3;
    const RESEND_THROTTLE_SECONDS = 60;

    /**
     * Show OTP verification form
     */
    public function showOtpForm(Customer $customer)
    {
        // Validate customer exists and needs verification
        if (!$customer->exists || $customer->hasVerifiedEmail()) {
            return redirect()->route('customer.login');
        }

$expiresIn = $customer->otp_expires_at ? max(0, $customer->otp_expires_at->diffInSeconds(now())) : 300;
        $endTimestamp = $customer->otp_expires_at ? $customer->otp_expires_at->timestamp : now()->addMinutes(5)->timestamp;

        return view('customer.auth.verify-otp', compact('customer', 'expiresIn', 'endTimestamp'));
    }

    /**
     * Verify OTP code
     */
    public function verifyOtp(Request $request, Customer $customer)
    {
        $fullOtp = implode('', $request->only('otp_digit1', 'otp_digit2', 'otp_digit3', 'otp_digit4', 'otp_digit5', 'otp_digit6'));
        $request->merge(['otp' => $fullOtp]);
        
        $request->validate([
            'otp' => ['required', 'string', 'size:6', 'digits:6'],
        ]);

        // Check if OTP is valid (with buffer)
        if (!$customer->isOtpValid($request->otp)) {
            Log::warning('OTP validation failed', [
                'customer_id' => $customer->id,
                'input_otp' => substr_replace($request->otp, '***', 2),
                'stored_otp' => substr_replace($customer->otp ?? '', '***', 2),
                'expires_in' => $customer->otp_expires_at ? $customer->otp_expires_at->diffInSeconds(now()) : 'null'
            ]);
            return back()->withErrors([
                'otp' => 'Invalid or expired code. Please request a new one.',
            ])->withInput();
        }

        // Mark email as verified and clear OTP
        $customer->update(['email_verified_at' => Carbon::now()]);
        $customer->clearOtp();

        // Log in the customer
        Auth::guard('customer')->login($customer);

        return redirect()->route('customer.dashboard')
            ->with('success', 'Email verified successfully! Welcome to NJ Car Rentals.');
    }

    /**
     * Resend OTP - Auto-clear expired + improved logic
     */
    public function resendOtp(Request $request, Customer $customer)
    {
        $request->validate([
            'email' => 'required|email|exists:customers,email',
        ]);

        // Verify email matches customer
        if ($customer->email !== $request->email) {
            return back()->withErrors(['email' => 'Email mismatch.']);
        }

        // Already verified
        if ($customer->hasVerifiedEmail()) {
            return redirect()->route('customer.login')
                ->with('info', 'Email already verified.');
        }

        // Auto-clear expired OTP to prevent stale data
        if ($customer->otp && $customer->otp_expires_at && Carbon::now()->gt($customer->otp_expires_at)) {
            $customer->clearOtp();
            Log::info('Auto-cleared expired OTP on resend', ['customer_id' => $customer->id]);
        }

        // Rate limiting
        $rateLimitKey = 'otp-resend:' . $customer->email;
        if (RateLimiter::tooManyAttempts($rateLimitKey, self::MAX_RESENDS_PER_HOUR)) {
            $seconds = RateLimiter::availableIn($rateLimitKey);
            return back()->withErrors([
                'email' => "Too many requests. Try again in " . ceil($seconds / 60) . " minutes."
            ]);
        }

        RateLimiter::hit($rateLimitKey, self::RESEND_THROTTLE_SECONDS);

        // Generate and send new OTP
        $otp = $customer->generateOtp();

        // OTP sent via email from Customer::generateOtp()
        return redirect()->route('customer.otp.show', $customer->id)
            ->with('success', 'New verification code sent to ' . $customer->email . '! Check your inbox (and spam folder).');
    }

    /**
     * Show OTP sent confirmation (alias)
     */
    public function showOtpSent(Customer $customer)
    {
        return $this->showOtpForm($customer);
    }
}

