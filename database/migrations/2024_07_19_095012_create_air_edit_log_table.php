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
        if (!Schema::hasTable('air_edit_log'))
        {
            Schema::create('air_edit_log', function (Blueprint $table) {
                $table->bigIncrements('air_edit_log_id');  
                $table->string('user_id')->nullable();//  
                $table->string('user_name')->nullable();// 
                $table->date('date_edit')->nullable();//
                $table->Time('time_edit')->nullable();//  
                $table->enum('status', ['SAVE', 'EDIT','DEL'])->default('SAVE');
                $table->string('detail')->nullable();// 
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('air_edit_log');
    }
};
