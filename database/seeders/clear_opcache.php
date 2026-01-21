<?php
// Clear OPcache
if (function_exists('opcache_reset')) {
    opcache_reset();
    echo "✓ OPcache cleared successfully!\n";
} else {
    echo "⚠ OPcache extension not available or not enabled.\n";
}

// Show OPcache status
if (function_exists('opcache_get_status')) {
    $status = opcache_get_status();
    if ($status !== false) {
        echo "\nOPcache Status:\n";
        echo "  Enabled: " . ($status['opcache_enabled'] ? 'Yes' : 'No') . "\n";
        echo "  Cache Full: " . ($status['cache_full'] ? 'Yes' : 'No') . "\n";
        echo "  Cached Scripts: " . $status['opcache_statistics']['num_cached_scripts'] . "\n";
        echo "  Hits: " . $status['opcache_statistics']['hits'] . "\n";
        echo "  Misses: " . $status['opcache_statistics']['misses'] . "\n";
    }
}
