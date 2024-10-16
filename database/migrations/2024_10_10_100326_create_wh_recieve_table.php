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
        if (!Schema::hasTable('wh_recieve'))
        {
            Schema::create('wh_recieve', function (Blueprint $table) {
                $table->bigIncrements('wh_recieve_id'); 
              
                $table->string('year')->nullable();          //  ปีงบประมาณ
                $table->date('recieve_date')->nullable();    //  วันที่รับ 
                $table->time('recieve_time')->nullable();    //  เวลา
                $table->string('recieve_no')->nullable();    //
                $table->string('stock_list_id')->nullable(); //  คลัง
                $table->string('vendor_id')->nullable();     //  บริษัท  
                $table->string('recieve_po')->nullable();     //เลขที่บริษัท
                // $table->string('wh_total')->nullable();  //   
                // $table->string('praman_buy')->nullable();  //  
                $table->decimal('total_price',total: 12, places: 4)->nullable(); //  
                $table->string('user_recieve')->nullable(); //     
                $table->enum('active', ['PREPARE','RECIVE','CONFIRM'])->default('PREPARE');                              
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wh_recieve');
    }
};
