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
        if (!Schema::hasTable('wh_kind'))
        {
            Schema::create('wh_kind', function (Blueprint $table) {
                $table->bigIncrements('wh_kind_id');
                $table->string('wh_kind_name')->nullable(); //
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wh_kind');
    }
};
