<?php
$head->appendScript('/js/user.js');

$title = trans('www.user.forgot.title');

?>
@extends('layout')

@section('content')

<div class="page">
    <div id="top-banner" class="tc">
        <a href="#">
            <img src="/images/temp/top-banner.jpg" />
        </a>
    </div>

    <div id="login-block">
        <div id="login-inner">
            <h1 class="tc">{{$title}}</h1>

            <form id="forgot-form" action="{{url_with_lng('/api/forgot', false)}}" method="post">
                <div class="form-box">
                    <input type="text" name="email" placeholder="{{trans('www.base.label.email')}}" />
                    <div id="form-error-email" class="form-error"></div>
                </div>
                {{csrf_field()}}
                <input type="submit" class="orange-bg fb" value="{{$title}}" />
            </form>
        </div>
    </div>
</div>

@stop