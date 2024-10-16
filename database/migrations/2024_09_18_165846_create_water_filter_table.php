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
        if (!Schema::hasTable('water_filter'))
        {
            Schema::create('water_filter', function (Blueprint $table) {
                $table->bigIncrements('water_filter_id'); 
                $table->string('water_year')->nullable(); // 
                $table->date('water_recieve_date')->nullable(); // 
                $table->string('water_code')->nullable(); //  
                $table->string('water_num')->nullable(); // เลขครุภัณฑ์
                $table->string('water_name')->nullable(); // 
           
                $table->decimal('water_price',total: 12, places: 2)->nullable(); //   
                $table->string('detail')->nullable(); // 
                $table->string('unit_id')->nullable(); // 
                $table->string('brand_id')->nullable(); // 
                $table->string('size')->nullable(); // 
                $table->string('water_system')->nullable(); //  
                $table->string('water_type_new')->nullable(); //  
                $table->string('water_type_old1')->nullable(); //  
                $table->string('water_type_old2')->nullable(); //  
                $table->string('water_type_old3')->nullable(); //  
                $table->string('water_type_old4')->nullable(); //  
                // $table->string('water_filter_name')->nullable(); //  
                $table->string('location_id')->nullable(); //  
                $table->string('location_name')->nullable(); //  
                $table->string('class')->nullable(); // 
                $table->binary('water_img')->nullable(); //                 
                $table->string('water_imgname', length: 200)->nullable(); //
                $table->longText('water_img_base')->nullable(); // 
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
        Schema::dropIfExists('water_filter');
    }
};
