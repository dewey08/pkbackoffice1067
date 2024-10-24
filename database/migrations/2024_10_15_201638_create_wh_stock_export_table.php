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
        if (!Schema::hasTable('wh_stock_export'))
        {
            Schema::create('wh_stock_export', function (Blueprint $table) {
                $table->bigIncrements('wh_stock_export_id');  
                $table->string('wh_request_id')->nullable(); // 
                $table->string('year')->nullable();               //  ปีงบประมาณ
                $table->date('export_date')->nullable();         //  วันที่รับ 
                $table->time('export_time')->nullable();         //  เวลา
                $table->string('export_no')->nullable();         //
                $table->string('stock_list_id')->nullable();     //  คลังหลัก
                $table->string('stock_list_subid')->nullable();  //  คลัง(ย่อย)  
                $table->string('export_po')->nullable();        //    
                $table->decimal('total_price',total: 12, places: 4)->nullable(); //  
                $table->string('user_export_send')->nullable(); //  
                $table->string('user_export_rep')->nullable(); //    
                $table->enum('active', ['EXPORT','SENDEXPORT','REPEXPORT','CONFIRM'])->default('EXPORT');                              
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wh_stock_export');
    }
};
