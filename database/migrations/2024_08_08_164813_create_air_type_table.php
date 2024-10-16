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
        if (!Schema::hasTable('air_type'))
        {
            Schema::create('air_type', function (Blueprint $table) {
                $table->bigIncrements('air_type_id'); 
                $table->string('air_type_name')->nullable();  //  
                $table->enum('status', ['N','Y'])->default('Y');                 
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('air_type');
    }
};
