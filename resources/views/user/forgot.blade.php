<?php

$title = trans('www.user.forgot.title');

$meta->title($title);
$meta->ogTitle($title);
$meta->ogImage(url('/images/fb-logo.png'));

$head->appendScript('/js/user.js');

?>
@extends('layout')

@section('content')

<div class="page">

    @include('blocks.top_banner')

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