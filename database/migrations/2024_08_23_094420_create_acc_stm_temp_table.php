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
        if (!Schema::hasTable('acc_stm_temp'))
        {
            Schema::connection('mysql')->create('acc_stm_temp', function (Blueprint $table) {
                $table->bigIncrements('acc_stm_temp_id');
                $table->string('vn')->nullable();//
                $table->string('an')->nullable();//
                $table->string('hn')->nullable();//
                $table->string('cid')->nullable();//
                $table->string('ptname')->nullable();//
                $table->string('income')->nullable();// 
                $table->enum('active_mini', ['N','Y','E'])->default('N');  
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('acc_stm_temp');
    }
};
