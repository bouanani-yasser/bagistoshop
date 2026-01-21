<?php

require __DIR__ . '/../../vendor/autoload.php';
$app = require_once __DIR__ . '/../../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$locale = DB::table('locales')->where('id', 2)->first();
echo "Default locale ID 2: {$locale->code} ({$locale->name})\n";

// Fix the product_flat entries for French and Arabic
echo "\nFixing product_flat entries...\n";

DB::table('product_flat')
    ->where('sku', 'like', 'DENTAL-%')
    ->where('locale', '!=', 'en')
    ->update([
        'status' => 1,
        'visible_individually' => 1,
        'new' => 1,
        'featured' => 1,
    ]);

echo "✓ Updated product_flat entries for all locales\n";

// Verify
$fixed = DB::table('product_flat')
    ->where('sku', 'DENTAL-001')
    ->get(['locale', 'status', 'visible_individually']);

echo "\nVerification:\n";
foreach ($fixed as $f) {
    echo "  Locale: {$f->locale}, Status: {$f->status}, Visible: {$f->visible_individually}\n";
}
