<?php

$title = trans('www.forgot_success.text');

$meta->title($title);
$meta->ogTitle($title);
$meta->ogImage(url('/images/fb-logo.png'));

?>
@extends('layout')

@section('content')

<div class="page">

    @include('blocks.top_banner')

    <div id="reg-success" class="tc">
        {{trans('www.forgot_success.text')}}
        <br />
        <br />
        <br />
        <a href="{{route('homepage', cLng('code'))}}" class="orange underline">{{trans('www.base.label.homepage')}}</a>
    </div>

</div>

@stop