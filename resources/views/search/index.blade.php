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
                        <option value="{{$value->id}}"{{$value->id == $reqData['mark_id'] ? 'selected="selected"' : ''}}>{{$value->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="select-box">
                <div class="select-arrow"></div>
                <div class="select-title"></div>
                <select name="transmission_id">
                    <option value="">{{trans('www.transmission.select.default')}}</option>
                    @foreach($transmissions as $value)
                        <option value="{{$value->id}}"{{$value->id == $reqData['transmission_id'] ? 'selected="selected"' : ''}}>{{$value->name}}</option>
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
                            <option value="{{$i}}"{{$value->id == $reqData['year_from'] ? 'selected="selected"' : ''}}>{{$i}}</option>
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
                            <option value="{{$i}}"{{$value->id == $reqData['year_to'] ? 'selected="selected"' : ''}}>{{$i}}</option>
                        @endfor
                    </select>
                </div>
            </div>
            <div class="cb"></div>
        </div>
        <div class="col col-2 fl">
            <div class="model-select select-box{{empty($models) ? ' disabled' : ''}}">
                <div class="select-arrow"></div>
                <div class="select-title"></div>
                <select name="model_id"{{empty($models) ? ' disabled="disabled"' : ''}}>
                    <option value="">{{trans('www.model.select.default')}}</option>
                    @if(!empty($models))
                        @foreach($models as $value)
                            <option class="opt" value="{{$value['id']}}"{{$value['id'] == $reqData['model_id'] ? ' selected="selected"' : ''}}>{{$value['name']}}</option>
                        @endforeach
                    @endif
                </select>
            </div>
            <div class="sub-col sub-col-1 fl">
                <div class="select-box">
                    <div class="select-arrow"></div>
                    <div class="select-title"></div>
                    <select name="rudder_id">
                        <option value="">{{trans('www.rudder.select.default')}}</option>
                        @foreach($rudders as $value)
                            <option value="{{$value->id}}"{{$value->id == $reqData['rudder_id'] ? 'selected="selected"' : ''}}>{{$value->name}}</option>
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
                            <option value="{{$value->id}}"{{$value->id == $reqData['engine_id'] ? 'selected="selected"' : ''}}>{{$value->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="cb"></div>
            <div class="mileage sub-col-1 fl">
                <input type="text" name="mileage_from" value="{{$reqData['mileage_from'] or ''}}" placeholder="{{trans('www.from')}}" />
            </div>
            <div class="mileage sub-col-1 fl">
                <input type="text" name="mileage_to" value="{{$reqData['mileage_to'] or ''}}" placeholder="{{trans('www.to')}}" />
            </div>
            <div class="mileage-measurement fl">
                <div class="select-box">
                    <div class="select-arrow"></div>
                    <div class="select-title"></div>
                    <select name="mileage_measurement">
                        <option value="{{Auto::MILEAGE_MEASUREMENT_KM}}"{{Auto::MILEAGE_MEASUREMENT_KM == $reqData['mileage_measurement'] ? 'selected="selected"' : ''}}>{{trans('www.mileage.measurement.km')}}</option>
                        <option value="{{Auto::MILEAGE_MEASUREMENT_MILE}}"{{Auto::MILEAGE_MEASUREMENT_MILE == $reqData['mileage_measurement'] ? 'selected="selected"' : ''}}>{{trans('www.mileage.measurement.mile')}}</option>
                    </select>
                </div>
            </div>
            <div class="cb"></div>
        </div>
        <div class="col col-3 fl">
            <div class="select-box">
                <div class="select-arrow"></div>
                <div class="select-title"></div>
                <select name="country_id">
                    <option value="">{{trans('www.country.select.default')}}</option>
                    @foreach($countries as $value)
                        <option value="{{$value->id}}"{{$value->id == $reqData['country_id'] ? 'selected="selected"' : ''}}>{{$value->name}}</option>
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
                            <option value="{{$value}}"{{$value == $reqData['volume_from'] ? 'selected="selected"' : ''}}>{{$value}}</option>
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
                            <option value="{{$value}}"{{$value == $reqData['volume_to'] ? 'selected="selected"' : ''}}>{{$value}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="cb"></div>
            <div class="sub-col sub-col-1 fl">
                <input type="text" name="price_from" value="{{$reqData['price_from'] or ''}}" placeholder="{{trans('www.price_from')}}" />
            </div>
            <div class="sub-col sub-col-2 fl">
                <input type="text" name="price_to" value="{{$reqData['price_to'] or ''}}" placeholder="{{trans('www.price_to')}}" />
            </div>
            <div class="cb"></div>
        </div>
        <div class="cb"></div>

        <div class="hidden{{$showAll ? '' : ' dpn'}}">
            <div class="col col-1 fl">
                <div class="sub-col sub-col-1 fl">
                    <div class="select-box">
                        <div class="select-arrow"></div>
                        <div class="select-title"></div>
                        <select name="body_id">
                            <option value="">{{trans('www.body.select.default')}}</option>
                            @foreach($bodies as $value)
                                <option value="{{$value->id}}"{{$value->id == $reqData['body_id'] ? 'selected="selected"' : ''}}>{{$value->name}}</option>
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
                                <option value="{{$value->id}}"{{$value->id == $reqData['train_id'] ? 'selected="selected"' : ''}}>{{$value->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="cb"></div>
                <div class="select-box">
                    <div class="select-arrow"></div>
                    <div class="select-title"></div>
                    <select name="cylinder_id">
                        <option value="">{{trans('www.cylinder_count.select.default')}}</option>
                        @foreach($cylindersCount as $value)
                            <option value="{{$value->id}}"{{$value->id == $reqData['cylinder_id'] ? 'selected="selected"' : ''}}>{{$value->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col col-2 fl">
                <div class="sub-col sub-col-1 fl">
                    <input type="text" name="horsepower_from" value="{{$reqData['horsepower_from'] or ''}}" placeholder="{{trans('www.horsepower.from')}}" />
                </div>
                <div class="sub-col sub-col-2 fl">
                    <input type="text" name="horsepower_to" value="{{$reqData['horsepower_to'] or ''}}" placeholder="{{trans('www.horsepower.to')}}" />
                </div>
                <div class="cb"></div>
                <div class="select-box">
                    <div class="select-arrow"></div>
                    <div class="select-title"></div>
                    <select name="door_id">
                        <option value="">{{trans('www.door_count.select.default')}}</option>
                        @foreach($doorsCount as $value)
                            <option value="{{$value->id}}"{{$value->id == $reqData['door_id'] ? 'selected="selected"' : ''}}>{{$value->name}}</option>
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
                                <option value="{{$value->id}}"{{$value->id == $reqData['color_id'] ? 'selected="selected"' : ''}}>{{$value->name}}</option>
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
                                <option value="{{$value->id}}"{{$value->id == $reqData['interior_color_id'] ? 'selected="selected"' : ''}}>{{$value->name}}</option>
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
                            <option value="{{$value->id}}"{{$value->id == $reqData['wheel_id'] ? 'selected="selected"' : ''}}>{{$value->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="cb"></div>
            <div class="tc">
                <div class="checkbox dib">
                    <label class="checkbox-label no-select">
                        {{trans('www.checkbox.customs_cleared')}}
                        <input type="checkbox" name="custom_cleared" value="{{Auto::CUSTOM_CLEARED}}"{{Auto::CUSTOM_CLEARED == $reqData['custom_cleared'] ? 'checked="checked"' : ''}} />
                    </label>
                </div>
                <div class="checkbox dib">
                    <label class="checkbox-label no-select">
                        {{trans('www.checkbox.damaged')}}
                        <input type="checkbox" name="damaged" value="{{Auto::DAMAGED}}"{{Auto::DAMAGED == $reqData['damaged'] ? 'checked="checked"' : ''}} />
                    </label>
                </div>
                <div class="checkbox dib">
                    <label class="checkbox-label no-select">
                        {{trans('www.checkbox.partial_pay')}}
                        <input type="checkbox" name="partial_pay" value="{{Auto::PARTIAL_PAY}}"{{Auto::PARTIAL_PAY == $reqData['partial_pay'] ? 'checked="checked"' : ''}} />
                    </label>
                </div>
                <div class="cb"></div>
            </div>
        </div>
        <div>
            <div class="fr">
                <input type="submit" class="btn" value="{{trans('www.search.search_btn')}}" />
            </div>
            <p class="show-all-p tc"><a href="#" class="orange show-all underline">{{$showAll ? trans('www.search.all_params.hide') : trans('www.search.all_params')}}</a></p>
            <div class="cb"></div>
        </div>

        </form>
        </div>

        <div id="autos">
            @foreach($autos as $key => $auto)
                @if($key != 0)<div class="line"></div>@endif
                <a href="{{url_with_lng('/auto/'.$auto->auto_id, false)}}" class="auto db">
                    <span class="auto-img db fl" style="background-image: url('{{$auto->images[0]->getImage()}}');"></span>
                    <span class="auto-info db fl">
                        <span class="title-box db fl">
                            <span class="title db fb">{{$auto->mark->name.' '.$auto->model->name}}</span>
                            <span class="details db">
                                @if(!empty($auto->volume_1))
                                    {{$auto->volume_1.'.'.$auto->volume_2}}
                                @endif
                                @if(!empty($auto->horsepower))
                                    {{'('.$auto->horsepower.trans('www.horsepower.short').')'}}
                                @endif
                                {{$auto->engine_ml->name.','}}
                                @if(!empty($auto->train_ml))
                                    {{$auto->train_ml->name.','}}
                                @endif
                                {{$auto->body_ml->name.','}}
                                {{$auto->color_ml->name}}
                            </span>
                            <span class="country db">Armenia</span>
                        </span>
                        <span class="price title db fb fl">{{Base::price($auto, $currencies, $defCurrency, $cCurrency)}}</span>
                        <span class="year db fl">{{$auto->year}}</span>
                        <span class="mileage db fr">
                            {{$auto->mileage_measurement == Auto::MILEAGE_MEASUREMENT_KM ? $auto->mileage_km : $auto->mileage_mile}}
                            {{trans('www.mileage.measurement.'.$auto->mileage_measurement)}}
                        </span>
                        <span class="db cb"></span>
                    </span>
                    <span class="db cb"></span>
                </a>
            @endforeach
        </div>
        @include('pagination.default', ['model' => $autos])

    </div>

    <div id="right-ads" class="fl">

    </div>
    <div class="cb"></div>

</div>

@stop