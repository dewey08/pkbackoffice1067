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
        if (!Schema::hasTable('air_setting'))
        {
        Schema::create('air_setting', function (Blueprint $table) {
            $table->bigIncrements('air_setting_id');
            $table->string('air_setting_name')->nullable();//
            $table->string('user_id')->nullable();//
            $table->string('staff_id')->nullable();// 
            $table->enum('active', ['Y', 'N'])->default('N'); //
            $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('air_setting');
    }
};
