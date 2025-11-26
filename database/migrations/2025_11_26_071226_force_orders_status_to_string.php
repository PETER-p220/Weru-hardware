<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        // NUCLEAR OPTION: Drop the column completely and re-add as string
        DB::statement('ALTER TABLE orders DROP COLUMN status');
        DB::statement("ALTER TABLE orders ADD COLUMN status VARCHAR(20) NOT NULL DEFAULT 'new' AFTER order_number");
    }

    public function down()
    {
        DB::statement('ALTER TABLE orders DROP COLUMN status');
        DB::statement("ALTER TABLE orders ADD COLUMN status ENUM('pending','processing','shipped','delivered','cancelled') DEFAULT 'pending' AFTER order_number");
    }
};