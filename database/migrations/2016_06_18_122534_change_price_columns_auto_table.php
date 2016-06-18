<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangePriceColumnsAutoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('autos', function (Blueprint $table) {
            $table->dropColumn('price_amd');
            $table->dropColumn('price_usd');
            $table->dropColumn('price_eur');
            $table->smallInteger('currency_id')->unsigned()->after('place');
            $table->integer('price')->unsigned()->after('currency_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('autos', function (Blueprint $table) {
            $table->dropColumn('currency_id');
            $table->dropColumn('price');
            $table->integer('price_amd')->unsigned()->after('place');
            $table->integer('price_usd')->unsigned()->after('price_amd');
            $table->integer('price_eur')->unsigned()->after('price_usd');
        });
    }
}
