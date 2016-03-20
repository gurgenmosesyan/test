<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Models\User\User;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('email');
            $table->string('password');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('phone', 30);
            $table->string('hash');
            $table->rememberToken();
            $table->timestamps();
            $table->enum('status', [User::STATUS_REGISTERED, User::STATUS_CONFIRMED, user::STATUS_BLOCKED]);
            $table->enum('show_status', [User::STATUS_ACTIVE, User::STATUS_DELETED]);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('users');
    }
}
