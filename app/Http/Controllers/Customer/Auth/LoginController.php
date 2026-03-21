<?php

namespace App\Http\Controllers\Customer\Auth;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Rules\ValidGmail;
use App\Mail\OtpMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;

class LoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest:customer')->except('logout');
    }

    public function showLoginForm()
    {
        return view('customer.auth.login');
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);

        $customer = Customer::where('email', $request->email)->first();

        if ($customer && !$customer->email_verified_at) {
            return redirect()->back()
                ->withInput($request->only('email', 'remember'))
                ->with(['verification_pending' => true, 'resend_email' => $request->email]);
        }

        if (Auth::guard('customer')->attempt(
            ['email' => $request->email, 'password' => $request->password],
            $request->remember
        )) {
            return redirect()->intended(route('customer.dashboard'));
        }

        return redirect()->back()->withInput($request->only('email', 'remember'))
            ->withErrors(['email' => 'These credentials do not match our records.']);
    }

    public function showRegistrationForm()
    {
        return view('customer.auth.register');
    }

    public function register(Request $request)
    {
        // Rate limiting: 3/min per IP
        $rateKey = 'register:' . $request->ip();
        if (RateLimiter::tooManyAttempts($rateKey, 3)) {
            $seconds = RateLimiter::availableIn($rateKey);
            return back()->withErrors(['email' => "Too many attempts. Try in " . ceil($seconds / 60) . " min."]);
        }
        RateLimiter::hit($rateKey, 60);

        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:100|min:2',
            'middle_initial' => 'nullable|string|max:5',
            'last_name' => 'required|string|max:100|min:2',
            'email' => ['required', 'string', 'email', 'max:255', 'unique:customers', new ValidGmail()],
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'required|string|min:10|max:20',
            'address' => 'required|string|min:20|max:500',
            'terms' => 'accepted',
        ], [
            'first_name.required' => 'First name required.',
            'last_name.required' => 'Last name required.',
            'email.required' => 'Email required.',
            'terms.accepted' => 'Accept terms.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $fullName = trim($request->first_name . ($request->middle_initial ? ' ' . $request->middle_initial : '') . ' ' . $request->last_name);

        $customer = Customer::create([
            'first_name' => $request->first_name,
            'middle_initial' => $request->middle_initial,
            'last_name' => $request->last_name,
            'name' => $fullName,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'address' => $request->address,
            'loyalty_points' => 0,
        ]);

        // Generate OTP
        $otp = $customer->generateOtp();

        // OTP sent via email from Customer::generateOtp()
        return redirect()->route('customer.otp.show', $customer->id)
            ->with('success', 'Registration successful! Check your email for the 6-digit verification code.');
    }

    public function logout(Request $request)
    {
        Auth::guard('customer')->logout();
        $request->session()->invalidate();
        return redirect()->route('customer.login');
    }
}

