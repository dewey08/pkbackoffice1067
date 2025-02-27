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
        if (!Schema::hasTable('wh_config_store'))
        {
            Schema::create('wh_config_store', function (Blueprint $table) {
                $table->bigIncrements('wh_config_store_id');
                $table->string('stock_list_id')->nullable();     // คลังหลัก
                $table->string('stock_list_subid')->nullable();  // คลังย่อย
                $table->string('user_id')->nullable();           // 
                $table->date('dateconfig')->nullable();          //  วันที่
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wh_config_store');
    }
};
