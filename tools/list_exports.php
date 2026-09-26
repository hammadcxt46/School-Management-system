<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

foreach (\DB::table('exports')->get() as $e) {
    echo 'id=' . $e->id . ' file=' . $e->file_name . ' disk=' . $e->file_disk . "\n";
}
