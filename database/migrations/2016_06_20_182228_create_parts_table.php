<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('mark_id')->unsigned();
            $table->integer('model_id')->unsigned();
            $table->smallInteger('currency_id')->unsigned();
            $table->integer('part1_price')->unsigned();
            $table->integer('part1_service_price')->unsigned();
            $table->integer('part2_price')->unsigned();
            $table->integer('part2_service_price')->unsigned();
            $table->integer('part3_price')->unsigned();
            $table->integer('part3_service_price')->unsigned();
            $table->integer('part4_price')->unsigned();
            $table->integer('part4_service_price')->unsigned();
            $table->integer('part5_price')->unsigned();
            $table->integer('part5_service_price')->unsigned();
            $table->integer('part6_price')->unsigned();
            $table->integer('part6_service_price')->unsigned();
            $table->integer('part7_price')->unsigned();
            $table->integer('part7_service_price')->unsigned();
            $table->integer('part8_price')->unsigned();
            $table->integer('part8_service_price')->unsigned();
            $table->integer('part9_price')->unsigned();
            $table->integer('part9_service_price')->unsigned();
            $table->integer('part10_price')->unsigned();
            $table->integer('part10_service_price')->unsigned();
            $table->timestamps();
            $table->index(['mark_id', 'model_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('parts');
    }
}
