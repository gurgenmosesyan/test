<?php
use App\Models\Auto\Auto;
use App\Helpers\Base;
use App\Models\Config\Manager as ConfManager;
use App\Models\Ad\Manager as AdManager;

$meta->title(trans('www.homepage.title'), false);
$meta->description(trans('www.homepage.description'));
$meta->keywords(trans('www.homepage.keywords'));
$meta->ogTitle(trans('www.homepage.title'));
$meta->ogDescription(trans('www.homepage.description'));
$meta->ogImage(url('/images/fb-logo.png'));
$meta->ogUrl(url_with_lng('/'));

$head->appendStyle('/css/jquery-ui.min.css');
$head->appendStyle('/css/owl.carousel.css');
$head->appendScript('/js/jquery-ui.min.js');
$head->appendScript('/js/owl.carousel.min.js');

$autoEmpty = ConfManager::getAutoEmpty();
$thinBanners = AdManager::get('thin');
$bottomBanners = AdManager::get('bottom');

$jsTrans->addTrans([
    'www.tooltip.url.text',
    'www.tax.error'
]);
?>
@extends('layout')

@section('content')

<div class="page">

    @include('blocks.top_banner')

    @if($isMobile)
        @include('blocks.top_cars_mobile')
    @else
        @include('blocks.top_cars')
    @endif

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
        @if($isMobile)
            @include('blocks.urgent_cars_mobile')
        @else
            @include('blocks.urgent_cars')
        @endif
        <div class="banner tc">
            @if(isset($thinBanners[2]))
                @if(empty($thinBanners[2]->link))
                    <img src="{{$thinBanners[2]->getImage()}}" />
                @else
                    <a href="{{$thinBanners[2]->link}}" target="_blank"><img src="{{$thinBanners[2]->getImage()}}" /></a>
                @endif
            @endif
        </div>
        @if($isMobile)
            @include('blocks.recently_cars_mobile')
        @else
            @include('blocks.recently_cars')
        @endif
    </div>

    <div id="calculators" class="fl">
        <div id="parts-calculator" class="calc-box">
            <h2 class="fl fb">{{trans('www.parts_calculator.title')}}</h2>
            <div class="help fr" title="{{trans('www.parts_calculator.tooltip.text')}}"></div>
            <div class="cb"></div>
            <div class="mark-select fl">
                <div class="select-box">
                    <div class="select-arrow"></div>
                    <div class="select-title"></div>
                    <select name="mark" data-only_model="true">
                        <option value="">{{trans('www.calculator.mark.select.default')}}</option>
                        @foreach($marks as $value)
                            <option value="{{$value->id}}">{{$value->name}}</option>
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
                <p class="parts-price tr">--</p>
                <div class="cb"></div>
            </div>
            <div class="calc-price">
                <p class="calc-result fl">{{trans('www.calculator.service.text')}}</p>
                <p class="service-price tr">--</p>
                <div class="cb"></div>
            </div>
            <div class="calc-price fb">
                <p class="calc-result fl">{{trans('www.calculator.total.text')}}</p>
                <p class="total-price tr">--</p>
                <div class="cb"></div>
            </div>
        </div>
        <div id="tax-calculator" class="calc-box">
            <h2 class="fl fb">{{trans('www.tax_calculator.title')}}</h2>
            <div class="help fr" title="{{trans('www.tax_calculator.tooltip.text')}}"></div>
            <div class="cb"></div>
            <form id="tax-form" action="" method="post">
                <div class="mark-select fl">
                    <div class="select-box">
                        <div class="select-arrow"></div>
                        <div class="select-title"></div>
                        <select name="mark_id" data-only_model="true">
                            <option value="">{{trans('www.calculator.mark.select.default')}}</option>
                            @foreach($marks as $value)
                                <option value="{{$value->id}}">{{$value->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="model-select fl">
                    <div class="select-box disabled">
                        <div class="select-arrow"></div>
                        <div class="select-title"></div>
                        <select name="model_id" disabled="disabled">
                            <option value="">{{trans('www.calculator.model.select.default')}}</option>
                        </select>
                    </div>
                </div>
                <div class="cb"></div>
                <div class="select-box mb15">
                    <div class="select-arrow"></div>
                    <div class="select-title"></div>
                    <select name="year">
                        <option value="">{{trans('www.calculator.year.select.default')}}</option>
                        @for($i = date('Y'); $i > 1909; $i--)
                            <option value="{{$i}}">{{$i}}</option>
                        @endfor
                    </select>
                </div>
                <div class="select-box mb15">
                    <div class="select-arrow"></div>
                    <div class="select-title"></div>
                    <select name="engine_id" data-only_model="true">
                        <option value="">{{trans('www.engine.select.default')}}</option>
                        @foreach($engines as $value)
                            <option value="{{$value->id}}">{{$value->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="select-box mb25">
                    <div class="select-arrow"></div>
                    <div class="select-title"></div>
                    <select name="volume">
                        <option value="">{{trans('www.sell_car.engine_volume')}}</option>
                        <?php $i = 0.1; ?>
                        @while($i < 10.1)
                            <?php $i = number_format($i, 1, '.', '.'); ?>
                            <option value="{{$i}}">{{$i}}</option>
                            <?php $i += 0.1; ?>
                        @endwhile
                    </select>
                </div>
                {{csrf_field()}}
                <div class="submit">
                    <input type="submit" class="fb" value="{{trans('www.calculators.calculate')}}" />
                    <div class="form-error fs14"></div>
                </div>
            </form>
            <div class="calc-price">
                <p class="calc-result fl">{{trans('www.tax.price')}}</p>
                <p class="service-price price tr">--</p>
                <div class="cb"></div>
            </div>
            <div class="calc-price">
                <p class="calc-result fl">{{trans('www.tax.customs')}}</p>
                <p class="service-price customs tr">--</p>
                <div class="cb"></div>
            </div>
            <div class="calc-price">
                <p class="calc-result fl">{{trans('www.tax.nullification')}}</p>
                <p class="service-price nullification tr">--</p>
                <div class="cb"></div>
            </div>
            <div class="calc-price">
                <p class="calc-result fl">{{trans('www.tax.rename')}}</p>
                <p class="service-price rename tr">--</p>
                <div class="cb"></div>
            </div>
            <div class="calc-price">
                <p class="calc-result fl">{{trans('www.tax.passport')}}</p>
                <p class="service-price passport tr">--</p>
                <div class="cb"></div>
            </div>
            <div class="calc-price">
                <p class="calc-result fl">{{trans('www.tax.number')}}</p>
                <p class="service-price number tr">--</p>
                <div class="cb"></div>
            </div>
            <div class="calc-price fb">
                <p class="calc-result fl">{{trans('www.calculator.total.text')}}</p>
                <p class="service-price total tr">--</p>
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
    $(document).ready(function() {
        $main.initTopCars();
        $main.initUrgentCars();
        $main.initRecentlyCars();
        $main.initPriceRange();
        $main.initTooltip();
        $main.initParts();
        $main.initTaxCalc();
    });
</script>

@stop