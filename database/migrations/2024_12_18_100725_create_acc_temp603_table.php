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
        if (!Schema::hasTable('acc_temp603'))
        {
            Schema::create('acc_temp603', function (Blueprint $table) {
                $table->bigIncrements('acc_temp603_id');
                $table->string('an')->nullable();
                $table->string('vn')->nullable();
                $table->string('hn')->nullable();
                $table->date('vstdate')->nullable();
                $table->date('dchdate')->nullable();
                $table->string('nhso_docno')->nullable();
                $table->string('nhso_ownright_pid')->nullable();
                $table->string('nhso_ownright_name')->nullable();
                $table->string('nhso_govname')->nullable();

                $table->string('user_id')->nullable();            //
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('acc_temp603');
    }
};
