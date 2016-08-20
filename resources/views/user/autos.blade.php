<?php
use App\Models\User\User;
use App\Models\Config\Manager;
use App\Helpers\Base;

$title = trans('www.user.profile.autos');

$autoEmpty = Manager::getAutoEmpty();
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
                <span class="item db fb active">
                    <span class="icon dib"></span>
                    <span class="text dib">{{trans('www.profile.link.my_cars')}}</span>
                </span>
            </div>
            <div class="link ads-link fl">
                <a href="#" class="item db fb">
                    <span class="icon dib"></span>
                    <span class="text dib">{{trans('www.profile.link.my_ads')}}</span>
                </a>
            </div>
            <div class="cb"></div>
        </div>

        <div id="main-left" class="fl">
            <div id="autos">
                @if($autos->isEmpty())
                    <p class="empty tc">{{trans('www.autos.empty_result')}}</p>
                @else
                    @foreach($autos as $key => $auto)
                        @if($key != 0)<div class="line"></div>@endif
                        <a href="{{url_with_lng('/profile/autos/'.$auto->id, false)}}" class="auto db">
                            <span class="auto-img db fl"><img src="{{$auto->getThumb($autoEmpty)}}" width="205" /></span>
                            <span class="auto-info db fl">
                                <span class="title-box db fl">
                                    <span class="title db fb">{{$auto->mark->name.' '.$auto->model->name}}</span>
                                    <span class="details db">
                                        @if(!empty($auto->volume_1))
                                            {{$auto->volume_1.'.'.$auto->volume_2}}
                                        @endif
                                        @if(!empty($auto->horsepower))
                                            {{'('.$auto->horsepower.' '.trans('www.horsepower.short').')'}}
                                        @endif
                                        {{$auto->engine_ml->name.','}}
                                        @if(!empty($auto->train_ml))
                                            {{$auto->train_ml->name.','}}
                                        @endif
                                        {{$auto->body_ml->name.','}}
                                        {{$auto->color_ml->name}}
                                    </span>
                                    <span class="country db">{{$auto->country_ml->name}}</span>
                                </span>
                                <span class="price title db fb fl">
                                    @if($auto->isContract())
                                        {{trans('www.auto.price.contract')}}
                                    @elseif($auto->isAuction())
                                        {{trans('www.auto.price.auction')}}
                                    @else
                                        {{Base::price($auto, $currencies, $defCurrency, $cCurrency)}}
                                    @endif
                                </span>
                                <span class="year db fl">{{$auto->year}}</span>
                                <span class="mileage db fr">{{$auto->mileageInfo()}}</span>
                                <span class="db cb"></span>
                                <span class="db status fb{{$auto->isApproved() ? ' approved' : ''}}">{{trans('www.auto.status.'.$auto->status)}}</span>
                            </span>
                            <span class="db cb"></span>
                        </a>
                    @endforeach
                    @include('pagination.default', ['model' => $autos])
                @endif
            </div>
        </div>
        <div id="main-right" class="fl">
            <img src="/images/temp/r-ad-1.jpg">
        </div>
        <div class="cb"></div>

    </div>
</div>

@stop