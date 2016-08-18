<?php

$title = trans('www.sell_car.add.success_text');

?>
@extends('layout')

@section('content')

    <div class="page">
        <div id="top-banner" class="tc">
            <a href="#">
                <img src="/images/temp/top-banner.jpg" />
            </a>
        </div>

        <div id="reg-success" class="tc">
            {{trans('www.sell_car.add.success_text')}}
            <br />
            <br />
            <br />
            <a href="{{route('sell', cLng('code'))}}" class="orange underline">{{trans('www.base.label.back')}}</a>
        </div>

    </div>

@stop