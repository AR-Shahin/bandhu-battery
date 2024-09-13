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
            $table->foreignId("category_id");
            $table->foreignId("sub_category_id")->nullable();
            $table->foreignId("brand_id");
            $table->foreignId("unit_id");
            $table->foreignId("vendor_id");
            $table->string("name");
            $table->string("code");
            $table->integer("stock");
            $table->text("description");
            $table->foreignId("admin_id");
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
