<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCryptoCurrencyPricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('crypto_currency_prices', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('crypto_currency_id');
            $table->date('date');
            $table->decimal('price', 8, 4);
            $table->timestamps();
            $table->foreign('crypto_currency_id')->references('id')->on('crypto_currencies');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('crypto_currency_prices');
    }
}
