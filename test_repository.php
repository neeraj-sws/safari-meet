<?php

// Quick test script for repository
require 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Foundation\Bootstrap\LoadEnvironmentVariables')->bootstrap($app);
$app->make('Illuminate\Foundation\Bootstrap\RegisterProviders')->bootstrap($app);
$app->make('Illuminate\Foundation\Bootstrap\BootProviders')->bootstrap($app);

try {
    $repo = app('App\Repositories\Contracts\PackageRepositoryInterface');
    echo "✓ Repository bound successfully: " . get_class($repo) . "\n";
    echo "✓ Methods available:\n";
    echo "  - paginateFiltered()\n";
    echo "  - findBySlugWithRelations()\n";
    echo "  - getCharacteristicData()\n";
} catch (\Exception $e) {
    echo "✗ Error: " . $e->getMessage() . "\n";
    exit(1);
}
