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
        if (!Schema::hasTable('fire_countcheck'))
        {
            Schema::create('fire_countcheck', function (Blueprint $table) {
                $table->bigIncrements('fire_countcheck_id');
                $table->string('fire_id')->nullable();  //  
                $table->string('fire_num')->nullable();  //  รหัส : OUT CO1
                $table->date('check_date')->nullable();  //          
                $table->string('fire_name')->nullable(); //   
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
        Schema::dropIfExists('fire_countcheck');
    }
};
