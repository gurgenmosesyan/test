<?php

$title = trans('www.user.activation.title');

$meta->title($title);
$meta->ogTitle($title);
$meta->ogImage(url('/images/fb-logo.png'));

?>
@extends('layout')

@section('content')

<div class="page">

    @include('blocks.top_banner')

    <div id="login-block">
        <div id="login-inner">
            <h1 class="tc">{{$title}}</h1>
            <p class="activation-info tc">
                @if($wrong)
                    {{trans('www.user.activation.wrong_hash')}}
                @else
                    {{trans('www.user.activation.success_message')}}
                    <a href="{{url_with_lng('/login')}}" class="orange">{{trans('www.user.profile.title')}}</a>
                @endif
            </p>
        </div>
    </div>
</div>

@stop