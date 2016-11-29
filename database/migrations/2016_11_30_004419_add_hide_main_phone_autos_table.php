<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Models\Auto\Auto;

class AddHideMainPhoneAutosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('autos', function (Blueprint $table) {
            $table->enum('hide_main_phone', [Auto::NOT_HIDE_MAIN_PHONE, Auto::HIDE_MAIN_PHONE])->after('additional_phone');
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
            $table->dropColumn('hide_main_phone');
        });
    }
}
