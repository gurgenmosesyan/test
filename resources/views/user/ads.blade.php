<?php

$title = trans('www.user.ads.title');

$meta->title($title);
$meta->ogTitle($title);
$meta->ogImage(url('/images/fb-logo.png'));

?>
@extends('layout')

@section('content')

<div class="page">

    <div id="profile">
        <div class="links tc">
            <div class="link profile-link fl">
                <a href="{{url_with_lng('/profile', false)}}" class="item db fb">
                    <span class="icon dib"></span>
                    <span class="text dib">{{trans('www.profile.link.my_profile')}}</span>
                </a>
            </div>
            <div class="link cars-link fl">
                <a href="{{url_with_lng('/profile/autos', false)}}" class="item db fb">
                    <span class="icon dib"></span>
                    <span class="text dib">{{trans('www.profile.link.my_cars')}}</span>
                </a>
            </div>
            <div class="link ads-link fl">
                <span class="item db fb active">
                    <span class="icon dib"></span>
                    <span class="text dib">{{trans('www.profile.link.my_ads')}}</span>
                </span>
            </div>
            <div class="cb"></div>
        </div>

        <div id="profile-govs">
            <div class="add-gov-btn tc">
                <a href="{{url_with_lng('/profile/ads/add', false)}}" class="btn dib fb">{{trans('www.ads.add.btn')}}</a>
            </div>
            @if($ads->isEmpty())
                <p class="empty tc">{{trans('www.ads.empty_list')}}</p>
            @else
                @foreach($ads as $key => $value)
                    <div class="gov gov-{{$key}}">
                        <div class="gov-img fl">
                            <img src="{{$value->getImage()}}" />
                        </div>
                        <div class="gov-info fl">
                            <p><strong>{{trans('www.ads.label.size')}}</strong> - {{trans('www.ads.label.size.'.$value->key)}}</p>
                            <p><strong>{{trans('www.ads.label.link')}}</strong> - <a href="{{$value->link}}" class="underline" target="_blank">{{$value->link}}</a></p>
                            <p><strong>{{trans('www.ads.label.deadline')}}</strong> - {{date('d.m.Y', strtotime($value->deadline)).' '.trans('www.ads.label.including')}}</p>
                            <p><strong>{{trans('www.ads.label.status')}}</strong> - {{trans('www.ads.label.status.'.$value->status)}}</p>
                        </div>
                        <div class="cb"></div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>

</div>

@stop