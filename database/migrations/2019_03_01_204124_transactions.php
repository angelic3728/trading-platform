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
            $table->unsignedInteger('mutual_fund_id')->nullable();
            $table->enum('type', ['buy', 'sell']);
            $table->decimal('price', 8, 2);
            $table->integer('shares');
            $table->boolean('is_fund')->default(false);
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('stock_id')->references('id')->on('stocks');
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
        Schema::dropIfExists('transactions');
    }
}
