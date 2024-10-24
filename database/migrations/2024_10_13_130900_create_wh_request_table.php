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
        if (!Schema::hasTable('wh_request'))
        {
            Schema::create('wh_request', function (Blueprint $table) {
                $table->bigIncrements('wh_request_id');  
                $table->string('year')->nullable();               //  ปีงบประมาณ
                $table->date('request_date')->nullable();         //  วันที่ขอเบิก
                $table->time('request_time')->nullable();         //  เวลา
                $table->date('repin_date')->nullable();         //  วันที่รับ 
                $table->time('repin_time')->nullable();         //  เวลา
                $table->string('request_no')->nullable();         //
                $table->string('stock_list_id')->nullable();     //  คลังหลัก
                $table->string('stock_list_subid')->nullable();  //  คลัง(ย่อย)  
                $table->string('request_po')->nullable();        //  เลขที่บริษัท 
                $table->decimal('total_price',total: 12, places: 4)->nullable(); //  
                $table->string('user_request')->nullable(); //     
                $table->enum('active', ['REQUEST','APPREQUEST','APPROVE','ALLOCATE','CONFIRM','CONFIRMSEND'])->default('REQUEST');                              
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wh_request');
    }
};
