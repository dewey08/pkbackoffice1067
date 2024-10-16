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
        if (!Schema::hasTable('air_maintenance_list'))
        {
            Schema::create('air_maintenance_list', function (Blueprint $table) {
                $table->bigIncrements('maintenance_list_id');  
                $table->string('air_repaire_type_code', length: 150)->nullable();  //  
                $table->string('maintenance_list_num', length: 10)->nullable();    //  การบำรุงรักษาครั้งที่ 1 , 2 , 3 
                $table->string('maintenance_list_name', length: 250)->nullable();  //    รายการบำรุงรักษา
                $table->enum('active', ['N','Y'])->default('Y');   //
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('air_maintenance_list');
    }
};
