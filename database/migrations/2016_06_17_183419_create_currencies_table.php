<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Models\Currency\Currency;

class CreateCurrenciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('currencies', function (Blueprint $table) {
            $table->smallIncrements('id');
            $table->string('code', 50);
            $table->enum('default', [Currency::IS_NOT_DEFAULT, Currency::IS_DEFAULT]);
            $table->float('rate');
            $table->string('icon');
            $table->timestamps();
            $table->enum('show_status', [Currency::STATUS_ACTIVE, Currency::STATUS_DELETED]);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('currencies');
    }
}
