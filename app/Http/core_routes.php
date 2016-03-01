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
    'middleware' => ['web', 'auth:admin', 'language'],
    'prefix' => 'admpanel/core',
    'namespace' => 'Core'
];

Route::group($params, function () {

    Route::get('/image/show', ['uses' => 'ImageUploaderController@show', 'as' => 'core_image_show']);
    Route::post('/image/upload', ['uses' => 'ImageUploaderController@upload', 'as' => 'core_image_upload']);

});
