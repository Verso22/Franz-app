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
        Schema::create('carts', function (Blueprint $table) {

            $table->id();

            // 👤 Cart owner (customer)
            $table->foreignId('user_id')
                    ->constrained()
                    ->onDelete('cascade');

            // 🧭 Cart status
            // active = still shopping
            // checked_out = converted to transaction
            $table->string('status')->default('active');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carts');
    }
};
