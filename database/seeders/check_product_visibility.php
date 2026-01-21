<?php

require __DIR__ . '/../../vendor/autoload.php';
$app = require_once __DIR__ . '/../../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "========================================\n";
echo "PRODUCT VISIBILITY CHECK\n";
echo "========================================\n\n";

// Check product_flat table
$products = DB::table('product_flat')
    ->where('sku', 'like', 'DENTAL-%')
    ->where('locale', 'en')
    ->where('channel', 'default')
    ->get(['sku', 'name', 'status', 'visible_individually', 'url_key', 'price']);

echo "Products in product_flat (EN, default channel):\n";
echo "Total: " . $products->count() . "\n\n";

foreach ($products as $product) {
    echo "SKU: {$product->sku}\n";
    echo "  Name: {$product->name}\n";
    echo "  Status: " . ($product->status ? 'ENABLED ✓' : 'DISABLED ✗') . "\n";
    echo "  Visible Individually: " . ($product->visible_individually ? 'YES ✓' : 'NO ✗') . "\n";
    echo "  URL Key: {$product->url_key}\n";
    echo "  Price: {$product->price}\n\n";
}

// Check if categories are visible
echo "\n========================================\n";
echo "CATEGORY STATUS\n";
echo "========================================\n\n";

$categories = DB::table('categories')
    ->join('category_translations', 'categories.id', '=', 'category_translations.category_id')
    ->where('category_translations.locale', 'en')
    ->where(function($query) {
        $query->where('category_translations.name', 'like', '%Dental%')
              ->orWhere('category_translations.name', 'like', '%Instrument%')
              ->orWhere('category_translations.name', 'like', '%Consumable%')
              ->orWhere('category_translations.name', 'like', '%Imaging%')
              ->orWhere('category_translations.name', 'like', '%Hygiene%')
              ->orWhere('category_translations.name', 'like', '%Prosthetic%')
              ->orWhere('category_translations.name', 'like', '%Orthodontic%');
    })
    ->select('categories.id', 'category_translations.name', 'categories.status', 'categories.display_mode')
    ->get();

foreach ($categories as $cat) {
    echo "Category: {$cat->name}\n";
    echo "  ID: {$cat->id}\n";
    echo "  Status: " . ($cat->status ? 'ENABLED ✓' : 'DISABLED ✗') . "\n";
    echo "  Display Mode: {$cat->display_mode}\n\n";
}
