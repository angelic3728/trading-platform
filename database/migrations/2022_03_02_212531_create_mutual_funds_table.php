<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMutualFundsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mutual_funds', function (Blueprint $table) {
            $table->increments('id');
            $table->string('symbol');
            $table->string('company_name');
            $table->string('link')->nullable();
            $table->string('data_source');
            $table->string('exchange')->nullable();
            $table->integer('discount_percentage')->default(0);
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
        Schema::dropIfExists('mutual_funds');
    }
}
