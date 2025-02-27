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
        if (!Schema::hasTable('stcok_card_new'))
        {
            Schema::create('stcok_card_new', function (Blueprint $table) {
                $table->bigIncrements('stcok_card_new_id'); 
                $table->enum('active', ['REP','PAY'])->default('Y'); 
                $table->string('bg_yearnow')->nullable();         //              
                $table->string('card_pro_id')->nullable();        //

                $table->string('card_vendor_id')->nullable();     // บริษัท
                $table->date('card_date')->nullable();             //ว/ด/ป 
                $table->string('recieve_po_sup')->nullable();      // เลขที่ใบส่งของ
                $table->string('card_qty')->nullable();       // จำนวนรับ
                $table->string('card_totalqty')->nullable();  // รวมรับ
                $table->string('card_price')->nullable();        // ราคา/หน่วย
                $table->date('card_date_expire')->nullable();   // วันหมดอายุ
                $table->string('card_totalallqty')->nullable();  //คงเหลือ    
                $table->string('request_no')->nullable();       // เลขที่ใบเบิก
                
                $table->string('user_id')->nullable(); // ผู้ตรวจ
                
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stcok_card_new');
    }
};
