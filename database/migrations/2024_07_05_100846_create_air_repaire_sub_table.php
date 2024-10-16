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
        if (!Schema::hasTable('air_repaire_sub'))
        {
            Schema::create('air_repaire_sub', function (Blueprint $table) {
                $table->bigIncrements('repaire_sub_id'); 
                $table->string('air_repaire_id', length: 10)->nullable();          // 
                $table->string('air_list_num', length: 250)->nullable();           // รหัสแอร์
                $table->string('air_repaire_ploblem_id', length: 250)->nullable();  //
                $table->string('repaire_sub_name', length: 250)->nullable();       //                 
                $table->string('repaire_no', length: 250)->nullable();             // ครั้งที่  
                $table->string('air_repaire_type_code', length: 150)->nullable();  //   
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('air_repaire_sub');
    }
};
