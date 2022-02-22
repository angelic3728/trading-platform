<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyStocksData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /**
         * Set the value for the exchange
         */
        DB::statement('UPDATE `stocks` SET `exchange` = "NYSE" WHERE `data_source` = "iex";');
        DB::statement('UPDATE `stocks` SET `exchange` = "LSE" WHERE `data_source` = "lse";');

        /**
         * Change all data sources to iex
         */
        DB::statement('UPDATE `stocks` SET `data_source` = "iex";');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
