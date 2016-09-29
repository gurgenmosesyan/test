<?php

$params = [
    'middleware' => ['web'],
    'prefix' => 'management/cms/core',
    'namespace' => 'Core'
];

Route::group($params, function() {

	Route::get('/login', ['middleware' => 'guest:admin', 'uses' => 'AccountController@login', 'as' => 'core_admin_login']);
	Route::post('/login', ['uses' => 'AccountController@loginApi', 'as' => 'core_admin_login_api']);

	Route::group(['middleware' => ['auth:admin', 'language']], function() {

		Route::get('/logout', ['uses' => 'AccountController@logout', 'as' => 'core_admin_logout']);

        Route::get('/image/show', ['uses' => 'ImageUploaderController@show', 'as' => 'core_image_show']);
        Route::post('/image/upload', ['uses' => 'ImageUploaderController@upload', 'as' => 'core_image_upload']);

        Route::post('/makeAlias', ['uses' => 'ApiController@makeAlias', 'as' => 'core_make_alias']);

        Route::group(['middleware' => ['access_control']], function() {

            Route::get('/admin', ['uses' => 'AdminController@table', 'as' => 'core_admin_table', 'permission' => 'admin']);
            Route::get('/admin/create', ['uses' => 'AdminController@create', 'as' => 'core_admin_create', 'permission' => 'admin']);
            Route::get('/admin/edit/{id}', ['uses' => 'AdminController@edit', 'as' => 'core_admin_edit', 'permission' => 'admin']);
            Route::post('/admin', ['uses' => 'AdminController@index', 'as' => 'core_admin_index', 'permission' => 'admin']);
            Route::post('/admin/store', ['uses' => 'AdminController@store', 'as' => 'core_admin_store', 'permission' => 'admin']);
            Route::post('/admin/update/{id}', ['uses' => 'AdminController@update', 'as' => 'core_admin_update', 'permission' => 'admin']);
            Route::post('/admin/delete/{id}', ['uses' => 'AdminController@delete', 'as' => 'core_admin_delete', 'permission' => 'admin']);
            Route::get('/admin/profile', ['uses' => 'AdminController@profile', 'as' => 'core_admin_profile']);
            Route::post('/admin/profile', ['uses' => 'AdminController@profileUpdate', 'as' => 'core_admin_profile_update']);

            Route::get('/language', ['uses' => 'LanguageController@table', 'as' => 'core_language_table', 'permission' => 'language']);
            Route::get('/language/create', ['uses' => 'LanguageController@create', 'as' => 'core_language_create', 'permission' => 'language']);
            Route::get('/language/edit/{id}', ['uses' => 'LanguageController@edit', 'as' => 'core_language_edit', 'permission' => 'language']);
            Route::post('/language', ['uses' => 'LanguageController@index', 'as' => 'core_language_index', 'permission' => 'language']);
            Route::post('/language/store', ['uses' => 'LanguageController@store', 'as' => 'core_language_store', 'permission' => 'language']);
            Route::post('/language/update/{id}', ['uses' => 'LanguageController@update', 'as' => 'core_language_update', 'permission' => 'language']);
            Route::post('/language/delete/{id}', ['uses' => 'LanguageController@delete', 'as' => 'core_language_delete', 'permission' => 'language']);

            Route::get('/dictionary', ['uses' => 'DictionaryController@table', 'as' => 'core_dictionary_table', 'permission' => 'dictionary']);
            Route::post('/dictionary', ['uses' => 'DictionaryController@index', 'as' => 'core_dictionary_index', 'permission' => 'dictionary']);
            Route::post('/dictionary/store', ['uses' => 'DictionaryController@store', 'as' => 'core_dictionary_store', 'permission' => 'dictionary']);
            Route::post('/dictionary/update', ['uses' => 'DictionaryController@update', 'as' => 'core_dictionary_update', 'permission' => 'dictionary']);
            Route::post('/dictionary/delete', ['uses' => 'DictionaryController@delete', 'as' => 'core_dictionary_delete', 'permission' => 'dictionary']);

        });

	});

});
