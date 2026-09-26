<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use App\Models\User;

class ResetUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Disable foreign keys for sqlite, clear users table
        DB::statement('PRAGMA foreign_keys = OFF;');
        DB::table('users')->delete();
        DB::statement('PRAGMA foreign_keys = ON;');

        // Ensure the super_admin role exists
        $role = Role::firstOrCreate(['name' => 'super_admin']);

        // Insert a super admin user with id = 1
        $now = now();
        DB::table('users')->insert([
            'id' => 1,
            'name' => 'Super Admin',
            'email' => 'superadmin@example.com',
            'role_id' => $role->id,
            'password' => Hash::make('password'),
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        // Assign the Spatie role to the Eloquent user model
        $user = User::find(1);
        if ($user) {
            $user->assignRole($role->name);
        }
    }
}
