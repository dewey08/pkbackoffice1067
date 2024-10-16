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
        if (!Schema::hasTable('wh_stock_list'))
        {
            Schema::create('wh_stock_list', function (Blueprint $table) {
                $table->bigIncrements('stock_list_id'); 
                $table->string('stock_list_name')->nullable(); //  
                $table->string('stock_type')->nullable(); //    
                $table->string('userid')->nullable();  //  
                                       
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wh_stock_list');
    }
};
