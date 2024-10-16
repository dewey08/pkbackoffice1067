<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    { 
        if (!Schema::hasTable('acc_stm_ti_total'))
        {
            Schema::connection('mysql')->create('acc_stm_ti_total', function (Blueprint $table) {
                $table->bigIncrements('acc_stm_ti_total_id'); 
                $table->string('acc_stm_ti_totalhead_id',100)->nullable();// 
                $table->string('HDBill_hreg',100)->nullable();//   
                $table->string('HDBill_hn')->nullable();//   
                $table->string('HDBill_name')->nullable();//
                $table->string('HDBill_pid')->nullable();// 
                $table->string('HDBill_wkno')->nullable();// 
                $table->string('HDBill_hds')->nullable();// 
                $table->string('HDBill_quota')->nullable();// 
                $table->string('HDBill_hdcharge')->nullable();// 
                $table->string('HDBill_payable')->nullable();// 
                $table->string('HDBill_outstanding')->nullable();// 
                $table->string('HDBill_EPO_effHDs')->nullable();// 
                $table->string('HDBill_EPO_effHCT')->nullable();// 
                $table->string('HDBill_EPO_epoPay')->nullable();// 
                $table->string('HDBill_EPO_epoAdm')->nullable();// 
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

                $table->string('repno')->nullable();// 
                $table->date('vstdate')->nullable();//วันที่เข้ารับบริการ 
                $table->date('date_save')->nullable();// 
                $table->string('vn')->nullable();// 
                $table->string('invno')->nullable();// 
                $table->string('EPOpay')->nullable();// 
                $table->string('Total_amount')->nullable();// 
                $table->string('sum_price_approve')->nullable();// 
                $table->text('STMdoc',500)->nullable();//  
                $table->enum('active', ['REP','APPROVE','CANCEL','FINISH'])->default('REP')->nullable(); 
                $table->timestamps();
                
                // $table->double('sum_price_approve', 12, 4)->nullable();//รวมจ่ายชดเชยสุทธิ 
              
                // $table->string('station')->nullable();// 
                // $table->string('vn')->nullable();//   
                // $table->string('invno')->nullable();//  
                // $table->string('dttran',255)->nullable();//   
                // $table->double('hdrate', 12, 4)->nullable();// 
                // $table->double('hdcharge', 12, 4)->nullable();// 
                // $table->double('amount', 12, 4)->nullable();// 
                // $table->double('paid', 12, 4)->nullable();// 
                // $table->double('EPOpay', 12, 4)->nullable();// 
              
               

                // $table->string('rid')->nullable();//  
                // $table->string('accp')->nullable();//  
                // $table->string('HDflag')->nullable();//   
                // $table->string('AccPeriod')->nullable();//  
                // $table->string('hdrate')->nullable();// 
                // $table->string('hdcharge')->nullable();// 
                // $table->string('amount')->nullable();// 
                // $table->string('paid')->nullable();// 
                // $table->string('EPOpay')->nullable();// 
                // $table->string('Total_amount')->nullable();//  
                // $table->string('Total_thamount')->nullable();//  
                
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('acc_stm_ti_total');
    }
};
