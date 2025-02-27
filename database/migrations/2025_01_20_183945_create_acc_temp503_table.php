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

        if (!Schema::hasTable('acc_temp503'))
        {
        Schema::create('acc_temp503', function (Blueprint $table) {
            $table->bigIncrements('acc_temp503_id');
            $table->string('vn')->nullable();//
            $table->string('an')->nullable();//
            $table->string('hn')->nullable();//
            $table->string('pttype')->nullable();//
            $table->string('hospmain')->nullable();//
            $table->date('vstdate')->nullable();//
            $table->string('type')->nullable();//
            $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('acc_temp503');
    }
};
