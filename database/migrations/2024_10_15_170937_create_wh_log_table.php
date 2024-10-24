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
        Schema::create('wh_log', function (Blueprint $table) {
            $table->id();
            $table->date('datesave')->nullable();         //  วันที่รับ 
            $table->time('timesave')->nullable();         //  เวลา
            $table->string('userid')->nullable();         //
            $table->string('comment')->nullable();         //
            $table->string('ip')->nullable(); 
            $table->string('wh_request_id')->nullable(); 
            $table->string('wh_recieve_id')->nullable(); 
            $table->string('wh_stock_export_id')->nullable(); 
            $table->string('wh_stock_dep_id')->nullable();  
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wh_log');
    }
};
