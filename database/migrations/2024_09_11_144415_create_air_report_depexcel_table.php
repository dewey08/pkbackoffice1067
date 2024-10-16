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
        if (!Schema::hasTable('air_report_depexcel'))
        {
            Schema::create('air_report_depexcel', function (Blueprint $table) {
                $table->bigIncrements('air_report_depexcel_id'); 
                $table->string('air_list_name')->nullable(); //   
                $table->string('air_location_name')->nullable(); // 
                $table->string('debsubsub')->nullable(); // 
                $table->string('plan_one')->nullable(); // 
                $table->string('plan_two')->nullable(); // 
                $table->string('supplies_name')->nullable(); // 

                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('air_report_depexcel');
    }
};
