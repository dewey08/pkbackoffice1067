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
        if (!Schema::hasTable('visit_pttype_import_excel'))
        {
        Schema::create('visit_pttype_import_excel', function (Blueprint $table) {
                $table->bigIncrements('visit_pttype_import_excel_id'); 
                $table->string('vn')->nullable();//  
                $table->string('hn')->nullable();// 
                $table->string('pid')->nullable();// 
                $table->string('pttype')->nullable();//  

                $table->string('hcode')->nullable();// 
                $table->string('hosname')->nullable();// 
                $table->string('cid')->nullable();// 
                $table->string('ptname')->nullable();// 
                $table->string('birthday')->nullable();// 
                $table->string('hometel')->nullable();// 
                $table->string('mainpttype')->nullable();// 
                $table->string('subpttype')->nullable();// 
                $table->string('repcode')->nullable();// 
                $table->string('claimcode')->nullable();// CLAIM CODE
                $table->string('claimtype')->nullable();// รหัสบริการ
                $table->string('servicerep')->nullable();// ประเภทการเข้ารับบริการ 
                $table->string('servicename')->nullable();//  บริการ
                $table->string('hncode')->nullable();// 
                $table->string('ancode')->nullable();// 
                $table->date('vstdate')->nullable();// วันที่เข้ารับบริการ
                $table->dateTime('regdate')->nullable();// วันที่บันทึก Authen Code
                $table->string('status')->nullable();//
                $table->string('repauthen')->nullable();//  ช่องทางการขอ Authen Code
                $table->string('authentication')->nullable();//วิธีการพิสูจน์ตัวตน
                $table->string('staffservice')->nullable();//ผู้จับของการเข้ารับบริการ
                $table->date('dateeditauthen')->nullable();//วันที่แก้ไข Authen Cod
                $table->string('nameeditauthen')->nullable();//ชื่อผู้ที่แก้ใข Authen Code
                $table->string('comment')->nullable();//หมายเหตุการยกเลิก
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visit_pttype_import_excel');
    }
};
