<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Core\Model;

class CreateTopCarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('top_cars', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('auto_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->date('deadline');
            $table->timestamps();
            $table->enum('show_status', [Model::STATUS_ACTIVE, Model::STATUS_DELETED]);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('top_cars');
    }
}
