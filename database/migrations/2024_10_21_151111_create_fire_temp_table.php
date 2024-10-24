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
        if (!Schema::hasTable('fire_temp'))
        {
            Schema::create('fire_temp', function (Blueprint $table) {
                $table->bigIncrements('fire_temp_id'); 
                $table->date('check_date')->nullable(); 
                $table->string('fire_id')->nullable(); 
                $table->string('fire_num')->nullable();  // 
                $table->string('fire_name')->nullable(); 
                $table->string('fire_size')->nullable(); 
                $table->string('fire_backup')->nullable(); 
                $table->string('fire_color')->nullable(); //  
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
        Schema::dropIfExists('fire_temp');
    }
};
