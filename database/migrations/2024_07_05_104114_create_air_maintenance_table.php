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
        if (!Schema::hasTable('air_maintenance'))
        {
            Schema::create('air_maintenance', function (Blueprint $table) {
                $table->bigIncrements('air_maintenance_id'); 
                $table->string('air_repaire_id', length: 10)->nullable();  // 
                $table->string('air_maintenance_name', length: 250)->nullable();  //  
                $table->string('air_repaire_type_code', length: 150)->nullable();  //    
                $table->string('air_repaire_type_id', length: 10)->nullable();  //    การบำรุงรักษาครั้งที่ 1 , 2 , 3
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('air_maintenance');
    }
};
