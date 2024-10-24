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
        if (!Schema::hasTable('wh_stock_card'))
        {
            Schema::create('wh_stock_card', function (Blueprint $table) {
                $table->bigIncrements('wh_stock_card_id'); 
                $table->string('stock_card_year')->nullable();  // 
                $table->string('stock_list_id')->nullable();    //   คลังหลัก
                $table->string('stock_list_subid')->nullable(); //  รับเข้าคลัง(ย่อย)   
                $table->string('wh_recieve_id')->nullable();    //  รับเข้า
                $table->string('wh_recieve_sub_id')->nullable();    //  รับเข้า
                $table->string('wh_stock_export_id')->nullable();    // จ่ายออก
                $table->string('wh_stock_export_sub_id')->nullable();    // จ่ายออก
                $table->string('pro_id')->nullable();           //  
                $table->string('pro_code')->nullable();         //   
                $table->string('pro_name')->nullable();         // 
                $table->string('qty')->nullable();              //  
                $table->string('unit_id')->nullable();          //  
                $table->string('unit_name')->nullable();        // 
                $table->decimal('one_price',total: 12, places: 2)->nullable(); //   
                $table->decimal('total_price',total: 12, places: 2)->nullable(); //  
                $table->string('lot_no')->nullable();           //    
                $table->date('date_start')->nullable();         //  
                $table->date('date_enddate')->nullable();       //   
                $table->enum('type', ['RECIEVE','PAY'])->default('RECIEVE');   
                $table->string('user_id')->nullable();          //                        
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wh_stock_card');
    }
};
