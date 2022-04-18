<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBondPricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bond_prices', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('bond_id');
            $table->date('date');
            $table->decimal('price', 8, 2);
            $table->timestamps();
            $table->foreign('bond_id')->references('id')->on('bonds');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bond_prices');
    }
}
