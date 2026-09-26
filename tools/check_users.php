<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();
$users = \DB::table('users')->get();
foreach ($users as $u) {
    echo "id: {$u->id} name: {$u->name} email: {$u->email} role_id: {$u->role_id}\n";
}
