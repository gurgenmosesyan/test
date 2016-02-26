<?php

use Illuminate\Database\Seeder;

class LanguageTableSeed extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		$data = [
			[
				'name' => 'English',
				'code' => 'en'
			],
			[
				'name' => 'Հայերեն',
				'code' => 'hy'
			],
			[
				'name' => 'Русский',
				'code' => 'ru'
			]
		];

		DB::table('languages')->truncate();
		DB::table('languages')->insert($data);
	}
}
