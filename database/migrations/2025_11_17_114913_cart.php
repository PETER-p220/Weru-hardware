<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('carts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable(); // null = guest
            $table->string('session_id')->nullable();         // for guests
            $table->json('items'); // stores array of cart items
            $table->timestamps();
            $table->index('user_id');
            $table->index('session_id');
            $table->unique(['user_id', 'session_id']); // prevent duplicates
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('carts');
    }
};