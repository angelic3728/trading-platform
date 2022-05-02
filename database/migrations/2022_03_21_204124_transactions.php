<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Transactions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('stock_id')->nullable();
            $table->unsignedInteger('fund_id')->nullable();
            $table->unsignedInteger('bond_id')->nullable();
            $table->unsignedInteger('crypto_id')->nullable();
            $table->enum('type', ['buy', 'sell']);
            $table->decimal('price', 8, 2);
            $table->decimal('shares', 8, 3);
            $table->tinyInteger('wherefrom')->default(0);
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('stock_id')->references('id')->on('stocks');
            $table->foreign('fund_id')->references('id')->on('funds');
            $table->foreign('bond_id')->references('id')->on('bonds');
            $table->foreign('crypto_id')->references('id')->on('crypto_currencies');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
}
