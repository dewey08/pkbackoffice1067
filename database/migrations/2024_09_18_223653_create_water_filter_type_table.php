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
        if (!Schema::hasTable('water_filter_type'))
        {
            Schema::create('water_filter_type', function (Blueprint $table) {
                $table->bigIncrements('water_filter_type_id');  
                $table->string('water_filter_type_name')->nullable(); //  
                $table->enum('active', ['Y','N','C'])->default('N');
                
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('water_filter_type');
    }
};
