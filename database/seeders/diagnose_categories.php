<?php

require __DIR__ . '/../../vendor/autoload.php';
$app = require_once __DIR__ . '/../../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "========================================\n";
echo "DENTAL CATEGORIES DIAGNOSTIC\n";
echo "========================================\n\n";

// Get dental categories
$dentalCats = DB::table('categories')
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
    ->select(
        'categories.*',
        'category_translations.name',
        'category_translations.slug'
    )
    ->get();

echo "Found " . count($dentalCats) . " dental categories\n\n";

foreach ($dentalCats as $cat) {
    echo "Category: {$cat->name}\n";
    echo "  ID: {$cat->id}\n";
    echo "  Slug: {$cat->slug}\n";
    echo "  Status: " . ($cat->status ? 'Enabled ✓' : 'Disabled ✗') . "\n";
    echo "  Display Mode: {$cat->display_mode}\n";
    echo "  Parent ID: {$cat->parent_id}\n";
    echo "  Position: {$cat->position}\n";
    echo "  Nested Set: _lft={$cat->_lft}, _rgt={$cat->_rgt}\n";
    
    // Check for products
    $productCount = DB::table('product_categories')
        ->where('category_id', $cat->id)
        ->count();
    echo "  Products: $productCount\n";
    
    // Check for translations
    $translationCount = DB::table('category_translations')
        ->where('category_id', $cat->id)
        ->count();
    echo "  Translations: $translationCount\n";
    
    echo "\n";
}

// Check if root category is properly set
echo "========================================\n";
echo "ROOT CATEGORY CHECK\n";
echo "========================================\n\n";

$rootCat = DB::table('categories')->where('id', 1)->first();
if ($rootCat) {
    echo "Root Category:\n";
    echo "  _lft: {$rootCat->_lft}\n";
    echo "  _rgt: {$rootCat->_rgt}\n";
    echo "  Status: " . ($rootCat->status ? 'Enabled' : 'Disabled') . "\n";
} else {
    echo "⚠ ROOT CATEGORY NOT FOUND!\n";
}

// Check category tree integrity
echo "\n========================================\n";
echo "CATEGORY TREE STRUCTURE\n";
echo "========================================\n\n";

$allCats = DB::table('categories')
    ->leftJoin('category_translations', function($join) {
        $join->on('categories.id', '=', 'category_translations.category_id')
             ->where('category_translations.locale', '=', 'en');
    })
    ->select('categories.id', 'categories.parent_id', 'categories._lft', 'categories._rgt', 'category_translations.name')
    ->orderBy('categories._lft')
    ->get();

foreach ($allCats as $cat) {
    $indent = str_repeat('  ', substr_count(DB::table('categories')->where('_lft', '<', $cat->_lft)->where('_rgt', '>', $cat->_rgt)->count(), '1'));
    echo $indent . "├─ {$cat->name} (ID: {$cat->id}, lft: {$cat->_lft}, rgt: {$cat->_rgt})\n";
}

echo "\n✅ Diagnostic complete!\n";