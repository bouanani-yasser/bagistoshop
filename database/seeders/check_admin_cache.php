<?php

require __DIR__ . '/../../vendor/autoload.php';
$app = require_once __DIR__ . '/../../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "========================================\n";
echo "BAGISTO ADMIN CACHE & SETTINGS CHECK\n";
echo "========================================\n\n";

// Check current locale settings
$defaultLocale = config('app.locale');
$availableLocales = config('app.available_locales');
echo "Default Locale: $defaultLocale\n";
echo "Available Locales: " . print_r($availableLocales, true) . "\n";

// Check all locales
$allLocales = DB::table('locales')->get();
echo "\nConfigured Locales in DB:\n";
foreach ($allLocales as $locale) {
    echo "  - {$locale->code} ({$locale->name})\n";
}

// Check channels
echo "\nChannels:\n";
$channels = DB::table('channels')->get();
foreach ($channels as $channel) {
    echo "  - ID: {$channel->id}, Code: {$channel->code}, Name: {$channel->name}\n";
    echo "    Root Category ID: {$channel->root_category_id}\n";
    echo "    Default Locale: {$channel->default_locale_id}\n";
}

// Check if dental categories appear in any specific locale
echo "\n========================================\n";
echo "DENTAL CATEGORY TRANSLATIONS CHECK\n";
echo "========================================\n\n";

$dentalTranslations = DB::table('category_translations')
    ->where('name', 'like', '%Dental%')
    ->orWhere('name', 'like', '%Instrument%')
    ->orWhere('name', 'like', '%Consommable%')
    ->get();

foreach ($dentalTranslations as $trans) {
    echo "Category ID: {$trans->category_id}\n";
    echo "  Locale: {$trans->locale}\n";
    echo "  Name: {$trans->name}\n";
    echo "  Slug: {$trans->slug}\n\n";
}

// Try to rebuild category cache
echo "========================================\n";
echo "REBUILDING CATEGORY TREE\n";
echo "========================================\n\n";

try {
    // Use Bagisto's Category model to rebuild the tree
    $categoryModel = app(\Webkul\Category\Models\Category::class);
    
    if (method_exists($categoryModel, 'fixTree')) {
        $categoryModel::fixTree();
        echo "✓ Category tree fixed\n";
    } else {
        echo "ℹ fixTree method not available\n";
    }
    
    // Check if there's a rebuildTree method
    if (method_exists($categoryModel, 'rebuildTree')) {
        $categoryModel::rebuildTree([]);
        echo "✓ Category tree rebuilt\n";
    }
} catch (Exception $e) {
    echo "Note: " . $e->getMessage() . "\n";
}

echo "\n========================================\n";
echo "CHECKING ADMIN MENU CONFIGURATION\n";
echo "========================================\n\n";

// Check if there's a menu cache or admin configuration
$cacheKeys = ['categories', 'category_tree', 'admin_menu', 'bagisto'];
foreach ($cacheKeys as $key) {
    if (Cache::has($key)) {
        echo "Cache key '$key' exists - clearing...\n";
        Cache::forget($key);
    }
}

echo "\n✓ All cache keys cleared\n";
echo "\nPlease try the following:\n";
echo "1. Clear browser cache (Ctrl+Shift+Delete)\n";
echo "2. Logout and login to admin panel\n";
echo "3. Go to Catalog → Categories\n";
echo "4. Check if 'Dental Products' appears under root category\n";