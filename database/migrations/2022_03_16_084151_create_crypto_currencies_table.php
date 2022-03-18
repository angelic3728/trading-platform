<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCryptoCurrenciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('crypto_currencies', function (Blueprint $table) {
            $table->increments('id');
            $table->string('symbol');
            $table->string('name');
            $table->string('coin_id')->nullable();
            $table->string('link')->nullable();
            $table->string('data_source');
            $table->decimal('discount_percentage', 8, 2)->default(3);
            $table->string('gcurrency')->default('USD');
            $table->boolean('highlighted')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('crypto_currencies');
    }
}
