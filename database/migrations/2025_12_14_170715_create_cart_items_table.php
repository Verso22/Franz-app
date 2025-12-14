<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('cart_items', function (Blueprint $table) {

            $table->id();

            // 🧺 Cart reference
            $table->foreignId('cart_id')
                    ->constrained()
                    ->onDelete('cascade');

            // 📦 Product reference
            $table->foreignId('product_id')
                    ->constrained()
                    ->onDelete('cascade');

            // 🔢 Quantity
            $table->integer('quantity')->default(1);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cart_items');
    }
};
