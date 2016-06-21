<?php

$params = [
    'middleware' => ['web', 'auth:admin', 'language'],
    'prefix' => 'management/cms',
    'namespace' => 'Admin'
];

Route::group($params, function () {

	Route::get('/', 'AutoController@table');

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
    Route::post('/api/model/get', ['uses' => 'ModelController@get']);

    Route::get('/body', ['uses' => 'BodyController@table', 'as' => 'admin_body_table']);
    Route::get('/body/create', ['uses' => 'BodyController@create', 'as' => 'admin_body_create']);
    Route::get('/body/edit/{id}', ['uses' => 'BodyController@edit', 'as' => 'admin_body_edit']);
    Route::post('/body', ['uses' => 'BodyController@index', 'as' => 'admin_body_index']);
    Route::post('/body/store', ['uses' => 'BodyController@store', 'as' => 'admin_body_store']);
    Route::post('/body/update/{id}', ['uses' => 'BodyController@update', 'as' => 'admin_body_update']);
    Route::post('/body/delete/{id}', ['uses' => 'BodyController@delete', 'as' => 'admin_body_delete']);

    Route::get('/rudder', ['uses' => 'RudderController@table', 'as' => 'admin_rudder_table']);
    Route::get('/rudder/create', ['uses' => 'RudderController@create', 'as' => 'admin_rudder_create']);
    Route::get('/rudder/edit/{id}', ['uses' => 'RudderController@edit', 'as' => 'admin_rudder_edit']);
    Route::post('/rudder', ['uses' => 'RudderController@index', 'as' => 'admin_rudder_index']);
    Route::post('/rudder/store', ['uses' => 'RudderController@store', 'as' => 'admin_rudder_store']);
    Route::post('/rudder/update/{id}', ['uses' => 'RudderController@update', 'as' => 'admin_rudder_update']);
    Route::post('/rudder/delete/{id}', ['uses' => 'RudderController@delete', 'as' => 'admin_rudder_delete']);

    Route::get('/color', ['uses' => 'ColorController@table', 'as' => 'admin_color_table']);
    Route::get('/color/create', ['uses' => 'ColorController@create', 'as' => 'admin_color_create']);
    Route::get('/color/edit/{id}', ['uses' => 'ColorController@edit', 'as' => 'admin_color_edit']);
    Route::post('/color', ['uses' => 'ColorController@index', 'as' => 'admin_color_index']);
    Route::post('/color/store', ['uses' => 'ColorController@store', 'as' => 'admin_color_store']);
    Route::post('/color/update/{id}', ['uses' => 'ColorController@update', 'as' => 'admin_color_update']);
    Route::post('/color/delete/{id}', ['uses' => 'ColorController@delete', 'as' => 'admin_color_delete']);

    Route::get('/interiorColor', ['uses' => 'InteriorColorController@table', 'as' => 'admin_interior_color_table']);
    Route::get('/interiorColor/create', ['uses' => 'InteriorColorController@create', 'as' => 'admin_interior_color_create']);
    Route::get('/interiorColor/edit/{id}', ['uses' => 'InteriorColorController@edit', 'as' => 'admin_interior_color_edit']);
    Route::post('/interiorColor', ['uses' => 'InteriorColorController@index', 'as' => 'admin_interior_color_index']);
    Route::post('/interiorColor/store', ['uses' => 'InteriorColorController@store', 'as' => 'admin_interior_color_store']);
    Route::post('/interiorColor/update/{id}', ['uses' => 'InteriorColorController@update', 'as' => 'admin_interior_color_update']);
    Route::post('/interiorColor/delete/{id}', ['uses' => 'InteriorColorController@delete', 'as' => 'admin_interior_color_delete']);

    Route::get('/transmission', ['uses' => 'TransmissionController@table', 'as' => 'admin_transmission_table']);
    Route::get('/transmission/create', ['uses' => 'TransmissionController@create', 'as' => 'admin_transmission_create']);
    Route::get('/transmission/edit/{id}', ['uses' => 'TransmissionController@edit', 'as' => 'admin_transmission_edit']);
    Route::post('/transmission', ['uses' => 'TransmissionController@index', 'as' => 'admin_transmission_index']);
    Route::post('/transmission/store', ['uses' => 'TransmissionController@store', 'as' => 'admin_transmission_store']);
    Route::post('/transmission/update/{id}', ['uses' => 'TransmissionController@update', 'as' => 'admin_transmission_update']);
    Route::post('/transmission/delete/{id}', ['uses' => 'TransmissionController@delete', 'as' => 'admin_transmission_delete']);

    Route::get('/engine', ['uses' => 'EngineController@table', 'as' => 'admin_engine_table']);
    Route::get('/engine/create', ['uses' => 'EngineController@create', 'as' => 'admin_engine_create']);
    Route::get('/engine/edit/{id}', ['uses' => 'EngineController@edit', 'as' => 'admin_engine_edit']);
    Route::post('/engine', ['uses' => 'EngineController@index', 'as' => 'admin_engine_index']);
    Route::post('/engine/store', ['uses' => 'EngineController@store', 'as' => 'admin_engine_store']);
    Route::post('/engine/update/{id}', ['uses' => 'EngineController@update', 'as' => 'admin_engine_update']);
    Route::post('/engine/delete/{id}', ['uses' => 'EngineController@delete', 'as' => 'admin_engine_delete']);

    Route::get('/cylinder', ['uses' => 'CylinderController@table', 'as' => 'admin_cylinder_table']);
    Route::get('/cylinder/create', ['uses' => 'CylinderController@create', 'as' => 'admin_cylinder_create']);
    Route::get('/cylinder/edit/{id}', ['uses' => 'CylinderController@edit', 'as' => 'admin_cylinder_edit']);
    Route::post('/cylinder', ['uses' => 'CylinderController@index', 'as' => 'admin_cylinder_index']);
    Route::post('/cylinder/store', ['uses' => 'CylinderController@store', 'as' => 'admin_cylinder_store']);
    Route::post('/cylinder/update/{id}', ['uses' => 'CylinderController@update', 'as' => 'admin_cylinder_update']);
    Route::post('/cylinder/delete/{id}', ['uses' => 'CylinderController@delete', 'as' => 'admin_cylinder_delete']);

    Route::get('/train', ['uses' => 'TrainController@table', 'as' => 'admin_train_table']);
    Route::get('/train/create', ['uses' => 'TrainController@create', 'as' => 'admin_train_create']);
    Route::get('/train/edit/{id}', ['uses' => 'TrainController@edit', 'as' => 'admin_train_edit']);
    Route::post('/train', ['uses' => 'TrainController@index', 'as' => 'admin_train_index']);
    Route::post('/train/store', ['uses' => 'TrainController@store', 'as' => 'admin_train_store']);
    Route::post('/train/update/{id}', ['uses' => 'TrainController@update', 'as' => 'admin_train_update']);
    Route::post('/train/delete/{id}', ['uses' => 'TrainController@delete', 'as' => 'admin_train_delete']);

    Route::get('/door', ['uses' => 'DoorController@table', 'as' => 'admin_door_table']);
    Route::get('/door/create', ['uses' => 'DoorController@create', 'as' => 'admin_door_create']);
    Route::get('/door/edit/{id}', ['uses' => 'DoorController@edit', 'as' => 'admin_door_edit']);
    Route::post('/door', ['uses' => 'DoorController@index', 'as' => 'admin_door_index']);
    Route::post('/door/store', ['uses' => 'DoorController@store', 'as' => 'admin_door_store']);
    Route::post('/door/update/{id}', ['uses' => 'DoorController@update', 'as' => 'admin_door_update']);
    Route::post('/door/delete/{id}', ['uses' => 'DoorController@delete', 'as' => 'admin_door_delete']);

    Route::get('/wheel', ['uses' => 'WheelController@table', 'as' => 'admin_wheel_table']);
    Route::get('/wheel/create', ['uses' => 'WheelController@create', 'as' => 'admin_wheel_create']);
    Route::get('/wheel/edit/{id}', ['uses' => 'WheelController@edit', 'as' => 'admin_wheel_edit']);
    Route::post('/wheel', ['uses' => 'WheelController@index', 'as' => 'admin_wheel_index']);
    Route::post('/wheel/store', ['uses' => 'WheelController@store', 'as' => 'admin_wheel_store']);
    Route::post('/wheel/update/{id}', ['uses' => 'WheelController@update', 'as' => 'admin_wheel_update']);
    Route::post('/wheel/delete/{id}', ['uses' => 'WheelController@delete', 'as' => 'admin_wheel_delete']);

    Route::get('/country', ['uses' => 'CountryController@table', 'as' => 'admin_country_table']);
    Route::get('/country/create', ['uses' => 'CountryController@create', 'as' => 'admin_country_create']);
    Route::get('/country/edit/{id}', ['uses' => 'CountryController@edit', 'as' => 'admin_country_edit']);
    Route::post('/country', ['uses' => 'CountryController@index', 'as' => 'admin_country_index']);
    Route::post('/country/store', ['uses' => 'CountryController@store', 'as' => 'admin_country_store']);
    Route::post('/country/update/{id}', ['uses' => 'CountryController@update', 'as' => 'admin_country_update']);
    Route::post('/country/delete/{id}', ['uses' => 'CountryController@delete', 'as' => 'admin_country_delete']);

    Route::get('/region', ['uses' => 'RegionController@table', 'as' => 'admin_region_table']);
    Route::get('/region/create', ['uses' => 'RegionController@create', 'as' => 'admin_region_create']);
    Route::get('/region/edit/{id}', ['uses' => 'RegionController@edit', 'as' => 'admin_region_edit']);
    Route::post('/region', ['uses' => 'RegionController@index', 'as' => 'admin_region_index']);
    Route::post('/region/store', ['uses' => 'RegionController@store', 'as' => 'admin_region_store']);
    Route::post('/region/update/{id}', ['uses' => 'RegionController@update', 'as' => 'admin_region_update']);
    Route::post('/region/delete/{id}', ['uses' => 'RegionController@delete', 'as' => 'admin_region_delete']);
    Route::post('/api/region/get', ['uses' => 'RegionController@get']);

    Route::get('/option', ['uses' => 'OptionController@table', 'as' => 'admin_option_table']);
    Route::get('/option/create', ['uses' => 'OptionController@create', 'as' => 'admin_option_create']);
    Route::get('/option/edit/{id}', ['uses' => 'OptionController@edit', 'as' => 'admin_option_edit']);
    Route::post('/option', ['uses' => 'OptionController@index', 'as' => 'admin_option_index']);
    Route::post('/option/store', ['uses' => 'OptionController@store', 'as' => 'admin_option_store']);
    Route::post('/option/update/{id}', ['uses' => 'OptionController@update', 'as' => 'admin_option_update']);
    Route::post('/option/delete/{id}', ['uses' => 'OptionController@delete', 'as' => 'admin_option_delete']);

    Route::get('/auto', ['uses' => 'AutoController@table', 'as' => 'admin_auto_table']);
    Route::get('/auto/create', ['uses' => 'AutoController@create', 'as' => 'admin_auto_create']);
    Route::get('/auto/edit/{id}', ['uses' => 'AutoController@edit', 'as' => 'admin_auto_edit']);
    Route::post('/auto', ['uses' => 'AutoController@index', 'as' => 'admin_auto_index']);
    Route::post('/auto/store', ['uses' => 'AutoController@store', 'as' => 'admin_auto_store']);
    Route::post('/auto/update/{id}', ['uses' => 'AutoController@update', 'as' => 'admin_auto_update']);
    Route::post('/auto/delete/{id}', ['uses' => 'AutoController@delete', 'as' => 'admin_auto_delete']);
    Route::post('/auto/changeStatus', ['uses' => 'AutoController@changeStatus', 'as' => 'admin_auto_change_status']);

    Route::get('/config/edit', ['uses' => 'ConfigController@edit', 'as' => 'admin_config_edit']);
    Route::post('/auto/update', ['uses' => 'ConfigController@update', 'as' => 'admin_config_update']);

    Route::get('/currency', ['uses' => 'CurrencyController@table', 'as' => 'admin_currency_table']);
    Route::get('/currency/create', ['uses' => 'CurrencyController@create', 'as' => 'admin_currency_create']);
    Route::get('/currency/edit/{id}', ['uses' => 'CurrencyController@edit', 'as' => 'admin_currency_edit']);
    Route::post('/currency', ['uses' => 'CurrencyController@index', 'as' => 'admin_currency_index']);
    Route::post('/currency/store', ['uses' => 'CurrencyController@store', 'as' => 'admin_currency_store']);
    Route::post('/currency/update/{id}', ['uses' => 'CurrencyController@update', 'as' => 'admin_currency_update']);
    Route::post('/currency/delete/{id}', ['uses' => 'CurrencyController@delete', 'as' => 'admin_currency_delete']);

    Route::get('/part', ['uses' => 'PartController@table', 'as' => 'admin_part_table']);
    Route::get('/part/create', ['uses' => 'PartController@create', 'as' => 'admin_part_create']);
    Route::get('/part/edit/{id}', ['uses' => 'PartController@edit', 'as' => 'admin_part_edit']);
    Route::post('/part', ['uses' => 'PartController@index', 'as' => 'admin_part_index']);
    Route::post('/part/store', ['uses' => 'PartController@store', 'as' => 'admin_part_store']);
    Route::post('/part/update/{id}', ['uses' => 'PartController@update', 'as' => 'admin_part_update']);
    Route::post('/part/delete/{id}', ['uses' => 'PartController@delete', 'as' => 'admin_part_delete']);

});
