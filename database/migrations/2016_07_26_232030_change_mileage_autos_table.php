<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeMileageAutosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('autos', function (Blueprint $table) {
            $table->dropColumn('mileage');
            $table->integer('mileage_km')->unsigned()->after('year');
            $table->integer('mileage_mile')->unsigned()->after('mileage_km');
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
            $table->dropColumn('mileage_km');
            $table->dropColumn('mileage_mile');
            $table->integer('mileage')->unsigned()->after('year');
        });
    }
}
