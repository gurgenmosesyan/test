<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Models\Payment\Payment;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->increments('id');
            $table->enum('type', [Payment::TYPE_TOP_CAR, Payment::TYPE_URGENT_CAR]);
            $table->integer('user_id')->unsigned();
            $table->integer('auto_id')->unsigned();
            $table->string('auto_auto_id');
            $table->tinyInteger('day')->unsigned();
            $table->string('order_id');
            $table->integer('amount')->unsigned();
            $table->text('data');
            $table->enum('status', [Payment::STATUS_NOT_PAYED, Payment::STATUS_PAYED]);
            $table->timestamps();
            $table->index('order_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('payments');
    }
}
