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
        if (!Schema::hasTable('fire_stock'))
        {
            Schema::create('fire_stock', function (Blueprint $table) {
                $table->bigIncrements('fire_stock_id'); 
                $table->string('fire_id')->nullable(); 
                $table->string('fire_num')->nullable();  // 
                $table->string('fire_name')->nullable(); 
                $table->string('fire_size')->nullable(); 
                $table->string('fire_backup')->nullable(); 
                $table->string('fire_color')->nullable(); // 
                $table->string('fire_check_location')->nullable(); // 
              
                $table->string('user_id')->nullable(); // ผู้ตรวจ
                
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fire_stock');
    }
};
