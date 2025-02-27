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
        if (!Schema::hasTable('operate_time_dsst'))
        {
        Schema::create('operate_time_dsst', function (Blueprint $table) {
            $table->bigIncrements('operate_time_dsst_id');
            $table->date('start_date')->nullable();// วันที่
            $table->date('end_date')->nullable();// วันที่
            $table->string('depsubsubid',10)->nullable();// หน่วยงาน
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
        Schema::dropIfExists('operate_time_dsst');
    }
};
