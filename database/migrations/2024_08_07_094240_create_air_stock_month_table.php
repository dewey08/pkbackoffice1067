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
        if (!Schema::hasTable('air_stock_month'))
        {
            Schema::create('air_stock_month', function (Blueprint $table) {
                $table->bigIncrements('air_stock_month_id'); 
                $table->string('months')->nullable();  // 
                $table->string('years')->nullable();  //
                $table->string('years_th')->nullable();  //   
                $table->string('total_qty')->nullable();  //  
                $table->decimal('total_price',total: 12, places: 2)->nullable(); //  
                $table->date('datesave')->nullable();  //  
                $table->string('userid')->nullable(); // 
                $table->enum('status', ['N','Y'])->default('Y');                 
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('air_stock_month');
    }
};
