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
        if (!Schema::hasTable('operate_time_dept'))
        {
        Schema::create('operate_time_dept', function (Blueprint $table) {
            $table->bigIncrements('operate_time_dept_id');
            $table->date('start_date')->nullable();// วันที่
            $table->date('end_date')->nullable();// วันที่
            $table->string('depid',10)->nullable();// กลุ่มภารกิจ
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
        Schema::dropIfExists('operate_time_dept');
    }
};
