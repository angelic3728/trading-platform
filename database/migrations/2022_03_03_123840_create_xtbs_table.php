<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateXtbsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('xtbs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('asx_code');
            $table->string('bond_issuer');
            $table->date('maturity_date');
            $table->string('coupon_type')->nullable();
            $table->string('next_ex_date')->date('next_ex_date');
            $table->string('coupon_pa')->nullable();
            $table->decimal('xtb_price', 8, 2);
            $table->string('ytm')->nullable();
            $table->decimal('current_yield', 8, 3);
            $table->decimal('trading_margin', 8, 3)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('xtbs');
    }
}
