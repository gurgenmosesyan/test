<?php
use App\Models\Auto\Auto;
use App\Helpers\Base;

$price = Base::price($auto, $currencies, $defCurrency, $cCurrency, 'code');
$title = $auto->mark->name.' '.$auto->model->name.' '.$auto->year.', '.strtoupper($price);

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

            <div id="auto">
                <div class="top-box fb">
                    <h1 class="fl">{{$auto->mark->name.' '.$auto->model->name}}</h1>
                    <p class="fr">{{Base::price($auto, $currencies, $defCurrency, $cCurrency)}}</p>
                    <div class="cb"></div>
                </div>
                <div class="line"></div>
                <div class="main-box">
                    <div class="main-left fl">
                        <p class="fl key">{{trans('www.auto.year')}}</p>
                        <p class="fl value fb">{{$auto->year}}</p>
                        <div class="cb"></div>
                        <p class="fl key">{{trans('www.auto.mileage')}}</p>
                        <p class="fl value fb">{{$auto->mileageInfo()}}</p>
                        <div class="cb"></div>
                        <p class="fl key">{{trans('www.auto.body')}}</p>
                        <p class="fl value">{{$auto->body_ml->name}}</p>
                        <div class="cb"></div>
                        <p class="fl key">{{trans('www.auto.color')}}</p>
                        <p class="fl value">{{$auto->color_ml->name}}</p>
                        <div class="cb"></div>
                        @if(!empty($auto->interior_color_id))
                            <p class="fl key">{{trans('www.auto.interior_color')}}</p>
                            <p class="fl value">{{$auto->interior_color_ml->name}}</p>
                            <div class="cb"></div>
                        @endif
                        <p class="fl key">{{trans('www.auto.engine')}}</p>
                        <p class="fl value">
                            @if(!empty($auto->volume_1)){{$auto->volume_1.'.'.$auto->volume_2.' / '}}@endif
                            @if(!empty($auto->horsepower)){{$auto->horsepower.' '.trans('www.horsepower.short').' / '}}@endif
                            {{$auto->engine_ml->name}}
                        </p>
                        <div class="cb"></div>
                        <p class="fl key">{{trans('www.auto.transmission')}}</p>
                        <p class="fl value">{{$auto->transmission_ml->name}}</p>
                        <div class="cb"></div>
                        @if(!empty($auto->train_id))
                            <p class="fl key">{{trans('www.auto.train')}}</p>
                            <p class="fl value">{{$auto->train_ml->name}}</p>
                            <div class="cb"></div>
                        @endif
                        <p class="fl key">{{trans('www.auto.rudder')}}</p>
                        <p class="fl value">{{$auto->rudder_ml->name}}</p>
                        <div class="cb"></div>
                        @if(!empty($auto->tuning))
                            <p class="fl key">{{trans('www.auto.tuning')}}</p>
                            <p class="fl value">{{$auto->tuning}}</p>
                            <div class="cb"></div>
                        @endif
                        @if(!empty($auto->cylinder_id))
                            <p class="fl key">{{trans('www.auto.cylinders')}}</p>
                            <p class="fl value">{{$auto->cylinder->name}}</p>
                            <div class="cb"></div>
                        @endif
                        @if(!empty($auto->door_id))
                            <p class="fl key">{{trans('www.auto.doors')}}</p>
                            <p class="fl value">{{$auto->door->name}}</p>
                            <div class="cb"></div>
                        @endif
                        @if(!empty($auto->cylinder_id))
                            <p class="fl key">{{trans('www.auto.wheels')}}</p>
                            <p class="fl value">{{$auto->wheel->name}}</p>
                            <div class="cb"></div>
                        @endif
                    </div>
                    <div class="main-right fl">

                    </div>
                    <div class="cb"></div>
                </div>
            </div>

        </div>

        <div id="main-right" class="fl">
            <img src="/images/temp/r-ad-1.jpg">
        </div>
        <div class="cb"></div>

    </div>

@stop