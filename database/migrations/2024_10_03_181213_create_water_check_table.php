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
        if (!Schema::hasTable('water_check'))
        {
            Schema::create('water_check', function (Blueprint $table) {
                $table->bigIncrements('water_check_id'); 
                $table->string('check_year')->nullable(); //  
                $table->date('check_date')->nullable();  //  
                $table->time('check_time')->nullable();  //  
                $table->string('water_filter_id')->nullable(); 
                $table->string('water_code')->nullable();  //เลขครุภัณฑ์ รหัส : OUT CO1
                $table->string('water_name')->nullable();  
                $table->enum('active', ['Y','N'])->default('Y'); 
                $table->string('filter')->nullable(); // 1.ไส้กรอง
                $table->string('filter_name')->nullable(); // 
                $table->string('filter_tank')->nullable(); // 2.ถังกรองน้ำ
                $table->string('filter_tank_name')->nullable(); // 
                $table->string('tube')->nullable(); // 3.หลอด UV
                $table->string('tube_name')->nullable(); // 
                $table->string('solinoi_vaw')->nullable(); // 4.โซลินอยวาล์ว
                $table->string('solinoi_vaw_name')->nullable(); // 
                $table->string('lowplessor_swith')->nullable(); // 5.โลเพรสเซอร์สวิส
                $table->string('lowplessor_swith_name')->nullable(); //  
                $table->string('hiplessor_swith')->nullable(); // 6.ไฮเพรสเซอร์สวิส
                $table->string('hiplessor_swith_name')->nullable(); //  
                $table->string('water_in')->nullable(); //  7.สายน้ำเข้า
                $table->string('water_in_name')->nullable(); //
                $table->string('hot_clod')->nullable(); //  8.ก๊อกน้ำร้อน-เย็น
                $table->string('hot_clod_name')->nullable(); //
                $table->string('pipes')->nullable(); //  9.ข้อต่อและท่อ
                $table->string('pipes_name')->nullable(); //
                $table->string('storage_tank')->nullable(); //  10.ถังเก็บน้ำกรอง
                $table->string('storage_tank_name')->nullable(); //

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
        Schema::dropIfExists('water_check');
    }
};
