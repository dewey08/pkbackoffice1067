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
        if (!Schema::hasTable('nurse_ksk'))
        {
            Schema::create('nurse_ksk', function (Blueprint $table) {
                $table->bigIncrements('nurse_ksk_id');  
                $table->string('depcode', length: 100)->nullable();  //  
                $table->string('department', length: 255)->nullable();  //  
                $table->string('nursing_product_a', length: 100)->nullable();  //  
                $table->string('nursing_product_b', length: 100)->nullable();  // 
                $table->string('nursing_product_c', length: 100)->nullable();  //  
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nurse_ksk');
    }
};
