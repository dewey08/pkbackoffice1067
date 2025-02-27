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
        if (!Schema::hasTable('a_ct_date'))
        {
            Schema::create('a_ct_date', function (Blueprint $table) {
                $table->bigIncrements('a_ct_date_id'); 
                $table->date('startdate')->nullable();  // 
                $table->string('enddate')->nullable();    //  
                $table->string('user_id')->nullable();          //                        
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('a_ct_date');
    }
};
