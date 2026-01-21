<?php

require __DIR__.'/../../vendor/autoload.php';

$app = require_once __DIR__.'/../../bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;

echo "Checking Arabic translations for dental categories...\n";
echo str_repeat('=', 80) . "\n\n";

// Get all dental categories with their translations
$categories = DB::table('categories')
    ->where('_lft', '>=', 26)
    ->orderBy('_lft')
    ->get();

foreach ($categories as $category) {
    echo "Category ID: {$category->id}\n";
    echo "Position: {$category->position}, LFT: {$category->_lft}, RGT: {$category->_rgt}\n";
    echo "Parent ID: {$category->parent_id}\n";
    
    // Get translations
    $translations = DB::table('category_translations')
        ->where('category_id', $category->id)
        ->orderBy('locale')
        ->get();
    
    echo "Translations:\n";
    foreach ($translations as $trans) {
        echo "  [{$trans->locale}] {$trans->name}\n";
        echo "       Slug: {$trans->slug}\n";
    }
    echo "\n";
}

echo str_repeat('=', 80) . "\n";
echo "Summary:\n";
$totalCategories = count($categories);
$arabicCount = DB::table('category_translations')
    ->join('categories', 'categories.id', '=', 'category_translations.category_id')
    ->where('categories._lft', '>=', 26)
    ->where('category_translations.locale', 'ar')
    ->count();

echo "Total dental categories: {$totalCategories}\n";
echo "Categories with Arabic translations: {$arabicCount}\n";

if ($arabicCount === $totalCategories) {
    echo "✓ All categories have Arabic translations!\n";
} else {
    echo "✗ Missing Arabic translations for " . ($totalCategories - $arabicCount) . " categories\n";
}
