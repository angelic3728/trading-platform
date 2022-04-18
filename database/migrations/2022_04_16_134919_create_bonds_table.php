<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBondsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bonds', function (Blueprint $table) {
            $table->increments('id');
            $table->string('symbol');
            $table->string('name');
            $table->string('link')->nullable();
            $table->string('data_source');
            $table->string('exchange')->nullable();
            $table->decimal('discount_percentage', 8, 2)->default(3);
            $table->string('gcurrency')->default('USD');
            $table->unsignedInteger('is_indexed')->default(0);
            $table->boolean('highlighted')->default(false);
            $table->boolean('widget')->default(false);
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
        Schema::dropIfExists('bonds');
    }
}
