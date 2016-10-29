<?php

$title = trans('www.404.title');

?>
@extends('layout')

@section('content')

<div id="error" class="tc">
    <h1>{{$title}}</h1>
    <p>{{trans('www.404.text')}}</p>
</div>

@stop