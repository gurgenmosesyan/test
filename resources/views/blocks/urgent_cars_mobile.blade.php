<?php
use App\Helpers\Base;

$delimiters = [4=>4, 8=>8, 12=>12, 16=>16, 20=>20, 24=>24, 28=>28];
?>
<div id="urgent-cars" class="small-box">
    <h2 class="orange fb"><a href="{{url_with_lng('/urgent-cars', false)}}" class="dib">{{trans('www.urgent_cars.title')}}</a></h2>
    <div class="help" title="{{trans('www.urgent_cars.tooltip.text')}}" data-url="#"></div>
    @if($urgentCars->isEmpty())
        <div class="no-cars tc">{{trans('www.no_cars')}}</div>
    @else
        <div class="car-block owl-carousel tc">
            <div class="box-part">
                @foreach($urgentCars->shuffle()->slice(0, 32) as $key => $value)
                    <?php $auto = $value->auto; ?>
                    @if(isset($delimiters[$key]) && isset($urgentCars[$key]))
                        <div class="cb"></div>
                        </div><div class="box-part">
                    @endif
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
                @endforeach
                <div class="cb"></div>
            </div>
        </div>
    @endif
</div>