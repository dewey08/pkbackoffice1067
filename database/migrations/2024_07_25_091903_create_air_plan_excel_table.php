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
        if (!Schema::hasTable('air_plan_excel'))
        {
            Schema::create('air_plan_excel', function (Blueprint $table) {
                $table->bigIncrements('air_plan_excel_id');  
                $table->string('air_plan_year')->nullable();//  
                $table->string('air_list_num')->nullable();// 
                $table->string('air_plan_month_id')->nullable();//   
                $table->enum('active', ['Y', 'N'])->default('N'); 
                $table->string('PlanDOC')->nullable();// 
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('air_plan_excel');
    }
};
