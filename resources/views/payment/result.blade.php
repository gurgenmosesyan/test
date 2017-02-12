<?php
use App\Models\Payment\Payment;

$title = trans('www.payment.result.title');

$meta->title($title);
$meta->ogTitle($title);
$meta->ogImage(url('/images/fb-logo.png'));

?>
@extends('layout')

@section('content')

<div class="page">

    @include('blocks.top_banner')

    <div id="reg-success" class="tc">
        @if($success)
            @if($type == Payment::TYPE_AD)
                {{trans('www.payment.ad.success.text')}}
            @else
                {{trans('www.payment.success.text')}}
            @endif
        @else
            {{trans('www.payment.status.error_'.$error)}}
        @endif
        <br />
        <br />
        <br />
        @if($type == Payment::TYPE_AD)
            <a href="{{url_with_lng('/profile/ads', false)}}" class="orange underline">{{trans('www.base.label.back')}}</a>
        @else
            <a href="{{url_with_lng('/auto/'.$autoId, false)}}" class="orange underline">{{trans('www.base.label.back_to_auto')}}</a>
        @endif
    </div>

</div>

@stop