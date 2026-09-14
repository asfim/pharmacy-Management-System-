<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$batches = \App\Models\Batch::doesntHave('stock_balances')->get();
foreach($batches as $b) {
    \App\Models\StockBalance::create([
        'branch_id' => 1,
        'product_id' => $b->product_id,
        'batch_id' => $b->id,
        'qty_on_hand' => $b->quantity
    ]);
}
echo 'Fixed ' . $batches->count() . ' batches.';
