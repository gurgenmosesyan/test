<?php
use App\Models\Auto\Auto;
use App\Helpers\Base;

$title = trans('www.homepage.title');
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
        <div class="car-block owl-carousel">
            <?php
            $topAutos = [];
            for ($i = 0; $i < 18; $i++) {
                $topAutos[] = [
                    'image' => '/images/temp/auto.jpg',
                    'price' => '2000000',
                    'currency_id' => '2',
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
                            <span class="auto-price orange-bg tc db">{{Base::price($auto, $currencies, $defCurrency, $cCurrency)}}</span>
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
            {{trans('www.quick_search.title')}}
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
                            <input type="checkbox" name="body" value="{{$body->id}}" />
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
                <a href="#" class="orange">{{trans('www.quick_search.advanced_search')}}</a>
            </p>

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

    <div id="homepage-left" class="fl">
        <div id="urgent-cars" class="small-box">
            <h2 class="orange fb"><span class="dib">{{trans('www.urgent_cars.title')}}</span></h2>
            <div class="help"><a href="#" class="db"></a></div>
            <div class="car-block owl-carousel">
                <?php
                $urgentAutos = [];
                for ($i = 0; $i < 32; $i++) {
                    $urgentAutos[] = [
                            'image' => '/images/temp/auto2.jpg',
                            'price' => '5000',
                            'currency_id' => '1',
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
                        @if(($key == 16) && isset($urgentAutos[$key+1]))
                            <div class="cb"></div>
                </div><div class="box-part">
                    @endif
                    <a href="#" class="auto-item db fl{{$key%4 == 0 ? ' mln' : ''}}">
                        <span class="auto-img db" style="background-image: url('{{$auto['image']}}');">
                            <span class="favorite-icon db"></span>
                            <span class="auto-price orange-bg tc db">{{Base::price($auto, $currencies, $defCurrency, $cCurrency)}}</span>
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
        <div class="banner tc">
            <a href="#">
                <img src="/images/temp/urgent-banner.jpg" />
            </a>
        </div>
        <div id="recently-cars" class="small-box">
            <h2 class="orange fb"><span class="dib">{{trans('www.recently_cars.title')}}</span></h2>
            <div class="car-block owl-carousel">
                <?php
                $recentlyCars = [];
                for ($i = 0; $i < 12; $i++) {
                    $recentlyCars[] = [
                            'image' => '/images/temp/auto2.jpg',
                            'price' => '250000',
                            'currency_id' => '3',
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
                    @foreach($recentlyCars as $key => $auto)
                        @if(($key == 4 || $key == 8) && isset($recentlyCars[$key+1]))
                            <div class="cb"></div>
                </div><div class="box-part">
                    @endif
                    <a href="#" class="auto-item db fl{{$key%4 == 0 ? ' mln' : ''}}">
                        <span class="auto-img db" style="background-image: url('{{$auto['image']}}');">
                            <span class="favorite-icon db"></span>
                            <span class="auto-price orange-bg tc db">{{Base::price($auto, $currencies, $defCurrency, $cCurrency)}}</span>
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

        <div class="home-right-ad">
            <img src="/images/temp/r-ad-1.jpg">
        </div>
    </div>
    <div class="cb"></div>

    <div class="home-ads">
        <img src="/images/temp/h-ads.png?v=1">
    </div>

</div>
<script type="text/javascript">
    $main.priceMax = {{$cCurrency['price_max']}};
    $main.priceFrom = {{$cCurrency['price_from']}};
    $main.priceTo = {{$cCurrency['price_to']}};
    $main.priceStep = {{$cCurrency['price_step']}};
</script>

@stop