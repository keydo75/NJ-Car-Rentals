<?php

namespace App\Http\Controllers\Customer\Auth;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Rules\ValidGmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Carbon\Carbon;

class ForgotPasswordController extends Controller
{
    // Show the forgot password form
    public function showForgotPasswordForm()
    {
        return view('customer.auth.forgot-password');
    }

    // Handle the forgot password request
    public function sendResetLink(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'email', 'exists:customers,email', new ValidGmail()]
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Check if email is verified
        $customer = Customer::where('email', $request->email)->first();
        
        if (!$customer || !$customer->email_verified_at) {
            return redirect()->back()
                ->withErrors(['email' => 'This email is not verified. Please verify your email first or use a verified email.'])
                ->withInput();
        }

        // Generate a random token
        $token = Str::random(64);
        
        // Delete any existing tokens for this email
        DB::table('password_reset_tokens')->where('email', $request->email)->delete();
        
        // Insert new token
        DB::table('password_reset_tokens')->insert([
            'email' => $request->email,
            'token' => $token,
            'created_at' => Carbon::now()
        ]);

        // In production, you would send an email here
        // For demo purposes, we'll show the link in the session
        session(['reset_token' => $token, 'reset_email' => $request->email]);

        return redirect()->route('customer.login')
            ->with('success', 'Password reset link has been sent to your email. Check your inbox or session for the reset link (demo mode).');
    }

    // Show the reset password form
    public function showResetPasswordForm($token)
    {
        return view('customer.auth.reset-password', ['token' => $token]);
    }

    // Handle the password reset
    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'email', 'exists:customers,email', new ValidGmail()],
            'password' => 'required|string|min:8|confirmed',
            'password_confirmation' => 'required',
            'token' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Verify the token
        $passwordReset = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->where('token', $request->token)
            ->first();

        if (!$passwordReset) {
            return redirect()->back()
                ->withErrors(['token' => 'Invalid or expired reset token.'])
                ->withInput();
        }

        // Check if token is expired (60 minutes)
        if (Carbon::parse($passwordReset->created_at)->addMinutes(60)->isPast()) {
            return redirect()->back()
                ->withErrors(['token' => 'Reset token has expired. Please request a new one.'])
                ->withInput();
        }

        // Update the customer's password
        $customer = Customer::where('email', $request->email)->first();
        $customer->update([
            'password' => Hash::make($request->password)
        ]);

        // Delete the used token
        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        return redirect()->route('customer.login')
            ->with('success', 'Your password has been reset successfully. Please login with your new password.');
    }
}

