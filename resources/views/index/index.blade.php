<?php
$title = trans('www.homepage.title');
?>
@extends('layout')

@section('content')

<div class="page">
    <div id="top-banner" class="tc">
        <a href="#">
            <img src="/images/temp/top-banner.jpg" />
        </a>
    </div>

    <div id="top-cars" class="fl">
        <h2 class="orange fb"><span class="dib">{{trans('www.top_cars.title')}}</span></h2>
        <div class="help"><a href="#" class="db"></a></div>
        <div class="top-block owl-carousel">
            <?php
            $topAutos = [];
            for ($i = 0; $i < 18; $i++) {
                $topAutos[] = [
                    'image' => '/images/temp/auto.jpg',
                    'price' => '50000$',
                    'title' => 'Mercedes-Benz E63 AMG',
                    'country' => 'Armenia',
                    'region' => 'Yerevan',
                    'mileage' => '32000',
                    'mileage_measurement' => 'km',
                    'year' => 2015
                ];
            }
            ?>
            <div class="box-part">
                @foreach($topAutos as $key => $auto)
                    @if(($key == 6 || $key == 12) && isset($topAutos[$key+1]))
                        <div class="cb"></div>
                        </div><div class="box-part">
                    @endif
                    <a href="#" class="auto-item db fl{{$key%3 == 0 ? ' mln' : ''}}">
                        <span class="auto-img db" style="background-image: url('{{$auto['image']}}');">
                            <span class="favorite-icon db"></span>
                            <span class="auto-price orange-bg tc db">{{$auto['price']}}</span>
                        </span>
                        <span class="auto-title db">{{$auto['title']}}</span>
                        <span class="auto-info db">{{$auto['country']}}@if(!empty($auto['region'])), {{$auto['region']}}@endif</span>
                        <span class="auto-info db">{{number_format($auto['mileage'], 0, ',', '.')}} * {{$auto['year']}}</span>
                    </a>
                @endforeach
                <div class="cb"></div>
            </div>
        </div>
    </div>

    <div id="quick-search" class="fl">
        <h2>
            {{trans('www.quick_search.title')}} <span>{{trans('www.quick_search.or')}}</span>
            <a href="#" class="orange">{{trans('www.quick_search.advanced_search')}}</a>
        </h2>
        <form id="quick-search-form" action="" method="get">
            <div class="country-select">
                <div class="select-box">
                    <div class="select-arrow"></div>
                    <div class="select-title"></div>
                    <select name="country">
                        <option value="">{{trans('www.country.select.default')}}</option>
                        @foreach($countries as $country)
                            <option value="{{$country->id}}">{{$country->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="mark-select">
                <div class="select-box">
                    <div class="select-arrow"></div>
                    <div class="select-title"></div>
                    <select name="mark">
                        <option value="">{{trans('www.mark.select.default')}}</option>
                        @foreach($marks as $mark)
                            <option value="{{$mark->id}}">{{$mark->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="model-select">
                <div class="select-box disabled">
                    <div class="select-arrow"></div>
                    <div class="select-title"></div>
                    <select name="model" disabled="disabled">
                        <option value="">{{trans('www.model.select.default')}}</option>
                    </select>
                </div>
            </div>
        </form>
    </div>
    <div class="cb"></div>

</div>

@stop