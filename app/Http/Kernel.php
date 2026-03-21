protected $routeMiddleware = [
    // ... existing middleware
    'auth' => \App\Http\Middleware\Authenticate::class,
    'admin' => \App\Http\Middleware\AdminMiddleware::class,
    'staff' => \App\Http\Middleware\StaffMiddleware::class,
    'customer' => \App\Http\Middleware\CustomerMiddleware::class,
    // ... rest of middleware
];