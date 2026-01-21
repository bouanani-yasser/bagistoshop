<?php

// Simple script to generate placeholder images for dental products
// Run this with: php generate_dental_images.php

$dentalImages = [
    'dental-drill.jpg' => ['#4A90E2', 'Dental Drill'],
    'dental-drill-2.jpg' => ['#4A90E2', 'Drill Detail'],
    'xray-machine.jpg' => ['#2C3E50', 'X-Ray Machine'],
    'dental-chair.jpg' => ['#27AE60', 'Dental Chair'],
    'dental-chair-side.jpg' => ['#27AE60', 'Chair Side View'],
    'suction-unit.jpg' => ['#E74C3C', 'Suction Unit'],
    'autoclave.jpg' => ['#8E44AD', 'Autoclave'],
    'autoclave-interior.jpg' => ['#8E44AD', 'Autoclave Interior'],
    'hand-instruments.jpg' => ['#F39C12', 'Hand Instruments'],
    'instruments-detail.jpg' => ['#F39C12', 'Instruments Detail'],
    'dental-light.jpg' => ['#F1C40F', 'Operating Light'],
    'compressor.jpg' => ['#34495E', 'Air Compressor'],
    'compressor-controls.jpg' => ['#34495E', 'Compressor Controls'],
    'dental-gloves.jpg' => ['#1ABC9C', 'Dental Gloves'],
    'crown-kit.jpg' => ['#E67E22', 'Crown Kit'],
    'crown-samples.jpg' => ['#E67E22', 'Crown Samples'],
    'bracket-set.jpg' => ['#9B59B6', 'Bracket Set'],
    'brackets-detail.jpg' => ['#9B59B6', 'Brackets Detail'],
    'intraoral-camera.jpg' => ['#3498DB', 'Intraoral Camera'],
];

$outputDir = 'dental/';

if (!is_dir($outputDir)) {
    mkdir($outputDir, 0755, true);
}

foreach ($dentalImages as $filename => $config) {
    [$color, $text] = $config;
    
    // Create image
    $image = imagecreate(400, 400);
    
    // Convert hex color to RGB
    $hex = str_replace('#', '', $color);
    $r = hexdec(substr($hex, 0, 2));
    $g = hexdec(substr($hex, 2, 2));
    $b = hexdec(substr($hex, 4, 2));
    
    $backgroundColor = imagecolorallocate($image, $r, $g, $b);
    $textColor = imagecolorallocate($image, 255, 255, 255);
    $borderColor = imagecolorallocate($image, 200, 200, 200);
    
    // Add border
    imagerectangle($image, 0, 0, 399, 399, $borderColor);
    
    // Add text
    $lines = explode(' ', $text);
    $y = 180;
    
    foreach ($lines as $line) {
        $textWidth = imagefontwidth(5) * strlen($line);
        $x = (400 - $textWidth) / 2;
        imagestring($image, 5, $x, $y, $line, $textColor);
        $y += 20;
    }
    
    // Add product type indicator
    imagestring($image, 3, 10, 10, 'DENTAL PRODUCT', $textColor);
    
    // Save image
    $filePath = $outputDir . $filename;
    
    if (pathinfo($filename, PATHINFO_EXTENSION) === 'jpg') {
        imagejpeg($image, $filePath, 90);
    } else {
        imagepng($image, $filePath);
    }
    
    imagedestroy($image);
    echo "Generated: $filePath\n";
}

echo "All dental product images generated successfully!\n";