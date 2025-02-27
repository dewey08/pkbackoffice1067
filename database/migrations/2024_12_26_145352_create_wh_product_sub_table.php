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
        if (!Schema::hasTable('wh_product_sub'))
        {
            Schema::create('wh_product_sub', function (Blueprint $table) {
                $table->bigIncrements('wh_product_sub_id');
                $table->string('pro_id')->nullable();      //
                $table->string('pro_color')->nullable();   //
                $table->string('pro_brand')->nullable();   //
                $table->string('pro_type')->nullable();  //
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wh_product_sub');
    }
};
