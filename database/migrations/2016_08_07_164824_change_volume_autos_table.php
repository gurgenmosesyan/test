<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeVolumeAutosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('autos', function (Blueprint $table) {
            $table->dropColumn('volume_1');
            $table->dropColumn('volume_2');
            $table->float('volume')->unsigned()->after('mileage_measurement');
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
            $table->dropColumn('volume');
            $table->tinyInteger('volume_1')->unsigned()->after('mileage_measurement');
            $table->tinyInteger('volume_2')->unsigned()->after('volume_1');
        });
    }
}
