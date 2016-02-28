<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

$params = [
    'middleware' => ['web'],
    'prefix' => 'admpanel',
    'namespace' => 'Admin'
];

Route::group($params, function () {

    Route::get('/login', ['middleware' => 'guest:admin', 'uses' => 'AccountController@login', 'as' => 'admin_login']);
    Route::post('/login', ['uses' => 'AccountController@loginApi', 'as' => 'admin_login_api']);

    Route::group(['middleware' => ['auth:admin', 'language']], function () {

        Route::get('/', 'IndexController@index');
        Route::get('/logout', ['uses' => 'AccountController@logout', 'as' => 'admin_logout']);

        Route::get('/admin', ['uses' => 'AdminController@table', 'as' => 'admin_table']);
        Route::get('/admin/create', ['uses' => 'AdminController@create', 'as' => 'admin_create']);
        Route::get('/admin/edit/{id}', ['uses' => 'AdminController@edit', 'as' => 'admin_edit']);
        Route::post('/admin', ['uses' => 'AdminController@index', 'as' => 'admin_index']);
        Route::post('/admin/store', ['uses' => 'AdminController@store', 'as' => 'admin_store']);
        Route::post('/admin/update/{id}', ['uses' => 'AdminController@update', 'as' => 'admin_update']);
        Route::post('/admin/delete/{id}', ['uses' => 'AdminController@delete', 'as' => 'admin_delete']);

        Route::get('/language', ['uses' => 'LanguageController@table', 'as' => 'admin_language_table']);
        Route::get('/language/create', ['uses' => 'LanguageController@create', 'as' => 'admin_language_create']);
        Route::get('/language/edit/{id}', ['uses' => 'LanguageController@edit', 'as' => 'admin_language_edit']);
        Route::post('/language', ['uses' => 'LanguageController@index', 'as' => 'admin_language_index']);
        Route::post('/language/store', ['uses' => 'LanguageController@store', 'as' => 'admin_language_store']);
        Route::post('/language/update/{id}', ['uses' => 'LanguageController@update', 'as' => 'admin_language_update']);
        Route::post('/language/delete/{id}', ['uses' => 'LanguageController@delete', 'as' => 'admin_language_delete']);

        Route::get('/dictionary', ['uses' => 'DictionaryController@table', 'as' => 'admin_dictionary_table']);
        Route::post('/dictionary', ['uses' => 'DictionaryController@index', 'as' => 'admin_dictionary_index']);
        Route::post('/dictionary/store', ['uses' => 'DictionaryController@store', 'as' => 'admin_dictionary_store']);
        Route::post('/dictionary/update', ['uses' => 'DictionaryController@update', 'as' => 'admin_dictionary_update']);
        Route::post('/dictionary/delete', ['uses' => 'DictionaryController@delete', 'as' => 'admin_dictionary_delete']);

        /**********************************************************/

        Route::get('/mark', ['uses' => 'MarkController@table', 'as' => 'admin_mark_table']);
        Route::get('/mark/create', ['uses' => 'MarkController@create', 'as' => 'admin_mark_create']);
        Route::get('/mark/edit/{id}', ['uses' => 'MarkController@edit', 'as' => 'admin_mark_edit']);
        Route::post('/mark', ['uses' => 'MarkController@index', 'as' => 'admin_mark_index']);
        Route::post('/mark/store', ['uses' => 'MarkController@store', 'as' => 'admin_mark_store']);
        Route::post('/mark/update/{id}', ['uses' => 'MarkController@update', 'as' => 'admin_mark_update']);
        Route::post('/mark/delete/{id}', ['uses' => 'MarkController@delete', 'as' => 'admin_mark_delete']);

        Route::get('/modelCategory', ['uses' => 'ModelCategoryController@table', 'as' => 'admin_model_category_table']);
        Route::get('/modelCategory/create', ['uses' => 'ModelCategoryController@create', 'as' => 'admin_model_category_create']);
        Route::get('/modelCategory/edit/{id}', ['uses' => 'ModelCategoryController@edit', 'as' => 'admin_model_category_edit']);
        Route::post('/modelCategory', ['uses' => 'ModelCategoryController@index', 'as' => 'admin_model_category_index']);
        Route::post('/modelCategory/store', ['uses' => 'ModelCategoryController@store', 'as' => 'admin_model_category_store']);
        Route::post('/modelCategory/update/{id}', ['uses' => 'ModelCategoryController@update', 'as' => 'admin_model_category_update']);
        Route::post('/modelCategory/delete/{id}', ['uses' => 'ModelCategoryController@delete', 'as' => 'admin_model_category_delete']);
        Route::post('/api/modelCategory/get', ['uses' => 'ModelCategoryController@get']);

        Route::get('/model', ['uses' => 'ModelController@table', 'as' => 'admin_model_table']);
        Route::get('/model/create', ['uses' => 'ModelController@create', 'as' => 'admin_model_create']);
        Route::get('/model/edit/{id}', ['uses' => 'ModelController@edit', 'as' => 'admin_model_edit']);
        Route::post('/model', ['uses' => 'ModelController@index', 'as' => 'admin_model_index']);
        Route::post('/model/store', ['uses' => 'ModelController@store', 'as' => 'admin_model_store']);
        Route::post('/model/update/{id}', ['uses' => 'ModelController@update', 'as' => 'admin_model_update']);
        Route::post('/model/delete/{id}', ['uses' => 'ModelController@delete', 'as' => 'admin_model_delete']);

        Route::get('/body', ['uses' => 'BodyController@table', 'as' => 'admin_body_table']);
        Route::get('/body/create', ['uses' => 'BodyController@create', 'as' => 'admin_body_create']);
        Route::get('/body/edit/{id}', ['uses' => 'BodyController@edit', 'as' => 'admin_body_edit']);
        Route::post('/body', ['uses' => 'BodyController@index', 'as' => 'admin_body_index']);
        Route::post('/body/store', ['uses' => 'BodyController@store', 'as' => 'admin_body_store']);
        Route::post('/body/update/{id}', ['uses' => 'BodyController@update', 'as' => 'admin_body_update']);
        Route::post('/body/delete/{id}', ['uses' => 'BodyController@delete', 'as' => 'admin_body_delete']);

    });

});
