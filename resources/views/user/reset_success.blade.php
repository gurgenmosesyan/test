<?php
use App\Models\Config\Manager;

$title = trans('www.reset_success.text');
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
        {{trans('www.reset_success.text')}}
        <br />
        <br />
        <br />
        <a href="{{route('user_login', cLng('code'))}}" class="orange underline">{{trans('www.base.label.login')}}</a>
    </div>

</div>

@stop