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
        if (!Schema::hasTable('vaccine_big_excel_rep'))
        {
            Schema::create('vaccine_big_excel_rep', function (Blueprint $table) {
                $table->bigIncrements('vaccine_big_excel_rep_id'); 
                $table->string('ptname', length: 200)->nullable(); //  
                $table->string('cid', length: 200)->nullable(); //                  
                $table->string('hospname', length: 200)->nullable();  //           
                $table->string('vaccine', length: 200)->nullable();  //   
                $table->string('hipdata_code', length: 200)->nullable(); // 
                $table->string('hipdata_name', length: 200)->nullable(); // 
                $table->string('authen', length: 200)->nullable(); //  
                $table->date('vstdate_start')->nullable();  //  
                $table->string('spsch', length: 200)->nullable(); //  
                $table->date('vstdate_end')->nullable();  //  
                $table->string('staff', length: 200)->nullable(); //  
                $table->string('n', length: 200)->nullable(); // 
                $table->string('status', length: 200)->nullable(); //  
                $table->string('no_pay')->nullable(); //                       เลขที่ใบเบิกจ่าย KTB20240621101357630
                $table->longText('STMDoc')->nullable(); //                     ชื่อไฟล์
                $table->string('userid')->nullable(); // 
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vaccine_big_excel_rep');
    }
};
