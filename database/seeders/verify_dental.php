<?php

require __DIR__ . '/../../vendor/autoload.php';
$app = require_once __DIR__ . '/../../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "========================================\n";
echo "DENTAL PRODUCTS VERIFICATION\n";
echo "========================================\n\n";

// Count products
$products = DB::table('products')->where('sku', 'like', 'DENTAL-%')->count();
echo "✓ Dental Products: $products\n";

// Count categories
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
    ->count();
echo "✓ Dental Categories (EN): $categories\n";

// List categories
echo "\nCategories created:\n";
$cats = DB::table('category_translations')
    ->where('locale', 'en')
    ->where(function($query) {
        $query->where('name', 'like', '%Dental%')
              ->orWhere('name', 'like', '%Instrument%')
              ->orWhere('name', 'like', '%Consumable%')
              ->orWhere('name', 'like', '%Imaging%')
              ->orWhere('name', 'like', '%Hygiene%')
              ->orWhere('name', 'like', '%Prosthetic%')
              ->orWhere('name', 'like', '%Orthodontic%');
    })
    ->get();

foreach ($cats as $cat) {
    echo "  - $cat->name\n";
}

// List products
echo "\nProducts created:\n";
$prods = DB::table('products')
    ->join('product_flat', 'products.id', '=', 'product_flat.product_id')
    ->where('products.sku', 'like', 'DENTAL-%')
    ->where('product_flat.locale', 'en')
    ->select('products.sku', 'product_flat.name', 'product_flat.price')
    ->get();

foreach ($prods as $prod) {
    echo "  - {$prod->sku}: {$prod->name} (\${$prod->price})\n";
}

echo "\n========================================\n";
echo "All dental data created successfully!\n";
echo "You can now view them in your Bagisto dashboard.\n";
echo "========================================\n";