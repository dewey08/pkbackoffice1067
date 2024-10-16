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
        if (!Schema::hasTable('acc_stm_lgoexcelnew'))
        {
            Schema::create('acc_stm_lgoexcelnew', function (Blueprint $table) {
                $table->bigIncrements('acc_stm_lgoexcelnew_id'); 

                $table->dateTime('transfer_date')->nullable();//   B - วันที่โอน                 
                $table->string('hn')->nullable();//      C - 
                $table->string('an')->nullable();//      D -  
                $table->string('fun')->nullable();//     E -  กองทุน
                $table->string('type')->nullable();//    F - ประเภท
                $table->string('cid')->nullable();//     G - เลขบัตรประชาชน
                $table->string('ptname')->nullable();//  H - ชื่อ-สกุล
                $table->date('vstdate')->nullable();//   I - วันที่เข้ารับบริการ 
                $table->string('pay')->nullable();//     J - จ่ายชดเชยสุทธิ 
                $table->string('rep_no')->nullable();//  K - REP_NO  
                $table->string('STMDoc')->nullable();//  
                $table->enum('active', ['N', 'Y', 'W'])->default('N'); 
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('acc_stm_lgoexcelnew');
    }
};
