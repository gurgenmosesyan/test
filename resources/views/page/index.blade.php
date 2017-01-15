<?php

$description = mb_substr(trim(strip_tags($page->text)), 0, 250);

$meta->title($page->title);
$meta->description($description);
$meta->ogTitle($page->title);
$meta->ogDescription($description);
$meta->ogImage(url('/images/fb-logo.png'));
$meta->ogUrl(url_with_lng('/page/'.$page->alias));

?>
@extends('layout')

@section('content')

<div class="page">

    @include('blocks.top_banner')

    <div id="main-left" class="fl">

        <div id="static">
            <h1 class="fb fs20 tc">{{$page->title}}</h1>
            <div class="html">{!!$page->text!!}</div>
        </div>

    </div>

    @include('blocks.right_banner')

    <div class="cb"></div>

</div>

@stop