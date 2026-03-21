<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class Customer extends Authenticatable implements CanResetPasswordContract
{
    use HasFactory, Notifiable, CanResetPassword;

protected $fillable = [
        'name',
        'first_name',
        'middle_initial',
        'last_name',
        'email',
        'password',
        'phone',
        'address',
        'loyalty_points',
        'verification_token',
        'email_verified_at',
        'otp',
        'otp_expires_at'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'otp_expires_at' => 'datetime',
    ];

    // Relationships
    public function rentals()
    {
        return $this->hasMany(Rental::class, 'user_id');
    }

    public function inquiries()
    {
        return $this->hasMany(Inquiry::class);
    }

    /**
     * Check if email is verified
     */
    public function hasVerifiedEmail(): bool
    {
        return !is_null($this->email_verified_at);
    }

    /**
     * Generate 6-digit OTP, expires in 10 min ✅ FIXED
     */
    public function generateOtp(): string
    {
        $this->otp = str_pad((string) rand(100000, 999999), 6, '0', STR_PAD_LEFT);
        $this->otp_expires_at = now()->addMinutes(5);
        $this->save();
        Log::info('Generated OTP (5 min expiry)', ['customer_id' => $this->id, 'expires_at' => $this->otp_expires_at]);
        
        // Send OTP via email
        Mail::to($this->email)->send(new \App\Mail\OtpMail($this->otp, $this->name));
        Log::info('OTP email sent successfully', [
            'customer_id' => $this->id, 
            'email' => $this->email,
            'otp_sent' => substr($this->otp, 0, 2) . '**' . substr($this->otp, 4)
        ]);
        
        return $this->otp;
    }

    /**
     * Validate input OTP
     */
    public function isOtpValid(string $inputOtp): bool
    {
        $isValid = filled($this->otp) 
            && $inputOtp === $this->otp
            && (!$this->otp_expires_at || now()->lte($this->otp_expires_at));
        
        Log::info('OTP validation result', [
            'customer_id' => $this->id,
            'valid' => $isValid,
            'input_matches' => $inputOtp === substr($this->otp ?? '', 0, 2) . '**' . substr($this->otp ?? '', 4),
            'seconds_left' => $this->otp_expires_at ? $this->otp_expires_at->diffInSeconds(now()) : null
        ]);
        
        return $isValid;
    }

    /**
     * Clear OTP and token post-verification
     */
    public function clearOtp(): void
    {
        $this->otp = null;
        $this->otp_expires_at = null;
        $this->verification_token = null;
        $this->saveQuietly();
    }

    /**
     * Customer role check
     */
    public function isCustomer(): bool
    {
        return true;
    }

    /**
     * Accessor for full name from first + middle initial + last name
     */
    public function getNameAttribute(): string
    {
        $parts = [];
        if ($this->first_name) $parts[] = $this->first_name;
        if ($this->middle_initial) $parts[] = $this->middle_initial;
        if ($this->last_name) $parts[] = $this->last_name;
        return trim(implode(' ', $parts));
    }
}
