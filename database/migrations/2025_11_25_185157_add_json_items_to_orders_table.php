<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            //
        $table->json('items')->nullable()->after('notes');
        $table->decimal('subtotal', 16, 2)->default(0)->after('total_amount');
        $table->decimal('delivery_fee', 10, 2)->default(25000)->after('subtotal');
        $table->decimal('vat_amount', 10, 2)->default(0)->after('delivery_fee');
        $table->string('payment_ref')->nullable()->after('payment_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            //
        });
    }
};
