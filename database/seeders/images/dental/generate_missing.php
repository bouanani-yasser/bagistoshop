<?php
// Generate missing dental product images

$newImages = [
    'dental-gloves.jpg' => ['#1ABC9C', 'Dental Gloves'],
    'crown-kit.jpg' => ['#E67E22', 'Crown Kit'],
    'crown-samples.jpg' => ['#E67E22', 'Crown Samples'],
    'bracket-set.jpg' => ['#9B59B6', 'Bracket Set'],
    'brackets-detail.jpg' => ['#9B59B6', 'Brackets Detail'],
    'intraoral-camera.jpg' => ['#3498DB', 'Intraoral Camera'],
];

foreach ($newImages as $filename => $config) {
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
    imagejpeg($image, $filename, 90);
    imagedestroy($image);
    echo "Generated: $filename\n";
}

echo "Additional dental images generated!\n";