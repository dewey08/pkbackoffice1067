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
        if (!Schema::hasTable('audit_approve_code'))
        {
            Schema::create('audit_approve_code', function (Blueprint $table) {
                $table->bigIncrements('audit_approve_code_id');
                $table->string('vn')->nullable();  //  
                $table->string('hn')->nullable();  //   
                $table->string('ptname')->nullable();  // 
                $table->string('staff')->nullable();  //          
                $table->date('debt_date')->nullable();  //  
                $table->time('debt_time')->nullable();  //
                $table->string('amount')->nullable();  // 
                $table->string('total_amount')->nullable();  // 
                $table->string('sss_approval_code')->nullable();  // 
                $table->string('sss_amount')->nullable();  // 
 
                $table->string('ECLAIM_NO')->nullable();  //
                $table->string('CID_SPSCH')->nullable();  //
                $table->string('PTNAME_SPSCH')->nullable();  //
                $table->string('HN_SPSCH')->nullable();  //
                $table->date('VSTDATE_SPSCH')->nullable();  //
                $table->time('VSTTIME_SPSCH')->nullable();  //
                $table->string('STATUS_SPSCH')->nullable();  //
                $table->string('Tran_ID')->nullable();  //
                $table->string('CLAIM')->nullable();  //
                $table->string('REP')->nullable();  //
                $table->string('ERROR_C')->nullable();  //
                $table->string('Deny')->nullable();  //
                $table->string('Channel')->nullable();  //
                
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('audit_approve_code');
    }
};
