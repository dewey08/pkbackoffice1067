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
                $table->date('pay_date')->nullable();        //  วันที่รับ 
                $table->time('pay_time')->nullable();        //  เวลา
                $table->string('pay_no')->nullable();        //
                $table->string('stock_list_id')->nullable(); //  คลัง
                $table->string('vendor_id')->nullable();     //  บริษัท  
                $table->string('pay_po')->nullable();        //เลขที่บริษัท 
                $table->decimal('total_price',total: 12, places: 4)->nullable(); //  
                $table->string('user_pay')->nullable(); //     
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
        Schema::dropIfExists('wh_pay');
    }
};
