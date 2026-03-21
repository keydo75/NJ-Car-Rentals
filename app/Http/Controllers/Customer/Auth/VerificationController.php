<?php

namespace App\Http\Controllers\Customer\Auth;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Mail\EmailVerificationMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Carbon\Carbon;

class VerificationController extends Controller
{
    /**
     * Maximum number of verification emails that can be sent per hour
     */
    const MAX_VERIFICATIONS_PER_HOUR = 3;

    /**
     * Verify the email address with token
     */
    public function verify(Request $request, $token)
    {
        $customer = Customer::where('verification_token', $token)->first();

        if (!$customer) {
            return redirect()->route('customer.login')
                ->with('error', 'Invalid verification token. Please request a new verification email.');
        }

        // Check if already verified
        if ($customer->email_verified_at) {
            return redirect()->route('customer.login')
                ->with('info', 'Your email has already been verified. Please login.');
        }

        // Mark as verified
        $customer->update([
            'email_verified_at' => Carbon::now(),
            'verification_token' => null
        ]);

        return redirect()->route('customer.verification.success')
            ->with('success', 'Email verified successfully! You can now login to your account.');
    }

    /**
     * Resend verification email with rate limiting
     */
    public function resend(Request $request)
    {
        // Validate email input
        $request->validate([
            'email' => 'required|email|exists:customers,email'
        ], [
            'email.exists' => 'No account found with this email address.'
        ]);

        $email = $request->email;
        $customer = Customer::where('email', $email)->first();

        // Check if already verified
        if ($customer->email_verified_at) {
            return redirect()->route('customer.login')
                ->with('info', 'This email has already been verified. Please login.');
        }

        // Rate limiting: Check how many times this email has requested verification in the last hour
        $rateLimitKey = 'verification-resend:' . $email;
        $attempts = RateLimiter::attempts($rateLimitKey);
        
        if ($attempts >= self::MAX_VERIFICATIONS_PER_HOUR) {
            $seconds = RateLimiter::availableIn($rateLimitKey);
            $minutes = ceil($seconds / 60);
            
            return redirect()->back()
                ->with('error', "Too many verification requests. Please try again in {$minutes} minute(s).");
        }

        // Rate limit: Allow 1 attempt per 60 seconds
        RateLimiter::hit($rateLimitKey, 60);

        // Generate new token
        $token = Str::random(64);
        $customer->update(['verification_token' => $token]);

        // Send verification email
        $verificationUrl = route('customer.verify', ['token' => $token]);
        
        try {
            Mail::to($customer->email)->send(new EmailVerificationMail($verificationUrl, $customer->name));
            
            return redirect()->route('customer.login')
                ->with('success', 'Verification email has been sent! Please check your inbox (and spam folder).');
        } catch (\Exception $e) {
            // Log the error for debugging
            \Log::error('Verification email failed: ' . $e->getMessage());
            
            // Show error message instead of false success
            return redirect()->route('customer.login')
                ->with('error', 'Failed to send verification email. Please try again later or contact support.');
        }
    }
}

