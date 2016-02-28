<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Models\Mark\Mark;

class CreateBodiesMlTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bodies_ml', function (Blueprint $table) {
            $table->integer('id')->unsignd();
            $table->tinyInteger('lng_id')->unsignd();
            $table->string('name');
            $table->enum('show_status', [Mark::STATUS_ACTIVE, Mark::STATUS_DELETED]);
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
        Schema::drop('bodies_ml');
    }
}
