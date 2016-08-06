<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeAutosFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $prefix = config('database.connections.mysql.prefix');
        DB::statement("ALTER TABLE `{$prefix}autos` CHANGE `cylinder_id` `cylinders` INT(10) UNSIGNED NOT NULL;");
        DB::statement("ALTER TABLE `{$prefix}autos` CHANGE `door_id` `doors` INT(10) UNSIGNED NOT NULL;");
        DB::statement("ALTER TABLE `{$prefix}autos` CHANGE `wheel_id` `wheels` INT(10) UNSIGNED NOT NULL;");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $prefix = config('database.connections.mysql.prefix');
        DB::statement("ALTER TABLE `{$prefix}autos` CHANGE `cylinders` `cylinder_id` INT(10) UNSIGNED NOT NULL;");
        DB::statement("ALTER TABLE `{$prefix}autos` CHANGE `doors` `door_id` INT(10) UNSIGNED NOT NULL;");
        DB::statement("ALTER TABLE `{$prefix}autos` CHANGE `wheels` `wheel_id` INT(10) UNSIGNED NOT NULL;");
    }
}
