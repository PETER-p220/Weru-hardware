<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('selcom_orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_id')->unique();
            $table->decimal('amount', 15, 2);
            $table->string('msisdn');
            $table->string('buyer_name')->nullable();
            $table->string('buyer_email')->nullable();
            $table->string('result')->nullable();
            $table->text('result_description')->nullable();
            $table->string('transid')->nullable();
            $table->json('raw_response')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('selcom_orders');
    }
};