<?php

$params = [
    'middleware' => ['web', 'auth:admin', 'access_control', 'language'],
    'prefix' => 'management/cms',
    'namespace' => 'Admin'
];

Route::group($params, function () {

	Route::get('/', 'IndexController@index');

    Route::get('/mark', ['uses' => 'MarkController@table', 'as' => 'admin_mark_table', 'permission' => 'mark']);
    Route::get('/mark/create', ['uses' => 'MarkController@create', 'as' => 'admin_mark_create', 'permission' => 'mark']);
    Route::get('/mark/edit/{id}', ['uses' => 'MarkController@edit', 'as' => 'admin_mark_edit', 'permission' => 'mark']);
    Route::post('/mark', ['uses' => 'MarkController@index', 'as' => 'admin_mark_index', 'permission' => 'mark']);
    Route::post('/mark/store', ['uses' => 'MarkController@store', 'as' => 'admin_mark_store', 'permission' => 'mark']);
    Route::post('/mark/update/{id}', ['uses' => 'MarkController@update', 'as' => 'admin_mark_update', 'permission' => 'mark']);
    Route::post('/mark/delete/{id}', ['uses' => 'MarkController@delete', 'as' => 'admin_mark_delete', 'permission' => 'mark']);

    Route::get('/modelCategory', ['uses' => 'ModelCategoryController@table', 'as' => 'admin_model_category_table', 'permission' => 'model_category']);
    Route::get('/modelCategory/create', ['uses' => 'ModelCategoryController@create', 'as' => 'admin_model_category_create', 'permission' => 'model_category']);
    Route::get('/modelCategory/edit/{id}', ['uses' => 'ModelCategoryController@edit', 'as' => 'admin_model_category_edit', 'permission' => 'model_category']);
    Route::post('/modelCategory', ['uses' => 'ModelCategoryController@index', 'as' => 'admin_model_category_index', 'permission' => 'model_category']);
    Route::post('/modelCategory/store', ['uses' => 'ModelCategoryController@store', 'as' => 'admin_model_category_store', 'permission' => 'model_category']);
    Route::post('/modelCategory/update/{id}', ['uses' => 'ModelCategoryController@update', 'as' => 'admin_model_category_update', 'permission' => 'model_category']);
    Route::post('/modelCategory/delete/{id}', ['uses' => 'ModelCategoryController@delete', 'as' => 'admin_model_category_delete', 'permission' => 'model_category']);
    Route::post('/api/modelCategory/get', ['uses' => 'ModelCategoryController@get', 'permission' => 'model_category']);

    Route::get('/model', ['uses' => 'ModelController@table', 'as' => 'admin_model_table', 'permission' => 'model']);
    Route::get('/model/create', ['uses' => 'ModelController@create', 'as' => 'admin_model_create', 'permission' => 'model']);
    Route::get('/model/edit/{id}', ['uses' => 'ModelController@edit', 'as' => 'admin_model_edit', 'permission' => 'model']);
    Route::post('/model', ['uses' => 'ModelController@index', 'as' => 'admin_model_index', 'permission' => 'model']);
    Route::post('/model/store', ['uses' => 'ModelController@store', 'as' => 'admin_model_store', 'permission' => 'model']);
    Route::post('/model/update/{id}', ['uses' => 'ModelController@update', 'as' => 'admin_model_update', 'permission' => 'model']);
    Route::post('/model/delete/{id}', ['uses' => 'ModelController@delete', 'as' => 'admin_model_delete', 'permission' => 'model']);
    Route::post('/api/model/get', ['uses' => 'ModelController@get']);

    Route::get('/body', ['uses' => 'BodyController@table', 'as' => 'admin_body_table', 'permission' => 'body']);
    Route::get('/body/create', ['uses' => 'BodyController@create', 'as' => 'admin_body_create', 'permission' => 'body']);
    Route::get('/body/edit/{id}', ['uses' => 'BodyController@edit', 'as' => 'admin_body_edit', 'permission' => 'body']);
    Route::post('/body', ['uses' => 'BodyController@index', 'as' => 'admin_body_index', 'permission' => 'body']);
    Route::post('/body/store', ['uses' => 'BodyController@store', 'as' => 'admin_body_store', 'permission' => 'body']);
    Route::post('/body/update/{id}', ['uses' => 'BodyController@update', 'as' => 'admin_body_update', 'permission' => 'body']);
    Route::post('/body/delete/{id}', ['uses' => 'BodyController@delete', 'as' => 'admin_body_delete', 'permission' => 'body']);

    Route::get('/rudder', ['uses' => 'RudderController@table', 'as' => 'admin_rudder_table', 'permission' => 'rudder']);
    Route::get('/rudder/create', ['uses' => 'RudderController@create', 'as' => 'admin_rudder_create', 'permission' => 'rudder']);
    Route::get('/rudder/edit/{id}', ['uses' => 'RudderController@edit', 'as' => 'admin_rudder_edit', 'permission' => 'rudder']);
    Route::post('/rudder', ['uses' => 'RudderController@index', 'as' => 'admin_rudder_index', 'permission' => 'rudder']);
    Route::post('/rudder/store', ['uses' => 'RudderController@store', 'as' => 'admin_rudder_store', 'permission' => 'rudder']);
    Route::post('/rudder/update/{id}', ['uses' => 'RudderController@update', 'as' => 'admin_rudder_update', 'permission' => 'rudder']);
    Route::post('/rudder/delete/{id}', ['uses' => 'RudderController@delete', 'as' => 'admin_rudder_delete', 'permission' => 'rudder']);

    Route::get('/color', ['uses' => 'ColorController@table', 'as' => 'admin_color_table', 'permission' => 'color']);
    Route::get('/color/create', ['uses' => 'ColorController@create', 'as' => 'admin_color_create', 'permission' => 'color']);
    Route::get('/color/edit/{id}', ['uses' => 'ColorController@edit', 'as' => 'admin_color_edit', 'permission' => 'color']);
    Route::post('/color', ['uses' => 'ColorController@index', 'as' => 'admin_color_index', 'permission' => 'color']);
    Route::post('/color/store', ['uses' => 'ColorController@store', 'as' => 'admin_color_store', 'permission' => 'color']);
    Route::post('/color/update/{id}', ['uses' => 'ColorController@update', 'as' => 'admin_color_update', 'permission' => 'color']);
    Route::post('/color/delete/{id}', ['uses' => 'ColorController@delete', 'as' => 'admin_color_delete', 'permission' => 'color']);

    Route::get('/interiorColor', ['uses' => 'InteriorColorController@table', 'as' => 'admin_interior_color_table', 'permission' => 'interior_color']);
    Route::get('/interiorColor/create', ['uses' => 'InteriorColorController@create', 'as' => 'admin_interior_color_create', 'permission' => 'interior_color']);
    Route::get('/interiorColor/edit/{id}', ['uses' => 'InteriorColorController@edit', 'as' => 'admin_interior_color_edit', 'permission' => 'interior_color']);
    Route::post('/interiorColor', ['uses' => 'InteriorColorController@index', 'as' => 'admin_interior_color_index', 'permission' => 'interior_color']);
    Route::post('/interiorColor/store', ['uses' => 'InteriorColorController@store', 'as' => 'admin_interior_color_store', 'permission' => 'interior_color']);
    Route::post('/interiorColor/update/{id}', ['uses' => 'InteriorColorController@update', 'as' => 'admin_interior_color_update', 'permission' => 'interior_color']);
    Route::post('/interiorColor/delete/{id}', ['uses' => 'InteriorColorController@delete', 'as' => 'admin_interior_color_delete', 'permission' => 'interior_color']);

    Route::get('/transmission', ['uses' => 'TransmissionController@table', 'as' => 'admin_transmission_table', 'permission' => 'transmission']);
    Route::get('/transmission/create', ['uses' => 'TransmissionController@create', 'as' => 'admin_transmission_create', 'permission' => 'transmission']);
    Route::get('/transmission/edit/{id}', ['uses' => 'TransmissionController@edit', 'as' => 'admin_transmission_edit', 'permission' => 'transmission']);
    Route::post('/transmission', ['uses' => 'TransmissionController@index', 'as' => 'admin_transmission_index', 'permission' => 'transmission']);
    Route::post('/transmission/store', ['uses' => 'TransmissionController@store', 'as' => 'admin_transmission_store', 'permission' => 'transmission']);
    Route::post('/transmission/update/{id}', ['uses' => 'TransmissionController@update', 'as' => 'admin_transmission_update', 'permission' => 'transmission']);
    Route::post('/transmission/delete/{id}', ['uses' => 'TransmissionController@delete', 'as' => 'admin_transmission_delete', 'permission' => 'transmission']);

    Route::get('/engine', ['uses' => 'EngineController@table', 'as' => 'admin_engine_table', 'permission' => 'engine']);
    Route::get('/engine/create', ['uses' => 'EngineController@create', 'as' => 'admin_engine_create', 'permission' => 'engine']);
    Route::get('/engine/edit/{id}', ['uses' => 'EngineController@edit', 'as' => 'admin_engine_edit', 'permission' => 'engine']);
    Route::post('/engine', ['uses' => 'EngineController@index', 'as' => 'admin_engine_index', 'permission' => 'engine']);
    Route::post('/engine/store', ['uses' => 'EngineController@store', 'as' => 'admin_engine_store', 'permission' => 'engine']);
    Route::post('/engine/update/{id}', ['uses' => 'EngineController@update', 'as' => 'admin_engine_update', 'permission' => 'engine']);
    Route::post('/engine/delete/{id}', ['uses' => 'EngineController@delete', 'as' => 'admin_engine_delete', 'permission' => 'engine']);

    Route::get('/cylinder', ['uses' => 'CylinderController@table', 'as' => 'admin_cylinder_table', 'permission' => 'cylinder']);
    Route::get('/cylinder/create', ['uses' => 'CylinderController@create', 'as' => 'admin_cylinder_create', 'permission' => 'cylinder']);
    Route::get('/cylinder/edit/{id}', ['uses' => 'CylinderController@edit', 'as' => 'admin_cylinder_edit', 'permission' => 'cylinder']);
    Route::post('/cylinder', ['uses' => 'CylinderController@index', 'as' => 'admin_cylinder_index', 'permission' => 'cylinder']);
    Route::post('/cylinder/store', ['uses' => 'CylinderController@store', 'as' => 'admin_cylinder_store', 'permission' => 'cylinder']);
    Route::post('/cylinder/update/{id}', ['uses' => 'CylinderController@update', 'as' => 'admin_cylinder_update', 'permission' => 'cylinder']);
    Route::post('/cylinder/delete/{id}', ['uses' => 'CylinderController@delete', 'as' => 'admin_cylinder_delete', 'permission' => 'cylinder']);

    Route::get('/train', ['uses' => 'TrainController@table', 'as' => 'admin_train_table', 'permission' => 'train']);
    Route::get('/train/create', ['uses' => 'TrainController@create', 'as' => 'admin_train_create', 'permission' => 'train']);
    Route::get('/train/edit/{id}', ['uses' => 'TrainController@edit', 'as' => 'admin_train_edit', 'permission' => 'train']);
    Route::post('/train', ['uses' => 'TrainController@index', 'as' => 'admin_train_index', 'permission' => 'train']);
    Route::post('/train/store', ['uses' => 'TrainController@store', 'as' => 'admin_train_store', 'permission' => 'train']);
    Route::post('/train/update/{id}', ['uses' => 'TrainController@update', 'as' => 'admin_train_update', 'permission' => 'train']);
    Route::post('/train/delete/{id}', ['uses' => 'TrainController@delete', 'as' => 'admin_train_delete', 'permission' => 'train']);

    Route::get('/door', ['uses' => 'DoorController@table', 'as' => 'admin_door_table', 'permission' => 'door']);
    Route::get('/door/create', ['uses' => 'DoorController@create', 'as' => 'admin_door_create', 'permission' => 'door']);
    Route::get('/door/edit/{id}', ['uses' => 'DoorController@edit', 'as' => 'admin_door_edit', 'permission' => 'door']);
    Route::post('/door', ['uses' => 'DoorController@index', 'as' => 'admin_door_index', 'permission' => 'door']);
    Route::post('/door/store', ['uses' => 'DoorController@store', 'as' => 'admin_door_store', 'permission' => 'door']);
    Route::post('/door/update/{id}', ['uses' => 'DoorController@update', 'as' => 'admin_door_update', 'permission' => 'door']);
    Route::post('/door/delete/{id}', ['uses' => 'DoorController@delete', 'as' => 'admin_door_delete', 'permission' => 'door']);

    Route::get('/wheel', ['uses' => 'WheelController@table', 'as' => 'admin_wheel_table', 'permission' => 'wheel']);
    Route::get('/wheel/create', ['uses' => 'WheelController@create', 'as' => 'admin_wheel_create', 'permission' => 'wheel']);
    Route::get('/wheel/edit/{id}', ['uses' => 'WheelController@edit', 'as' => 'admin_wheel_edit', 'permission' => 'wheel']);
    Route::post('/wheel', ['uses' => 'WheelController@index', 'as' => 'admin_wheel_index', 'permission' => 'wheel']);
    Route::post('/wheel/store', ['uses' => 'WheelController@store', 'as' => 'admin_wheel_store', 'permission' => 'wheel']);
    Route::post('/wheel/update/{id}', ['uses' => 'WheelController@update', 'as' => 'admin_wheel_update', 'permission' => 'wheel']);
    Route::post('/wheel/delete/{id}', ['uses' => 'WheelController@delete', 'as' => 'admin_wheel_delete', 'permission' => 'wheel']);

    Route::get('/country', ['uses' => 'CountryController@table', 'as' => 'admin_country_table', 'permission' => 'country']);
    Route::get('/country/create', ['uses' => 'CountryController@create', 'as' => 'admin_country_create', 'permission' => 'country']);
    Route::get('/country/edit/{id}', ['uses' => 'CountryController@edit', 'as' => 'admin_country_edit', 'permission' => 'country']);
    Route::post('/country', ['uses' => 'CountryController@index', 'as' => 'admin_country_index', 'permission' => 'country']);
    Route::post('/country/store', ['uses' => 'CountryController@store', 'as' => 'admin_country_store', 'permission' => 'country']);
    Route::post('/country/update/{id}', ['uses' => 'CountryController@update', 'as' => 'admin_country_update', 'permission' => 'country']);
    Route::post('/country/delete/{id}', ['uses' => 'CountryController@delete', 'as' => 'admin_country_delete', 'permission' => 'country']);

    Route::get('/region', ['uses' => 'RegionController@table', 'as' => 'admin_region_table', 'permission' => 'region']);
    Route::get('/region/create', ['uses' => 'RegionController@create', 'as' => 'admin_region_create', 'permission' => 'region']);
    Route::get('/region/edit/{id}', ['uses' => 'RegionController@edit', 'as' => 'admin_region_edit', 'permission' => 'region']);
    Route::post('/region', ['uses' => 'RegionController@index', 'as' => 'admin_region_index', 'permission' => 'region']);
    Route::post('/region/store', ['uses' => 'RegionController@store', 'as' => 'admin_region_store', 'permission' => 'region']);
    Route::post('/region/update/{id}', ['uses' => 'RegionController@update', 'as' => 'admin_region_update', 'permission' => 'region']);
    Route::post('/region/delete/{id}', ['uses' => 'RegionController@delete', 'as' => 'admin_region_delete', 'permission' => 'region']);
    Route::post('/api/region/get', ['uses' => 'RegionController@get', 'permission' => 'region']);

    Route::get('/option', ['uses' => 'OptionController@table', 'as' => 'admin_option_table', 'permission' => 'option']);
    Route::get('/option/create', ['uses' => 'OptionController@create', 'as' => 'admin_option_create', 'permission' => 'option']);
    Route::get('/option/edit/{id}', ['uses' => 'OptionController@edit', 'as' => 'admin_option_edit', 'permission' => 'option']);
    Route::post('/option', ['uses' => 'OptionController@index', 'as' => 'admin_option_index', 'permission' => 'option']);
    Route::post('/option/store', ['uses' => 'OptionController@store', 'as' => 'admin_option_store', 'permission' => 'option']);
    Route::post('/option/update/{id}', ['uses' => 'OptionController@update', 'as' => 'admin_option_update', 'permission' => 'option']);
    Route::post('/option/delete/{id}', ['uses' => 'OptionController@delete', 'as' => 'admin_option_delete', 'permission' => 'option']);

    Route::get('/auto', ['uses' => 'AutoController@table', 'as' => 'admin_auto_table', 'permission' => 'auto']);
    Route::get('/auto/create', ['uses' => 'AutoController@create', 'as' => 'admin_auto_create', 'permission' => 'auto']);
    Route::get('/auto/edit/{id}', ['uses' => 'AutoController@edit', 'as' => 'admin_auto_edit', 'permission' => 'auto']);
    Route::post('/auto', ['uses' => 'AutoController@index', 'as' => 'admin_auto_index', 'permission' => 'auto']);
    Route::post('/auto/store', ['uses' => 'AutoController@store', 'as' => 'admin_auto_store', 'permission' => 'auto']);
    Route::post('/auto/update/{id}', ['uses' => 'AutoController@update', 'as' => 'admin_auto_update', 'permission' => 'auto']);
    Route::post('/auto/delete/{id}', ['uses' => 'AutoController@delete', 'as' => 'admin_auto_delete', 'permission' => 'auto']);
    Route::post('/auto/changeStatus', ['uses' => 'AutoController@changeStatus', 'as' => 'admin_auto_change_status', 'permission' => 'auto']);
    Route::post('/auto/get', ['uses' => 'AutoController@get', 'as' => 'admin_auto_get', 'permission' => 'auto']);

    Route::get('/config/edit', ['uses' => 'ConfigController@edit', 'as' => 'admin_config_edit', 'permission' => 'config']);
    Route::post('/config/update', ['uses' => 'ConfigController@update', 'as' => 'admin_config_update', 'permission' => 'config']);

    Route::get('/currency', ['uses' => 'CurrencyController@table', 'as' => 'admin_currency_table', 'permission' => 'currency']);
    Route::get('/currency/create', ['uses' => 'CurrencyController@create', 'as' => 'admin_currency_create', 'permission' => 'currency']);
    Route::get('/currency/edit/{id}', ['uses' => 'CurrencyController@edit', 'as' => 'admin_currency_edit', 'permission' => 'currency']);
    Route::post('/currency', ['uses' => 'CurrencyController@index', 'as' => 'admin_currency_index', 'permission' => 'currency']);
    Route::post('/currency/store', ['uses' => 'CurrencyController@store', 'as' => 'admin_currency_store', 'permission' => 'currency']);
    Route::post('/currency/update/{id}', ['uses' => 'CurrencyController@update', 'as' => 'admin_currency_update', 'permission' => 'currency']);
    Route::post('/currency/delete/{id}', ['uses' => 'CurrencyController@delete', 'as' => 'admin_currency_delete', 'permission' => 'currency']);

    Route::get('/part', ['uses' => 'PartController@table', 'as' => 'admin_part_table', 'permission' => 'part']);
    Route::get('/part/create', ['uses' => 'PartController@create', 'as' => 'admin_part_create', 'permission' => 'part']);
    Route::get('/part/edit/{id}', ['uses' => 'PartController@edit', 'as' => 'admin_part_edit', 'permission' => 'part']);
    Route::post('/part', ['uses' => 'PartController@index', 'as' => 'admin_part_index', 'permission' => 'part']);
    Route::post('/part/store', ['uses' => 'PartController@store', 'as' => 'admin_part_store', 'permission' => 'part']);
    Route::post('/part/update/{id}', ['uses' => 'PartController@update', 'as' => 'admin_part_update', 'permission' => 'part']);
    Route::post('/part/delete/{id}', ['uses' => 'PartController@delete', 'as' => 'admin_part_delete', 'permission' => 'part']);

    Route::get('/topCar', ['uses' => 'TopCarController@table', 'as' => 'admin_top_car_table', 'permission' => 'top_car']);
    Route::get('/topCar/create', ['uses' => 'TopCarController@create', 'as' => 'admin_top_car_create', 'permission' => 'top_car']);
    Route::get('/topCar/edit/{id}', ['uses' => 'TopCarController@edit', 'as' => 'admin_top_car_edit', 'permission' => 'top_car']);
    Route::post('/topCar', ['uses' => 'TopCarController@index', 'as' => 'admin_top_car_index', 'permission' => 'top_car']);
    Route::post('/topCar/store', ['uses' => 'TopCarController@store', 'as' => 'admin_top_car_store', 'permission' => 'top_car']);
    Route::post('/topCar/update/{id}', ['uses' => 'TopCarController@update', 'as' => 'admin_top_car_update', 'permission' => 'top_car']);
    Route::post('/topCar/delete/{id}', ['uses' => 'TopCarController@delete', 'as' => 'admin_top_car_delete', 'permission' => 'top_car']);

    Route::get('/urgentCar', ['uses' => 'UrgentCarController@table', 'as' => 'admin_urgent_car_table', 'permission' => 'urgent_car']);
    Route::get('/urgentCar/create', ['uses' => 'UrgentCarController@create', 'as' => 'admin_urgent_car_create', 'permission' => 'urgent_car']);
    Route::get('/urgentCar/edit/{id}', ['uses' => 'UrgentCarController@edit', 'as' => 'admin_urgent_car_edit', 'permission' => 'urgent_car']);
    Route::post('/urgentCar', ['uses' => 'UrgentCarController@index', 'as' => 'admin_urgent_car_index', 'permission' => 'urgent_car']);
    Route::post('/urgentCar/store', ['uses' => 'UrgentCarController@store', 'as' => 'admin_urgent_car_store', 'permission' => 'urgent_car']);
    Route::post('/urgentCar/update/{id}', ['uses' => 'UrgentCarController@update', 'as' => 'admin_urgent_car_update', 'permission' => 'urgent_car']);
    Route::post('/urgentCar/delete/{id}', ['uses' => 'UrgentCarController@delete', 'as' => 'admin_urgent_car_delete', 'permission' => 'urgent_car']);

    Route::get('/ad', ['uses' => 'AdController@table', 'as' => 'admin_ad_table', 'permission' => 'ad']);
    Route::get('/ad/create', ['uses' => 'AdController@create', 'as' => 'admin_ad_create', 'permission' => 'ad']);
    Route::get('/ad/edit/{id}', ['uses' => 'AdController@edit', 'as' => 'admin_ad_edit', 'permission' => 'ad']);
    Route::post('/ad', ['uses' => 'AdController@index', 'as' => 'admin_ad_index', 'permission' => 'ad']);
    Route::post('/ad/store', ['uses' => 'AdController@store', 'as' => 'admin_ad_store', 'permission' => 'ad']);
    Route::post('/ad/update/{id}', ['uses' => 'AdController@update', 'as' => 'admin_ad_update', 'permission' => 'ad']);
    Route::post('/ad/delete/{id}', ['uses' => 'AdController@delete', 'as' => 'admin_ad_delete', 'permission' => 'ad']);

    Route::get('/tax', ['uses' => 'TaxController@table', 'as' => 'admin_tax_table', 'permission' => 'tax']);
    Route::get('/tax/create', ['uses' => 'TaxController@create', 'as' => 'admin_tax_create', 'permission' => 'tax']);
    Route::get('/tax/edit/{id}', ['uses' => 'TaxController@edit', 'as' => 'admin_tax_edit', 'permission' => 'tax']);
    Route::post('/tax', ['uses' => 'TaxController@index', 'as' => 'admin_tax_index', 'permission' => 'tax']);
    Route::post('/tax/store', ['uses' => 'TaxController@store', 'as' => 'admin_tax_store', 'permission' => 'tax']);
    Route::post('/tax/update/{id}', ['uses' => 'TaxController@update', 'as' => 'admin_tax_update', 'permission' => 'tax']);
    Route::post('/tax/delete/{id}', ['uses' => 'TaxController@delete', 'as' => 'admin_tax_delete', 'permission' => 'tax']);

    Route::get('/footerMenu', ['uses' => 'FooterMenuController@table', 'as' => 'admin_footer_menu_table', 'permission' => 'footer_menu']);
    Route::get('/footerMenu/create', ['uses' => 'FooterMenuController@create', 'as' => 'admin_footer_menu_create', 'permission' => 'footer_menu']);
    Route::get('/footerMenu/edit/{id}', ['uses' => 'FooterMenuController@edit', 'as' => 'admin_footer_menu_edit', 'permission' => 'footer_menu']);
    Route::post('/footerMenu', ['uses' => 'FooterMenuController@index', 'as' => 'admin_footer_menu_index', 'permission' => 'footer_menu']);
    Route::post('/footerMenu/store', ['uses' => 'FooterMenuController@store', 'as' => 'admin_footer_menu_store', 'permission' => 'footer_menu']);
    Route::post('/footerMenu/update/{id}', ['uses' => 'FooterMenuController@update', 'as' => 'admin_footer_menu_update', 'permission' => 'footer_menu']);
    Route::post('/footerMenu/delete/{id}', ['uses' => 'FooterMenuController@delete', 'as' => 'admin_footer_menu_delete', 'permission' => 'footer_menu']);

});
