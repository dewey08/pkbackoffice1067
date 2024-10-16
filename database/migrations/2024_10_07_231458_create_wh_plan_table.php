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
        if (!Schema::hasTable('wh_plan'))
        {
            Schema::create('wh_plan', function (Blueprint $table) {
                $table->bigIncrements('wh_plan_id'); 
                $table->string('wh_plan_year')->nullable(); //  
                $table->date('plan_recieve_date')->nullable();  //  
                $table->string('pro_id')->nullable();  //  
                $table->string('praman_chay')->nullable();  //   ประมาณการใช้ในปี 2568  
                $table->string('wh_total')->nullable();  //  ปริมาณยอดคงคลังยกมา
                $table->string('praman_buy')->nullable();  // ประมาณการจัดซื้อในปี 2568 (หน่วย)
                $table->decimal('one_price',total: 12, places: 2)->nullable(); //   ราคาต่อหน่วย  (บาท)
                $table->decimal('total_price',total: 12, places: 2)->nullable(); // ประมาณการจัดซื้อปี 2568 (บาท)
                $table->string('trimart')->nullable(); 
                $table->string('trimat_one')->nullable();  //ไตรมาสที่1 จำนวน  
                $table->decimal('trimat_one_price',total: 12, places: 2)->nullable();  // ไตรมาสที่1 มูลค่า(บาท) 
                $table->string('trimat_two')->nullable();  //ไตรมาสที่2 จำนวน  
                $table->decimal('trimat_two_price',total: 12, places: 2)->nullable();  // ไตรมาสที่2 มูลค่า(บาท) 
                $table->string('trimat_tree')->nullable();  //ไตรมาสที่3จำนวน  
                $table->decimal('trimat_tree_price',total: 12, places: 2)->nullable();  // ไตรมาสที่3มูลค่า(บาท) 
                $table->string('trimat_four')->nullable();  //ไตรมาสที่4  จำนวน  
                $table->decimal('trimat_four_price',total: 12, places: 2)->nullable();  // ไตรมาสที่4 มูลค่า(บาท) 
                $table->string('total_plan')->nullable();  // ยอดรวมจัดซื้อจำนวน
                $table->decimal('total_plan_price',total: 12, places: 2)->nullable();  //ยอดรวมจัดซื้อจำนวน มูลค่า(บาท) 
                $table->string('user_id')->nullable(); //                                 
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wh_plan');
    }
};
