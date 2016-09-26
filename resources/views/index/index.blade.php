<?php
use App\Models\Auto\Auto;
use App\Helpers\Base;
use App\Models\Config\Manager as ConfManager;
use App\Models\Ad\Manager as AdManager;

$title = trans('www.homepage.title');

$autoEmpty = ConfManager::getAutoEmpty();
$thinBanners = AdManager::get('thin');
$bottomBanners = AdManager::get('bottom');
?>
@extends('layout')

@section('content')

<div class="page">

    @include('blocks.top_banner')

    <div id="top-cars" class="fl">
        <h2 class="orange fb"><span class="dib">{{trans('www.top_cars.title')}}</span></h2>
        <div class="help"><a href="#" class="db"></a></div>
        @if($topCars->isEmpty())
            <div class="no-cars tc">{{trans('www.no_cars')}}</div>
        @else
            <div class="car-block owl-carousel">
                <div class="box-part">
                    @foreach($topCars->shuffle()->slice(0, 18) as $key => $value)
                        <?php $auto = $value->auto; ?>
                        @if(($key == 6 || $key == 12) && isset($topCars[$key+1]))
                            <div class="cb"></div>
                            </div><div class="box-part">
                        @endif
                        <a href="{{url_with_lng('/auto/'.$auto->auto_id, false)}}" class="auto-item db fl{{$key%3 == 0 ? ' mln' : ''}}">
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

    <div id="quick-search" class="fl">
        <h2>
            {{trans('www.quick_search.title')}}
        </h2>
        <form id="quick-search-form" action="{{url_with_lng('/search', false)}}" method="get">
            <div class="country-select">
                <div class="select-box">
                    <div class="select-arrow"></div>
                    <div class="select-title"></div>
                    <select name="country_id">
                        <option value="">{{trans('www.country.select.default')}}</option>
                        @foreach($countries as $country)
                            <option value="{{$country->id}}">{{$country->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="mark-select">
                <div class="select-box">
                    <div class="select-arrow"></div>
                    <div class="select-title"></div>
                    <select name="mark_id">
                        <option value="">{{trans('www.mark.select.default')}}</option>
                        @foreach($marks as $mark)
                            <option value="{{$mark->id}}">{{$mark->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="model-select">
                <div class="select-box disabled">
                    <div class="select-arrow"></div>
                    <div class="select-title"></div>
                    <select name="model_id" disabled="disabled">
                        <option value="">{{trans('www.model.select.default')}}</option>
                    </select>
                </div>
            </div>
            <div id="price-range-box">
                <div class="price-text-box">
                    <span class="price-text">{{trans('www.price_range.text')}}</span>
                    <span class="price-from-text">{{$cCurrency['price_from']}}</span>{{$cCurrency['sign']}} -
                    <span class="price-to-text">{{$cCurrency['price_to']}}</span>{{$cCurrency['sign']}}
                </div>
                <input type="hidden" name="price_from" class="price-from" value="{{$cCurrency['price_from']}}" />
                <input type="hidden" name="price_to" class="price-to" value="{{$cCurrency['price_to']}}" />
                <div id="price-range"></div>
            </div>
            <div class="year-from-select fl">
                <div class="select-box">
                    <div class="select-arrow"></div>
                    <div class="select-title"></div>
                    <select name="year_from">
                        <option value="">{{trans('www.year_from')}}</option>
                        @for($i = date('Y'); $i > 1909; $i--)
                            <option value="{{$i}}">{{$i}}</option>
                        @endfor
                    </select>
                </div>
            </div>
            <div class="year-to-select fl">
                <div class="select-box">
                    <div class="select-arrow"></div>
                    <div class="select-title"></div>
                    <select name="year_to">
                        <option value="">{{trans('www.year_to')}}</option>
                        @for($i = date('Y'); $i > 1909; $i--)
                            <option value="{{$i}}">{{$i}}</option>
                        @endfor
                    </select>
                </div>
            </div>
            <div class="cb"></div>

            <div class="custom-cleared fl">
                <label class="checkbox-label no-select">
                    {{trans('www.checkbox.customs_cleared')}}
                    <input type="checkbox" name="custom_cleared" value="{{Auto::CUSTOM_CLEARED}}" />
                </label>
            </div>
            <div class="damaged fl">
                <label class="checkbox-label no-select">
                    {{trans('www.checkbox.damaged')}}
                    <input type="checkbox" name="damaged" value="{{Auto::DAMAGED}}" />
                </label>
            </div>
            <div class="cb"></div>
            <div class="partial-pay">
                <label class="checkbox-label no-select">
                    {{trans('www.checkbox.partial_pay')}}
                    <input type="checkbox" name="partial_pay" value="{{Auto::PARTIAL_PAY}}" />
                </label>
            </div>
            <div class="search-bodies">
                @foreach($bodies as $key => $body)
                    <div class="search-body no-select search-body-{{$key}} fl">
                        <label class="body-checkbox db" style="background-image: url('{{$body->getImage()}}');">
                            <input type="checkbox" name="body_id" value="{{$body->id}}" />
                        </label>
                    </div>
                @endforeach
                <div class="cb"></div>
            </div>
            <div class="submit tc">
                <div class="dib fb">{{trans('www.search.btn')}}</div>
                <input type="submit" />
            </div>
            <p class="adv-search-link tc">
                <a href="{{url_with_lng('/search', false)}}" class="orange">{{trans('www.quick_search.advanced_search')}}</a>
            </p>

        </form>
    </div>
    <div class="cb"></div>

    <div id="mid-banners">
        @foreach($thinBanners->slice(0, 2) as $value)
            <div class="mid-banner fl tc">
                @if(empty($value->link))
                    <img src="{{$value->getImage()}}" />
                @else
                    <a href="{{$value->link}}" target="_blank"><img src="{{$value->getImage()}}" /></a>
                @endif
            </div>
        @endforeach
        <div class="cb"></div>
    </div>

    <div id="homepage-left" class="fl">
        <div id="urgent-cars" class="small-box">
            <h2 class="orange fb"><span class="dib">{{trans('www.urgent_cars.title')}}</span></h2>
            <div class="help"><a href="#" class="db"></a></div>
            @if($urgentCars->isEmpty())
                <div class="no-cars tc">{{trans('www.no_cars')}}</div>
            @else
                <div class="car-block owl-carousel">
                    <div class="box-part">
                        @foreach($urgentCars->shuffle()->slice(0, 32) as $key => $value)
                            <?php $auto = $value->auto; ?>
                            @if(($key == 16) && isset($urgentCars[$key+1]))
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
        <div class="banner tc">
            @if(isset($thinBanners[2]))
                @if(empty($thinBanners[2]->link))
                    <img src="{{$thinBanners[2]->getImage()}}" />
                @else
                    <a href="{{$thinBanners[2]->link}}" target="_blank"><img src="{{$thinBanners[2]->getImage()}}" /></a>
                @endif
            @endif
        </div>
        <div id="recently-cars" class="small-box">
            <h2 class="orange fb"><span class="dib">{{trans('www.recently_cars.title')}}</span></h2>
            @if($recentCars->isEmpty())
                <div class="no-cars tc">{{trans('www.no_cars')}}</div>
            @else
                <div class="car-block owl-carousel">
                    <div class="box-part">
                        @foreach($recentCars as $key => $auto)
                            @if(($key == 4 || $key == 8) && isset($recentCars[$key+1]))
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
    </div>

    <div id="calculators" class="fl">
        <div id="parts-calculator" class="calc-box">
            <h2 class="fl fb">{{trans('www.parts_calculator.title')}}</h2>
            <div class="help fr"><a href="#" class="db"></a></div>
            <div class="cb"></div>
            <div class="mark-select fl">
                <div class="select-box">
                    <div class="select-arrow"></div>
                    <div class="select-title"></div>
                    <select name="mark" data-only_model="true">
                        <option value="">{{trans('www.calculator.mark.select.default')}}</option>
                        @foreach($marks as $mark)
                            <option value="{{$mark->id}}">{{$mark->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="model-select fl">
                <div class="select-box disabled">
                    <div class="select-arrow"></div>
                    <div class="select-title"></div>
                    <select name="model" disabled="disabled">
                        <option value="">{{trans('www.calculator.model.select.default')}}</option>
                    </select>
                </div>
            </div>
            <div class="cb"></div>
            <div class="parts-block">
                <div class="parts-loader dpn"></div>
                <div class="parts-checkboxes">
                    @for($i = 1; $i < 11; $i++)
                        <div class="part-checkbox">
                            <label class="checkbox-label no-select disabled">
                                {{trans('www.part.form.part'.$i)}}
                                <input type="checkbox" value="1" disabled="disabled" />
                            </label>
                        </div>
                    @endfor
                </div>
            </div>
            <div class="calc-price">
                <p class="calc-result fl">{{trans('www.calculator.parts.text')}}</p>
                <p class="parts-price fr">--</p>
                <div class="cb"></div>
            </div>
            <div class="calc-price">
                <p class="calc-result fl">{{trans('www.calculator.service.text')}}</p>
                <p class="service-price fr">--</p>
                <div class="cb"></div>
            </div>
            <div class="calc-price fb">
                <p class="calc-result fl">{{trans('www.calculator.total.text')}}</p>
                <p class="total-price fr">--</p>
                <div class="cb"></div>
            </div>
        </div>
        <div id="tax-calculator" class="calc-box">
            <h2 class="fl fb">{{trans('www.tax_calculator.title')}}</h2>
            <div class="help fr"><a href="#" class="db"></a></div>
            <div class="cb"></div>
            <form id="tax-form" action="" method="post">
                <div class="price-box">
                    <input type="text" placeholder="{{trans('www.calculator.price.placeholder')}}" />
                </div>
                <div class="year-select">
                    <div class="select-box">
                        <div class="select-arrow"></div>
                        <div class="select-title"></div>
                        <select name="year">
                            <option value="">{{trans('www.calculator.year.select.default')}}</option>
                            @for($i = date('Y'); $i > 1909; $i--)
                                <option value="{{$i}}">{{$i}}</option>
                            @endfor
                        </select>
                    </div>
                </div>
                <div class="submit">
                    <input type="submit" class="fb" value="{{trans('www.calculators.calculate')}}" />
                </div>
            </form>
            <div class="calc-price">
                <p class="calc-result fl">{{trans('www.calculator.tax.text')}}</p>
                <p class="service-price fr">--</p>
                <div class="cb"></div>
            </div>
            <div class="calc-price">
                <p class="calc-result fl">{{trans('www.calculator.vat.text')}}</p>
                <p class="service-price fr">--</p>
                <div class="cb"></div>
            </div>
            <div class="calc-price">
                <p class="calc-result fl">{{trans('www.calculator.ecology.text')}}</p>
                <p class="service-price fr">--</p>
                <div class="cb"></div>
            </div>
            <div class="calc-price fb">
                <p class="calc-result fl">{{trans('www.calculator.total.text')}}</p>
                <p class="total-price fr">--</p>
                <div class="cb"></div>
            </div>
        </div>

        @include('blocks.right_banner')

    </div>
    <div class="cb"></div>

    <div id="bottom-govs">
        @foreach($bottomBanners->slice(0, 4) as $key => $value)
            <div class="bottom-gov fl bottom-gov-{{$key}}">
                @if(empty($value->link))
                    <img src="{{$value->getImage()}}" />
                @else
                    <a href="{{$value->link}}" target="_blank"><img src="{{$value->getImage()}}" /></a>
                @endif
            </div>
        @endforeach
        <div class="cb"></div>
    </div>

</div>
<script type="text/javascript">
    $main.priceMax = {{$cCurrency['price_max']}};
    $main.priceFrom = {{$cCurrency['price_from']}};
    $main.priceTo = {{$cCurrency['price_to']}};
    $main.priceStep = {{$cCurrency['price_step']}};
</script>

@stop