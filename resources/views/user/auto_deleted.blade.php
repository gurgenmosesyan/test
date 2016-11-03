<?php
use App\Models\Config\Manager;

$title = trans('www.auto_deleted.title');
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
        {{trans('www.auto_deleted.text')}}
        <br />
        <br />
        <br />
        <a href="{{route('profile_autos', cLng('code'))}}" class="orange underline">{{trans('www.base.label.back_to_list')}}</a>
    </div>

</div>

@stop