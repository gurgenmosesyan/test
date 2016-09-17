<?php

$title = trans('www.reg_success.title');

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
        {{trans('www.reg_success.text')}}
        <br />
        <br />
        <br />
        <a href="{{route('homepage', cLng('code'))}}" class="orange underline">{{trans('www.base.label.homepage')}}</a>
    </div>

</div>

@stop