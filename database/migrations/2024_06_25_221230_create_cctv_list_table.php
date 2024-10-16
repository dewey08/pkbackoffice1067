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
        if (!Schema::hasTable('cctv_list'))
        {
            Schema::create('cctv_list', function (Blueprint $table) {
                $table->bigIncrements('cctv_list_id'); 
                $table->string('cctv_list_num', length: 200)->nullable();  //           
                $table->string('cctv_list_name', length: 200)->nullable(); //  
                $table->string('cctv_list_year', length: 200)->nullable(); // 
                $table->date('cctv_recive_date')->nullable();  //  
                $table->string('cctv_location', length: 200)->nullable(); //  
                $table->string('cctv_location_detail', length: 200)->nullable(); //  
                $table->string('cctv_type', length: 200)->nullable(); //
                $table->string('cctv_monitor', length: 200)->nullable(); //                 
                $table->enum('cctv_status', ['1','0'])->default('0');    
                $table->binary('cctv_img')->nullable();
                $table->string('cctv_img_name')->nullable();
                $table->longText('cctv_img_base')->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cctv_list');
    }
};
