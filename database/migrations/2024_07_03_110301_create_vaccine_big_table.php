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
        if (!Schema::hasTable('vaccine_big'))
        {
            Schema::create('vaccine_big', function (Blueprint $table) {
                $table->bigIncrements('vaccine_big_id'); 
                $table->string('vn', length: 200)->nullable();  //           
                $table->string('cid', length: 200)->nullable(); //  
                $table->string('hn', length: 200)->nullable(); // 
                $table->date('vstdate')->nullable();  //  
                $table->string('ptname', length: 200)->nullable(); //  
                $table->string('icode', length: 200)->nullable(); //   
                $table->decimal('income',total: 3, places: 0)->nullable(); // 
                $table->decimal('sumprice',total: 3, places: 0)->nullable(); // 
                $table->string('staff', length: 200)->nullable(); //  
                $table->string('authen', length: 200)->nullable(); //  
                $table->longText('STMDoc')->nullable(); //  
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vaccine_big');
    }
};
