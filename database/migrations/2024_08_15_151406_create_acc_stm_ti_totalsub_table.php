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
        if (!Schema::hasTable('acc_stm_ti_totalsub'))
        {
            Schema::connection('mysql')->create('acc_stm_ti_totalsub', function (Blueprint $table) {
                $table->bigIncrements('acc_stm_ti_totalsub_id');
                $table->string('acc_stm_ti_total_id',100)->nullable();//  
                $table->string('wkno',100)->nullable();//  
                $table->string('HDBill_TBill_hcode')->nullable();// 
                $table->string('HDBill_TBill_station')->nullable();// 
                $table->string('HDBill_TBill_wkno')->nullable();// 
                $table->string('HDBill_TBill_hreg')->nullable();// 
                $table->string('HDBill_TBill_hn')->nullable();// 
                $table->string('HDBill_TBill_invno')->nullable();// 
                $table->string('HDBill_TBill_dttran')->nullable();// 
                $table->string('HDBill_TBill_hdrate')->nullable();// 
                $table->string('HDBill_TBill_hdcharge')->nullable();// 
                $table->string('HDBill_TBill_amount')->nullable();// 
                $table->string('HDBill_TBill_paid')->nullable();// 
                $table->string('HDBill_TBill_rid')->nullable();// 
                $table->string('HDBill_TBill_accp')->nullable();// 
                $table->string('HDBill_TBill_HDflag')->nullable();//  
                $table->string('HDBill_TBill_totalamount')->nullable();// 
                $table->string('STMdoc')->nullable();// 
                $table->timestamps();
                 
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('acc_stm_ti_totalsub');
    }
};
