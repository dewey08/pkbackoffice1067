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
        if (!Schema::hasTable('operate_time_dep'))
        {
        Schema::create('operate_time_dep', function (Blueprint $table) {
            $table->bigIncrements('operate_time_dep_id');
            $table->date('operate_time_dep_date')->nullable();// วันที่
            $table->string('operate_time_dep_personid',10)->nullable();//ID hrd_person
            $table->string('operate_time_dep_person',255)->nullable();//NAME hrd_person
            $table->string('operate_time_dep_typeid',10)->nullable();// ประเภท
            $table->string('operate_time_dep_typename',255)->nullable();// ประเภท
            $table->string('operate_time_depid',10)->nullable();// กลุ่มภารกิจ
            $table->string('operate_time_depname',255)->nullable();// กลุ่มภารกิจ
            $table->Time('operate_time_dep_in')->nullable();// เวลา IN
            $table->Time('operate_time_dep_out')->nullable();// เวลา OUT
            $table->Time('operate_time_dep_otin')->nullable();// เวลา OT IN
            $table->Time('operate_time_dep_otout')->nullable();// เวลา OT OUT
            $table->string('totaltime_narmal',10)->nullable();//
            $table->string('totaltime_ot',10)->nullable();//
            $table->string('user_id',10)->nullable();//
            $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('operate_time_dep');
    }
};
