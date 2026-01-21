<?php

require __DIR__ . '/../../vendor/autoload.php';
$app = require_once __DIR__ . '/../../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "========================================\n";
echo "PRODUCT_FLAT LOCALE DISTRIBUTION\n";
echo "========================================\n\n";

// Count products per locale
$locales = ['en', 'FR', 'ar'];
foreach ($locales as $locale) {
    $count = DB::table('product_flat')
        ->where('sku', 'like', 'DENTAL-%')
        ->where('locale', $locale)
        ->count();
    
    echo "Locale $locale: $count products\n";
}

echo "\n========================================\n";
echo "DETAILED CHECK FOR DENTAL-001\n";
echo "========================================\n\n";

$products = DB::table('product_flat')
    ->where('sku', 'DENTAL-001')
    ->get(['locale', 'name', 'url_key', 'status', 'visible_individually', 'product_number']);

foreach ($products as $p) {
    echo "Locale: {$p->locale}\n";
    echo "  Name: {$p->name}\n";
    echo "  URL Key: {$p->url_key}\n";
    echo "  Product Number: {$p->product_number}\n";
    echo "  Status: {$p->status}\n";
    echo "  Visible: {$p->visible_individually}\n\n";
}

// Check product_attribute_values
echo "\n========================================\n";
echo "PRODUCT ATTRIBUTE VALUES CHECK\n";
echo "========================================\n\n";

$productId = DB::table('products')->where('sku', 'DENTAL-001')->value('id');
$attrs = DB::table('product_attribute_values')
    ->join('attributes', 'product_attribute_values.attribute_id', '=', 'attributes.id')
    ->where('product_attribute_values.product_id', $productId)
    ->where('attributes.code', 'name')
    ->get(['product_attribute_values.locale', 'product_attribute_values.text_value']);

echo "Name attribute values:\n";
foreach ($attrs as $attr) {
    echo "  Locale {$attr->locale}: {$attr->text_value}\n";
}
