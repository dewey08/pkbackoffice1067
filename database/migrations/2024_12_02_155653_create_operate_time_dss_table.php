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
        if (!Schema::hasTable('operate_time_dss'))
        {
        Schema::create('operate_time_dss', function (Blueprint $table) {
            $table->bigIncrements('operate_time_dss_id');
            $table->date('operate_time_dss_date')->nullable();// วันที่
            $table->string('operate_time_dss_personid',10)->nullable();//ID hrd_person
            $table->string('operate_time_dss_person',255)->nullable();//NAME hrd_person
            $table->string('operate_time_dss_typeid',10)->nullable();// ประเภท
            $table->string('operate_time_dss_typename',255)->nullable();// ประเภท
            $table->string('operate_time_dss_dssid',10)->nullable();// หน่วยงาน
            $table->string('operate_time_dss_dss',255)->nullable();// หน่วยงาน
            $table->Time('operate_time_dss_in')->nullable();// เวลา IN
            $table->Time('operate_time_dss_out')->nullable();// เวลา OUT
            $table->Time('operate_time_dss_otin')->nullable();// เวลา OT IN
            $table->Time('operate_time_dss_otout')->nullable();// เวลา OT OUT
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
        Schema::dropIfExists('operate_time_dss');
    }
};
