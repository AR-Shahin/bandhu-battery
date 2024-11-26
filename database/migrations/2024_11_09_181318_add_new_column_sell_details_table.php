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
        Schema::table('sell_details', function (Blueprint $table) {
           // $table->text("product_codes")->nullable()->after("quantity");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sell_details', function (Blueprint $table) {
           // $table->dropColumn(['product_codes']);
        });
    }
};
