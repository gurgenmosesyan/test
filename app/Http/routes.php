<?php

Route::group(['middleware' => ['web', 'front'], 'prefix' => '{lngCode}'], function () {

    Route::get('/registration', 'UserController@registration');
    Route::post('/api/registration', 'UserApiController@registration');

});
