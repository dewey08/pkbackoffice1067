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
        if (!Schema::hasTable('gas_type'))
        {
            Schema::create('gas_type', function (Blueprint $table) {
                $table->bigIncrements('gas_type_id'); 
                $table->string('gas_type_name')->nullable(); //  
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
        Schema::dropIfExists('gas_type');
    }
};
