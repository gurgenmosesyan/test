<?php
use App\Models\Config\Manager;

$title = trans('www.profile_changed.text');
$logo = Manager::getLogo();
$meta->title($title);
$meta->ogTitle($title);
$meta->ogImage(url($logo));

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