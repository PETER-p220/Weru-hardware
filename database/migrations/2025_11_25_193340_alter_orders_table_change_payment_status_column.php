<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        // Step 1: Convert to VARCHAR to escape ENUM restrictions
        DB::statement("ALTER TABLE orders MODIFY payment_status VARCHAR(20) NOT NULL DEFAULT 'pending'");

        // Step 2: Update all values safely
        DB::statement("UPDATE orders SET payment_status = 'pending'");

        // Step 3: Convert back to proper ENUM
        DB::statement("ALTER TABLE orders MODIFY payment_status ENUM('pending','paid','failed','refunded') NOT NULL DEFAULT 'pending'");
    }

    public function down()
    {
        DB::statement("ALTER TABLE orders MODIFY payment_status ENUM('unpaid','paid') NOT NULL DEFAULT 'unpaid'");
    }
};