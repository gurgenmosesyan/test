<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Helpers\Head;
use App\Helpers\JsTrans;

class AppServiceProvider extends ServiceProvider
{
	/**
	 * Bootstrap any application services.
	 *
	 * @return void
	 */
	public function boot()
	{
		view()->share('head', Head::getInstance());
		view()->share('jsTrans', new JsTrans());
	}

	/**
	 * Register any application services.
	 *
	 * @return void
	 */
	public function register()
	{
		//
	}
}
