<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Core\Model;

class CreateUrgentCarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('urgent_cars', function (Blueprint $table) {
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
        Schema::drop('urgent_cars');
    }
}
