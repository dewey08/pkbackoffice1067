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
        if (!Schema::hasTable('air_plan_month'))
        {
            Schema::create('air_plan_month', function (Blueprint $table) {
                $table->bigIncrements('air_plan_month_id'); 
                $table->string('years')->nullable();//  
                $table->string('air_plan_month')->nullable();//  
                $table->string('air_plan_year')->nullable();//  
                $table->string('air_plan_name')->nullable();// 
                $table->enum('active', ['Y', 'N'])->default('N'); 
                $table->string('air_repaire_type_id')->nullable();// 
                $table->date('start_date')->nullable();// 
                $table->date('end_date')->nullable();// 
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('air_plan_month');
    }
};
