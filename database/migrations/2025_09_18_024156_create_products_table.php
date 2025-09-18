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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');           // Product name
            $table->text('description');      // Description
            $table->integer('stock');         // Stock quantity
            $table->decimal('price', 10, 2);  // Price
            $table->string('category');       // Category
            $table->string('brand');          // Brand
            $table->date('expiry_date');      // Expiry date
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
