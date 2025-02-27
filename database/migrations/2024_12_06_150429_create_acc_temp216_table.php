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
        if (!Schema::hasTable('acc_temp216'))
        {
        Schema::create('acc_temp216', function (Blueprint $table) {
            $table->bigIncrements('acc_temp216_id');
            $table->date('vstdate')->nullable();// วันที่
            $table->string('vn',100)->nullable();//
            $table->string('hn',100)->nullable();//
            $table->string('pttype',100)->nullable();//
            $table->string('hospmain',100)->nullable();//
            $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('acc_temp216');
    }
};
