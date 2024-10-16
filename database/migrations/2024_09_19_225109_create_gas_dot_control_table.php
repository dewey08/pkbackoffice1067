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
        if (!Schema::hasTable('gas_dot_control'))
        {
            Schema::create('gas_dot_control', function (Blueprint $table) {
                $table->bigIncrements('gas_dot_control_id');  
                $table->string('gas_list_id', length: 20)->nullable(); 
                $table->string('gas_list_num', length: 100)->nullable(); 
                $table->string('gas_list_name', length: 100)->nullable(); 
                $table->string('gas_type', length: 100)->nullable(); 
                $table->string('dot', length: 20)->nullable();  //           
                $table->string('dot_name', length: 255)->nullable(); //  
                $table->string('location_id', length: 255)->nullable(); //  
                $table->string('location_name', length: 255)->nullable(); //  
                $table->string('detail', length: 255)->nullable(); //   
                $table->string('class', length: 20)->nullable(); //             
                $table->string('user_id', length: 200)->nullable(); //   
                 
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gas_dot_control');
    }
};
