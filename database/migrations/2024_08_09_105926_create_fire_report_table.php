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
        if (!Schema::hasTable('fire_report'))
        {
            Schema::create('fire_report', function (Blueprint $table) {
                $table->bigIncrements('fire_report_id');
                $table->string('fire_id')->nullable();  //  
                $table->string('fire_num')->nullable();  //  รหัส : OUT CO1
                $table->string('months')->nullable();  // 
                $table->string('years')->nullable();  //          
                $table->date('check_date')->nullable();  //  
                $table->enum('check_status', ['N','Y'])->default('N');  
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fire_report');
    }
};
