<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Models\Payment\Payment;

class ChangePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $prefix = config('database.connections.mysql.prefix');
        $modulesStr = "'".Payment::TYPE_TOP_CAR."','".Payment::TYPE_URGENT_CAR."','".Payment::TYPE_AD."'";
        DB::statement("ALTER TABLE `" . $prefix . "payments` CHANGE `type` `type` ENUM(" . $modulesStr . ")");

        Schema::table('payments', function (Blueprint $table) {
            $table->integer('object_id')->after('type');
            $table->enum('refund', [Payment::NOT_REFUND, Payment::REFUND])->after('status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $prefix = config('database.connections.mysql.prefix');
        $modulesStr = "'".Payment::TYPE_TOP_CAR."','".Payment::TYPE_URGENT_CAR."'";
        DB::statement("ALTER TABLE `" . $prefix . "payments` CHANGE `type` `type` ENUM(" . $modulesStr . ")");

        Schema::table('payments', function (Blueprint $table) {
            $table->dropColumn('object_id');
            $table->dropColumn('refund');
        });
    }
}
