<?php

require __DIR__ . '/../../vendor/autoload.php';
$app = require_once __DIR__ . '/../../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "Checking channel structure...\n";
$channel = DB::table('channels')->first();
var_dump($channel);

echo "\n\nProduct flat for DENTAL-001:\n";
$flats = DB::table('product_flat')->where('sku', 'DENTAL-001')->get();
foreach ($flats as $flat) {
    echo "  Locale: {$flat->locale}, Channel: {$flat->channel}, Status: {$flat->status}, Visible: {$flat->visible_individually}\n";
}
