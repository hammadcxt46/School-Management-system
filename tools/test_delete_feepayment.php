<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "Attempting delete feepayment...\n";
$p = \App\Models\FeePayment::first();
if ($p) {
    echo "Deleting feepayment id={$p->id}\n";
    try {
        $p->delete();
        echo "Deleted\n";
    } catch (\Exception $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }
} else {
    echo "No fee payments found\n";
}
