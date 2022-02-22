<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RedoForeigns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('documents', function (Blueprint $table) {
            $table->dropForeign('documents_user_id_foreign');
            $table->dropForeign('documents_provided_by_foreign');

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('provided_by')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::table('transactions', function (Blueprint $table) {
            $table->dropForeign('transactions_user_id_foreign');
            $table->dropForeign('transactions_stock_id_foreign');

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('stock_id')->references('id')->on('stocks')->onDelete('cascade');
        });

        Schema::table('activation_tokens', function (Blueprint $table) {
            $table->dropForeign('activation_tokens_user_id_foreign');

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
