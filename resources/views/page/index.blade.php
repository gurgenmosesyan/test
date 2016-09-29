<?php
$title = $page->title;
?>
@extends('layout')

@section('content')

    <div class="page">

        @include('blocks.top_banner')

        <div id="main-left" class="fl">

            <div id="static">
                <h1 class="fb fs20 tc">{{$title}}</h1>
                <div class="html">{!!$page->text!!}</div>
            </div>

        </div>

        @include('blocks.right_banner')

        <div class="cb"></div>

    </div>

@stop