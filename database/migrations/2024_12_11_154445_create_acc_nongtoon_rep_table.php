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
        if (!Schema::hasTable('acc_nongtoon_rep'))
        {
            Schema::create('acc_nongtoon_rep', function (Blueprint $table) {
                $table->bigIncrements('acc_nongtoon_rep_id');
                $table->string('rep_no')->nullable();                 //   B
                $table->string('tran_id')->nullable();              //C
                $table->string('hn')->nullable();                  //D
                $table->string('an')->nullable();                  //E
                $table->string('cid')->nullable();                 //F
                $table->string('ptname')->nullable();              //G
                $table->string('hipdata_code')->nullable();       //H
                $table->string('hmain_op')->nullable();          // I
                $table->date('date_send')->nullable();             //  วันที่ส่งข้อมูล   J
                $table->date('vstdate')->nullable();             //               K
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
                $table->enum('status', ['Y', 'N'])->default('N'); //
                $table->string('status_pay')->nullable();         //               X
                $table->string('comment')->nullable();            //               Y
                $table->string('comment_orther')->nullable();     //               Z
                $table->string('icode_inst')->nullable();         //               AA
                $table->string('name_inst')->nullable();          //               AB
                $table->string('hospsub')->nullable();          //               AC
                $table->string('STMDoc')->nullable();             //
                $table->string('user_id')->nullable();            //
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('acc_nongtoon_rep');
    }
};
