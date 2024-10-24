<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    { 
        if (!Schema::hasTable('wh_product'))
        {
            Schema::create('wh_product', function (Blueprint $table) {
                $table->bigIncrements('pro_id'); 
                $table->string('barcode')->nullable();  //
                $table->string('pro_year')->nullable(); //  
                $table->date('recieve_date')->nullable();  //  
                $table->string('pro_code')->nullable();  // รหัส : OUT CO1
                $table->string('pro_num')->nullable();  //เลขครุภัณฑ์
                $table->string('pro_name')->nullable();  
                $table->string('pro_type')->nullable(); //ประเภท                 
                $table->string('unit_id')->nullable(); //  หน่วย
                $table->binary('img')->nullable();
                $table->string('img_name')->nullable();
                $table->longText('img_base')->nullable();
                $table->enum('active', ['Y','N'])->default('Y'); 
                $table->string('user_id')->nullable(); //
                                 
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('wh_product');
    }
};
