<?php

require __DIR__ . '/../../vendor/autoload.php';
$app = require_once __DIR__ . '/../../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "========================================\n";
echo "PRODUCT FLAT TABLE CHECK\n";
echo "========================================\n\n";

// Check one product in detail
$product = DB::table('product_flat')
    ->where('sku', 'DENTAL-001')
    ->where('locale', 'en')
    ->where('channel', 'default')
    ->first();

if ($product) {
    echo "Product DENTAL-001 details:\n";
    foreach ((array)$product as $key => $value) {
        if ($value === null) {
            echo "  ⚠ $key: NULL\n";
        } else {
            echo "  $key: $value\n";
        }
    }
} else {
    echo "⚠ Product DENTAL-001 not found in product_flat!\n";
}

// Check if product_url_rewrites table exists
echo "\n========================================\n";
echo "URL REWRITES CHECK\n";
echo "========================================\n\n";

try {
    $urlRewrites = DB::table('product_url_rewrites')
        ->where('locale', 'en')
        ->where('redirect_type', null)
        ->get(['request_path', 'target_path']);
    
    echo "URL Rewrites found: " . $urlRewrites->count() . "\n";
    
    $dentalUrlRewrites = DB::table('product_url_rewrites')
        ->where('request_path', 'like', '%dental%')
        ->orWhere('request_path', 'like', '%professional-dental-drill%')
        ->get();
    
    echo "Dental URL Rewrites: " . $dentalUrlRewrites->count() . "\n\n";
    
    foreach ($dentalUrlRewrites as $rewrite) {
        echo "  {$rewrite->request_path} -> {$rewrite->target_path}\n";
    }
    
} catch (\Exception $e) {
    echo "⚠ product_url_rewrites table might not exist or error: " . $e->getMessage() . "\n";
}

// Check super_attributes table
echo "\n========================================\n";
echo "SUPER ATTRIBUTES CHECK\n";
echo "========================================\n\n";

$productId = DB::table('products')->where('sku', 'DENTAL-001')->value('id');
$superAttrs = DB::table('product_super_attributes')->where('product_id', $productId)->count();
echo "Super attributes for DENTAL-001: $superAttrs (should be 0 for simple products)\n";
