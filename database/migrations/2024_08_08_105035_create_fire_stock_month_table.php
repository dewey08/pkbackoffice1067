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
        if (!Schema::hasTable('fire_stock_month'))
        {
            Schema::create('fire_stock_month', function (Blueprint $table) {
                $table->bigIncrements('fire_stock_month_id'); 
                $table->string('months')->nullable();  // 
                $table->string('years')->nullable();  //
                $table->string('years_th')->nullable();  //  

                $table->string('total_all_qty')->nullable();  // 

                $table->string('total_backup_r10')->nullable();  // 
                $table->string('total_backup_r15')->nullable();  // 
                $table->string('total_backup_r20')->nullable();  // 

                $table->string('total_backup_g10')->nullable();  // 
                $table->string('total_backup_g15')->nullable();  // 
                $table->string('total_backup_g20')->nullable();  // 

                $table->string('total_red10')->nullable();  // 
                $table->string('total_red15')->nullable();  // 
                $table->string('total_red20')->nullable();  // 

                $table->string('total_green10')->nullable();  // 
                $table->string('total_green15')->nullable();  // 
                $table->string('total_green20')->nullable();  // 
               
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
        Schema::dropIfExists('fire_stock_month');
    }
};
