<?php
require 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

echo "Creating admin: admin / admin123\n";

Admin::updateOrCreate(
    ['email' => 'admin'],
    [
        'name' => 'Admin',
        'username' => 'admin',
        'email' => 'admin',
        'password' => Hash::make('admin123'),
        'admin_level
