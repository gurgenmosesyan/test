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
        {{trans('www.auto_updated.text')}}
        <br />
        <br />
        <br />
        <a href="{{url_with_lng('/auto/'.$autoId, false)}}" class="orange underline">{{trans('www.base.label.back_to_auto')}}</a>
    </div>

</div>

@stop