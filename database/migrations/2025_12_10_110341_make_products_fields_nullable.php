<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            if (Schema::hasColumn('products', 'description')) {
                $table->text('description')->nullable()->change(); // description optional
            }
            if (Schema::hasColumn('products', 'category')) {
                $table->string('category')->nullable()->change();  // category optional
            }
            if (Schema::hasColumn('products', 'brand')) {
                $table->string('brand')->nullable()->change();     // brand optional
            }
            if (Schema::hasColumn('products', 'expiry_date')) {
                $table->date('expiry_date')->nullable()->change(); // expiry_date optional
            }
            if (! Schema::hasColumn('products', 'deleted_at')) {
                $table->softDeletes(); // ensure deleted_at exists (safe check)
            }
        });
    }

    public function down(): void
    {
        // Be conservative: do not force NOT NULL on rollback (could break rows).
        // If you really want to revert, do it manually after ensuring no NULLs.
    }
};
