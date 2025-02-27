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
        if (!Schema::hasTable('checkup_report'))
        {
            Schema::create('checkup_report', function (Blueprint $table) {
                $table->bigIncrements('checkup_report_id'); 
                $table->string('vn')->nullable();// รหัส              
                $table->string('hn')->nullable();//                 
                $table->date('vstdate')->nullable();//
                $table->Time('vsttime')->nullable();//
                $table->string('department')->nullable();//
                $table->string('ptname')->nullable();//
                $table->string('cid')->nullable();//  
                $table->string('pttype')->nullable();// สิทธิ์
                $table->string('sex')->nullable();//
                $table->string('sex_code')->nullable();//
                $table->string('age_y')->nullable();// 
                $table->string('bw')->nullable();// 
                $table->string('height')->nullable();// 
                $table->string('waist')->nullable();// 
                $table->string('temperature')->nullable();// 
                $table->string('rr')->nullable();// 
                $table->string('pulse')->nullable();// 
                $table->string('bmi')->nullable();// 
                $table->string('bps')->nullable();//  
                $table->string('bpd')->nullable();//
                $table->string('hometel')->nullable();//                  

                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('checkup_report');
    }
};
