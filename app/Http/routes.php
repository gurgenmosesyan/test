<?php

Route::group(['middleware' => ['web', 'front']], function() {

    Route::get('/', 'IndexController@index');

    Route::group(['prefix' => '{lngCode}'], function() {

        Route::get('/', ['uses' => 'IndexController@index', 'as' => 'homepage']);

        Route::group(['middleware' => 'guest:user'], function() {
            Route::get('/login', ['uses' => 'UserController@login', 'as' => 'user_login']);
            Route::get('/registration', 'UserController@registration');
            Route::get('/activation/{hash}', 'UserController@activation');
            Route::get('/forgot', 'UserController@forgot');
            Route::get('/reset/{hash}', 'UserController@reset');
            Route::post('/api/login', 'UserApiController@login');
            Route::post('/api/registration', 'UserApiController@registration');
            Route::post('/api/forgot', 'UserApiController@forgot');
            Route::post('/api/reset', 'UserApiController@reset');

            Route::post('/api/fbLogin', 'UserApiController@fbLogin');
        });

        Route::group(['middleware' => 'auth:user'], function() {
            Route::get('/profile', ['uses' => 'UserController@profile', 'as' => 'user_profile']);
            Route::get('/logout', ['uses' => 'UserController@logout', 'as' => 'user_logout']);
        });

    });

});
