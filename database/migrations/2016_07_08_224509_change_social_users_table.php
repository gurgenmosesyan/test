<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Models\User\User;

class ChangeSocialUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('social');
        });
        Schema::table('users', function (Blueprint $table) {
            $table->enum('social', ['', User::SOCIAL_FB, User::SOCIAL_GP])->after('phone');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('social');
        });
        Schema::table('users', function (Blueprint $table) {
            $table->enum('social', [User::SOCIAL_FB, User::SOCIAL_GP])->after('phone');
        });
    }
}
