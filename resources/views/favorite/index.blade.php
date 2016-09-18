<?php
use App\Models\Config\Manager;
use App\Helpers\Base;

$title = trans('www.favorites.title');

$autoEmpty = Manager::getAutoEmpty();
?>
@extends('layout')

@section('content')

<div class="page">

    <div id="top-banner" class="tc">
        <a href="#">
            <img src="/images/temp/top-banner.jpg" />
        </a>
    </div>

    <div id="main-left" class="fl">

        <div id="autos">
            @if($autos->isEmpty())
                <p class="empty tc">{{trans('www.autos.empty_result')}}</p>
            @else
                @foreach($autos as $key => $auto)
                    @if($key != 0)<div class="line"></div>@endif
                    <a href="{{url_with_lng('/auto/'.$auto->auto_id, false)}}" class="auto db">
                        <span class="auto-img db fl">
                            <img src="{{$auto->getThumb($autoEmpty)}}" width="205" />
                            <span class="favorite-icon fav-{{$auto->id}} db active" data-id="{{$auto->id}}"></span>
                        </span>
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
                    </span>
                        <span class="db cb"></span>
                    </a>
                @endforeach
            @endif
        </div>
    </div>

    <div id="main-right" class="fl">
        <img src="/images/temp/r-ad-1.jpg">
    </div>
    <div class="cb"></div>

</div>

@stop