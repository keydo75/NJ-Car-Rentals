@extends('layouts.guest')

@section('title', 'Verify Email')

@section('styles')
<style>
.otp-container {
    max-width: 400px;
    display: flex;
    gap: 0.75rem;
    justify-content: center;
    margin: 2rem 0;
}
.otp-input {
    width: 56px;
    height: 64px;
    font-size: 1.75rem;
    font-weight: 700;
    text-align: center;
    border: 2px solid var(--border-color);
    border-radius: var(--radius-lg);
    background: var(--bg-input);
    color: var(--text-primary);
    transition: all var(--transition-base);
    caret-color: var(--color-accent);
}
.otp-input:focus {
    border-color: var(--color-accent);
    box-shadow: 0 0 0 0.25rem rgba(var(--color-accent-rgb), 0.25);
    outline: none;
    transform: scale(1.05);
}
.otp-input.error {
    border-color: var(--color-danger);
    animation: shake 0.5s ease-in-out;
}
@keyframes shake {
    0%, 100% { transform: translateX(0); }
    25% { transform: translateX(-5px); }
    75% { transform: translateX(5px); }
}
.resend-cooldown {
    opacity: 0.5;
    cursor: not-allowed;
    pointer-events: none;
}
.verify-btn:disabled {
    opacity: 0.7;
    cursor: not-allowed;
}
@media (max-width: 480px) {
    .otp-input {
        width: 48px;
        height: 56px;
        font-size: 1.5rem;
    }
}
</style>
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5 col-xl-4">
            <div class="card glass shadow-xl">
                <div class="card-body p-5 text-center">
                    <!-- Logo -->
                    <div class="mb-4">
                        <img src="{{ asset('images/njcarrentallogo-removebg-preview.png') }}" alt="NJ Car Rentals" class="img-fluid" style="max-height: 80px;">
                    </div>

                    <!-- Header -->
                    <h2 class="h3 fw-bold mb-3 text-primary">
                        <i class="bi bi-envelope-check me-2"></i>
                        Verify Your Email
                    </h2>
                    <p class="text-muted mb-4">
                        We've sent a <strong>6-digit verification code</strong> to
                        <br><span class="fw-semibold text-accent fs-6">{{ $customer->email }}</span>
                    </p>

                    @if (session('otp_bypass'))
                    <div class="alert alert-success">
                        <strong>Local Dev OTP:</strong> {{ session('otp_bypass') }}
                    </div>
                    @endif

                    @if (isset($expiresIn))
                    <div class="alert alert-info d-flex align-items-center mb-4">
                        <i class="bi bi-clock me-2"></i>
                        <small>Code expires in <span id="countdown" class="fw-bold text-warning">{{ $expiresIn }}</span> seconds</small>
                    </div>
                    @endif

                    <!-- Errors -->
                    @if ($errors->any())
                    <div class="alert alert-danger d-flex align-items-center">
                        <i class="bi bi-exclamation-triangle-fill me-2 flex-shrink-0"></i>
                        {{ $errors->first() }}
                    </div>
                    @endif

                    <!-- OTP Form -->
                        <form id="otpForm" method="POST" action="{{ route('customer.otp.verify', $customer->id) }}" class="mb-4">
                            @csrf
                            @method('POST')
                        <div class="otp-container">
                            @for ($i = 1; $i <= 6; $i++)
                                <input 
                                    type="text" 
                                    inputmode="numeric" 
                                    pattern="[0-9]*"
                                    id="otp{{ $i }}" 
                                    name="otp_digit{{ $i }}" 
                                    class="otp-input form-control form-control-lg" 
                                    maxlength="1" 
                                    autocomplete="one-time-code"
                                    aria-label="OTP digit {{ $i }}"
                                    @if($i==1) autofocus @endif
                                    required
                                >
                            @endfor
                            <input type="hidden" name="otp" id="otp_combined" value=""> 
                        </div>
                        <input type="hidden" name="email" value="{{ $customer->email }}">
                    </form>

                    <!-- Verify Button -->
                    <button type="submit" form="otpForm" class="btn btn-lg btn-primary w-100 mb-4 verify-btn" id="verifyBtn">
                        <span class="btn-text">
                            <i class="bi bi-check-circle me-2"></i>Verify Code
                        </span>
                        <span class="btn-spinner d-none">
                            <span class="spinner-border spinner-border-sm me-2" role="status"></span>
                            Verifying...
                        </span>
                    </button>

                    <!-- Resend -->
                    <div class="d-flex justify-content-center align-items-center">
                        <form id="resendForm" method="POST" action="{{ route('customer.otp.resend', $customer->id) }}" class="d-inline">
                            @csrf
                            @method('POST')
                            <input type="hidden" name="email" value="{{ $customer->email }}">
                            <button type="submit" class="btn btn-outline-primary btn-sm resend-btn" id="resendBtn">
                                <i class="bi bi-arrow-clockwise me-1"></i>Resend Code
                            </button>
                        </form>
                        <span id="resendCooldown" class="ms-2 text-muted small d-none"></span>
                    </div>
                </div>
            </div>

            <div class="text-center mt-4">
                <p class="text-muted small mb-0">
                    Didn't receive the code? Check your spam folder or 
                    <a href="{{ route('customer.login') }}" class="text-accent fw-semibold">return to login</a>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const otpInputs = document.querySelectorAll('.otp-input');
    const form = document.getElementById('otpForm');
    const verifyBtn = document.getElementById('verifyBtn');
    const resendBtn = document.getElementById('resendBtn');
    const resendForm = document.getElementById('resendForm');
    let resendCooldown = 60; // 60 seconds
    let cooldownTimer = null;

    // Focus first input
    otpInputs[0].focus();

    // Input handling
    otpInputs.forEach((input, index) => {
        input.addEventListener('input', (e) => {
            // Only allow numbers
            e.target.value = e.target.value.replace(/[^0-9]/g, '').slice(0,1);
            
            // Move to next
            if (e.target.value && index < 5) {
                otpInputs[index + 1].focus();
            }
            
            // Auto-submit when complete
            if (isFormComplete()) {
                setTimeout(() => form.submit(), 500);
            }
        });

        input.addEventListener('keydown', (e) => {
            // Backspace to previous
            if (e.key === 'Backspace' && !e.target.value && index > 0) {
                otpInputs[index - 1].focus();
            }
            // Allow paste handling separately
        });

        input.addEventListener('paste', (e) => {
            e.preventDefault();
            const paste = (e.clipboardData || window.clipboardData).getData('text');
            const numbers = paste.replace(/[^0-9]/g, '').slice(0,6);
            
            for (let i = 0; i < numbers.length && i < 6; i++) {
                otpInputs[i].value = numbers[i];
            }
            otpInputs[Math.min(numbers.length, 5)].focus();
        });
    });

    // Form validation
    form.addEventListener('submit', function() {
        if (!isFormComplete()) {
            showError('Please enter all 6 digits');
            return false;
        }
        showLoading(true);
    });

    // Resend with cooldown
    resendBtn.addEventListener('click', function(e) {
        if (resendCooldown > 0) {
            e.preventDefault();
            return false;
        }
        resendBtn.dataset.originalHTML = resendBtn.innerHTML;
        showLoadingResend(true);
        resendForm.submit();
    });

    function isFormComplete() {
        return Array.from(otpInputs).every(input => input.value.length === 1);
    }

    function showError(message) {
        otpInputs[0].classList.add('error');
        otpInputs[0].focus();
        setTimeout(() => otpInputs[0].classList.remove('error'), 2000);
    }

    function showLoading(show) {
        const btnText = verifyBtn.querySelector('.btn-text');
        const btnSpinner = verifyBtn.querySelector('.btn-spinner');
        verifyBtn.disabled = show;
        
        if (show) {
            btnText.classList.add('d-none');
            btnSpinner.classList.remove('d-none');
        } else {
            btnText.classList.remove('d-none');
            btnSpinner.classList.add('d-none');
        }
    }

    function showLoadingResend(show) {
        resendBtn.disabled = show;
        const originalHTML = resendBtn.dataset.originalHTML || resendBtn.innerHTML;
        if (show) {
            resendBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-1" role="status"></span>Sending...';
        } else {
            resendBtn.innerHTML = originalHTML;
        }
    }

    // Precise countdown using timestamp - FIXED instant 0 issue
    let timer = null;
    @if(isset($endTimestamp))
    const endTime = {{ $endTimestamp }} * 1000;
    const countdownEl = document.getElementById('countdown');
    
    function updateCountdown() {
        const remainingMs = endTime - Date.now();
        const remainingSec = Math.floor(remainingMs / 1000);
        if (remainingSec > 0) {
            countdownEl.textContent = remainingSec;
        } else {
            clearInterval(timer);
            // Expire state
            otpInputs.forEach(input => input.disabled = true);
            verifyBtn.disabled = true;
            verifyBtn.innerHTML = '<i class="bi bi-x-circle me-2"></i>Expired';
            verifyBtn.classList.add('btn-danger');
            resendBtn.classList.remove('resend-cooldown');
            resendBtn.innerHTML = '<i class="bi bi-arrow-clockwise me-2"></i><strong>Resend Code</strong>';
            countdownEl.closest('.alert').innerHTML = '<i class="bi bi-exclamation-triangle-fill text-warning me-2"></i><strong>Expired!</strong> <a href="#" onclick="document.getElementById(\'resendForm\').submit();return false;" class="text-primary">Get new code</a>';
        }
    }
    
    timer = setInterval(updateCountdown, 1000);
    updateCountdown(); // Initial
    @endif

    // Resend cooldown timer
    const cooldownEl = document.getElementById('resendCooldown');
    cooldownTimer = setInterval(() => {
        if (resendCooldown > 0) {
            resendCooldown--;
            resendBtn.classList.add('resend-cooldown');
            cooldownEl.classList.remove('d-none');
            cooldownEl.textContent = `(${resendCooldown}s)`;
        } else {
            clearInterval(cooldownTimer);
            resendBtn.classList.remove('resend-cooldown');
            cooldownEl.classList.add('d-none');
        }
    }, 1000);
});
</script>
@endsection
