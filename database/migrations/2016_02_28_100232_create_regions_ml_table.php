<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Core\Model;

class CreateRegionsMlTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('regions_ml', function (Blueprint $table) {
            $table->integer('id')->unsignd();
            $table->tinyInteger('lng_id')->unsignd();
            $table->string('name');
            $table->enum('show_status', [Model::STATUS_ACTIVE, Model::STATUS_DELETED]);
            $table->primary(['id', 'lng_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('regions_ml');
    }
}
