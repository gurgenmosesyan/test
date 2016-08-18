<?php

$title = trans('www.profile_changed.text');

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
        {{trans('www.profile_changed.text')}}
        <br />
        <br />
        <br />
        <a href="{{route('user_profile', cLng('code'))}}" class="orange underline">{{trans('www.base.label.back')}}</a>
    </div>

</div>

@stop