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
        if (!Schema::hasTable('gas_stock'))
        {
        Schema::create('gas_stock', function (Blueprint $table) {
            $table->bigIncrements('gas_stock_id');
            $table->string('stock_year')->nullable();//
            $table->string('stock_list_id')->nullable();//
            $table->string('stock_list_name')->nullable();//
            $table->string('stock_type')->nullable();//
            $table->string('gas_list_id')->nullable();//
            $table->string('gas_list_num')->nullable();//
            $table->string('gas_list_name')->nullable();//
            $table->string('size')->nullable();// 
            $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gas_stock');
    }
};
