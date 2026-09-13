<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$branches = \App\Models\Branch::all();
echo "Branches count: " . $branches->count() . "\n";
foreach ($branches as $b) {
    echo "  ID: {$b->id}, Name: {$b->name}\n";
}
