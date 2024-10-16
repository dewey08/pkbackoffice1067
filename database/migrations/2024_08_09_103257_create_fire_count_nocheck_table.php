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
        if (!Schema::hasTable('fire_count_nocheck'))
        {
            Schema::create('fire_count_nocheck', function (Blueprint $table) {
                $table->bigIncrements('fire_count_nocheck_id');
                $table->string('fire_id')->nullable();  //  
                $table->string('fire_num')->nullable();  //  รหัส : OUT CO1
                $table->string('months')->nullable();  // 
                $table->string('years')->nullable();  //          
               
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fire_count_nocheck');
    }
};
