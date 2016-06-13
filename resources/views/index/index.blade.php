<?php
use App\Models\Auto\Auto;

$title = trans('www.homepage.title');
$prices = config('autotrade.prices');
?>
@extends('layout')

@section('content')

<div class="page">
    <div id="top-banner" class="tc">
        <a href="#">
            <img src="/images/temp/top-banner.jpg" />
        </a>
    </div>

    <div id="top-cars" class="fl">
        <h2 class="orange fb"><span class="dib">{{trans('www.top_cars.title')}}</span></h2>
        <div class="help"><a href="#" class="db"></a></div>
        <div class="top-block owl-carousel">
            <?php
            $topAutos = [];
            for ($i = 0; $i < 18; $i++) {
                $topAutos[] = [
                    'image' => '/images/temp/auto.jpg',
                    'price' => '50000$',
                    'title' => 'Mercedes-Benz E63 AMG',
                    'country' => 'Armenia',
                    'region' => 'Yerevan',
                    'mileage' => '32000',
                    'mileage_measurement' => 'km',
                    'year' => 2015
                ];
            }
            ?>
            <div class="box-part">
                @foreach($topAutos as $key => $auto)
                    @if(($key == 6 || $key == 12) && isset($topAutos[$key+1]))
                        <div class="cb"></div>
                        </div><div class="box-part">
                    @endif
                    <a href="#" class="auto-item db fl{{$key%3 == 0 ? ' mln' : ''}}">
                        <span class="auto-img db" style="background-image: url('{{$auto['image']}}');">
                            <span class="favorite-icon db"></span>
                            <span class="auto-price orange-bg tc db">{{$auto['price']}}</span>
                        </span>
                        <span class="auto-title db">{{$auto['title']}}</span>
                        <span class="auto-info db">{{$auto['country']}}@if(!empty($auto['region'])), {{$auto['region']}}@endif</span>
                        <span class="auto-info db">{{number_format($auto['mileage'], 0, ',', '.')}} * {{$auto['year']}}</span>
                    </a>
                @endforeach
                <div class="cb"></div>
            </div>
        </div>
    </div>

    <div id="quick-search" class="fl">
        <h2>
            {{trans('www.quick_search.title')}} <span>{{trans('www.quick_search.or')}}</span>
            <a href="#" class="orange">{{trans('www.quick_search.advanced_search')}}</a>
        </h2>
        <form id="quick-search-form" action="" method="get">
            <div class="country-select">
                <div class="select-box">
                    <div class="select-arrow"></div>
                    <div class="select-title"></div>
                    <select name="country">
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
                    <select name="mark">
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
                    <select name="model" disabled="disabled">
                        <option value="">{{trans('www.model.select.default')}}</option>
                    </select>
                </div>
            </div>
            <div id="price-range-box">
                <div class="price-text-box">
                    <span class="price-text">{{trans('www.price_range.text')}}</span>
                    <span class="price-from-text">{{$prices['price_from']}}</span>$ -
                    <span class="price-to-text">{{$prices['price_to']}}</span>$
                </div>
                <input type="hidden" name="price_from" class="price-from" value="{{$prices['price_from']}}" />
                <input type="hidden" name="price_to" class="price-to" value="{{$prices['price_to']}}" />
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
                    <span class="ch-icon"></span>
                    <span class="ch-title">{{trans('www.checkbox.customs_cleared')}}</span>
                    <input type="checkbox" name="custom_cleared" value="{{Auto::CUSTOM_CLEARED}}" />
                </label>
            </div>
            <div class="damaged fl">
                <label class="checkbox-label no-select">
                    <span class="ch-icon"></span>
                    <span class="ch-title">{{trans('www.checkbox.damaged')}}</span>
                    <input type="checkbox" name="damaged" value="{{Auto::DAMAGED}}" />
                </label>
            </div>
            <div class="cb"></div>
            <div class="partial-pay">
                <label class="checkbox-label no-select">
                    <span class="ch-icon"></span>
                    <span class="ch-title">{{trans('www.checkbox.partial_pay')}}</span>
                    <input type="checkbox" name="partial_pay" value="{{Auto::PARTIAL_PAY}}" />
                </label>
            </div>
            <div class="search-bodies">
                @foreach($bodies as $key => $body)
                    <div class="search-body search-body-{{$key}} fl">
                        <label class="checkbox-label body-label" style="background-image: url('{{$body->getImage()}}');">
                            <input type="radio" name="body" value="{{$body->id}}" />
                        </label>
                    </div>
                @endforeach
                <div class="cb"></div>
            </div>
            <div class="submit tc">
                <div class="dib fb">{{trans('www.search.btn')}}</div>
                <input type="submit" />
            </div>

        </form>
    </div>
    <div class="cb"></div>

    <div id="mid-banners">
        <div class="mid-banner fl tc">
            <a href="#">
                <img src="/images/temp/banner2.jpg" />
            </a>
        </div>
        <div class="mid-banner fl tc">
            <a href="#">
                <img src="/images/temp/banner3.jpg" />
            </a>
        </div>
        <div class="cb"></div>
    </div>

    <div id="urgent-cars" class="fl">
        <h2 class="orange fb"><span class="dib">{{trans('www.urgent_cars.title')}}</span></h2>
        <div class="help"><a href="#" class="db"></a></div>
        <div class="top-block owl-carousel">
            <?php
            $urgentAutos = [];
            for ($i = 0; $i < 31; $i++) {
                $urgentAutos[] = [
                        'image' => '/images/temp/auto2.jpg',
                        'price' => '50000$',
                        'title' => 'Mercedes-Benz E63 AMG',
                        'country' => 'Russia',
                        'region' => 'St. Peterburg',
                        'mileage' => '32000',
                        'mileage_measurement' => 'km',
                        'year' => 2015
                ];
            }
            ?>
            <div class="box-part">
                @foreach($urgentAutos as $key => $auto)
                    @if(($key == 6 || $key == 12) && isset($topAutos[$key+1]))
                        <div class="cb"></div>
                        </div><div class="box-part">
                @endif
                <a href="#" class="auto-item db fl{{$key%3 == 0 ? ' mln' : ''}}">
                        <span class="auto-img db" style="background-image: url('{{$auto['image']}}');">
                            <span class="favorite-icon db"></span>
                            <span class="auto-price orange-bg tc db">{{$auto['price']}}</span>
                        </span>
                    <span class="auto-title db">{{$auto['title']}}</span>
                    <span class="auto-info db">{{$auto['country']}}@if(!empty($auto['region'])), {{$auto['region']}}@endif</span>
                    <span class="auto-info db">{{number_format($auto['mileage'], 0, ',', '.')}} * {{$auto['year']}}</span>
                </a>
                @endforeach
                <div class="cb"></div>
            </div>
        </div>
    </div>

    <div id="calculators" class="fl">
        <div id="parts-calculator">

        </div>
        <div id="tax-calculator"></div>
    </div>
    <div class="cb"></div>

</div>
<script type="text/javascript">
    $main.priceFrom = {{$prices['price_from']}};
    $main.priceTo = {{$prices['price_to']}};
    $main.priceMax = {{$prices['price_max']}};
</script>

@stop