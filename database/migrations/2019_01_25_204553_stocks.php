<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Stocks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stocks', function (Blueprint $table) {
            $table->increments('id');
            $table->string('symbol');
            $table->string('company_name');
            $table->string('company_exchange')->nullable();
            $table->string('company_website')->nullable();
            $table->string('company_industry')->nullable();
            $table->string('company_sector')->nullable();
            $table->text('company_description')->nullable();
            $table->string('link')->nullable();
            $table->string('data_source');
            $table->string('isin')->nullable();
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
        Schema::dropIfExists('stocks');
    }
}
