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
        if (!Schema::hasTable('air_report_dep'))
        {
            Schema::create('air_report_dep', function (Blueprint $table) {
                $table->bigIncrements('air_report_dep_id'); 
                $table->string('years')->nullable(); // 
                $table->string('air_plan_year')->nullable(); //   
                $table->string('air_plan_month')->nullable(); // 
                $table->string('air_plan_name')->nullable(); //  
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('air_report_dep');
    }
};
