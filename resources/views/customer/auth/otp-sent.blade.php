@extends('layouts.guest')

@section('title', 'Check Your Email - NJ Car Rentals')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-50 to-indigo-100 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full bg-white shadow-xl rounded-2xl p-8 space-y-8">
        <div class="text-center">
            <div class="mx-auto h-24 w-24 bg-gradient-to-r from-green-400 to-green-600 rounded-2xl flex items-center justify-center">
                <svg class="h-12 w-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M3 8l7.27 7.27c.883.883 2.317.883 3.2 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
            </div>
            <h2 class="mt-6 text-3xl font-bold text-gray-900">Check your email</h2>
            <p class="mt-2 text-lg text-gray-600">
                We've sent a 6-digit verification code to
            </p>
            <p class="mt-1 text-xl font-semibold text-gray-900">{{ $customer->email }}</p>
        </div>

        @if (session('success'))
            <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        <div class="space-y-4">
            <div class="text-center">
                <p class="text-sm text-gray-600">
                    Didn't receive the email? Check your spam folder.
                </p>
            </div>
            <form method="POST" action="{{ route('customer.otp.resend', $customer->id) }}" class="space-y-4">
                @csrf
                <input type="email" name="email" value="{{ $customer->email }}" hidden required>
                <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-200">
                    <svg class="w-5 h-5 mr-2 -ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.27 7.27c.883.883 2.317.883 3.2 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    Resend Verification Code
                </button>
            </form>
        </div>

        <div class="text-center text-sm text-gray-500 space-y-2">
            <p>By continuing, you agree to our <a href="#" class="text-blue-600 hover:underline">Terms of Service</a> and <a href="#" class="text-blue-600 hover:underline">Privacy Policy</a></p>
        </div>
    </div>
</div>
@endsection
