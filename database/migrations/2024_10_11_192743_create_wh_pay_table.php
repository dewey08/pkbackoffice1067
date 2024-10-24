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
        if (!Schema::hasTable('wh_pay'))
        {
            Schema::create('wh_pay', function (Blueprint $table) {
                $table->bigIncrements('wh_pay_id');  
                $table->string('year')->nullable();          //  ปีงบประมาณ
                $table->string('wh_request_id')->nullable(); // 
                $table->date('pay_date')->nullable();        //  วันที่จ่าย
                $table->time('pay_time')->nullable();        //  เวลา
                $table->string('pay_no')->nullable();        //
                $table->string('stock_list_id')->nullable(); //  คลัง
                $table->string('stock_list_subid')->nullable();  //  คลัง(ย่อย)    
                $table->string('pay_po')->nullable();        //เลขที่บริษัท 
                $table->decimal('total_price',total: 12, places: 4)->nullable(); //  
                $table->string('user_pay')->nullable(); //  
                $table->string('user_export_send')->nullable(); //  
                $table->string('user_export_rep')->nullable(); //    
                $table->enum('active', ['REQUEST','PAY','APPROVE','CONFIRM'])->default('REQUEST');                              
                $table->timestamps();
            });
        }
         
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wh_pay');
    }
};
