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
        if (!Schema::hasTable('acc_ofc_dateconfig'))
        {
            Schema::connection('mysql')->create('acc_ofc_dateconfig', function (Blueprint $table) {
                $table->bigIncrements('acc_ofc_dateconfig_id');
                $table->date('startdate')->nullable();//
                $table->date('enddate')->nullable();// 
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('acc_ofc_dateconfig');
    }
};
