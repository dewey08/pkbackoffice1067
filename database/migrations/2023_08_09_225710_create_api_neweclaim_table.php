<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('api_neweclaim'))
        {
            Schema::connection('mysql')->create('api_neweclaim', function (Blueprint $table) {
                $table->bigIncrements('api_neweclaim_id');
                $table->string('user_id')->nullable();//
                $table->string('api_neweclaim_user')->nullable();//
                $table->string('api_neweclaim_pass')->nullable();//
                $table->text('api_neweclaim_token')->nullable();//
                $table->string('password_hash')->nullable();//
                $table->string('hospital_code')->nullable();//
               
                $table->enum('active_mini', ['N','Y','E'])->default('N'); 
                $table->text('basic_auth')->nullable();//
                $table->text('newe_eclaim_token')->nullable();//
                $table->string('new_eclaim_pass')->nullable();//
                $table->timestamps();
            });
        }
    }
    
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('api_neweclaim');
    }
};
