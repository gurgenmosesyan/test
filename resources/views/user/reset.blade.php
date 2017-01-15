<?php

$title = trans('www.user.reset.title');

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

            @if($data['wrong_hash'])
                <p class="tc">{{trans('www.user.reset.wrong_hash')}}</p>
            @else
                <form id="reset-form" action="{{url_with_lng('/api/reset', false)}}" method="post">
                    <div class="form-box">
                        <input type="password" name="password" placeholder="{{trans('www.base.label.password')}}" />
                        <div id="form-error-password" class="form-error"></div>
                    </div>
                    <div  class="form-box">
                        <input type="password" name="re_password" placeholder="{{trans('www.base.label.re_password')}}" />
                        <div id="form-error-re_password" class="form-error"></div>
                    </div>
                    <input type="hidden" name="hash" value="{{$data['hash']}}" />
                    {{csrf_field()}}
                    <input type="submit" class="orange-bg fb" value="{{$title}}" />
                </form>
            @endif
        </div>
    </div>
</div>

@stop