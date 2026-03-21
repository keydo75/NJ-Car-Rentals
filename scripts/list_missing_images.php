<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$vehicles = \App\Models\Vehicle::whereNull('image_url')
    ->orWhere('image_url','')
    ->orWhereNull('image_path')
    ->orWhere('image_path','')
    ->get(['id','make','model','image_url','image_path']);

echo $vehicles->toJson(JSON_PRETTY_PRINT) . PHP_EOL;