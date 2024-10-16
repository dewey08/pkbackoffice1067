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
        if (!Schema::hasTable('air_report_ploblems'))
        {
            Schema::create('air_report_ploblems', function (Blueprint $table) {
                $table->bigIncrements('air_report_ploblems_id'); 
                $table->date('repaire_date_start')->nullable();  // 
                $table->date('repaire_date_end')->nullable();  // 
                $table->string('air_repaire_ploblem_id', length: 250)->nullable();  //    
                $table->string('air_repaire_ploblemname', length: 250)->nullable();  //   
                $table->string('air_repaire_type_code', length: 250)->nullable();  // 
                $table->string('count_ploblems', length: 250)->nullable();  //  
                $table->string('more_one', length: 250)->nullable();  //      
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('air_report_ploblems');
    }
};
