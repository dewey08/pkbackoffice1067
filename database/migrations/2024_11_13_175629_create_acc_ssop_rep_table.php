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
        if (!Schema::hasTable('acc_ssop_rep'))
        {
            Schema::create('acc_ssop_rep', function (Blueprint $table) {
                $table->bigIncrements('acc_ssop_rep_id'); 
                $table->string('object_name')->nullable();  // 
                $table->string('line1')->nullable();    //    
                $table->string('line2')->nullable(); //   
                $table->string('line3')->nullable();    // 
                $table->string('line4')->nullable();    // 
                $table->string('line5')->nullable();    //  
                $table->string('line6')->nullable();    // จ
                $table->string('line7')->nullable();           //  
                $table->string('line8')->nullable();         //   
                $table->string('line9')->nullable();         // 
                $table->string('line10')->nullable();              //  
                $table->string('line11')->nullable();          //  
                $table->string('line12')->nullable();        // 
                // $table->decimal('one_price',total: 12, places: 2)->nullable(); //    
                // $table->string('lot_no')->nullable();           //     
                // $table->enum('type', ['RECIEVE','PAY'])->default('RECIEVE');   
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
        Schema::dropIfExists('acc_ssop_rep');
    }
};
