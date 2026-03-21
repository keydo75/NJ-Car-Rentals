<?php

require __DIR__.'/../vendor/autoload.php';

$app = require_once __DIR__.'/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

Admin::where('id',1)->update([
    'email' => 'admin',
    'password' => Hash::make('admin 123')
]);

echo "Admin updated!\n";
echo "Email: admin\n";
echo "Password: admin 123\n";
echo "Username still: " . Admin::first()->username . "\n";
?>

