<?php

Route::group(['middleware' => ['web', 'guest:user']], function() {
    Route::get('/api/google/login', ['uses' => 'UserApiController@googleLogin', 'as' => 'google_login']);
});

Route::group(['middleware' => ['web']], function() {
    Route::post('/api/model', 'ApiController@model');
    Route::post('/api/part', 'ApiController@part');
});

Route::group(['middleware' => ['web', 'auth:user']], function() {
    Route::get('/api/image/show', 'ImageUploadController@show');
    Route::post('/api/image/upload', 'ImageUploadController@upload');
});

Route::group(['middleware' => ['web', 'front']], function() {

    Route::get('/', 'IndexController@index');

    Route::group(['prefix' => '{lngCode}'], function() {

        Route::get('/currency', 'CurrencyController@index');

        Route::get('/', ['uses' => 'IndexController@index', 'as' => 'homepage']);

        Route::group(['middleware' => 'guest:user'], function() {
            Route::get('/login', ['uses' => 'UserController@login', 'as' => 'user_login']);
            Route::get('/registration', 'UserController@registration');
            Route::get('/registration/success', ['uses' => 'UserController@registrationSuccess', 'as' => 'success_reg']);
            Route::get('/activation/{hash}', 'UserController@activation');
            Route::get('/forgot', 'UserController@forgot');
            Route::get('/forgot/success', ['uses' => 'UserController@forgotSuccess', 'as' => 'forgot_success']);
            Route::get('/reset/success', ['uses' => 'UserController@resetSuccess', 'as' => 'reset_success']);
            Route::get('/reset/{hash}', 'UserController@reset');
            Route::post('/api/login', 'UserApiController@login');
            Route::post('/api/registration', 'UserApiController@registration');
            Route::post('/api/forgot', 'UserApiController@forgot');
            Route::post('/api/reset', 'UserApiController@reset');

            Route::post('/api/fb/login', 'UserApiController@fbLogin');
        });

        Route::group(['middleware' => 'auth:user'], function() {
            Route::get('/profile', ['uses' => 'UserController@profile', 'as' => 'user_profile']);
            Route::get('/profile/edit', 'UserController@profileEdit');
            Route::get('/profile/changed', ['uses' => 'UserController@profileChanged', 'as' => 'profile_changed']);
            Route::post('/api/profile/edit', 'UserApiController@profileEdit');
            Route::get('/profile/autos', 'UserController@autos');
            Route::get('/profile/autos/{id}', 'UserController@autosEdit');
            Route::get('/logout', ['uses' => 'UserController@logout', 'as' => 'user_logout']);
            Route::get('/sell', ['uses' => 'SellController@index', 'as' => 'sell']);
            Route::get('/sell/success', ['uses' => 'SellController@success', 'as' => 'sell_success']);
            Route::post('/api/sell', 'SellApiController@add');
            Route::post('/api/region', 'ApiController@region');
        });

        Route::get('/search', 'SearchController@index');
        Route::get('/auto/{autoId}', 'AutoController@index');

    });

});
