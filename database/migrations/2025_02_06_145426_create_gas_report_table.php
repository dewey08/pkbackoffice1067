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
        if (!Schema::hasTable('gas_report'))
        {
        Schema::create('gas_report', function (Blueprint $table) {
            $table->bigIncrements('gas_report_id');
            $table->string('bg_yearnow')->nullable();//
            $table->string('months')->nullable();//
            $table->string('years')->nullable();//
            $table->string('years_th')->nullable();//
            $table->string('total_qty')->nullable();//
            $table->string('total_price')->nullable();//
            $table->Date('datesave')->nullable();//
            $table->string('userid')->nullable();//
            $table->enum('active', ['Y', 'N'])->default('N'); //
            $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gas_report');
    }
};
