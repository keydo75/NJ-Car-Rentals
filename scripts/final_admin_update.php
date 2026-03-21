<?php

require __DIR__.'/../vendor/autoload.php';

$app = require_once __DIR__.'/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Admin;
use App\Models\Staff;
use Illuminate\Support\Facades\Hash;

// Update admin password to admin123
Admin::where('id',1)->update([
    'password' => Hash::make('admin123')
]);

// Delete staff
Staff::truncate();

echo "Admin password updated to 'admin123' (email: admin, username: admin)\n";
echo "Staff table cleared.\n";
?>

