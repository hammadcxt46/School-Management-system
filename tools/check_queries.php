<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "Checking SchoolExpense monthly aggregation...\n";
try {
    $res = \App\Models\SchoolExpense::select(\Illuminate\Support\Facades\DB::raw("CAST(strftime('%m', created_at) AS INTEGER) as month"), \Illuminate\Support\Facades\DB::raw('SUM(amount) as total'))
        ->where('created_at', '>=', now()->subYears(1))
        ->groupBy('month')
        ->get();
    foreach ($res as $r) {
        echo "month={$r->month} total={$r->total}\n";
    }
} catch (Exception $e) {
    echo "SchoolExpense query failed: " . $e->getMessage() . "\n";
}

echo "\nChecking FeePayment monthly aggregation...\n";
try {
    $res = \App\Models\FeePayment::select(\Illuminate\Support\Facades\DB::raw("CAST(strftime('%m', created_at) AS INTEGER) as month"), \Illuminate\Support\Facades\DB::raw('SUM(amount) as total'))
        ->where('created_at', '>=', now()->subYears(1))
        ->groupBy('month')
        ->get();
    foreach ($res as $r) {
        echo "month={$r->month} total={$r->total}\n";
    }
} catch (Exception $e) {
    echo "FeePayment query failed: " . $e->getMessage() . "\n";
}
