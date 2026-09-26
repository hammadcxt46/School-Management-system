<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();
$roles = \DB::table('roles')->get();
foreach ($roles as $r) {
    echo "roles id={$r->id} name={$r->name}\n";
}
