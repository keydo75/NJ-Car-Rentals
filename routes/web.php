<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\RentalController;
use App\Http\Controllers\Admin\Auth\LoginController as AdminLoginController;
use App\Http\Controllers\Admin\VehicleController as AdminVehicleController;
use App\Http\Controllers\Staff\Auth\LoginController as StaffLoginController;
use App\Http\Controllers\Customer\Auth\LoginController as CustomerLoginController;
use App\Http\Controllers\Customer\Auth\OtpController;
use App\Http\Controllers\Customer\Auth\VerificationController;
use App\Http\Controllers\Customer\ProfileController;
use App\Http\Controllers\Admin\CustomerController as AdminCustomerController;
use App\Http\Controllers\Admin\RentalController as AdminRentalController;
use App\Http\Controllers\Admin\InquiryController as AdminInquiryController;
use App\Models\Rental;
use App\Models\Inquiry;
use App\Models\Vehicle;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\InquiryController;
use App\Http\Controllers\Api\GpsPositionController;
use App\Http\Controllers\Api\MessageController;
use App\Http\Controllers\Api\TransactionController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\ChatController;

// Homepage
Route::get('/', [HomeController::class, 'index'])->name('home');

// ======================
// SEPARATE AUTH ROUTES (OPTION B)
// ======================

// ADMIN AUTH
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AdminLoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AdminLoginController::class, 'login']);
    Route::post('/logout', [AdminLoginController::class, 'logout'])->name('logout');
    
    Route::middleware('auth:admin')->group(function () {
        Route::get('/dashboard', function (Request $request) {
            $admin = auth()->guard('admin')->user();

            // Stats Cards
            $stats = [
                'revenue_last_30_days' => Rental::where('created_at', '>=', now()->subDays(30))->where('status', 'completed')->sum('total_price'),
                'rentals_last_30_days' => Rental::where('created_at', '>=', now()->subDays(30))->count(),
                'pending_inquiries' => Inquiry::where('status', 'pending')->count(),
                'available_vehicles' => Vehicle::where('status', 'available')->count(),
            ];

            // Recent Rentals Table
            $recentRentals = Rental::with(['customer', 'vehicle'])->latest()->take(5)->get();

            // Chart Data: Rentals per day for the last 7 days
            $rentalsPerDay = Rental::query()
                ->select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as count'))
                ->where('created_at', '>=', now()->subDays(7))
                ->groupBy('date')
                ->orderBy('date', 'ASC')
                ->get()->pluck('count', 'date');

            $chartLabels = [];
            $chartData = [];
            $dateIterator = now()->subDays(6);
            while ($dateIterator <= now()) {
                $formattedDate = $dateIterator->format('Y-m-d');
                $chartLabels[] = $dateIterator->format('M d');
                $chartData[] = $rentalsPerDay[$formattedDate] ?? 0;
                $dateIterator->addDay();
            }

            $charts = ['rentals' => ['labels' => $chartLabels, 'data' => $chartData]];

            return view('admin.dashboard', compact('admin', 'stats', 'recentRentals', 'charts'));
        })->name('dashboard');

        // Vehicle Management
        Route::resource('vehicles', AdminVehicleController::class);
        Route::post('vehicles/{id}/restore', [AdminVehicleController::class, 'restore'])->name('vehicles.restore');
        Route::delete('vehicles/{id}/force-delete', [AdminVehicleController::class, 'forceDelete'])->name('vehicles.force-delete');

        // Customer Management - Full CRUD
        Route::resource('customers', AdminCustomerController::class);

        // Rental Management
        Route::resource('rentals', AdminRentalController::class, ['only' => ['index', 'show']]);
        Route::put('rentals/{rental}/status', [AdminRentalController::class, 'updateStatus'])->name('rentals.updateStatus');

        // Inquiry Management
        Route::resource('inquiries', AdminInquiryController::class, ['only' => ['index', 'show']]);
        Route::put('inquiries/{inquiry}/status', [AdminInquiryController::class, 'updateStatus'])->name('inquiries.updateStatus');

        // Chat
        Route::get('/chat', [ChatController::class, 'adminChat'])->name('chat');
        Route::get('/chat/messages', [ChatController::class, 'getMessages'])->name('chat.messages');
        Route::post('/chat/send', [ChatController::class, 'sendMessage'])->name('chat.send');
        Route::get('/chat/unread-count', [ChatController::class, 'getUnreadCount'])->name('chat.unread');

        // Reports
        Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    });
});

// STAFF AUTH
Route::prefix('staff')->name('staff.')->group(function () {
    Route::get('/login', [StaffLoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [StaffLoginController::class, 'login']);
    Route::post('/logout', [StaffLoginController::class, 'logout'])->name('logout');
    
    Route::middleware('auth:staff')->group(function () {
        Route::get('/dashboard', function () {
            $staff = auth()->guard('staff')->user();
            return view('staff.dashboard', compact('staff'));
        })->name('dashboard');
        // ... other staff routes
    });
});

// CUSTOMER AUTH - FIXED ROUTES
Route::prefix('customer')->name('customer.')->group(function () {
    Route::get('/login', [CustomerLoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [CustomerLoginController::class, 'login']);
    Route::post('/logout', [CustomerLoginController::class, 'logout'])->name('logout');
    
    // FIXED OTP Routes - Both GET and POST for resend
    Route::get('/otp/{customer}', [OtpController::class, 'showOtpForm'])->name('otp.show');
    Route::post('/otp/{customer}/verify', [OtpController::class, 'verifyOtp'])->name('otp.verify');
    Route::match(['GET', 'POST'], '/otp/{customer}/resend', [OtpController::class, 'resendOtp'])->name('otp.resend');
    
    Route::get('/verification-success', function () {
        return view('customer.auth.verification-success');
    })->name('verification.success');
    
    // Forgot Password Routes
    Route::get('/forgot-password', [\App\Http\Controllers\Customer\Auth\ForgotPasswordController::class, 'showForgotPasswordForm'])->name('password.request');
    Route::post('/forgot-password', [\App\Http\Controllers\Customer\Auth\ForgotPasswordController::class, 'sendResetLink'])->name('password.email');
    Route::get('/reset-password/{token}', [\App\Http\Controllers\Customer\Auth\ForgotPasswordController::class, 'showResetPasswordForm'])->name('password.reset');
    Route::post('/reset-password', [\App\Http\Controllers\Customer\Auth\ForgotPasswordController::class, 'resetPassword'])->name('password.update');
    
    // Customer registration
    Route::get('/register', function () {
        return view('customer.auth.register');
    })->name('register');
    Route::post('/register', [CustomerLoginController::class, 'register'])->name('register.submit');
    
    Route::middleware('auth:customer')->group(function () {
        Route::get('/dashboard', function () {
            $customer = auth()->guard('customer')->user();
            return view('customer.dashboard', compact('customer'));
        })->name('dashboard');

        Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');

        Route::get('/inquiries', [\App\Http\Controllers\Customer\InquiryController::class, 'index'])->name('inquiries');
        Route::put('/inquiries/{id}/cancel', [\App\Http\Controllers\Customer\InquiryController::class, 'cancel'])->name('inquiries.cancel');

        Route::get('/bookings', [\App\Http\Controllers\Customer\BookingController::class, 'index'])->name('bookings');
        Route::put('/bookings/{id}/cancel', [\App\Http\Controllers\Customer\BookingController::class, 'cancel'])->name('bookings.cancel');

        Route::get('/chat', [ChatController::class, 'customerChat'])->name('chat');
        Route::get('/chat/messages', [ChatController::class, 'getMessages'])->name('chat.messages');
        Route::post('/chat/send', [ChatController::class, 'sendMessage'])->name('chat.send');
        Route::get('/chat/unread-count', [ChatController::class, 'getUnreadCount'])->name('chat.unread');
    });
});

// Public Vehicle Browsing
Route::prefix('vehicles')->group(function () {
    Route::get('/', [VehicleController::class, 'index'])->name('vehicles.index');
    Route::get('/rental', [VehicleController::class, 'rental'])->name('vehicles.rental');
    Route::get('/sale', [VehicleController::class, 'sale'])->name('vehicles.sale');
    Route::get('/{id}', [VehicleController::class, 'show'])->name('vehicles.show');

    Route::post('/{id}/inquiries', [InquiryController::class, 'store'])->middleware('auth:customer')->name('inquiries.store');
    Route::post('/rentals', [RentalController::class, 'store'])->middleware('auth:customer')->name('rentals.store');
    Route::get('/rentals/calculate-price', [RentalController::class, 'calculatePrice'])->name('rentals.calculatePrice');
    Route::post('/{id}/image', [VehicleController::class, 'uploadImage'])->name('vehicles.uploadImage');
});

// Other Pages
Route::get('/contact', function () {
    return view('contact');
})->name('contact');

// Newsletter subscription
Route::post('/subscribe', [SubscriptionController::class, 'store'])->name('subscribe');

// API endpoints
Route::prefix('api')->group(function () {
    Route::post('/gps', [GpsPositionController::class, 'store']);
    Route::get('/messages', [MessageController::class, 'index']);
    Route::post('/messages', [MessageController::class, 'store']);
    Route::post('/transactions', [TransactionController::class, 'store']);
});

// Login/Register redirects
Route::get('/login', [CustomerLoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [CustomerLoginController::class, 'login']);

Route::get('/register', function () {
    return redirect()->route('customer.register');
})->name('register');

// Home redirect based on auth
Route::get('/home', function () {
    if (auth()->guard('admin')->check()) {
        return redirect()->route('admin.dashboard');
    }
    if (auth()->guard('staff')->check()) {
        return redirect()->route('staff.dashboard');
    }
    if (auth()->guard('customer')->check()) {
        return redirect()->route('customer.dashboard');
    }
    return redirect()->route('home');
});
