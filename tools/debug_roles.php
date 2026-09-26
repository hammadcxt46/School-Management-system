<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;

echo "Users:\n";
foreach (\DB::table('users')->get() as $u) {
    echo "id={$u->id} name={$u->name} email={$u->email} role_id={$u->role_id}\n";
}

echo "\nRoles (roles table):\n";
foreach (\DB::table('roles')->get() as $r) {
    echo "id={$r->id} name={$r->name} guard_name={$r->guard_name}\n";
}

echo "\nmodel_has_roles:\n";
foreach (\DB::table('model_has_roles')->get() as $m) {
    echo "role_id={$m->role_id} model_type={$m->model_type} model_id={$m->model_id}\n";
}

echo "\nFor user id=1 (Eloquent):\n";
$user = User::find(1);
if ($user) {
    echo "exists. Spatie roles: " . json_encode($user->getRoleNames()) . "\n";
    echo "hasRole('super_admin'): " . ($user->hasRole('super_admin') ? 'yes' : 'no') . "\n";
    echo "hasAnyRole(['super_admin','admin','panel_user']): " . ($user->hasAnyRole(['super_admin','admin','panel_user']) ? 'yes' : 'no') . "\n";
    echo "Filament canAccessPanel?: " . ($user->canAccessPanel(\Filament\Panel::make('admin')) ? 'yes' : 'no') . "\n";
} else {
    echo "user id=1 not found\n";
}
