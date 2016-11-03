<?php
use App\Models\Config\Manager;

$logo = Manager::getLogo();
$meta->title(trans('www.sell_car.title'));
$meta->ogTitle(trans('www.sell_car.title'));
$meta->ogImage(url($logo));
$meta->ogUrl(url_with_lng('/sell'));

?>
@extends('layout')

@section('content')

<div class="page">
    <div id="sell" class="tc">
        <p class="auto-limit-txt">{{trans('www.auto.add.limit.text')}}</p>
    </div>
</div>

@stop