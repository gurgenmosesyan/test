<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeCylindersDoorsWheelsTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $prefix = config('database.connections.mysql.prefix');
        DB::statement("ALTER TABLE `{$prefix}cylinders` CHANGE `name` `count` INT(10) UNSIGNED NOT NULL;");
        DB::statement("ALTER TABLE `{$prefix}doors` CHANGE `name` `count` INT(10) UNSIGNED NOT NULL;");
        DB::statement("ALTER TABLE `{$prefix}wheels` CHANGE `name` `count` INT(10) UNSIGNED NOT NULL;");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $prefix = config('database.connections.mysql.prefix');
        DB::statement("ALTER TABLE `{$prefix}cylinders` CHANGE `count` `name` VARCHAR(255) NOT NULL;");
        DB::statement("ALTER TABLE `{$prefix}doors` CHANGE `count` `name` VARCHAR(255) NOT NULL;");
        DB::statement("ALTER TABLE `{$prefix}wheels` CHANGE `count` `name` VARCHAR(255) NOT NULL;");
    }
}
