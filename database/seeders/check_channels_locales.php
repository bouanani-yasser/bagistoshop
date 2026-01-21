<?php

require __DIR__ . '/../../vendor/autoload.php';
$app = require_once __DIR__ . '/../../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "========================================\n";
echo "CHANNELS AND LOCALES CHECK\n";
echo "========================================\n\n";

// Check channels
$channels = DB::table('channels')->get();
echo "Channels:\n";
foreach ($channels as $channel) {
    $name = isset($channel->name) ? $channel->name : 'N/A';
    echo "  ID: {$channel->id} | Code: {$channel->code} | Name: {$name}\n";
    
    // Get locales for this channel
    $locales = DB::table('channel_locales')
        ->join('locales', 'channel_locales.locale_id', '=', 'locales.id')
        ->where('channel_locales.channel_id', $channel->id)
        ->get(['locales.code', 'locales.name']);
    
    echo "    Locales: ";
    foreach ($locales as $locale) {
        echo "{$locale->code} ({$locale->name}), ";
    }
    echo "\n\n";
}

// Check how many product_flat entries per locale
echo "\n========================================\n";
echo "PRODUCT_FLAT DISTRIBUTION\n";
echo "========================================\n\n";

$locales = DB::table('locales')->get();
foreach ($locales as $locale) {
    $count = DB::table('product_flat')
        ->where('sku', 'like', 'DENTAL-%')
        ->where('locale', $locale->code)
        ->count();
    
    echo "Locale {$locale->code} ({$locale->name}): $count dental products\n";
}

// Check active locale
echo "\n========================================\n";
echo "CURRENT DEFAULT LOCALE\n";
echo "========================================\n\n";

$defaultLocale = DB::table('locales')->where('code', 'en')->first();
if ($defaultLocale) {
    echo "Default locale code: {$defaultLocale->code}\n";
    echo "Default locale name: {$defaultLocale->name}\n";
}
