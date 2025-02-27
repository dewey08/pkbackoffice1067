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
        if (!Schema::hasTable('wh_report_month'))
        {
            Schema::create('wh_report_month', function (Blueprint $table) {
                $table->bigIncrements('wh_report_month_id');
                $table->date('dateyok')->nullable(); //
                $table->date('datesend')->nullable(); //
                $table->date('daterep')->nullable(); //
                $table->string('pro_id')->nullable(); //
                $table->string('pro_type')->nullable();           //ประเภท
                $table->string('unit_id')->nullable();            //  หน่วย
                $table->string('yokma_qty')->nullable();          // จำนวน
                $table->string('yokma_price')->nullable();        // ราคา / หน่วย
                $table->string('yokma_price_total')->nullable();  // จำนวนเงินรวม
                $table->string('rep_qty')->nullable();            // จำนวน
                $table->string('rep_price')->nullable();          // ราคา / หน่วย
                $table->string('rep_price_total')->nullable();    // จำนวนเงินรวม
                $table->string('pay_qty')->nullable();            // จำนวน
                $table->string('pay_price')->nullable();          // ราคา / หน่วย
                $table->string('pay_price_total')->nullable();    // จำนวนเงินรวม
                $table->string('total_qty')->nullable();          // จำนวน
                $table->string('total_price')->nullable();        // ราคา / หน่วย
                $table->string('total_price_total')->nullable();  // จำนวนเงินรวม
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
        Schema::dropIfExists('wh_report_month');
    }
};
