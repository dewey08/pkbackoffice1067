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
        if (!Schema::hasTable('wh_pay_sub'))
        {
            Schema::create('wh_pay_sub', function (Blueprint $table) {
                $table->bigIncrements('wh_pay_sub_id'); 
                $table->string('pay_year')->nullable();  // 
                $table->string('stock_list_id')->nullable(); //     คลังใหญ่
                $table->string('stock_list_id_sub')->nullable(); //  คลังย่อย
                $table->string('wh_pay_id')->nullable(); // 
                $table->string('pro_id')->nullable();  //  
                $table->string('pro_name')->nullable();  //   
                $table->string('qty')->nullable();  //  
                $table->string('unit_id')->nullable();  //  
                $table->string('unit_name')->nullable();  // 
                $table->decimal('one_price',total: 12, places: 2)->nullable(); //   
                $table->decimal('total_price',total: 12, places: 2)->nullable(); //                  
                $table->string('user_id')->nullable(); //   
                $table->string('lot_no')->nullable();  //    
                $table->date('date_start')->nullable();  //  
                $table->date('date_enddate')->nullable();  //                           
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wh_pay_sub');
    }
};
