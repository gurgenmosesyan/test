<?php

$title = trans('www.reg_success.title');

?>
@extends('layout')

@section('content')

<div class="page">
    <div id="top-banner" class="tc">
        <a href="#">
            <img src="/images/temp/top-banner.jpg" />
        </a>
    </div>

    <div id="reg-success" class="tc">
        {{trans('www.reg_success.text')}}
    </div>

</div>

@stop