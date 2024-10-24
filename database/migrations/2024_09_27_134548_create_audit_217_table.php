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
        if (!Schema::hasTable('audit_217'))
        {
            Schema::create('audit_217', function (Blueprint $table) {
                $table->bigIncrements('audit_217_id');  
                $table->string('vn', length: 100)->nullable(); 
                $table->string('icd10', length: 100)->nullable(); 
                $table->string('hn', length: 100)->nullable();  
                $table->string('ptname', length: 255)->nullable(); // 
                $table->date('vstdate')->nullable(); // 
                $table->time('vsttime')->nullable(); //   
                $table->string('diagtype', length: 255)->nullable(); // 
                $table->string('hcode', length: 255)->nullable(); // 
                $table->string('doctor', length: 200)->nullable(); //
                $table->string('episode', length: 200)->nullable(); //
                $table->string('staff', length: 200)->nullable(); //
                $table->enum('active', ['Y','N'])->default('N');
                $table->string('spclty', length: 200)->nullable(); //
                $table->string('pttype', length: 200)->nullable(); //
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('audit_217');
    }
};
