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
        if (!Schema::hasTable('acc_mareng'))
        {
            Schema::create('acc_mareng', function (Blueprint $table) {
                $table->bigIncrements('acc_mareng_id'); 
               
                $table->string('vn')->nullable();    //  
                $table->string('icd10')->nullable();    // 
                $table->string('hn')->nullable();    // 
                $table->date('vstdate')->nullable();  //
                $table->time('vsttime')->nullable();  //
                $table->string('diagtype')->nullable();    // 
                $table->string('hcode')->nullable();    // 
                $table->string('doctor')->nullable();    // 
                $table->string('episode')->nullable();    // 
                $table->string('staff')->nullable();    // 
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
        Schema::dropIfExists('acc_mareng');
    }
};
