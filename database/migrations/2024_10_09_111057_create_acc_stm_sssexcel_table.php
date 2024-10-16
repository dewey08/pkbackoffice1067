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
        if (!Schema::hasTable('acc_stm_sssexcel'))
        {
            Schema::create('acc_stm_sssexcel', function (Blueprint $table) {
                $table->bigIncrements('acc_stm_sssexcel_id'); 
                $table->string('vn')->nullable(); //  
                $table->string('an')->nullable(); //  
                $table->string('hn')->nullable(); //  
                $table->string('cid')->nullable(); //  
                $table->string('ptname')->nullable(); //  
                $table->date('vstdate')->nullable();  //  
                $table->date('dchdate')->nullable();  //  
                $table->string('pttype')->nullable();  // 
                $table->string('nhso_docno')->nullable();  // 
                $table->string('hospmain')->nullable();  
                $table->string('income')->nullable(); //                  
                $table->string('claim')->nullable(); //  
                $table->string('debit')->nullable(); //
                $table->string('stm')->nullable(); //
                $table->string('difference')->nullable(); //
                $table->string('stm_no')->nullable(); //
                $table->date('date_save')->nullable();  //                   
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('acc_stm_sssexcel');
    }
};
