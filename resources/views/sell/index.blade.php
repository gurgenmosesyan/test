<?php
use App\Models\Auto\Auto;

$title = trans('www.sell_car.title');

?>
@extends('layout')

@section('content')

<div class="page">
    <div id="sell">

        <div class="sell-left fl">

            <label class="required fl">{{trans('www.sell_car.mark')}}</label>
            <div class="mark-select inp fl">
                <div class="select-box">
                    <div class="select-arrow"></div>
                    <div class="select-title"></div>
                    <select name="mark_id" data-only_model="true">
                        <option value="">{{trans('www.base.label.select')}}</option>
                        @foreach($marks as $mark)
                            <option value="{{$mark->id}}">{{$mark->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="cb"></div>

            <label class="required fl">{{trans('www.sell_car.body')}}</label>
            <div class="select-box inp fl">
                <div class="select-arrow"></div>
                <div class="select-title"></div>
                <select name="body_id">
                    <option value="">{{trans('www.base.label.select')}}</option>
                    @foreach($bodies as $body)
                        <option value="{{$body->id}}">{{$body->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="cb"></div>

            <label class="required fl">{{trans('www.sell_car.year')}}</label>
            <div class="select-box inp fl">
                <div class="select-arrow"></div>
                <div class="select-title"></div>
                <select name="year">
                    <option value="">{{trans('www.base.label.select')}}</option>
                    @for($i = date('Y')+2; $i > 1909; $i--)
                        <option value="{{$i}}">{{$i}}</option>
                    @endfor
                </select>
            </div>
            <div class="cb"></div>

            <label class="required fl">{{trans('www.sell_car.transmission')}}</label>
            <div class="select-box inp fl">
                <div class="select-arrow"></div>
                <div class="select-title"></div>
                <select name="transmission_id">
                    <option value="">{{trans('www.base.label.select')}}</option>
                    @foreach($transmissions as $transmission)
                        <option value="{{$transmission->id}}">{{$transmission->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="cb"></div>

            <label class="required fl">{{trans('www.sell_car.color')}}</label>
            <div class="select-box inp fl">
                <div class="select-arrow"></div>
                <div class="select-title"></div>
                <select name="color_id">
                    <option value="">{{trans('www.base.label.select')}}</option>
                    @foreach($colors as $color)
                        <option value="{{$color->id}}">{{$color->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="cb"></div>

            <label class="required fl">{{trans('www.sell_car.engine')}}</label>
            <div class="select-box inp fl">
                <div class="select-arrow"></div>
                <div class="select-title"></div>
                <select name="engine_id">
                    <option value="">{{trans('www.base.label.select')}}</option>
                    @foreach($engines as $engine)
                        <option value="{{$engine->id}}">{{$engine->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="cb"></div>

            <label class="fl">{{trans('www.sell_car.horsepower')}}</label>
            <div class="inp fl"><input type="text" name="horsepower" value="" /></div>
            <div class="cb"></div>

            <label class="fl">{{trans('www.sell_car.train')}}</label>
            <div class="select-box inp fl">
                <div class="select-arrow"></div>
                <div class="select-title"></div>
                <select name="train_id">
                    <option value="">{{trans('www.base.label.select')}}</option>
                    @foreach($trains as $train)
                        <option value="{{$train->id}}">{{$train->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="cb"></div>

            <label class="fl">{{trans('www.sell_car.wheel')}}</label>
            <div class="select-box inp fl">
                <div class="select-arrow"></div>
                <div class="select-title"></div>
                <select name="wheel_id">
                    <option value="">{{trans('www.base.label.select')}}</option>
                    @foreach($wheels as $wheel)
                        <option value="{{$wheel->id}}">{{$wheel->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="cb"></div>

            <label class="required fl">{{trans('www.sell_car.country')}}</label>
            <div class="select-box country-select inp fl">
                <div class="select-arrow"></div>
                <div class="select-title"></div>
                <select name="country_id">
                    <option value="">{{trans('www.base.label.select')}}</option>
                    @foreach($countries as $country)
                        <option value="{{$country->id}}">{{$country->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="cb"></div>

            <label class="fl">{{trans('www.sell_car.place')}}</label>
            <div class="inp fl"><input type="text" name="place" value="" /></div>
            <div class="cb"></div>

        </div>
        <div class="sell-right fl">

            <label class="required fl">{{trans('www.sell_car.model')}}</label>
            <div class="model-select inp fl">
                <div class="select-box disabled">
                    <div class="select-arrow"></div>
                    <div class="select-title"></div>
                    <select name="model_id" disabled="disabled">
                        <option value="">{{trans('www.base.label.select')}}</option>
                    </select>
                </div>
            </div>
            <div class="cb"></div>

            <label class="fl">{{trans('www.sell_car.tuning')}}</label>
            <div class="inp fl"><input type="text" name="tuning" value="" /></div>
            <div class="cb"></div>

            <label class="required fl">{{trans('www.sell_car.mileage')}}</label>
            <div class="mileage-box inp fl">
                <div class="mileage-input fl"><input type="text" name="mileage" value="" /></div>
                <div class="select-box mileage-select fl">
                    <div class="select-arrow"></div>
                    <div class="select-title"></div>
                    <select name="mileage_measurement">
                        <option value="{{Auto::MILEAGE_MEASUREMENT_KM}}">{{trans('www.sell_car.mileage.measurement.'.Auto::MILEAGE_MEASUREMENT_KM)}}</option>
                        <option value="{{Auto::MILEAGE_MEASUREMENT_MILE}}">{{trans('www.sell_car.mileage.measurement.'.Auto::MILEAGE_MEASUREMENT_MILE)}}</option>
                    </select>
                </div>
                <div class="cb"></div>
            </div>
            <div class="cb"></div>

            <label class="required fl">{{trans('www.sell_car.rudder')}}</label>
            <div class="select-box inp fl">
                <div class="select-arrow"></div>
                <div class="select-title"></div>
                <select name="rudder_id">
                    <option value="">{{trans('www.base.label.select')}}</option>
                    @foreach($rudders as $rudder)
                        <option value="{{$rudder->id}}">{{$rudder->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="cb"></div>

            <label class="fl">{{trans('www.sell_car.interior_color')}}</label>
            <div class="select-box inp fl">
                <div class="select-arrow"></div>
                <div class="select-title"></div>
                <select name="interior_color_id">
                    <option value="">{{trans('www.base.label.select')}}</option>
                    @foreach($interiorColors as $color)
                        <option value="{{$color->id}}">{{$color->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="cb"></div>

            <label class="fl">{{trans('www.sell_car.engine_volume')}}</label>
            <div class="inp fl">
                <div class="engine-volume1 fl">
                    <div class="select-box">
                        <div class="select-arrow"></div>
                        <div class="select-title"></div>
                        <select name="volume_1">
                            <option value="">{{trans('www.base.label.select')}}</option>
                            @for($i = 0; $i < 16; $i++)
                                <option value="{{$i}}">{{$i}}</option>
                            @endfor
                        </select>
                    </div>
                </div>
                <div class="engine-volume2 fl">
                    <div class="select-box">
                        <div class="select-arrow"></div>
                        <div class="select-title"></div>
                        <select name="volume_2">
                            <option value="">{{trans('www.base.label.select')}}</option>
                            @for($i = 0; $i < 10; $i++)
                                <option value="{{$i}}">{{$i}}</option>
                            @endfor
                        </select>
                    </div>
                </div>
                <div class="cb"></div>
            </div>
            <div class="cb"></div>

            <label class="fl">{{trans('www.sell_car.cylinders_count')}}</label>
            <div class="select-box inp fl">
                <div class="select-arrow"></div>
                <div class="select-title"></div>
                <select name="cylinder_id">
                    <option value="">{{trans('www.base.label.select')}}</option>
                    @foreach($cylinders as $cylinder)
                        <option value="{{$cylinder->id}}">{{$cylinder->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="cb"></div>

            <label class="fl">{{trans('www.sell_car.doors_count')}}</label>
            <div class="select-box inp fl">
                <div class="select-arrow"></div>
                <div class="select-title"></div>
                <select name="door_id">
                    <option value="">{{trans('www.base.label.select')}}</option>
                    @foreach($doors as $door)
                        <option value="{{$door->id}}">{{$door->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="cb"></div>

            <label class="fl">{{trans('www.sell_car.vin')}}</label>
            <div class="inp fl"><input type="text" name="vin" value="" /></div>
            <div class="cb"></div>

            <label class="fl">{{trans('www.sell_car.region')}}</label>
            <div class="select-box disabled region-select inp fl">
                <div class="select-arrow"></div>
                <div class="select-title"></div>
                <select name="region_id" disabled="disabled">
                    <option value="">{{trans('www.base.label.select')}}</option>
                </select>
            </div>
            <div class="cb"></div>

            <label class="required fl">{{trans('www.sell_car.price')}}</label>
            <div class="inp fl">
                <div class="mileage-input fl"><input type="text" name="price" value="" /></div>
                <div class="select-box mileage-select fl">
                    <div class="select-arrow"></div>
                    <div class="select-title"></div>
                    <select name="currency_id">
                        @foreach($currenciesData as $currency)
                            <option value="{{$currency->id}}">{{$currency->code}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="cb"></div>
            </div>
            <div class="cb"></div>

        </div>
        <div class="cb"></div>

    </div>
</div>

@stop