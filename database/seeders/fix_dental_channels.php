<?php

require __DIR__ . '/../../vendor/autoload.php';
$app = require_once __DIR__ . '/../../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "Checking dental categories channel assignment...\n\n";

// Get all dental category IDs
$dentalCatIds = DB::table('category_translations')
    ->where('slug', 'like', '%dental%')
    ->orWhere('slug', 'like', '%dentaire%')
    ->orWhere('slug', 'like', '%instrument%')
    ->orWhere('slug', 'like', '%consommable%')
    ->orWhere('slug', 'like', '%imagerie%')
    ->orWhere('slug', 'like', '%hygiene%')
    ->orWhere('slug', 'like', '%prothes%')
    ->orWhere('slug', 'like', '%orthodont%')
    ->pluck('category_id')
    ->unique();

$missingChannels = [];

foreach ($dentalCatIds as $catId) {
    $categoryName = DB::table('category_translations')
        ->where('category_id', $catId)
        ->where('locale', 'en')
        ->value('name');
    
    $inChannel = DB::table('category_channels')
        ->where('category_id', $catId)
        ->exists();
    
    echo "Category: $categoryName (ID: $catId) - ";
    
    if ($inChannel) {
        echo "✓ Assigned to channel\n";
    } else {
        echo "✗ NOT assigned to channel\n";
        $missingChannels[] = $catId;
    }
}

if (!empty($missingChannels)) {
    echo "\n========================================\n";
    echo "FIXING: Assigning categories to default channel...\n";
    echo "========================================\n\n";
    
    foreach ($missingChannels as $catId) {
        DB::table('category_channels')->insert([
            'category_id' => $catId,
            'channel_id' => 1, // Default channel
        ]);
        
        $categoryName = DB::table('category_translations')
            ->where('category_id', $catId)
            ->where('locale', 'en')
            ->value('name');
        
        echo "✓ Assigned '$categoryName' to default channel\n";
    }
    
    echo "\n✅ All categories are now assigned to channels!\n";
} else {
    echo "\n✅ All categories already assigned to channels!\n";
}