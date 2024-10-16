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
        if (!Schema::hasTable('air_temp_ploblem'))
        {
            Schema::create('air_temp_ploblem', function (Blueprint $table) {
                $table->bigIncrements('air_temp_ploblem_id');  
                $table->string('air_list_num', length: 150)->nullable();  //        
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('air_temp_ploblem');
    }
};
