<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsCurrenciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('currencies', function (Blueprint $table) {
            $table->integer('price_max')->unsigned()->after('sign');
            $table->integer('price_from')->unsigned()->after('price_max');
            $table->integer('price_to')->unsigned()->after('price_from');
            $table->integer('price_step')->unsigned()->after('price_to');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('currencies', function (Blueprint $table) {
            $table->dropColumn('price_max');
            $table->dropColumn('price_from');
            $table->dropColumn('price_to');
            $table->dropColumn('price_step');
        });
    }
}
