<?php
use App\Models\Auto\Auto;

$title = trans('www.search.title');

?>
@extends('layout')

@section('content')

<div class="page">

    <div id="top-banner" class="tc">
        <a href="#">
            <img src="/images/temp/top-banner.jpg" />
        </a>
    </div>

    <div id="search" class="fl">

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
                    <select name="transmission_id">
                        <option value="">{{trans('www.transmission.select.default')}}</option>
                        @foreach($transmissions as $value)
                            <option value="{{$value->id}}">{{$value->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="cb"></div>
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
                    <select name="train_id">
                        <option value="">{{trans('www.train.select.default')}}</option>
                        @foreach($trains as $value)
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
                        <option value="">{{trans('www.to')}}</option>
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
                <input type="text" name="price_to" value="" placeholder="{{trans('www.to')}}" />
            </div>
            <div class="cb"></div>
        </div>
        <div class="cb"></div>

        <p class="show-all-p tc"><a href="#" class="orange show-all underline">{{trans('www.search.all_params')}}</a></p>
    </div>

    <div class="col col-1 fl"></div>
    <div class="col col-2 fl"></div>
    <div class="col col-3 fl"></div>
    <div class="cb"></div>

    <div id="right-ads" class="fl">

    </div>
    <div class="cb"></div>

</div>

@stop