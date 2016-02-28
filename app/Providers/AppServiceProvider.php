<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Helpers\Head;
use App\Helpers\JsTrans;
use Validator;
use App\Models\Language\Language;

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

        Validator::extend('ml', function($attribute, $value, $parameters, $validator) {
            if (!is_array($value)) {
                return false;
            }
            $languages = Language::all()->keyBy('id');
            foreach ($value as $lngId => $val) {
                if (!isset($languages[$lngId])) {
                    return false;
                }
            }
            return true;
        });
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
