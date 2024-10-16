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
        if (!Schema::hasTable('water_check_list'))
        {
            Schema::create('water_check_list', function (Blueprint $table) {
                $table->bigIncrements('water_check_list_id');  
                $table->char('water_check_list_name', length: 250)->nullable();  //   
                $table->enum('active', ['Y','N'])->default('N');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('water_check_list');
    }
};
