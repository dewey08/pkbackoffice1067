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
       
        if (!Schema::hasTable('wh_plan_main'))
        {
            Schema::create('wh_plan_main', function (Blueprint $table) {
                $table->bigIncrements('wh_plan_main_id');   
                $table->string('wh_plan_mainname')->nullable();         //
                
                $table->string('user_id')->nullable(); //     
                $table->enum('active', ['Y','N'])->default('Y');                              
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wh_plan_main');
    }
};