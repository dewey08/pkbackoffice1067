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
        if (!Schema::hasTable('air_repaire_excel'))
        {
            Schema::create('air_repaire_excel', function (Blueprint $table) {
                $table->bigIncrements('air_repaire_excel_id');
                $table->char('air_repaire_id', length: 10)->nullable();  // 
                $table->date('repaire_date')->nullable();  //
                $table->time('repaire_time')->nullable();  //
                $table->char('air_repaire_no', length: 150)->nullable();  //  เลขที่แจ้ง
                $table->char('air_repaire_num', length: 250)->nullable();  //  รหัส 
                $table->char('air_list_num', length: 200)->nullable();  //           
                $table->char('air_list_name', length: 200)->nullable(); //   
                $table->char('btu', length: 200)->nullable(); //        
                $table->char('air_location_name', length: 200)->nullable();  //  
                $table->char('debsubsub', length: 200)->nullable();  // ปัญหา 
                $table->longText('repaire_sub_name')->nullable();   
                $table->char('staff_name', length: 200)->nullable();      
                $table->char('tect_name', length: 200)->nullable();      
                $table->char('air_techout_name', length: 200)->nullable();    
                 
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('air_repaire_excel');
    }
};
