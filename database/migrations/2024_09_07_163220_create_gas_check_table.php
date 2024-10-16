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
        if (!Schema::hasTable('gas_check'))
        {
            Schema::create('gas_check', function (Blueprint $table) {
                $table->bigIncrements('gas_check_id'); 
                $table->string('check_year')->nullable(); //  
                $table->date('check_date')->nullable();  //  
                $table->time('check_time')->nullable();  // 
                $table->string('gas_type')->nullable(); 

                $table->string('gas_list_id')->nullable(); 
                $table->string('gas_list_num')->nullable();  //เลขครุภัณฑ์ รหัส : OUT CO1
                $table->string('gas_list_name')->nullable(); 
                $table->string('size')->nullable(); //   
                $table->enum('active', ['NotReady','Ready','Borrow','"Wait"'])->default('Ready'); 

                $table->text('gas_check_body')->nullable(); // 1.ตัวถัง
                $table->text('gas_check_body_name')->nullable(); // 
                $table->text('gas_check_valve')->nullable(); // 2.วาลว์
                $table->text('gas_check_valve_name')->nullable(); // 
                $table->text('gas_check_pressure')->nullable(); // 3.แรงดัน
                $table->text('gas_check_pressure_name')->nullable(); // 

                $table->text('gas_check_pressure_min')->nullable(); // 
                $table->text('gas_check_pressure_max')->nullable(); // 

                $table->text('standard_value')->nullable(); // ค่ามาตรฐาน
                $table->text('standard_value_min')->nullable(); // ค่าต่ำ
                $table->text('standard_value_max')->nullable(); //ค่ามากสุด
                $table->text('pressure_value')->nullable(); //แรงดัน
                $table->text('pariman_value')->nullable(); //ระดับปริมาณ

                $table->text('oxygen_check')->nullable(); //
                $table->text('nitrous_oxide_check')->nullable(); //
                $table->text('pneumatic_air_check')->nullable(); //
                $table->text('vacuum_check')->nullable(); //

                $table->string('user_id')->nullable(); // ผู้ตรวจ
                
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gas_check');
    }
};
