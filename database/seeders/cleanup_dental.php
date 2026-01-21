<?php

require __DIR__ . '/../../vendor/autoload.php';

$app = require_once __DIR__ . '/../../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

// Delete dental products
$deletedProducts = DB::table('products')->where('sku', 'like', 'DENTAL-%')->delete();
echo "Deleted $deletedProducts dental products\n";

// Delete dental categories
$dentalCategoryIds = DB::table('category_translations')
    ->where('slug', 'like', '%dental%')
    ->orWhere('slug', 'like', '%dentaire%')
    ->orWhere('slug', 'like', '%orthodont%')
    ->orWhere('slug', 'like', '%prothes%')
    ->orWhere('slug', 'like', '%hygiene-dentaire%')
    ->orWhere('slug', 'like', '%imagerie%')
    ->orWhere('slug', 'like', '%consommable%')
    ->orWhere('slug', 'like', '%instrument%')
    ->pluck('category_id');

if ($dentalCategoryIds->isNotEmpty()) {
    $deletedCategories = DB::table('categories')->whereIn('id', $dentalCategoryIds)->delete();
    echo "Deleted $deletedCategories dental categories\n";
}

echo "Cleanup complete!\n";