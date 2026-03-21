<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Customer;
use App\Models\Rental;

$customerId = $argv[1] ?? null;
if (!$customerId) {
    echo "Usage: php scripts/check_customer_bookings.php <customer_id>\n";
    exit(1);
}

$customer = Customer::find($customerId);
if (!$customer) {
    echo "Customer with id {$customerId} not found.\n";
    exit(1);
}

echo "Customer: {$customer->id} | {$customer->name} | {$customer->email}\n";

$bookings = Rental::where('user_id', $customer->id)->orderBy('created_at', 'desc')->get();
echo "Rental query returned: " . $bookings->count() . " rows\n\n";
foreach ($bookings as $b) {
    echo "#{$b->id} vehicle_id={$b->vehicle_id} status={$b->status} start={$b->start_date} end={$b->end_date} created={$b->created_at}\n";
}

// Also show $customer->rentals relationship
echo "\nUsing relationship customer->rentals():\n";
$rel = $customer->rentals()->orderBy('created_at', 'desc')->get();
echo "Relationship returned: " . $rel->count() . " rows\n";
foreach ($rel as $b) {
    echo "#{$b->id} vehicle_id={$b->vehicle_id} status={$b->status}\n";
}

echo "\nDone.\n";
