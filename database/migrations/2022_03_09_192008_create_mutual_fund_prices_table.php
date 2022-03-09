<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMutualFundPricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mutual_fund_prices', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('mutual_fund_id');
            $table->date('date');
            $table->decimal('price', 8, 2);
            $table->timestamps();

            $table->foreign('mutual_fund_id')->references('id')->on('mutual_funds');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mutual_fund_prices');
    }
}
