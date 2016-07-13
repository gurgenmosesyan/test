<?php
use App\Models\Auto\Auto;

$head->appendScript('/js/sell.js');

$title = trans('www.sell_car.title');

?>
@extends('layout')

@section('content')

<div class="page">
    <div id="sell">

        <div class="col-2 sell-left fl">

            <label class="required fl"><span>{{trans('www.sell_car.mark')}}</span></label>
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

            <label class="required fl"><span>{{trans('www.sell_car.body')}}</span></label>
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

            <label class="required fl"><span>{{trans('www.sell_car.year')}}</span></label>
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

            <label class="required fl"><span>{{trans('www.sell_car.transmission')}}</span></label>
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

            <label class="required fl"><span>{{trans('www.sell_car.color')}}</span></label>
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

            <label class="required fl"><span>{{trans('www.sell_car.engine')}}</span></label>
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

            <label class="fl"><span>{{trans('www.sell_car.horsepower')}}</span></label>
            <div class="inp fl"><input type="text" name="horsepower" value="" /></div>
            <div class="cb"></div>

            <label class="fl"><span>{{trans('www.sell_car.train')}}</span></label>
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

            <label class="fl"><span>{{trans('www.sell_car.wheel')}}</span></label>
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

            <label class="required fl"><span>{{trans('www.sell_car.country')}}</span></label>
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

            <label class="fl"><span>{{trans('www.sell_car.place')}}</span></label>
            <div class="inp fl"><input type="text" name="place" value="" /></div>
            <div class="cb"></div>

            <label class="required fl"><span>{{trans('www.sell_car.term')}}</span></label>
            <div class="select-box inp fl">
                <div class="select-arrow"></div>
                <div class="select-title"></div>
                <select name="country_id">
                    <option value="">{{trans('www.base.label.select')}}</option>
                    @for($i = 10; $i > 0; $i--)
                        <option value="{{$i}}">{{trans('www.sell_car.term.week', ['week' => $i])}}</option>
                    @endfor
                </select>
            </div>
            <div class="cb"></div>

        </div>
        <div class="col-2 sell-right fl">

            <label class="required fl"><span>{{trans('www.sell_car.model')}}</span></label>
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

            <label class="fl"><span>{{trans('www.sell_car.tuning')}}</span></label>
            <div class="inp fl"><input type="text" name="tuning" value="" /></div>
            <div class="cb"></div>

            <label class="required fl"><span>{{trans('www.sell_car.mileage')}}</span></label>
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

            <label class="required fl"><span>{{trans('www.sell_car.rudder')}}</span></label>
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

            <label class="fl"><span>{{trans('www.sell_car.interior_color')}}</span></label>
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

            <label class="fl"><span>{{trans('www.sell_car.engine_volume')}}</span></label>
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

            <label class="fl"><span>{{trans('www.sell_car.cylinders_count')}}</span></label>
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

            <label class="fl"><span>{{trans('www.sell_car.doors_count')}}</span></label>
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

            <label class="fl"><span>{{trans('www.sell_car.vin')}}</span></label>
            <div class="inp fl"><input type="text" name="vin" value="" /></div>
            <div class="cb"></div>

            <label class="fl"><span>{{trans('www.sell_car.region')}}</span></label>
            <div class="select-box disabled region-select inp fl">
                <div class="select-arrow"></div>
                <div class="select-title"></div>
                <select name="region_id" disabled="disabled">
                    <option value="">{{trans('www.base.label.select')}}</option>
                </select>
            </div>
            <div class="cb"></div>

            <label class="fl"><span>{{trans('www.sell_car.additional_phone')}}</span></label>
            <div class="inp fl"><input type="text" name="additional_phone" value="" /></div>
            <div class="cb"></div>

        </div>
        <div class="cb"></div>

        <div class="separator"></div>

        <div class="col-2 sell-left fl">
            <label class="required fl"><span>{{trans('www.sell_car.price')}}</span></label>
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

        <div class="col-3 sell-left fl">

            <label class="checkbox-label no-select">
                {{trans('www.sell_car.contract')}}
                <input type="checkbox" name="contract" value="{{Auto::CONTRACT}}" />
            </label>

            <label class="checkbox-label no-select">
                {{trans('www.sell_car.exchange')}}
                <input type="checkbox" name="exchange" value="{{Auto::EXCHANGE}}" />
            </label>

            <label class="checkbox-label no-select">
                {{trans('www.sell_car.damaged')}}
                <input type="checkbox" name="damaged" value="{{Auto::DAMAGED}}" />
            </label>

        </div>
        <div class="col-3 sell-middle fl">

            <label class="checkbox-label no-select">
                {{trans('www.sell_car.auction')}}
                <input type="checkbox" name="auction" value="{{Auto::AUCTION}}" />
            </label>

            <label class="checkbox-label no-select">
                {{trans('www.sell_car.partial_pay')}}
                <input type="checkbox" name="partial_pay" value="{{Auto::PARTIAL_PAY}}" />
            </label>

        </div>
        <div class="col-3 sell-right fl">

            <label class="checkbox-label no-select">
                {{trans('www.sell_car.bank')}}
                <input type="checkbox" name="bank" value="{{Auto::BANK}}" />
            </label>

            <label class="checkbox-label no-select">
                {{trans('www.sell_car.customs_cleared')}}
                <input type="checkbox" name="custom_cleared" value="{{Auto::CUSTOM_CLEARED}}" />
            </label>

        </div>
        <div class="cb"></div>

        <div class="separator"></div>

        <div class="col-1">
            <label class="fl">{{trans('www.sell_car.description')}}</label>
            <div class="inp fl"><textarea name="description"></textarea></div>
            <div class="cb"></div>
        </div>

        <div class="separator"></div>

        <?php
        $optionsCol1 = $optionsCol2 = $optionsCol3 = '';
        $i = 1;
        foreach($options as $opt) {
            $buffer = '<label class="checkbox-label no-select">'.$opt->name.'<input type="checkbox" name="options[]" value="'.$opt->id.'" /></label>';
            if ($i == 1) {
                $optionsCol1 .= $buffer;
            } else if ($i == 2) {
                $optionsCol2 .= $buffer;
            } else {
                $optionsCol3 .= $buffer;
                $i = 0;
            }
            $i++;
        }
        ?>
        <div class="col-3 sell-left fl">{!!$optionsCol1!!}</div>
        <div class="col-3 sell-middle fl">{!!$optionsCol2!!}</div>
        <div class="col-3 sell-right fl">{!!$optionsCol3!!}</div>
        <div class="cb"></div>

        <div class="separator"></div>

        <div class="col-1">
            <div><a href="#" id="upload-image" class="dib orange-bg">{{trans('www.sell_car.upload_image')}}</a></div>
            <div id="sell-images"></div>
            <div class="cb"></div>
        </div>

    </div>
</div>

@stop