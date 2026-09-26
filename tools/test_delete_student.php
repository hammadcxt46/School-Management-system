<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "Attempting delete...\n";
$s = \App\Models\Student::first();
if ($s) {
    echo "Deleting student id={$s->id}\n";
    try {
        $s->delete();
        echo "Deleted\n";
    } catch (\Exception $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }
} else {
    echo "No students found\n";
}
