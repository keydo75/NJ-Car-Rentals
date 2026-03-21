<?php
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

foreach (App\Models\Vehicle::all() as $v) {
    echo $v->id.' | '.$v->year.' '.$v->make.' '.$v->model.' | image_path: '.($v->image_path ?? 'NULL').' | image_url: '.($v->image_url ?? 'NULL')."\n";
}
