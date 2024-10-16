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
        if (!Schema::hasTable('wh_unit'))
        {
            Schema::create('wh_unit', function (Blueprint $table) {
                $table->bigIncrements('wh_unit_id'); 
                $table->string('wh_unit_name')->nullable(); //   
                $table->enum('active', ['Y','N'])->default('Y');  
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wh_unit');
    }
};
