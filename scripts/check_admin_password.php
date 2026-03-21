<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$admin = App\Models\Admin::where('email', 'admin@njcarrentals.com')->first();
if (! $admin) {
    echo "ADMIN_NOT_FOUND\n";
    exit(1);
}

echo (Illuminate\Support\Facades\Hash::check('password 123', $admin->password) ? "MATCH\n" : "NO_MATCH\n");

// Show current username and email for debugging
echo "username: " . ($admin->username ?? '(null)') . "\n";
echo "email: " . ($admin->email ?? '(null)') . "\n";
