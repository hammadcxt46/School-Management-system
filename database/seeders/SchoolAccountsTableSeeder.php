<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SchoolAccountsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       // Get the application name
        $appName = config('app.name');

        // Only insert the account if it doesn't already exist
        $exists = DB::table('school_accounts')
            ->where('name', $appName)
            ->exists();

        if (! $exists) {
            DB::table('school_accounts')->insert([
                'created_at' => now(),
                'name' => $appName,
                'income' => 0.0,
                'expenses' => 0.0,
                'balance' => 0.0,
            ]);
        }
    }
}
