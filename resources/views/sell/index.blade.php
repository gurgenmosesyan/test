<?php
use App\Models\Auto\Auto;

$head->appendScript('/js/sell.js');

$title = trans('www.sell_car.title');

$jsTrans->addTrans([
    'www.sell_car.submit',
    'www.sell_car.next'
]);
?>
@extends('layout')

@section('content')
<div class="page">
    <div id="sell">
        <form id="sell-form" action="{{url_with_lng('/api/sell', false)}}" method="post">

            <div id="page1" class="sell-page opened">
                <div class="form-box">
                    <label class="required fl"><span>{{trans('www.sell_car.mark')}}</span></label>
                    <div class="mark-select inp fl">
                        <div class="select-box">
                            <div class="select-arrow"></div>
                            <div class="select-title"></div>
                            <select name="mark_id" data-only_model="true">
                                <option value="">{{trans('www.base.label.select')}}</option>
                                @foreach($marks as $mark)
                                    <option value="{{$mark->id}}">{{$mark->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div id="form-error-mark_id" class="form-error"></div>
                    </div>
                    <div class="cb"></div>
                </div>
                <div class="form-box">
                    <label class="required fl"><span>{{trans('www.sell_car.model')}}</span></label>
                    <div class="model-select inp fl">
                        <div class="select-box disabled">
                            <div class="select-arrow"></div>
                            <div class="select-title"></div>
                            <select name="model_id" disabled="disabled">
                                <option value="">{{trans('www.base.label.select')}}</option>
                            </select>
                        </div>
                        <div id="form-error-model_id" class="form-error"></div>
                    </div>
                    <div class="cb"></div>
                </div>
                <div class="form-box">
                    <label class="required fl"><span>{{trans('www.sell_car.year')}}</span></label>
                    <div class="inp fl">
                        <div class="select-box">
                            <div class="select-arrow"></div>
                            <div class="select-title"></div>
                            <select name="year">
                                <option value="">{{trans('www.base.label.select')}}</option>
                                @for($i = date('Y')+2; $i > 1909; $i--)
                                    <option value="{{$i}}">{{$i}}</option>
                                @endfor
                            </select>
                        </div>
                        <div id="form-error-year" class="form-error"></div>
                    </div>
                    <div class="cb"></div>
                </div>
            </div>
            <div id="page2" class="sell-page">
                <div class="form-box">
                    <label class="required fl"><span>{{trans('www.sell_car.transmission')}}</span></label>
                    <div class="inp fl">
                        <div class="select-box">
                            <div class="select-arrow"></div>
                            <div class="select-title"></div>
                            <select name="transmission_id">
                                <option value="">{{trans('www.base.label.select')}}</option>
                                @foreach($transmissions as $transmission)
                                    <option value="{{$transmission->id}}">{{$transmission->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div id="form-error-transmission_id" class="form-error"></div>
                    </div>
                    <div class="cb"></div>
                </div>
                <div class="form-box">
                    <label class="required fl"><span>{{trans('www.sell_car.rudder')}}</span></label>
                    <div class="inp fl">
                        <div class="select-box">
                            <div class="select-arrow"></div>
                            <div class="select-title"></div>
                            <select name="rudder_id">
                                <option value="">{{trans('www.base.label.select')}}</option>
                                @foreach($rudders as $rudder)
                                    <option value="{{$rudder->id}}">{{$rudder->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div id="form-error-rudder_id" class="form-error"></div>
                    </div>
                    <div class="cb"></div>
                </div>
                <div class="form-box">
                    <label class="required fl"><span>{{trans('www.sell_car.body')}}</span></label>
                    <div class="inp fl">
                        <div class="select-box">
                            <div class="select-arrow"></div>
                            <div class="select-title"></div>
                            <select name="body_id">
                                <option value="">{{trans('www.base.label.select')}}</option>
                                @foreach($bodies as $body)
                                    <option value="{{$body->id}}">{{$body->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div id="form-error-body_id" class="form-error"></div>
                    </div>
                    <div class="cb"></div>
                </div>
                <div class="form-box">
                    <label class="fl"><span>{{trans('www.sell_car.tuning')}}</span></label>
                    <div class="inp fl">
                        <input type="text" name="tuning" value="" />
                        <div id="form-error-tuning" class="form-error"></div>
                    </div>
                    <div class="cb"></div>
                </div>
                <div class="form-box">
                    <label class="required fl"><span>{{trans('www.sell_car.color')}}</span></label>
                    <div class="inp fl">
                        <div class="select-box">
                            <div class="select-arrow"></div>
                            <div class="select-title"></div>
                            <select name="color_id">
                                <option value="">{{trans('www.base.label.select')}}</option>
                                @foreach($colors as $color)
                                    <option value="{{$color->id}}">{{$color->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div id="form-error-color_id" class="form-error"></div>
                    </div>
                    <div class="cb"></div>
                </div>
                <div class="form-box">
                    <label class="fl"><span>{{trans('www.sell_car.interior_color')}}</span></label>
                    <div class="inp fl">
                        <div class="select-box">
                            <div class="select-arrow"></div>
                            <div class="select-title"></div>
                            <select name="interior_color_id">
                                <option value="">{{trans('www.base.label.select')}}</option>
                                @foreach($interiorColors as $color)
                                    <option value="{{$color->id}}">{{$color->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div id="form-error-interior_color_id" class="form-error"></div>
                    </div>
                    <div class="cb"></div>
                </div>
            </div>
            <div id="page3" class="sell-page">
                <div class="form-box">
                    <label class="required fl"><span>{{trans('www.sell_car.engine')}}</span></label>
                    <div class="inp fl">
                        <div class="select-box">
                            <div class="select-arrow"></div>
                            <div class="select-title"></div>
                            <select name="engine_id">
                                <option value="">{{trans('www.base.label.select')}}</option>
                                @foreach($engines as $engine)
                                    <option value="{{$engine->id}}">{{$engine->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div id="form-error-engine_id" class="form-error"></div>
                    </div>
                    <div class="cb"></div>
                </div>
                <div class="form-box">
                    <label class="fl"><span>{{trans('www.sell_car.engine_volume')}}</span></label>
                    <div class="inp fl">
                        <div class="select-box">
                            <div class="select-arrow"></div>
                            <div class="select-title"></div>
                            <select name="volume">
                                <option value="">{{trans('www.base.label.select')}}</option>
                                <?php $i = 0.1; ?>
                                @while($i < 10.1)
                                    <?php $i = number_format($i, 1, '.', '.'); ?>
                                    <option value="{{$i}}">{{$i}}</option>
                                    <?php $i += 0.1; ?>
                                @endwhile
                            </select>
                        </div>
                        <div id="form-error-volume" class="form-error"></div>
                    </div>
                    <div class="cb"></div>
                </div>
                <div class="form-box">
                    <label class="fl"><span>{{trans('www.sell_car.horsepower')}}</span></label>
                    <div class="inp fl">
                        <input type="text" name="horsepower" maxlength="4" value="" />
                        <div id="form-error-horsepower" class="form-error"></div>
                    </div>
                    <div class="cb"></div>
                </div>
                <div class="form-box">
                    <label class="fl"><span>{{trans('www.sell_car.train')}}</span></label>
                    <div class="inp fl">
                        <div class="select-box">
                            <div class="select-arrow"></div>
                            <div class="select-title"></div>
                            <select name="train_id">
                                <option value="">{{trans('www.base.label.select')}}</option>
                                @foreach($trains as $train)
                                    <option value="{{$train->id}}">{{$train->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div id="form-error-train_id" class="form-error"></div>
                    </div>
                    <div class="cb"></div>
                </div>
                <div class="form-box">
                    <label class="fl"><span>{{trans('www.sell_car.cylinders_count')}}</span></label>
                    <div class="inp fl">
                        <div class="select-box">
                            <div class="select-arrow"></div>
                            <div class="select-title"></div>
                            <select name="cylinders">
                                <option value="">{{trans('www.base.label.select')}}</option>
                                @foreach($cylinders as $cylinder)
                                    <option value="{{$cylinder->count}}">{{$cylinder->count}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div id="form-error-cylinders" class="form-error"></div>
                    </div>
                    <div class="cb"></div>
                </div>
                <div class="form-box">
                    <label class="fl"><span>{{trans('www.sell_car.vin')}}</span></label>
                    <div class="inp fl">
                        <input type="text" name="vin" value="" />
                        <div id="form-error-vin" class="form-error"></div>
                    </div>
                    <div class="cb"></div>
                </div>
                <div class="form-box">
                    <label class="required fl"><span>{{trans('www.sell_car.mileage')}}</span></label>
                    <div class="mileage-box inp fl">
                        <div class="mileage-input fl">
                            <input type="text" name="mileage" value="" />
                            <div id="form-error-mileage" class="form-error"></div>
                        </div>
                        <div class="mileage-select fl">
                            <div class="select-box">
                                <div class="select-arrow"></div>
                                <div class="select-title"></div>
                                <select name="mileage_measurement">
                                    <option value="{{Auto::MILEAGE_MEASUREMENT_KM}}">{{trans('www.sell_car.mileage.measurement.'.Auto::MILEAGE_MEASUREMENT_KM)}}</option>
                                    <option value="{{Auto::MILEAGE_MEASUREMENT_MILE}}">{{trans('www.sell_car.mileage.measurement.'.Auto::MILEAGE_MEASUREMENT_MILE)}}</option>
                                </select>
                            </div>
                            <div id="form-error-mileage_measurement" class="form-error"></div>
                        </div>
                        <div class="cb"></div>
                    </div>
                    <div class="cb"></div>
                </div>
            </div>
            <div id="page4" class="sell-page">
                <div class="form-box">
                    <label class="required fl"><span>{{trans('www.sell_car.country')}}</span></label>
                    <div class="inp fl">
                        <div class="select-box country-select">
                            <div class="select-arrow"></div>
                            <div class="select-title"></div>
                            <select name="country_id">
                                <option value="">{{trans('www.base.label.select')}}</option>
                                @foreach($countries as $country)
                                    <option value="{{$country->id}}">{{$country->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div id="form-error-country_id" class="form-error"></div>
                    </div>
                    <div class="cb"></div>
                </div>
                <div class="form-box">
                    <label class="fl"><span>{{trans('www.sell_car.region')}}</span></label>
                    <div class="inp fl">
                        <div class="select-box disabled region-select">
                            <div class="select-arrow"></div>
                            <div class="select-title"></div>
                            <select name="region_id" disabled="disabled">
                                <option value="">{{trans('www.base.label.select')}}</option>
                            </select>
                        </div>
                        <div id="form-error-region_id" class="form-error"></div>
                    </div>
                    <div class="cb"></div>
                </div>
                <div class="form-box">
                    <label class="fl"><span>{{trans('www.sell_car.place')}}</span></label>
                    <div class="inp fl">
                        <input type="text" name="place" value="" />
                        <div id="form-error-place" class="form-error"></div>
                    </div>
                    <div class="cb"></div>
                </div>
            </div>
            <div id="page5" class="sell-page">
                <div class="form-box">
                    <label class="required fl"><span>{{trans('www.sell_car.term')}}</span></label>
                    <div class="inp fl">
                        <div class="select-box">
                            <div class="select-arrow"></div>
                            <div class="select-title"></div>
                            <select name="term">
                                <option value="">{{trans('www.base.label.select')}}</option>
                                @for($i = 10; $i > 0; $i--)
                                    <option value="{{$i}}">{{trans('www.sell_car.term.week', ['week' => $i])}}</option>
                                @endfor
                            </select>
                        </div>
                        <div id="form-error-term" class="form-error"></div>
                    </div>
                    <div class="cb"></div>
                </div>
                <div id="price-box" class="form-box">
                    <label class="required fl"><span>{{trans('www.sell_car.price')}}</span></label>
                    <div class="inp fl price">
                        <div class="mileage-input fl">
                            <input type="text" name="price" value="" />
                            <div id="form-error-price" class="form-error"></div>
                        </div>
                        <div class="mileage-select fl">
                            <div class="select-box">
                                <div class="select-arrow"></div>
                                <div class="select-title"></div>
                                <select name="currency_id">
                                    @foreach($currenciesData as $currency)
                                        <option value="{{$currency->id}}">{{$currency->code}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div id="form-error-currency_id" class="form-error"></div>
                        </div>
                        <div class="cb"></div>
                    </div>
                    <div class="cb"></div>
                </div>
                <div class="form-box">
                    <label class="fl"><span>{{trans('www.sell_car.additional_phone')}}</span></label>
                    <div class="inp fl">
                        <input type="text" name="additional_phone" value="" />
                        <div id="form-error-additional_phone" class="form-error"></div>
                    </div>
                    <div class="cb"></div>
                </div>
                <div class="col-2 fl">
                    <div class="form-box">
                        <label class="checkbox-label no-select">
                            {{trans('www.sell_car.contract')}}
                            <input type="checkbox" id="contract" name="contract" value="{{Auto::CONTRACT}}" />
                        </label>
                        <div id="form-error-contract" class="form-error"></div>
                    </div>
                    <div class="form-box">
                        <label class="checkbox-label no-select">
                            {{trans('www.sell_car.damaged')}}
                            <input type="checkbox" name="damaged" value="{{Auto::DAMAGED}}" />
                        </label>
                        <div id="form-error-damaged" class="form-error"></div>
                    </div>
                    <div class="form-box">
                        <label class="checkbox-label no-select">
                            {{trans('www.sell_car.partial_pay')}}
                            <input type="checkbox" name="partial_pay" value="{{Auto::PARTIAL_PAY}}" />
                        </label>
                        <div id="form-error-partial_pay" class="form-error"></div>
                    </div>
                    <div class="form-box">
                        <label class="checkbox-label no-select">
                            {{trans('www.sell_car.customs_cleared')}}
                            <input type="checkbox" name="custom_cleared" value="{{Auto::CUSTOM_CLEARED}}" />
                        </label>
                        <div id="form-error-custom_cleared" class="form-error"></div>
                    </div>
                </div>
                <div class="col-2 fl">
                    <div class="form-box">
                        <label class="checkbox-label no-select">
                            {{trans('www.sell_car.auction')}}
                            <input type="checkbox" id="auction" name="auction" value="{{Auto::AUCTION}}" />
                        </label>
                        <div id="form-error-auction" class="form-error"></div>
                    </div>
                    <div class="form-box">
                        <label class="checkbox-label no-select">
                            {{trans('www.sell_car.exchange')}}
                            <input type="checkbox" name="exchange" value="{{Auto::EXCHANGE}}" />
                        </label>
                    </div>
                    <div class="form-box">
                        <label class="checkbox-label no-select">
                            {{trans('www.sell_car.bank')}}
                            <input type="checkbox" name="bank" value="{{Auto::BANK}}" />
                        </label>
                        <div id="form-error-bank" class="form-error"></div>
                    </div>
                </div>
                <div class="cb"></div>
            </div>
            <div id="page6" class="sell-page">
                <?php
                if (!$options->isEmpty()) {
                $optionsCol1 = $optionsCol2 = $optionsCol3 = '';
                $i = 1;
                foreach($options as $key => $opt) {
                    $buffer =  '<div class="form-box">';
                    $buffer .=     '<label class="checkbox-label no-select">'.$opt->name;
                    $buffer .=         '<input type="checkbox" name="options[]" value="'.$opt->id.'" />';
                    $buffer .=     '</label>';
                    $buffer .=     '<div id="form-error-options_'.$key.'" class="form-error"></div>';
                    $buffer .= '</div>';
                    if ($i == 1) {
                        $optionsCol1 .= $buffer;
                    } else if ($i == 2) {
                        $optionsCol2 .= $buffer;
                    } else {
                        $optionsCol3 .= $buffer;
                        $i = 0;
                    }
                    $i++;
                }
                ?>
                <div class="col-2 fl">{!!$optionsCol1!!}</div>
                <div class="col-2 fl">{!!$optionsCol2!!}</div>
                <div class="col-2 fl">{!!$optionsCol3!!}</div>
                <div class="cb"></div>
                <?php } ?>
            </div>
            <div id="page7" class="sell-page">
                <div>
                    <a href="#" id="upload-image" class="btn dib">{{trans('www.sell_car.upload_image')}}</a>
                    <div class="dib dpn upload-load"></div>
                    <div id="form-error-images" class="form-error"></div>
                </div>
                <div id="sell-images"></div>
                <div class="cb"></div>

                <div class="form-box">
                    <label>{{trans('www.sell_car.description')}}</label>
                    <br />
                    <div class="description">
                        <textarea name="description"></textarea>
                        <div id="form-error-description" class="form-error"></div>
                    </div>
                    <div class="cb"></div>
                </div>
            </div>
            <div id="page-submit" class="sell-page tc">
                {{csrf_field()}}
                <div class="submit-box">
                    <input type="hidden" id="action" name="action" value="next" />
                    <div id="back-box" class="fl">
                        <a href="#" id="back" class="btn dib">{{trans('www.sell_car.back')}}</a>
                    </div>
                    <div class="fr">
                        <input type="submit" id="submit" class="btn" value="{{trans('www.sell_car.next')}}" />
                    </div>
                    <div class="cb"></div>
                </div>
            </div>
        </form>
    </div>
</div>
<script type="text/javascript">
    $sell.initPages();
</script>

@stop