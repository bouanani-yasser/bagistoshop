<?php

require __DIR__ . '/../../vendor/autoload.php';
$app = require_once __DIR__ . '/../../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "========================================\n";
echo "PRODUCT URL AND INVENTORY CHECK\n";
echo "========================================\n\n";

// Check product URLs
$products = DB::table('product_flat')
    ->where('sku', 'like', 'DENTAL-%')
    ->where('locale', 'en')
    ->where('channel', 'default')
    ->get(['id', 'sku', 'name', 'url_key', 'status', 'visible_individually']);

echo "Product URLs:\n";
foreach ($products as $product) {
    $url = "http://127.0.0.1:8000/{$product->url_key}";
    echo "SKU: {$product->sku}\n";
    echo "  URL: {$url}\n";
    echo "  Status: " . ($product->status ? 'Enabled' : 'Disabled') . "\n";
    echo "  Visible: " . ($product->visible_individually ? 'Yes' : 'No') . "\n";
    
    // Check inventory
    $productId = DB::table('products')->where('sku', $product->sku)->value('id');
    $inventories = DB::table('product_inventories')->where('product_id', $productId)->get();
    
    if ($inventories->isEmpty()) {
        echo "  ⚠ INVENTORY: NOT SET (This will cause 404!) \n";
    } else {
        foreach ($inventories as $inv) {
            echo "  Inventory ID {$inv->id}: Qty = {$inv->qty}\n";
        }
    }
    echo "\n";
}

// Check inventory sources
echo "\n========================================\n";
echo "INVENTORY SOURCES\n";
echo "========================================\n\n";

$sources = DB::table('inventory_sources')->get();
foreach ($sources as $source) {
    echo "Source ID: {$source->id}\n";
    echo "  Code: {$source->code}\n";
    echo "  Name: {$source->name}\n";
    echo "  Status: " . ($source->status ? 'Active' : 'Inactive') . "\n\n";
}
