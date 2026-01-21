<?php

require __DIR__ . '/../../vendor/autoload.php';
$app = require_once __DIR__ . '/../../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "========================================\n";
echo "PRODUCT FLAT MISSING FIELDS CHECK\n";
echo "========================================\n\n";

// Check DENTAL-001 in all locales
$products = DB::table('product_flat')->where('sku', 'DENTAL-001')->get();

foreach ($products as $product) {
    echo "Locale: {$product->locale}\n";
    echo "  Name: " . ($product->name ?: '⚠ MISSING') . "\n";
    echo "  Description: " . (strlen($product->description ?? '') > 0 ? 'Present' : '⚠ MISSING') . "\n";
    echo "  Short Description: " . (strlen($product->short_description ?? '') > 0 ? 'Present' : '⚠ MISSING') . "\n";
    echo "  URL Key: " . ($product->url_key ?: '⚠ MISSING') . "\n";
    echo "  Meta Title: " . ($product->meta_title ?: '⚠ MISSING') . "\n";
    echo "  Price: " . ($product->price ?: '⚠ MISSING') . "\n";
    echo "  Product Number: " . ($product->product_number ?: 'NULL') . "\n\n";
}
