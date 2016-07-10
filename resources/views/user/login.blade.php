<?php
use App\Models\User\User;
$head->appendScript('/js/user.js');

$title = trans('www.login.title');

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
            <form id="login-form" action="{{url_with_lng('/api/login', false)}}" method="post">
                <div class="form-box">
                    <input type="text" name="email" placeholder="{{trans('www.base.label.email')}}" />
                    <div id="form-error-email" class="form-error"></div>
                </div>
                <div  class="form-box">
                    <input type="password" name="password" placeholder="{{trans('www.base.label.password')}}" />
                    <div id="form-error-password" class="form-error"></div>
                </div>
                <?php /* <div>
                    <input type="checkbox" name="remember_me" value="{{User::REMEMBER_ME}}" /> Remember me
                    <div id="form-error-remember_me" class="form-error"></div>
                </div> */ ?>
                {{csrf_field()}}
                <input type="submit" class="orange-bg fb" value="{{$title}}" />
            </form>
            <p class="link tc">{{trans('www.login.link_title')}} <a href="{{url_with_lng('/forgot', false)}}" class="orange">{{trans('www.user.forgot.title')}}</a></p>
        </div>
    </div>
</div>

@stop