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
        if (!Schema::hasTable('water_report'))
        {
            Schema::create('water_report', function (Blueprint $table) {
                $table->bigIncrements('water_report_id'); 
                $table->string('bg_yearnow')->nullable();//
                $table->string('months')->nullable();//
                $table->string('years')->nullable();//
                $table->string('years_th')->nullable();//
           
                $table->string('water_all')->nullable(); // 
                $table->string('water_week')->nullable(); // 
                $table->string('water_checkall')->nullable(); // 

                $table->string('filter_check')->nullable(); // 1.ไส้กรอง all
                $table->string('filter_n')->nullable(); // 
                $table->string('filter_y')->nullable(); // 

                $table->string('filter_tank_check')->nullable(); // 2.ถังกรองน้ำ
                $table->string('filter_tank_n')->nullable(); // 
                $table->string('filter_tank_y')->nullable(); // 

                $table->string('tube_check')->nullable(); // 3.หลอด UV
                $table->string('tube_n')->nullable(); // 
                $table->string('tube_y')->nullable(); // 

                $table->string('solinoi_vaw_check')->nullable(); // 4.โซลินอยวาล์ว
                $table->string('solinoi_vaw_n')->nullable(); // 
                $table->string('solinoi_vaw_y')->nullable(); //

                $table->string('lowplessor_swith_check')->nullable(); // 5.โลเพรสเซอร์สวิส
                $table->string('lowplessor_swith_n')->nullable(); //  
                $table->string('lowplessor_swith_y')->nullable(); // 

                $table->string('hiplessor_swith_check')->nullable(); // 6.ไฮเพรสเซอร์สวิส
                $table->string('hiplessor_swith_n')->nullable(); //  
                $table->string('hiplessor_swith_y')->nullable(); //  

                $table->string('water_in_check')->nullable(); //  7.สายน้ำเข้า
                $table->string('water_in_n')->nullable(); //
                $table->string('water_in_y')->nullable(); //

                $table->string('hot_clod_check')->nullable(); //  8.ก๊อกน้ำร้อน-เย็น
                $table->string('hot_clod_n')->nullable(); //
                $table->string('hot_clod_y')->nullable(); //

                $table->string('pipes_check')->nullable(); //  9.ข้อต่อและท่อ
                $table->string('pipes_n')->nullable(); //
                $table->string('pipes_y')->nullable(); //

                $table->string('storage_tank_check')->nullable(); //  10.ถังเก็บน้ำกรอง
                $table->string('storage_tank_n')->nullable(); //
                $table->string('storage_tank_y')->nullable(); //

                $table->enum('active', ['Y','N'])->default('Y'); 
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
        Schema::dropIfExists('water_report');
    }
};
