<?php
use App\Models\Auto\Auto;
use App\Helpers\Base;

$title = trans('www.search.title');

$jsTrans->addTrans([
    'www.search.all_params',
    'www.search.all_params.hide',
]);
?>
@extends('layout')

@section('content')

<div class="page">

    <div id="top-banner" class="tc">
        <a href="#">
            <img src="/images/temp/top-banner.jpg" />
        </a>
    </div>

    <div id="main-left" class="fl">
        <div id="search">
        <form action="{{url_with_lng('/search', false)}}" method="get">
        <div class="col col-1 fl">
            <div class="mark-select select-box">
                <div class="select-arrow"></div>
                <div class="select-title"></div>
                <select name="mark_id">
                    <option value="">{{trans('www.mark.select.default')}}</option>
                    @foreach($marks as $value)
                        <option value="{{$value->id}}">{{$value->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="select-box">
                <div class="select-arrow"></div>
                <div class="select-title"></div>
                <select name="transmission_id">
                    <option value="">{{trans('www.transmission.select.default')}}</option>
                    @foreach($transmissions as $value)
                        <option value="{{$value->id}}">{{$value->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="sub-col sub-col-1 fl">
                <div class="select-box">
                    <div class="select-arrow"></div>
                    <div class="select-title"></div>
                    <select name="year_from">
                        <option value="">{{trans('www.year_from')}}</option>
                        @for($i = date('Y'); $i > 1909; $i--)
                            <option value="{{$i}}">{{$i}}</option>
                        @endfor
                    </select>
                </div>
            </div>
            <div class="sub-col sub-col-2 fl">
                <div class="select-box">
                    <div class="select-arrow"></div>
                    <div class="select-title"></div>
                    <select name="year_to">
                        <option value="">{{trans('www.year_to')}}</option>
                        @for($i = date('Y'); $i > 1909; $i--)
                            <option value="{{$i}}">{{$i}}</option>
                        @endfor
                    </select>
                </div>
            </div>
            <div class="cb"></div>
        </div>
        <div class="col col-2 fl">
            <div class="model-select select-box disabled">
                <div class="select-arrow"></div>
                <div class="select-title"></div>
                <select name="model_id" disabled="disabled">
                    <option value="">{{trans('www.model.select.default')}}</option>
                </select>
            </div>
            <div class="sub-col sub-col-1 fl">
                <div class="select-box">
                    <div class="select-arrow"></div>
                    <div class="select-title"></div>
                    <select name="rudder_id">
                        <option value="">{{trans('www.rudder.select.default')}}</option>
                        @foreach($rudders as $value)
                            <option value="{{$value->id}}">{{$value->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="sub-col sub-col-2 fl">
                <div class="select-box">
                    <div class="select-arrow"></div>
                    <div class="select-title"></div>
                    <select name="engine_id">
                        <option value="">{{trans('www.engine.select.default')}}</option>
                        @foreach($engines as $value)
                            <option value="{{$value->id}}">{{$value->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="cb"></div>
            <div class="mileage sub-col-1 fl">
                <input type="text" name="mileage_from" value="" placeholder="{{trans('www.from')}}" />
            </div>
            <div class="mileage sub-col-1 fl">
                <input type="text" name="mileage_to" value="" placeholder="{{trans('www.to')}}" />
            </div>
            <div class="mileage-measurement fl">
                <div class="select-box">
                    <div class="select-arrow"></div>
                    <div class="select-title"></div>
                    <select name="engine_id">
                        <option value="{{Auto::MILEAGE_MEASUREMENT_KM}}">{{trans('www.mileage.measurement.km')}}</option>
                        <option value="{{Auto::MILEAGE_MEASUREMENT_MILE}}">{{trans('www.mileage.measurement.mile')}}</option>
                    </select>
                </div>
            </div>
            <div class="cb"></div>
        </div>
        <div class="col col-3 fl">
            <div class="select-box">
                <div class="select-arrow"></div>
                <div class="select-title"></div>
                <select name="mark_id">
                    <option value="">{{trans('www.country.select.default')}}</option>
                    @foreach($countries as $value)
                        <option value="{{$value->id}}">{{$value->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="sub-col sub-col-1 fl">
                <div class="select-box">
                    <div class="select-arrow"></div>
                    <div class="select-title"></div>
                    <select name="volume_from">
                        <option value="">{{trans('www.volume.from')}}</option>
                        @foreach(config('auto.engine_volumes') as $value)
                            <option value="{{$value}}">{{$value}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="sub-col sub-col-2 fl">
                <div class="select-box">
                    <div class="select-arrow"></div>
                    <div class="select-title"></div>
                    <select name="volume_to">
                        <option value="">{{trans('www.volume.to')}}</option>
                        @foreach(config('auto.engine_volumes') as $value)
                            <option value="{{$value}}">{{$value}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="cb"></div>
            <div class="sub-col sub-col-1 fl">
                <input type="text" name="price_from" value="" placeholder="{{trans('www.price_from')}}" />
            </div>
            <div class="sub-col sub-col-2 fl">
                <input type="text" name="price_to" value="" placeholder="{{trans('www.price_to')}}" />
            </div>
            <div class="cb"></div>
        </div>
        <div class="cb"></div>

        <div class="hidden dpn">
            <div class="col col-1 fl">
                <div class="sub-col sub-col-1 fl">
                    <div class="select-box">
                        <div class="select-arrow"></div>
                        <div class="select-title"></div>
                        <select name="body_id">
                            <option value="">{{trans('www.body.select.default')}}</option>
                            @foreach($bodies as $value)
                                <option value="{{$value->id}}">{{$value->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="sub-col sub-col-2 fl">
                    <div class="select-box">
                        <div class="select-arrow"></div>
                        <div class="select-title"></div>
                        <select name="train_id">
                            <option value="">{{trans('www.train.select.default')}}</option>
                            @foreach($trains as $value)
                                <option value="{{$value->id}}">{{$value->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="cb"></div>
                <div class="select-box">
                    <div class="select-arrow"></div>
                    <div class="select-title"></div>
                    <select name="cylinder_count_id">
                        <option value="">{{trans('www.cylinder_count.select.default')}}</option>
                        @foreach($cylindersCount as $value)
                            <option value="{{$value->id}}">{{$value->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col col-2 fl">
                <div class="sub-col sub-col-1 fl">
                    <input type="text" name="horsepower_from" value="" placeholder="{{trans('www.horsepower.from')}}" />
                </div>
                <div class="sub-col sub-col-2 fl">
                    <input type="text" name="horsepower_to" value="" placeholder="{{trans('www.horsepower.to')}}" />
                </div>
                <div class="cb"></div>
                <div class="select-box">
                    <div class="select-arrow"></div>
                    <div class="select-title"></div>
                    <select name="door_count_id">
                        <option value="">{{trans('www.door_count.select.default')}}</option>
                        @foreach($doorsCount as $value)
                            <option value="{{$value->id}}">{{$value->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col col-3 fl">
                <div class="sub-col sub-col-1 fl">
                    <div class="select-box">
                        <div class="select-arrow"></div>
                        <div class="select-title"></div>
                        <select name="color_id">
                            <option value="">{{trans('www.color.select.default')}}</option>
                            @foreach($colors as $value)
                                <option value="{{$value->id}}">{{$value->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="sub-col sub-col-2 fl">
                    <div class="select-box">
                        <div class="select-arrow"></div>
                        <div class="select-title"></div>
                        <select name="interior_color_id">
                            <option value="">{{trans('www.interior_color.select.default')}}</option>
                            @foreach($interiorColors as $value)
                                <option value="{{$value->id}}">{{$value->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="cb"></div>
                <div class="select-box">
                    <div class="select-arrow"></div>
                    <div class="select-title"></div>
                    <select name="wheel_id">
                        <option value="">{{trans('www.wheel.select.default')}}</option>
                        @foreach($wheels as $value)
                            <option value="{{$value->id}}">{{$value->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="cb"></div>
            <div class="tc">
                <div class="checkbox dib">
                    <label class="checkbox-label no-select">
                        {{trans('www.checkbox.customs_cleared')}}
                        <input type="checkbox" name="custom_cleared" value="{{Auto::CUSTOM_CLEARED}}" />
                    </label>
                </div>
                <div class="checkbox dib">
                    <label class="checkbox-label no-select">
                        {{trans('www.checkbox.damaged')}}
                        <input type="checkbox" name="damaged" value="{{Auto::DAMAGED}}" />
                    </label>
                </div>
                <div class="checkbox dib">
                    <label class="checkbox-label no-select">
                        {{trans('www.checkbox.partial_pay')}}
                        <input type="checkbox" name="partial_pay" value="{{Auto::PARTIAL_PAY}}" />
                    </label>
                </div>
                <div class="cb"></div>
            </div>
        </div>
        <div>
            <div class="fr">
                <input type="submit" class="btn" value="{{trans('www.search.search_btn')}}" />
            </div>
            <p class="show-all-p tc"><a href="#" class="orange show-all underline">{{trans('www.search.all_params')}}</a></p>
            <div class="cb"></div>
        </div>

        </form>
        </div>

        <div id="autos">
            <?php
            $autos = [];
            for ($i = 0; $i < 18; $i++) {
                $autos[] = [
                    'image' => '/images/temp/auto.jpg',
                    'price' => '2000000',
                    'currency_id' => '2',
                    'title' => 'Mercedes-Benz E63 AMG',
                    'country' => 'Armenia',
                    'region' => 'Yerevan',
                    'mileage' => '32000',
                    'mileage_measurement' => 'km',
                    'year' => 2015
                ];
            }
            ?>
            @foreach($autos as $key => $auto)
                @if($key != 0)<div class="line"></div>@endif
                <a href="" class="auto db">
                    <span class="auto-img db fl">
                        <img src="{{url($auto['image'])}}" width="205" />
                    </span>
                    <span class="auto-info db fl">
                        <span class="title-box db fl">
                            <span class="title db fb">{{$auto['title']}}</span>
                        </span>
                        <span class="price title db fb fl">{{Base::price($auto, $currencies, $defCurrency, $cCurrency)}}</span>
                        <span class="year db fl">{{$auto['year']}}</span>
                        <span class="mileage db fr">{{$auto['mileage'].' '.$auto['mileage_measurement']}}</span>
                        <span class="db cb"></span>
                    </span>
                    <span class="db cb"></span>
                </a>
            @endforeach
        </div>

    </div>

    <div id="right-ads" class="fl">

    </div>
    <div class="cb"></div>

</div>

@stop