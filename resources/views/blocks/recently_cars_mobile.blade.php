<?php
use App\Helpers\Base;
?>
<div id="recently-cars" class="small-box">
    <h2 class="orange fb"><a href="{{url_with_lng('/search', false)}}" class="dib">{{trans('www.recently_cars.title')}}</a></h2>
    @if($recentCars->isEmpty())
        <div class="no-cars tc">{{trans('www.no_cars')}}</div>
    @else
        <div class="car-block owl-carousel tc">
            @foreach($recentCars as $key => $auto)
                <div class="box-part">
                    <a href="{{url_with_lng('/auto/'.$auto->auto_id, false)}}" class="auto-item db fl{{$key%4 == 0 ? ' mln' : ''}}">
                        <span class="auto-img db" style="background-image: url('{{$auto->getThumb($autoEmpty)}}');">
                            <span class="favorite-icon fav-{{$auto->id}} db{{isset($favorites[$auto->id]) ? ' active' : ''}}" data-id="{{$auto->id}}"></span>
                            <span class="auto-price orange-bg tc db">
                                @if($auto->isContract())
                                    {{trans('www.auto.price.contract')}}
                                @elseif($auto->isAuction())
                                    {{trans('www.auto.price.auction')}}
                                @else
                                    {{Base::price($auto, $currencies, $defCurrency, $cCurrency)}}
                                @endif
                            </span>
                        </span>
                        <span class="auto-title db">{{$auto->mark->name.' '.$auto->model->name}}</span>
                        <span class="auto-info db">{{$auto->country_ml->name}}@if(!empty($auto->region_ml)), {{$auto->region_ml->name}}@endif</span>
                        <span class="auto-info db">{{$auto->mileageInfo()}} * {{$auto->year}}</span>
                    </a>
                </div>
            @endforeach
        </div>
    @endif
</div>