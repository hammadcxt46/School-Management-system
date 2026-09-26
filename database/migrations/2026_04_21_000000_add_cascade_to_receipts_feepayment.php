<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $connection = config('database.default');
        $driver = config("database.connections.{$connection}.driver");

        // Attempt a normal drop + add foreign key (works for MySQL/Postgres)
        try {
            Schema::table('receipts', function (Blueprint $table) {
                // drop existing foreign key if present
                $table->dropForeign(['feepayment_id']);
            });

            Schema::table('receipts', function (Blueprint $table) {
                $table->foreign('feepayment_id')->references('id')->on('fee_payments')->onDelete('cascade');
            });

            return;
        } catch (\Throwable $e) {
            // some drivers (sqlite) can't drop constraints directly; fall through to rebuild approach
        }

        // If SQLite (or other) - rebuild the table with cascade on the FK
        if ($driver === 'sqlite') {
            DB::beginTransaction();
            try {
                DB::statement('PRAGMA foreign_keys = OFF');

                // create new table with desired FK
                Schema::create('receipts_temp', function (Blueprint $table) {
                    $table->id();
                    $table->unsignedBigInteger('feepayment_id')->nullable();
                    $table->unsignedBigInteger('student_id')->nullable();
                    $table->float('existing_balance', 8, 2)->default(0.00);
                    $table->float('amount_paid', 8, 2)->default(0.00);
                    $table->float('new_balance', 8, 2)->default(0.00);
                    $table->timestamps();
                });

                // copy data
                DB::table('receipts_temp')->insertUsing([
                    'id','feepayment_id','student_id','existing_balance','amount_paid','new_balance','created_at','updated_at'
                ], DB::table('receipts')->select('id','feepayment_id','student_id','existing_balance','amount_paid','new_balance','created_at','updated_at'));

                // drop old and rename
                Schema::drop('receipts');
                Schema::rename('receipts_temp', 'receipts');

                // recreate FK with cascade
                Schema::table('receipts', function (Blueprint $table) {
                    $table->foreign('feepayment_id')->references('id')->on('fee_payments')->onDelete('cascade');
                });

                DB::statement('PRAGMA foreign_keys = ON');
                DB::commit();
            } catch (\Throwable $ex) {
                DB::rollBack();
                throw $ex;
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $connection = config('database.default');
        $driver = config("database.connections.{$connection}.driver");

        try {
            Schema::table('receipts', function (Blueprint $table) {
                $table->dropForeign(['feepayment_id']);
            });

            Schema::table('receipts', function (Blueprint $table) {
                $table->foreign('feepayment_id')->references('id')->on('fee_payments');
            });
        } catch (\Throwable $e) {
            // best effort; on sqlite we won't try to rebuild here
        }
    }
};
