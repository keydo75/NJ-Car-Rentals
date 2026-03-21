<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Vehicle;

$vehicles = Vehicle::all();
$changes = [];
foreach ($vehicles as $v) {
    $orig = ['id' => $v->id, 'image_path' => $v->image_path, 'image_url' => $v->image_url];

    $ip = trim((string)($v->image_path ?? ''));
    $iu = trim((string)($v->image_url ?? ''));

    // Normalize leading slashes
    $norm = function ($s) {
        if ($s === '') return '';
        $s = preg_replace('#^/+#', '', $s);
        return $s;
    };

    $new_ip = $ip !== '' ? $norm($ip) : '';
    $new_iu = $iu !== '' ? $norm($iu) : '';

    // If image_url contains a storage path and image_path is empty, move it to image_path and clear image_url
    if ($new_ip === '' && preg_match('#^(storage/|/storage/)#i', $iu)) {
        $new_ip = preg_replace('#^/+#', '', $iu);
        $new_iu = '';
    }

    // If image_path points to images/ but image_url is empty, prefer images in image_url
    if ($new_iu === '' && preg_match('#^(images/|/images/)#i', $new_ip)) {
        // keep image_path as-is; no move necessary
    }

    // If both are non-empty and identical, clear image_url to avoid duplicates
    if ($new_ip !== '' && $new_iu !== '' && $new_ip === $new_iu) {
        $new_iu = '';
    }

    // Preserve absolute URLs (http...)
    if (preg_match('#^https?://#i', $iu)) {
        $new_iu = $iu; // keep full URL
    }

    // Apply changes
    $applied = false;
    if ($v->image_path !== ($new_ip === '' ? null : $new_ip)) {
        $v->image_path = $new_ip === '' ? null : $new_ip;
        $applied = true;
    }
    if ($v->image_url !== ($new_iu === '' ? null : $new_iu)) {
        $v->image_url = $new_iu === '' ? null : $new_iu;
        $applied = true;
    }

    if ($applied) {
        $v->save();
        $changes[] = ['id' => $v->id, 'before' => $orig, 'after' => ['image_path' => $v->image_path, 'image_url' => $v->image_url]];
    }
}

$backupFile = __DIR__ . '/vehicle_images_backup_' . date('Ymd_His') . '.json';
file_put_contents($backupFile, json_encode($changes, JSON_PRETTY_PRINT));

echo "Normalization complete. Changes: " . count($changes) . "\n";
echo "Backup written to: $backupFile\n";
if (count($changes) > 0) {
    foreach ($changes as $c) {
        echo "- ID {$c['id']}: {image_path} {$c['before']['image_path']} -> {$c['after']['image_path']}, {image_url} {$c['before']['image_url']} -> {$c['after']['image_url']}\n";
    }
}
