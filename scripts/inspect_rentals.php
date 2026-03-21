<?php

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

echo "Inspecting latest rentals and user mappings...\n\n";

$rows = DB::select('SELECT id, user_id, vehicle_id, status, created_at FROM rentals ORDER BY id DESC LIMIT 50');
if (!count($rows)) {
    echo "No rentals found.\n";
    exit(0);
}

foreach ($rows as $r) {
    $inCustomers = DB::table('customers')->where('id', $r->user_id)->first();
    $inUsers = null;
    if (Schema::hasTable('users')) {
        $inUsers = DB::table('users')->where('id', $r->user_id)->first();
    }

    $vehicle = DB::table('vehicles')->where('id', $r->vehicle_id)->first();

    echo "Rental #{$r->id} — user_id={$r->user_id} vehicle_id={$r->vehicle_id} status={$r->status} created={$r->created_at}\n";
    echo "  in customers: " . ($inCustomers ? 'YES' : 'NO') . "\n";
    if ($inCustomers) {
        echo "    customer: {$inCustomers->id} | {$inCustomers->name} | {$inCustomers->email}\n";
    }
    echo "  in users: " . ($inUsers ? 'YES' : 'NO') . "\n";
    if ($inUsers) {
        echo "    user: {$inUsers->id} | {$inUsers->name} | {$inUsers->email}\n";
    }
    echo "\n";
}

echo "Done.\n";
