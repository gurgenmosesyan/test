<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Core\Admin\Admin;

class ChangeAdmUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('adm_users', function (Blueprint $table) {
            $table->text('permissions')->after('password');
            $table->enum('super_admin', [Admin::NOT_SUPER_ADMIN, Admin::SUPER_ADMIN])->after('permissions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('adm_users', function (Blueprint $table) {
            $table->dropColumn('permissions');
            $table->dropColumn('super_admin');
        });
    }
}
