<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Models\Ad\Ad;

class CreateAdsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ads', function (Blueprint $table) {
            $table->increments('id');
            $table->enum('key', [
                Ad::KEY_TOP,
                Ad::KEY_THIN,
                Ad::KEY_RIGHT,
                Ad::KEY_BOTTOM,
            ]);
            $table->integer('user_id')->unsigned();
            $table->string('image');
            $table->string('link');
            $table->date('deadline');
            $table->timestamps();
            $table->enum('show_status', [Ad::STATUS_ACTIVE, Ad::STATUS_DELETED]);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('ads');
    }
}
