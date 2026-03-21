<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo asset('storage/images/vehicles/mFYZxXZp2w0JQh0AnnEPF9kobilFaxwA9wpyc2B0.png') . PHP_EOL;