<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ImproveStocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::table('stocks', function (Blueprint $table) {

            /**
             * Drop unnececary columns
             */
            $table->dropColumn(['company_exchange', 'company_website', 'company_industry', 'company_sector', 'company_description', 'isin']);

            /**
             * Add exchange
             */
            $table->string('exchange')->after('data_source')->nullable();

        });

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
