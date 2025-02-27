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
        if (!Schema::hasTable('acc_lgo_repexcel'))
        {
            Schema::create('acc_lgo_repexcel', function (Blueprint $table) {
                $table->bigIncrements('acc_lgo_repexcel_id'); 
                $table->string('rep')->nullable();           // A
                $table->string('no')->nullable();            // B
                $table->string('tran_id')->nullable();        // C
                $table->string('hn')->nullable();             //  D
                $table->string('an')->nullable();             //  E
                $table->string('pid')->nullable();            //   F
                $table->string('ptname')->nullable();         //  G
                $table->string('type')->nullable();           //   H
                $table->string('vstdate')->nullable();         //   I
                $table->string('dchdate')->nullable();         //  J
                $table->string('income_cherd')->nullable();          // K 
                $table->string('pp_cherd')->nullable();              //  L
                $table->string('error_code')->nullable();      // M
                $table->string('toon')->nullable();             // N
                $table->string('type_service')->nullable();     // M
                $table->string('refer')->nullable();            // P
                $table->string('ucc')->nullable();              // R
                $table->string('hospmain')->nullable();        // S
                $table->string('hospsub')->nullable();         // T
                $table->string('href')->nullable();           // U
                $table->string('hcode')->nullable();          // V
                $table->string('prov1')->nullable();          // W
                $table->string('hoscode')->nullable();        // X
                $table->string('hosname')->nullable();        // y
                $table->string('proj')->nullable();          // z
                $table->string('pa')->nullable();          // aa
                $table->string('drg')->nullable();          //ab
                $table->string('rw')->nullable();          // ac
                $table->string('income')->nullable();          //ad
                $table->string('pp_claim')->nullable();          //ae
                $table->string('income_claim')->nullable();          // af   เบิกได้
                $table->string('income_noclaim')->nullable();    //ag เบิกไม่ได้
                $table->string('rcpt')->nullable();          //ah   
                $table->string('pay')->nullable();                //  ai
                $table->string('ps')->nullable();                //  aj
                $table->string('psper')->nullable();              // ak
                $table->string('ccuf')->nullable();               //al
                $table->string('adjrw')->nullable();              // am
                $table->string('prb')->nullable();                // an
                $table->string('iplg')->nullable();               // ao
                $table->string('oplg')->nullable();              // ap
                $table->string('palg')->nullable();              // aq
                $table->string('instlg')->nullable();             //ar
                $table->string('otlg')->nullable();              // as
                $table->string('pp_grnee')->nullable();          //  at
                $table->string('drug')->nullable();               //  au
                $table->string('iplg_deny')->nullable();          // av
                $table->string('oplg_deny')->nullable();          // aw
                $table->string('palg_deny')->nullable();          // ax
                $table->string('instlg_deny')->nullable();          // ay
                $table->string('otlg_deny')->nullable();          //  az
                $table->string('ors')->nullable();                //  ba
                $table->string('va')->nullable();                 //bb
                $table->string('audit')->nullable();                //bc  
                $table->string('STMdoc')->nullable();             // 
                // $table->string('rcpt')->nullable();             //  Ah
                $table->string('user_id')->nullable();                         
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('acc_lgo_repexcel');
    }
};
