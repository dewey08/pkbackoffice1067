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
        if (!Schema::hasTable('fdh_mini_dataset'))
        {
            Schema::connection('mysql')->create('fdh_mini_dataset', function (Blueprint $table) { 
                $table->bigIncrements('fdh_mini_dataset_id');//  
               
                $table->dateTime('service_date_time')->nullable();//   วันเวลาที่เข้ารับบริการ รับเป็นปีค.ศ. (Format: YYYY-MM-DD hh:mm)
               
                $table->string('cid')->nullable();//     เลขบัตรประชาชนผู้เข้ารับบริการ 
                $table->string('hcode')->nullable();//    รหัสหน่วยบริการ
                $table->string('total_amout')->nullable();//    ยอดค่าใช้จ่ายทั้งหมด
                $table->string('invoice_number')->nullable();//  เลขใบ invoice number
                $table->string('vn')->nullable();//           เลข visit number

                $table->string('pttype')->nullable();// 
                $table->string('ptname')->nullable();// 
                $table->string('hn')->nullable();// 
                $table->date('vstdate')->nullable();//  
                $table->time('vsttime')->nullable();// 
                
                $table->date('datesave')->nullable();//  วั่นที่ส่ง 
                $table->string('user_id')->nullable();//  ผู้ส่ง
                $table->enum('active', ['N','Y'])->default('N')->nullable();
                $table->enum('active_nhso', ['N','Y'])->default('N')->nullable();
                $table->longText('transaction_uid')->nullable();// 
                $table->string('id_booking')->nullable();// 
                $table->string('uuid_booking')->nullable();// 
                $table->string('claimcode')->nullable();//   
                $table->string('claimtype')->nullable();//   claimServiceCode
                $table->string('servicename')->nullable();// 

                $table->string('rcpt_money')->nullable();//   paidAmount
                $table->string('uc_money')->nullable();//     privilegeAmount
                $table->string('mainInsclCode')->nullable();// mainInscl
                // $table->string('claimServiceCode')->nullable();// PG0060001
                $table->string('sourceId')->nullable();//  PKOFFICE
                $table->string('computerName')->nullable();//
                $table->string('recorderPid')->nullable();//   cid authคนที่ ใช้เครื่อง

                $table->string('serviceDateTime')->nullable();//
                $table->string('invoiceDateTime')->nullable();//
                $table->string('transactionId')->nullable();//
                $table->string('totalAmount')->nullable();//

                $table->string('visitNumber')->nullable();//
                $table->string('paidAmount')->nullable();//
                $table->string('privilegeAmount')->nullable();//
                $table->string('claimServiceCode')->nullable();//
                $table->string('code')->nullable();//
                $table->string('name')->nullable();//
                $table->string('seq')->nullable();//
                $table->string('authenCode')->nullable();//
                $table->string('dataError')->nullable();//

                $table->timestamps();
            }); 
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fdh_mini_dataset');
    }
};
