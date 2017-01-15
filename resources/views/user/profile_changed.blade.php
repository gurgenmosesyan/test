<?php

$title = trans('www.profile_changed.text');

$meta->title($title);
$meta->ogTitle($title);
$meta->ogImage(url('/images/fb-logo.png'));

?>
@extends('layout')

@section('content')

<div class="page">

    @include('blocks.top_banner')

    <div id="reg-success" class="tc">
        {{trans('www.profile_changed.text')}}
        <br />
        <br />
        <br />
        <a href="{{route('user_profile', cLng('code'))}}" class="orange underline">{{trans('www.base.label.back')}}</a>
    </div>

</div>

@stop