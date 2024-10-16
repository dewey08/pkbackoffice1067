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
        if (!Schema::hasTable('acc_function'))
        {
            Schema::create('acc_function', function (Blueprint $table) {
                $table->bigIncrements('acc_function_id'); 
                $table->string('pang')->nullable(); // 
                $table->enum('claim_active', ['Y','N'])->default('N'); 
                $table->enum('active', ['Y','N'])->default('N'); 
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('acc_function');
    }
};
