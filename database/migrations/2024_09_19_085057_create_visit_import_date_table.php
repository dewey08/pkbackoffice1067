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
        if (!Schema::hasTable('visit_import_date'))
        {
            Schema::create('visit_import_date', function (Blueprint $table) {
                $table->bigIncrements('visit_import_date_id'); 
                $table->date('startdate')->nullable(); // 
                $table->date('enddate')->nullable(); //  
                
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
        Schema::dropIfExists('visit_import_date');
    }
};
