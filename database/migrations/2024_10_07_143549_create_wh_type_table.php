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
        if (!Schema::hasTable('wh_type'))
        {
            Schema::create('wh_type', function (Blueprint $table) {
                $table->bigIncrements('wh_type_id'); 
                $table->string('wh_type_name')->nullable(); //   
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
        Schema::dropIfExists('wh_type');
    }
};
