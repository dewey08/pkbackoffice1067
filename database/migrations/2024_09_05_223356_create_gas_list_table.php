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
        if (!Schema::hasTable('gas_list'))
        {
            Schema::create('gas_list', function (Blueprint $table) {
                $table->bigIncrements('gas_list_id'); 
                $table->date('gas_recieve_date')->nullable(); 
                $table->string('gas_type')->nullable(); 
                $table->string('gas_list_num', length: 255)->nullable();  //           
                $table->string('gas_list_name', length: 255)->nullable(); //  
                $table->string('detail', length: 255)->nullable(); //  
                $table->string('size', length: 255)->nullable(); //  
                $table->decimal('gas_price',total: 12, places: 2)->nullable(); //  
                $table->string('gas_year', length: 200)->nullable(); //       
                $table->string('gas_unit', length: 200)->nullable(); //    
                $table->string('gas_brand', length: 200)->nullable(); //          
                $table->enum('active', ['NotReady','Ready','Borrow','Wait'])->default('Ready'); 

                $table->string('location_id', length: 255)->nullable(); // 
                $table->string('location_name', length: 255)->nullable(); //
                $table->binary('gas_img')->nullable(); //                 
                $table->string('gas_imgname', length: 200)->nullable(); //
                $table->longText('gas_img_base')->nullable(); // 
                $table->date('gas_recive_date')->nullable();  // 
                $table->enum('gas_backup', ['Y','N'])->default('N');
                $table->date('gas_date_pdd')->nullable();  // วันที่ผลิต
                $table->date('gas_date_exp')->nullable();  // วันหมดอายุ                  
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
        Schema::dropIfExists('gas_list');
    }
};
