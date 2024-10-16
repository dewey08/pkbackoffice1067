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
        Schema::create('authen_date', function (Blueprint $table) {
            $table->bigIncrements('authen_id'); 
            $table->date('authen_date')->nullable();    //  วันที่ 
            $table->time('authen_time')->nullable();    //  เวลา
            $table->date('startdate')->nullable();      //   
            $table->date('enddate')->nullable();        // 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('authen_date');
    }
};
