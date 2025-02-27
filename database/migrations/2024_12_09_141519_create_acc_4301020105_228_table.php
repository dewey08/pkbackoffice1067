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
        if (!Schema::hasTable('acc_4301020105_228'))
        {
            Schema::create('acc_4301020105_228', function (Blueprint $table) {
                $table->bigIncrements('acc_4301020105_228_id');
                $table->string('vn')->nullable();                 //  รหัส
                $table->string('an')->nullable();                 //
                $table->string('hn')->nullable();                 //
                $table->string('cid')->nullable();                //
                $table->string('ptname')->nullable();             //
                $table->date('vstdate')->nullable();              //
                $table->Time('vsttime')->nullable();              //
                $table->string('hm')->nullable();                 //
                $table->date('regdate')->nullable();              //
                $table->date('dchdate')->nullable();              //
                $table->string('main_dep')->nullable();           //
                $table->string('pttype')->nullable();             //
                $table->string('pttype_nhso')->nullable();        //
                $table->date('pttype_nhso_startdate')->nullable();//
                $table->string('income_group')->nullable();       //
                $table->string('acc_code')->nullable();           //
                $table->string('account_code')->nullable();       //
                $table->string('pdx')->nullable();    //
                $table->string('claim_code')->nullable();    //
                $table->string('income')->nullable();             //
                $table->string('uc_money')->nullable();           //
                $table->string('discount_money')->nullable();     //
                $table->string('rcpt_money')->nullable();         //  paid_money
                $table->string('rcpno')->nullable();              //
                $table->string('debit')->nullable();              //
                $table->string('debit_drug')->nullable();         //  เฉพาะรายการยา
                $table->string('debit_instument')->nullable();    //  เฉพาะรอวัยวะเทียม
                $table->string('debit_refer')->nullable();        //  เฉพาะ Refer
                $table->string('debit_toa')->nullable();          //
                $table->string('debit_total')->nullable();        //
                $table->string('max_debt_amount')->nullable();    //

                $table->date('date_req')->nullable();             //  วันที่ส่งข้อมูล   J
                $table->date('vstdate_stm')->nullable();          //               K
                $table->string('stm_rep')->nullable();            //               B
                $table->string('stm_trainid')->nullable();        //               C
                $table->string('stm_type_no')->nullable();        //               L
                $table->string('stm_type_name')->nullable();      //               M
                $table->string('stm_req_qty')->nullable();        //               N
                $table->string('stm_req_price')->nullable();      //               O
                $table->string('stm_burk_price')->nullable();     //               Q
                $table->string('stm_chodchey')->nullable();       //               T
                $table->string('stm_chodchey_no')->nullable();    //               U
                $table->string('stm_chodchey_plus')->nullable();  //               V
                $table->string('stm_chodchey_back')->nullable();  //               W
                $table->string('acc_debtor_userid')->nullable();  //
                $table->enum('status', ['Y', 'N'])->default('N'); //               X
                $table->string('comment')->nullable();            //               Y
                $table->string('comment_orther')->nullable();     //               Z
                $table->string('icode_inst')->nullable();         //               AA
                $table->string('name_inst')->nullable();          //               AB
                $table->string('STMDoc')->nullable();             //
                $table->string('user_id')->nullable();
                $table->string('hospsub')->nullable();          //                 //
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('acc_4301020105_228');
    }
};
