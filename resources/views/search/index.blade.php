<?php
use App\Models\Auto\Auto;
use App\Helpers\Base;
use App\Models\Config\Manager;

$logo = Manager::getLogo();
$meta->title(trans('www.search.title'));
$meta->description(trans('www.search.description'));
$meta->keywords(trans('www.search.keywords'));
$meta->ogTitle(trans('www.search.title'));
$meta->ogDescription(trans('www.search.description'));
$meta->ogImage(url($logo));

$jsTrans->addTrans([
    'www.search.all_params',
    'www.search.all_params.hide',
]);

$autoEmpty = Manager::getAutoEmpty();
?>
@extends('layout')

@section('content')

<div class="page">

    @include('blocks.top_banner')

    <div id="main-left" class="fl">
        <div id="search">
        <form action="{{url_with_lng('/search', false)}}" method="get">
        <div class="col col-1 fl">
            <div class="mark-select select-box">
                <div class="select-arrow"></div>
                <div class="select-title"></div>
                <select name="mark_id">
                    <option value="">{{trans('www.mark.select.default')}}</option>
                    @foreach($marks as $value)
                        <option value="{{$value->id}}"{{$value->id == $reqData['mark_id'] ? ' selected="selected"' : ''}}>{{$value->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="select-box">
                <div class="select-arrow"></div>
                <div class="select-title"></div>
                <select name="transmission_id">
                    <option value="">{{trans('www.transmission.select.default')}}</option>
                    @foreach($transmissions as $value)
                        <option value="{{$value->id}}"{{$value->id == $reqData['transmission_id'] ? ' selected="selected"' : ''}}>{{$value->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="sub-col sub-col-1 fl">
                <div class="select-box">
                    <div class="select-arrow"></div>
                    <div class="select-title"></div>
                    <select name="year_from">
                        <option value="">{{trans('www.year_from')}}</option>
                        @for($i = date('Y'); $i > 1909; $i--)
                            <option value="{{$i}}"{{$i == $reqData['year_from'] ? ' selected="selected"' : ''}}>{{$i}}</option>
                        @endfor
                    </select>
                </div>
            </div>
            <div class="sub-col sub-col-2 fl">
                <div class="select-box">
                    <div class="select-arrow"></div>
                    <div class="select-title"></div>
                    <select name="year_to">
                        <option value="">{{trans('www.year_to')}}</option>
                        @for($i = date('Y'); $i > 1909; $i--)
                            <option value="{{$i}}"{{$i == $reqData['year_to'] ? ' selected="selected"' : ''}}>{{$i}}</option>
                        @endfor
                    </select>
                </div>
            </div>
            <div class="cb"></div>
        </div>
        <div class="col col-2 fl">
            <div class="model-select select-box{{empty($models) ? ' disabled' : ''}}">
                <div class="select-arrow"></div>
                <div class="select-title"></div>
                <select name="model_id"{{empty($models) ? ' disabled="disabled"' : ''}}>
                    <option value="">{{trans('www.model.select.default')}}</option>
                    @if(!empty($models))
                        @foreach($models as $value)
                            <option class="opt" value="{{$value['id']}}"{{$value['id'] == $reqData['model_id'] ? ' selected="selected"' : ''}}>{{$value['name']}}</option>
                        @endforeach
                    @endif
                </select>
            </div>
            <div class="sub-col sub-col-1 fl">
                <div class="select-box">
                    <div class="select-arrow"></div>
                    <div class="select-title"></div>
                    <select name="rudder_id">
                        <option value="">{{trans('www.rudder.select.default')}}</option>
                        @foreach($rudders as $value)
                            <option value="{{$value->id}}"{{$value->id == $reqData['rudder_id'] ? ' selected="selected"' : ''}}>{{$value->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="sub-col sub-col-2 fl">
                <div class="select-box">
                    <div class="select-arrow"></div>
                    <div class="select-title"></div>
                    <select name="engine_id">
                        <option value="">{{trans('www.engine.select.default')}}</option>
                        @foreach($engines as $value)
                            <option value="{{$value->id}}"{{$value->id == $reqData['engine_id'] ? ' selected="selected"' : ''}}>{{$value->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="cb"></div>
            <div class="mileage sub-col-1 fl">
                <input type="text" name="mileage_from" value="{{$reqData['mileage_from'] or ''}}" placeholder="{{trans('www.from')}}" />
            </div>
            <div class="mileage sub-col-1 fl">
                <input type="text" name="mileage_to" value="{{$reqData['mileage_to'] or ''}}" placeholder="{{trans('www.to')}}" />
            </div>
            <div class="mileage-measurement fl">
                <div class="select-box">
                    <div class="select-arrow"></div>
                    <div class="select-title"></div>
                    <select name="mileage_measurement">
                        <option value="{{Auto::MILEAGE_MEASUREMENT_KM}}"{{Auto::MILEAGE_MEASUREMENT_KM == $reqData['mileage_measurement'] ? ' selected="selected"' : ''}}>{{trans('www.mileage.measurement.km')}}</option>
                        <option value="{{Auto::MILEAGE_MEASUREMENT_MILE}}"{{Auto::MILEAGE_MEASUREMENT_MILE == $reqData['mileage_measurement'] ? ' selected="selected"' : ''}}>{{trans('www.mileage.measurement.mile')}}</option>
                    </select>
                </div>
            </div>
            <div class="cb"></div>
        </div>
        <div class="col col-3 fl">
            <div class="select-box">
                <div class="select-arrow"></div>
                <div class="select-title"></div>
                <select name="country_id">
                    <option value="">{{trans('www.country.select.default')}}</option>
                    @foreach($countries as $value)
                        <option value="{{$value->id}}"{{$value->id == $reqData['country_id'] ? ' selected="selected"' : ''}}>{{$value->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="sub-col sub-col-1 fl">
                <div class="select-box">
                    <div class="select-arrow"></div>
                    <div class="select-title"></div>
                    <select name="volume_from">
                        <option value="">{{trans('www.volume.from')}}</option>
                        @foreach(config('auto.engine_volumes') as $value)
                            <option value="{{$value}}"{{$value == $reqData['volume_from'] ? ' selected="selected"' : ''}}>{{$value}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="sub-col sub-col-2 fl">
                <div class="select-box">
                    <div class="select-arrow"></div>
                    <div class="select-title"></div>
                    <select name="volume_to">
                        <option value="">{{trans('www.volume.to')}}</option>
                        @foreach(config('auto.engine_volumes') as $value)
                            <option value="{{$value}}"{{$value == $reqData['volume_to'] ? ' selected="selected"' : ''}}>{{$value}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="cb"></div>
            <div class="sub-col sub-col-1 fl">
                <input type="text" name="price_from" value="{{$reqData['price_from'] or ''}}" placeholder="{{trans('www.price_from')}}" />
            </div>
            <div class="sub-col sub-col-2 fl">
                <input type="text" name="price_to" value="{{$reqData['price_to'] or ''}}" placeholder="{{trans('www.price_to')}}" />
            </div>
            <div class="cb"></div>
        </div>
        <div class="cb"></div>

        <div class="hidden{{$showAll ? '' : ' dpn'}}">
            <div class="col col-1 fl">
                <div class="sub-col sub-col-1 fl">
                    <div class="select-box">
                        <div class="select-arrow"></div>
                        <div class="select-title"></div>
                        <select name="body_id">
                            <option value="">{{trans('www.body.select.default')}}</option>
                            @foreach($bodies as $value)
                                <option value="{{$value->id}}"{{$value->id == $reqData['body_id'] ? ' selected="selected"' : ''}}>{{$value->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="sub-col sub-col-2 fl">
                    <div class="select-box">
                        <div class="select-arrow"></div>
                        <div class="select-title"></div>
                        <select name="train_id">
                            <option value="">{{trans('www.train.select.default')}}</option>
                            @foreach($trains as $value)
                                <option value="{{$value->id}}"{{$value->id == $reqData['train_id'] ? ' selected="selected"' : ''}}>{{$value->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="cb"></div>
                <div class="select-box">
                    <div class="select-arrow"></div>
                    <div class="select-title"></div>
                    <select name="cylinders">
                        <option value="">{{trans('www.cylinder_count.select.default')}}</option>
                        @foreach($cylindersCount as $value)
                            <option value="{{$value->count}}"{{$value->count == $reqData['cylinders'] ? ' selected="selected"' : ''}}>{{$value->count}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col col-2 fl">
                <div class="sub-col sub-col-1 fl">
                    <input type="text" name="horsepower_from" value="{{$reqData['horsepower_from'] or ''}}" placeholder="{{trans('www.horsepower.from')}}" />
                </div>
                <div class="sub-col sub-col-2 fl">
                    <input type="text" name="horsepower_to" value="{{$reqData['horsepower_to'] or ''}}" placeholder="{{trans('www.horsepower.to')}}" />
                </div>
                <div class="cb"></div>
                <div class="select-box">
                    <div class="select-arrow"></div>
                    <div class="select-title"></div>
                    <select name="doors">
                        <option value="">{{trans('www.door_count.select.default')}}</option>
                        @foreach($doorsCount as $value)
                            <option value="{{$value->count}}"{{$value->count == $reqData['doors'] ? ' selected="selected"' : ''}}>{{$value->count}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col col-3 fl">
                <div class="sub-col sub-col-1 fl">
                    <div class="select-box">
                        <div class="select-arrow"></div>
                        <div class="select-title"></div>
                        <select name="color_id">
                            <option value="">{{trans('www.color.select.default')}}</option>
                            @foreach($colors as $value)
                                <option value="{{$value->id}}"{{$value->id == $reqData['color_id'] ? ' selected="selected"' : ''}}>{{$value->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="sub-col sub-col-2 fl">
                    <div class="select-box">
                        <div class="select-arrow"></div>
                        <div class="select-title"></div>
                        <select name="interior_color_id">
                            <option value="">{{trans('www.interior_color.select.default')}}</option>
                            @foreach($interiorColors as $value)
                                <option value="{{$value->id}}"{{$value->id == $reqData['interior_color_id'] ? ' selected="selected"' : ''}}>{{$value->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="cb"></div>
                <div class="select-box">
                    <div class="select-arrow"></div>
                    <div class="select-title"></div>
                    <select name="wheels">
                        <option value="">{{trans('www.wheel.select.default')}}</option>
                        @foreach($wheels as $value)
                            <option value="{{$value->count}}"{{$value->count == $reqData['wheels'] ? ' selected="selected"' : ''}}>{{$value->count}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="cb"></div>
            <div class="checkboxes tc">
                <div class="checkbox dib">
                    <label class="checkbox-label no-select">
                        {{trans('www.checkbox.customs_cleared')}}
                        <input type="checkbox" name="custom_cleared" value="{{Auto::CUSTOM_CLEARED}}"{{Auto::CUSTOM_CLEARED == $reqData['custom_cleared'] ? 'checked="checked"' : ''}} />
                    </label>
                </div>
                <div class="checkbox dib">
                    <label class="checkbox-label no-select">
                        {{trans('www.checkbox.damaged')}}
                        <input type="checkbox" name="damaged" value="{{Auto::DAMAGED}}"{{Auto::DAMAGED == $reqData['damaged'] ? 'checked="checked"' : ''}} />
                    </label>
                </div>
                <div class="checkbox dib">
                    <label class="checkbox-label no-select">
                        {{trans('www.checkbox.partial_pay')}}
                        <input type="checkbox" name="partial_pay" value="{{Auto::PARTIAL_PAY}}"{{Auto::PARTIAL_PAY == $reqData['partial_pay'] ? 'checked="checked"' : ''}} />
                    </label>
                </div>
            </div>
        </div>
        <div>
            <div class="fr">
                <input type="submit" class="btn" value="{{trans('www.search.search_btn')}}" />
            </div>
            <p class="show-all-p tc"><a href="#" class="orange show-all underline">{{$showAll ? trans('www.search.all_params.hide') : trans('www.search.all_params')}}</a></p>
            <div class="cb"></div>
        </div>

        </form>
        </div>

        <div id="autos">
            @if($autos->isEmpty())
                <p class="empty tc">{{trans('www.autos.empty_result')}}</p>
            @else
                @foreach($autos as $key => $auto)
                    @if($key != 0)<div class="line"></div>@endif
                    <a href="{{url_with_lng('/auto/'.$auto->auto_id, false)}}" class="auto db">
                        <span class="auto-img db fl">
                            <img src="{{$auto->getThumb($autoEmpty)}}" width="205" />
                            <span class="favorite-icon fav-{{$auto->id}} db{{isset($favorites[$auto->id]) ? ' active' : ''}}" data-id="{{$auto->id}}"></span>
                        </span>
                        <span class="auto-info db fl">
                            <span class="title-box db fl">
                                <span class="title db fb">{{$auto->mark->name.' '.$auto->model->name}}</span>
                                <span class="details db">
                                    @if(!empty($auto->volume))
                                        {{number_format($auto->volume, 1)}}
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
                <?php
                if (!empty($reqData['mark_id'])) {
                    $autos->appends('mark_id', $reqData['mark_id']);
                }
                if (!empty($reqData['model_id'])) {
                    $autos->appends('model_id', $reqData['model_id']);
                }
                if (!empty($reqData['country_id'])) {
                    $autos->appends('country_id', $reqData['country_id']);
                }
                if (!empty($reqData['transmission_id'])) {
                    $autos->appends('transmission_id', $reqData['transmission_id']);
                }
                if (!empty($reqData['rudder_id'])) {
                    $autos->appends('rudder_id', $reqData['rudder_id']);
                }
                if (!empty($reqData['engine_id'])) {
                    $autos->appends('engine_id', $reqData['engine_id']);
                }
                if (!empty($reqData['volume_from'])) {
                    $autos->appends('volume_from', $reqData['volume_from']);
                }
                if (!empty($reqData['volume_to'])) {
                    $autos->appends('volume_to', $reqData['volume_to']);
                }
                if (!empty($reqData['year_from'])) {
                    $autos->appends('year_from', $reqData['year_from']);
                }
                if (!empty($reqData['year_to'])) {
                    $autos->appends('year_to', $reqData['year_to']);
                }
                if (!empty($reqData['body_id'])) {
                    $autos->appends('body_id', $reqData['body_id']);
                }
                if (!empty($reqData['train_id'])) {
                    $autos->appends('train_id', $reqData['train_id']);
                }
                if (!empty($reqData['horsepower_from'])) {
                    $autos->appends('horsepower_from', $reqData['horsepower_from']);
                }
                if (!empty($reqData['horsepower_to'])) {
                    $autos->appends('horsepower_to', $reqData['horsepower_to']);
                }
                if (!empty($reqData['color_id'])) {
                    $autos->appends('color_id', $reqData['color_id']);
                }
                if (!empty($reqData['interior_color_id'])) {
                    $autos->appends('color_id', $reqData['interior_color_id']);
                }
                if (!empty($reqData['cylinders'])) {
                    $autos->appends('cylinders', $reqData['cylinders']);
                }
                if (!empty($reqData['doors'])) {
                    $autos->appends('doors', $reqData['doors']);
                }
                if (!empty($reqData['wheels'])) {
                    $autos->appends('wheels', $reqData['wheels']);
                }
                if (!empty($reqData['custom_cleared'])) {
                    $autos->appends('custom_cleared', $reqData['custom_cleared']);
                }
                if (!empty($reqData['damaged'])) {
                    $autos->appends('damaged', $reqData['damaged']);
                }
                if (!empty($reqData['partial_pay'])) {
                    $autos->appends('partial_pay', $reqData['partial_pay']);
                }
                if (!empty($reqData['mileage_from'])) {
                    $autos->appends('mileage_from', $reqData['mileage_from']);
                }
                if (!empty($reqData['mileage_to'])) {
                    $autos->appends('mileage_to', $reqData['mileage_to']);
                }
                if (!empty($reqData['mileage_measurement'])) {
                    $autos->appends('mileage_measurement', $reqData['mileage_measurement']);
                }
                if (!empty($reqData['price_from'])) {
                    $autos->appends('price_from', $reqData['price_from']);
                }
                if (!empty($reqData['price_to'])) {
                    $autos->appends('price_to', $reqData['price_to']);
                }
                ?>
                @include('pagination.default', ['model' => $autos])
            @endif
        </div>

    </div>

    @include('blocks.right_banner')

    <div class="cb"></div>

</div>
<?php
$meta->ogUrl($autos->url($autos->currentPage()));
?>

@stop