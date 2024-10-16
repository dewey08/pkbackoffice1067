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
        if (!Schema::hasTable('acc_rep_401'))
        {
            Schema::create('acc_rep_401', function (Blueprint $table) {
                $table->bigIncrements('acc_rep_401_id');  
                $table->string('rep_a', length: 20)->nullable(); 
                $table->string('no_b', length: 100)->nullable(); 
                $table->string('tran_id_c', length: 100)->nullable(); 
                $table->string('hn_d', length: 100)->nullable(); 
                $table->string('an_e', length: 100)->nullable();  //           
                $table->string('pid_f', length: 255)->nullable(); //  
                $table->string('ptname_g', length: 255)->nullable(); //  
                $table->string('type_h', length: 255)->nullable(); //  
                $table->date('vstdate_i')->nullable(); // 
                $table->date('dchdate_j')->nullable(); //   
                $table->string('income_k', length: 255)->nullable(); // 
                $table->string('pp_l', length: 255)->nullable(); // 
                $table->string('error_m', length: 100)->nullable(); // 
                $table->string('kongtoon_n', length: 255)->nullable(); // 
                $table->string('type_service_o', length: 255)->nullable(); //  
                $table->string('send_p', length: 255)->nullable(); // 
                $table->string('uuc_q', length: 255)->nullable(); // 
                $table->string('uuc1_r', length: 255)->nullable(); // 
                $table->string('hospmain_s', length: 255)->nullable(); // 
                $table->string('hospsub_t', length: 255)->nullable(); // 
                $table->string('href_u', length: 100)->nullable(); //   
                $table->string('hcode_v', length: 100)->nullable(); //
                $table->string('prov1_w', length: 100)->nullable(); //
                $table->string('codedep_x', length: 100)->nullable(); //
                $table->string('namedep_y', length: 255)->nullable(); //
                $table->string('proj_z', length: 100)->nullable(); //
                $table->string('pa_aa', length: 100)->nullable(); //
                $table->string('drg_ab', length: 100)->nullable(); //
                $table->string('rw_ac', length: 100)->nullable(); //
                $table->string('geb_income_ad', length: 200)->nullable(); //
                $table->string('geb_pp_ae', length: 200)->nullable(); //
                $table->string('income_pay_af', length: 200)->nullable(); //
                $table->string('income_nopay_ag', length: 200)->nullable(); //
                $table->string('rcpt_ah', length: 200)->nullable(); //
                $table->string('aut_pay_ai', length: 200)->nullable(); //
                $table->string('ps_aj', length: 200)->nullable(); //   
                $table->string('psper_ak', length: 200)->nullable(); //  
                $table->string('ccuf_al', length: 200)->nullable(); //  
                $table->string('adjrw_am', length: 200)->nullable(); //  
                $table->string('prb_an', length: 200)->nullable(); //  
                $table->string('ipcs_ao', length: 200)->nullable(); //         
                $table->string('ipcs_ors_ap', length: 200)->nullable(); //  
                $table->string('opcs_aq', length: 200)->nullable(); //  
                $table->string('pacs_ar', length: 200)->nullable(); //  
                $table->string('instcs_as', length: 200)->nullable(); //  
                $table->string('otcs_at', length: 200)->nullable(); //  
                $table->string('pp_au', length: 200)->nullable(); //  
                $table->string('drug_av', length: 200)->nullable(); //  
                $table->string('ipcs_aw', length: 200)->nullable(); //  
                $table->string('opcs_ax', length: 200)->nullable(); //  
                $table->string('pacs_ay', length: 200)->nullable(); //  
                $table->string('instcs_az', length: 200)->nullable(); //  
                $table->string('otcs_ba', length: 200)->nullable(); //  
                $table->string('ors_bb', length: 200)->nullable(); //  
                $table->string('va_bc', length: 200)->nullable(); //  
                $table->string('audit_bd', length: 200)->nullable(); //  
 
                $table->string('user_id', length: 200)->nullable(); //   
                 
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('acc_rep_401');
    }
};
