<?php
$head->appendScript('/js/user.js');

$title = trans('www.reg.title');

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
            <div class="fb-login fl">
                <a href="#" id="fb-login" class="db"></a>
            </div>
            <div class="google-login fl">
                <a href="#" id="google-login" class="db"></a>
            </div>
            <div class="cb"></div>
            <div class="line-block">
                <div class="line fl"></div>
                <div class="or fl tc">{{trans('www.base.label.or')}}</div>
                <div class="line fl"></div>
                <div class="cb"></div>
            </div>
            <form id="registration-form" action="{{url_with_lng('/api/registration', false)}}" method="post">
                <div class="form-box">
                    <input type="text" name="email" placeholder="{{trans('www.base.label.email')}}" />
                    <div id="form-error-email" class="form-error"></div>
                </div>
                <div class="form-box">
                    <input type="password" name="password" placeholder="{{trans('www.base.label.password')}}" />
                    <div id="form-error-password" class="form-error"></div>
                </div>
                <div class="form-box">
                    <input type="password" name="re_password" placeholder="{{trans('www.base.label.re_password')}}" />
                    <div id="form-error-re_password" class="form-error"></div>
                </div>
                <div class="form-box">
                    <input type="text" name="first_name" placeholder="{{trans('www.base.label.first_name')}}" />
                    <div id="form-error-first_name" class="form-error"></div>
                </div>
                <div class="form-box">
                    <input type="text" name="last_name" placeholder="{{trans('www.base.label.last_name')}}" />
                    <div id="form-error-last_name" class="form-error"></div>
                </div>
                <div class="form-box">
                    <input type="text" name="phone" placeholder="{{trans('www.base.label.phone')}}" />
                    <div id="form-error-phone" class="form-error"></div>
                </div>
                {{csrf_field()}}
                <input type="submit" class="orange-bg fb" value="{{$title}}" />
            </form>
            <p class="link tc">{{trans('www.reg.link_title')}} <a href="{{url_with_lng('/login', false)}}" class="orange">{{trans('www.login.title')}}</a></p>
        </div>
    </div>

</div>

@stop