<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

$admin = Admin::where('email', 'admin@njcarrentals.com')->first();
if (! $admin) {
    echo "ADMIN_NOT_FOUND\n";
    exit(1);
}

$admin->password = Hash::make('password 123');
$admin->save();

echo "UPDATED\n";
