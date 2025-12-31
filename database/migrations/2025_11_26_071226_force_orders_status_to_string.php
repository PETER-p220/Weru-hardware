<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        $driver = DB::getDriverName();
        
        if ($driver === 'sqlite') {
            // SQLite doesn't support AFTER keyword and DROP COLUMN may not be available
            // Check if column exists and update values if needed
            // For SQLite, the column type is already flexible, so we just ensure default value
            if (Schema::hasColumn('orders', 'status')) {
                // Update existing NULL or invalid values
                DB::table('orders')
                    ->whereNull('status')
                    ->orWhere('status', '')
                    ->update(['status' => 'new']);
            }
            // SQLite columns are already flexible, no need to recreate
        } else {
            // MySQL/MariaDB - use DROP and ADD
            DB::statement('ALTER TABLE orders DROP COLUMN status');
            DB::statement("ALTER TABLE orders ADD COLUMN status VARCHAR(20) NOT NULL DEFAULT 'new' AFTER order_number");
        }
    }

    public function down()
    {
        $driver = DB::getDriverName();
        
        if ($driver === 'sqlite') {
            // SQLite - just update values if needed, no need to drop/add column
            DB::table('orders')
                ->where('status', 'new')
                ->update(['status' => 'pending']);
        } else {
            // MySQL/MariaDB
            DB::statement('ALTER TABLE orders DROP COLUMN status');
            DB::statement("ALTER TABLE orders ADD COLUMN status ENUM('pending','processing','shipped','delivered','cancelled') DEFAULT 'pending' AFTER order_number");
        }
    }
};