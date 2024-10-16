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
        if (!Schema::hasTable('wh_stock_sub'))
        {
            Schema::create('wh_stock_sub', function (Blueprint $table) {
                $table->bigIncrements('wh_stock_sub_id'); 
                $table->string('stock_year')->nullable(); //   
                $table->string('stock_list_id')->nullable();  //  
                $table->string('stock_list_name')->nullable();  //  
                $table->string('pro_id')->nullable();  //  
                $table->string('pro_code')->nullable();  // 
                $table->string('pro_name')->nullable();  //  
                $table->string('unit_id')->nullable();  // 
                $table->decimal('stock_price',total: 12, places: 2)->nullable(); //
                $table->string('stock_qty')->nullable();  //   
                $table->string('stock_rep')->nullable();  //  
                $table->string('stock_pay')->nullable();  //  
                $table->string('stock_total')->nullable();  //                           
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wh_stock_sub');
    }
};
