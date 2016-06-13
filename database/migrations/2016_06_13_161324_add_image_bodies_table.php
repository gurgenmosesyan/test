<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Models\Body\Body;

class AddImageBodiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bodies', function (Blueprint $table) {
            $table->enum('show_in_search', [Body::NOT_SHOW_IN_SEARCH, Body::SHOW_IN_SEARCH])->after('id');
            $table->string('image')->after('show_in_search');
            $table->integer('sort_order')->unsigned()->after('image');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bodies', function (Blueprint $table) {
            $table->dropColumn('show_in_search');
            $table->dropColumn('image');
            $table->dropColumn('sort_order');
        });
    }
}
