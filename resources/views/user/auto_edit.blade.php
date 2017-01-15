<?php
use App\Models\Auto\Auto;

$head->appendScript('/js/sell.js');
$head->appendScript('/js/user.js');

$title = trans('www.base.label.edit');

$meta->title($title);
$meta->ogTitle($title);
$meta->ogImage(url('/images/fb-logo.png'));

$autoOptions = $auto->options->keyBy('option_id');

$user = Auth::guard('user')->user();

$jsTrans->addTrans(['www.auto.images.limit.text']);
?>
@extends('layout')

@section('content')
<script type="text/javascript">
    $sell.images = <?php echo json_encode($auto->images); ?>;
    $sell.defImgSrc = '{{$auto->image}}';
</script>
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
                <a href="{{url_with_lng('/profile/autos', false)}}" class="item db fb active">
                    <span class="icon dib"></span>
                    <span class="text dib">{{trans('www.profile.link.my_cars')}}</span>
                </a>
            </div>
            <div class="link ads-link fl">
                <a href="#" class="item db fb">
                    <span class="icon dib"></span>
                    <span class="text dib">{{trans('www.profile.link.my_ads')}}</span>
                </a>
            </div>
            <div class="cb"></div>
        </div>
    </div>

    <div id="sell">
        @if($auto->isBlocked())
            <p class="status fb">{{trans('www.auto.status.blocked')}}</p>
        @endif
        <form id="auto-edit-form" action="{{url_with_lng('/profile/auto/'.$auto->id, false)}}" method="post">
            <div class="col-2 sell-left fl">

                <div class="form-box">
                    <label class="required fl"><span>{{trans('www.sell_car.mark')}}</span></label>
                    <div class="mark-select inp fl">
                        <div class="select-box">
                            <div class="select-arrow"></div>
                            <div class="select-title"></div>
                            <select name="mark_id" data-only_model="true">
                                <option value="">{{trans('www.base.label.select')}}</option>
                                @foreach($marks as $value)
                                    <option value="{{$value->id}}"{{$value->id == $auto->mark_id ? ' selected="selected"' : ''}}>{{$value->name}}</option>
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
                        <div class="select-box">
                            <div class="select-arrow"></div>
                            <div class="select-title"></div>
                            <select name="model_id">
                                <option value="">{{trans('www.base.label.select')}}</option>
                                @foreach($models as $value)
                                    <option class="opt" value="{{$value->id}}"{{$value->id == $auto->model_id ? ' selected="selected"' : ''}}>{{$value->name}}</option>
                                @endforeach
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
                                    <option value="{{$i}}"{{$i == $auto->year ? ' selected="selected"' : ''}}>{{$i}}</option>
                                @endfor
                            </select>
                        </div>
                        <div id="form-error-year" class="form-error"></div>
                    </div>
                    <div class="cb"></div>
                </div>
                <div class="form-box">
                    <label class="required fl"><span>{{trans('www.sell_car.transmission')}}</span></label>
                    <div class="inp fl">
                        <div class="select-box">
                            <div class="select-arrow"></div>
                            <div class="select-title"></div>
                            <select name="transmission_id">
                                <option value="">{{trans('www.base.label.select')}}</option>
                                @foreach($transmissions as $value)
                                    <option value="{{$value->id}}"{{$value->id == $auto->transmission_id ? ' selected="selected"' : ''}}>{{$value->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div id="form-error-transmission_id" class="form-error"></div>
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
                                @foreach($colors as $value)
                                    <option value="{{$value->id}}"{{$value->id == $auto->color_id ? ' selected="selected"' : ''}}>{{$value->name}}</option>
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
                                @foreach($interiorColors as $value)
                                    <option value="{{$value->id}}"{{$value->id == $auto->interior_color_id ? ' selected="selected"' : ''}}>{{$value->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div id="form-error-interior_color_id" class="form-error"></div>
                    </div>
                    <div class="cb"></div>
                </div>
                <div class="form-box">
                    <label class="required fl"><span>{{trans('www.sell_car.engine')}}</span></label>
                    <div class="inp fl">
                        <div class="select-box">
                            <div class="select-arrow"></div>
                            <div class="select-title"></div>
                            <select name="engine_id">
                                <option value="">{{trans('www.base.label.select')}}</option>
                                @foreach($engines as $value)
                                    <option value="{{$value->id}}"{{$value->id == $auto->engine_id ? ' selected="selected"' : ''}}>{{$value->name}}</option>
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
                                    <option value="{{$i}}"{{$i == $auto->volume ? ' selected="selected"' : ''}}>{{$i}}</option>
                                    <?php $i += 0.1; ?>
                                @endwhile
                            </select>
                        </div>
                        <div id="form-error-volume" class="form-error"></div>
                    </div>
                    <div class="cb"></div>
                </div>
                <div class="form-box">
                    <label class="required fl"><span>{{trans('www.sell_car.country')}}</span></label>
                    <div class="inp fl">
                        <div class="select-box country-select">
                            <div class="select-arrow"></div>
                            <div class="select-title"></div>
                            <select name="country_id">
                                <option value="">{{trans('www.base.label.select')}}</option>
                                @foreach($countries as $value)
                                    <option value="{{$value->id}}"{{$value->id == $auto->country_id ? ' selected="selected"' : ''}}>{{$value->name}}</option>
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
                        <div class="select-box region-select">
                            <div class="select-arrow"></div>
                            <div class="select-title"></div>
                            <select name="region_id">
                                <option value="">{{trans('www.base.label.select')}}</option>
                                @foreach($regions as $value)
                                    <option class="opt" value="{{$value->id}}"{{$value->id == $auto->region_id ? ' selected="selected"' : ''}}>{{$value->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div id="form-error-region_id" class="form-error"></div>
                    </div>
                    <div class="cb"></div>
                </div>
                <div class="form-box">
                    <label class="fl"><span>{{trans('www.sell_car.place')}}</span></label>
                    <div class="inp fl">
                        <input type="text" name="place" value="{{$auto->place or ''}}" />
                        <div id="form-error-place" class="form-error"></div>
                    </div>
                    <div class="cb"></div>
                </div>
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
                        <div class="mt5">{{date('d.m.Y', strtotime($auto->term))}}</div>
                    </div>
                    <div class="cb"></div>
                </div>

            </div>
            <div class="col-2 sell-right fl">

                <div class="form-box">
                    <label class="required fl"><span>{{trans('www.sell_car.body')}}</span></label>
                    <div class="inp fl">
                        <div class="select-box">
                            <div class="select-arrow"></div>
                            <div class="select-title"></div>
                            <select name="body_id">
                                <option value="">{{trans('www.base.label.select')}}</option>
                                @foreach($bodies as $value)
                                    <option value="{{$value->id}}"{{$value->id == $auto->body_id ? ' selected="selected"' : ''}}>{{$value->name}}</option>
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
                        <input type="text" name="tuning" value="{{$auto->tuning or ''}}" />
                        <div id="form-error-tuning" class="form-error"></div>
                    </div>
                    <div class="cb"></div>
                </div>
                <div class="form-box">
                    <label class="required fl"><span>{{trans('www.sell_car.mileage')}}</span></label>
                    <div class="mileage-box inp fl">
                        <div class="mileage-input fl">
                            <input type="text" name="mileage" class="number" value="{{$auto->mileageInfo(false)}}" />
                            <div id="form-error-mileage" class="form-error"></div>
                        </div>
                        <div class="mileage-select fl">
                            <div class="select-box">
                                <div class="select-arrow"></div>
                                <div class="select-title"></div>
                                <select name="mileage_measurement">
                                    <option value="{{Auto::MILEAGE_MEASUREMENT_KM}}"{{$auto->mileage_measurement == Auto::MILEAGE_MEASUREMENT_KM ? ' selected="selected"' : ''}}>{{trans('www.sell_car.mileage.measurement.'.Auto::MILEAGE_MEASUREMENT_KM)}}</option>
                                    <option value="{{Auto::MILEAGE_MEASUREMENT_MILE}}"{{$auto->mileage_measurement == Auto::MILEAGE_MEASUREMENT_MILE ? ' selected="selected"' : ''}}>{{trans('www.sell_car.mileage.measurement.'.Auto::MILEAGE_MEASUREMENT_MILE)}}</option>
                                </select>
                            </div>
                            <div id="form-error-mileage_measurement" class="form-error"></div>
                        </div>
                        <div class="cb"></div>
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
                                @foreach($rudders as $value)
                                    <option value="{{$value->id}}"{{$value->id == $auto->rudder_id ? ' selected="selected"' : ''}}>{{$value->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div id="form-error-rudder_id" class="form-error"></div>
                    </div>
                    <div class="cb"></div>
                </div>
                <div class="form-box">
                    <label class="fl"><span>{{trans('www.sell_car.horsepower')}}</span></label>
                    <div class="inp fl">
                        <input type="text" name="horsepower" class="number" maxlength="4" value="{{$auto->horsepower or ''}}" />
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
                                @foreach($trains as $value)
                                    <option value="{{$value->id}}"{{$value->id == $auto->train_id ? ' selected="selected"' : ''}}>{{$value->name}}</option>
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
                                @foreach($cylinders as $value)
                                    <option value="{{$value->count}}"{{$value->count == $auto->cylinders ? ' selected="selected"' : ''}}>{{$value->count}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div id="form-error-cylinders" class="form-error"></div>
                    </div>
                    <div class="cb"></div>
                </div>
                <div class="form-box">
                    <label class="fl"><span>{{trans('www.sell_car.doors_count')}}</span></label>
                    <div class="inp fl">
                        <div class="select-box">
                            <div class="select-arrow"></div>
                            <div class="select-title"></div>
                            <select name="doors">
                                <option value="">{{trans('www.base.label.select')}}</option>
                                @foreach($doors as $value)
                                    <option value="{{$value->count}}"{{$value->count == $auto->doors ? ' selected="selected"' : ''}}>{{$value->count}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div id="form-error-doors" class="form-error"></div>
                    </div>
                    <div class="cb"></div>
                </div>
                <div class="form-box">
                    <label class="fl"><span>{{trans('www.sell_car.vin')}}</span></label>
                    <div class="inp fl">
                        <input type="text" name="vin" value="{{$auto->vin or ''}}" />
                        <div id="form-error-vin" class="form-error"></div>
                    </div>
                    <div class="cb"></div>
                </div>
                <div class="form-box">
                    <label class="fl"><span>{{trans('www.sell_car.wheel')}}</span></label>
                    <div class="inp fl">
                        <div class="select-box">
                            <div class="select-arrow"></div>
                            <div class="select-title"></div>
                            <select name="wheels">
                                <option value="">{{trans('www.base.label.select')}}</option>
                                @foreach($wheels as $value)
                                    <option value="{{$value->count}}"{{$value->count == $auto->wheels ? ' selected="selected"' : ''}}>{{$value->count}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div id="form-error-wheels" class="form-error"></div>
                    </div>
                    <div class="cb"></div>
                </div>
                <div class="form-box">
                    <label class="fl"><span>{{trans('www.sell_car.main_phone')}}</span></label>
                    <div class="inp fl">
                        <label><span>{{$user->phone}}</span></label>
                    </div>
                    <div class="cb"></div>
                </div>
                <div class="form-box">
                    <label class="checkbox-label no-select resp">
                        {{trans('www.sell_car.hide_main_phone')}}
                        <input type="checkbox" id="hide-main-phone" name="hide_main_phone" value="{{Auto::HIDE_MAIN_PHONE}}"{!! $auto->hide_main_phone == Auto::HIDE_MAIN_PHONE ? ' checked="checked"' : '' !!} />
                    </label>
                    <div id="form-error-hide_main_phone" class="form-error"></div>
                </div>
                <div class="form-box">
                    <label id="additional-phone" class="fl"><span>{{trans('www.sell_car.additional_phone')}}</span></label>
                    <div class="inp fl">
                        <input type="text" name="additional_phone" value="{{$auto->additional_phone or ''}}" />
                        <div id="form-error-additional_phone" class="form-error"></div>
                    </div>
                    <div class="cb"></div>
                </div>

            </div>
            <div class="cb"></div>

            <div class="separator"></div>

            <div class="col-2 sell-left fl">
                <div id="price-box" class="form-box">
                    <label class="required fl"><span>{{trans('www.sell_car.price')}}</span></label>
                    <div class="inp fl price">
                        <div class="mileage-input fl">
                            <input type="text" name="price" class="number" value="{{$auto->price or ''}}" />
                            <div id="form-error-price" class="form-error"></div>
                        </div>
                        <div class="mileage-select fl">
                            <div class="select-box">
                                <div class="select-arrow"></div>
                                <div class="select-title"></div>
                                <select name="currency_id">
                                    @foreach($currenciesData as $value)
                                        <option value="{{$value->id}}"{{$value->id == $auto->currency_id ? ' selected="selected"' : ''}}>{{$value->code}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div id="form-error-currency_id" class="form-error"></div>
                        </div>
                        <div class="cb"></div>
                    </div>
                    <div class="cb"></div>
                </div>
            </div>
            <div class="cb"></div>

            <div class="col-3 sell-left fl">
                <div class="form-box">
                    <label class="checkbox-label no-select">
                        {{trans('www.sell_car.contract')}}
                        <input type="checkbox" id="contract" name="contract" value="{{Auto::CONTRACT}}"{{$auto->isContract() ? ' checked="checked"' : ''}} />
                    </label>
                    <div id="form-error-contract" class="form-error"></div>
                </div>
                <div class="form-box">
                    <label class="checkbox-label no-select">
                        {{trans('www.sell_car.exchange')}}
                        <input type="checkbox" name="exchange" value="{{Auto::EXCHANGE}}"{{$auto->isExchange() ? ' checked="checked"' : ''}} />
                    </label>
                </div>
                <div class="form-box">
                    <label class="checkbox-label no-select">
                        {{trans('www.sell_car.damaged')}}
                        <input type="checkbox" name="damaged" value="{{Auto::DAMAGED}}"{{$auto->isDamaged() ? ' checked="checked"' : ''}} />
                    </label>
                    <div id="form-error-damaged" class="form-error"></div>
                </div>
            </div>
            <div class="col-3 sell-middle fl">
                <div class="form-box">
                    <label class="checkbox-label no-select">
                        {{trans('www.sell_car.auction')}}
                        <input type="checkbox" id="auction" name="auction" value="{{Auto::AUCTION}}"{{$auto->isAuction() ? ' checked="checked"' : ''}} />
                    </label>
                    <div id="form-error-auction" class="form-error"></div>
                </div>
                <div class="form-box">
                    <label class="checkbox-label no-select">
                        {{trans('www.sell_car.partial_pay')}}
                        <input type="checkbox" name="partial_pay" value="{{Auto::PARTIAL_PAY}}"{{$auto->isPartialPay() ? ' checked="checked"' : ''}} />
                    </label>
                    <div id="form-error-partial_pay" class="form-error"></div>
                </div>
            </div>
            <div class="col-3 sell-right fl">
                <div class="form-box">
                    <label class="checkbox-label no-select">
                        {{trans('www.sell_car.bank')}}
                        <input type="checkbox" name="bank" value="{{Auto::BANK}}"{{$auto->isBank() ? ' checked="checked"' : ''}} />
                    </label>
                    <div id="form-error-bank" class="form-error"></div>
                </div>
                <div class="form-box">
                    <label class="checkbox-label no-select">
                        {{trans('www.sell_car.customs_cleared')}}
                        <input type="checkbox" name="custom_cleared" value="{{Auto::CUSTOM_CLEARED}}"{{$auto->isCustomCleared() ? ' checked="checked"' : ''}} />
                    </label>
                    <div id="form-error-custom_cleared" class="form-error"></div>
                </div>
            </div>
            <div class="cb"></div>

            <div class="separator"></div>

            <div class="col-1">
                <div class="form-box">
                    <label class="fl">{{trans('www.sell_car.description')}}</label>
                    <div class="inp fl">
                        <textarea name="description">{{$auto->description or ''}}</textarea>
                        <div id="form-error-description" class="form-error"></div>
                    </div>
                    <div class="cb"></div>
                </div>
            </div>

            <div class="separator"></div>

            <?php
            if (!$options->isEmpty()) {
            $optionsCol1 = $optionsCol2 = $optionsCol3 = '';
            $i = 1;
            foreach($options as $key => $opt) {
                $buffer =  '<div class="form-box">';
                $buffer .=     '<label class="checkbox-label no-select">'.$opt->name;
                $buffer .=         '<input type="checkbox" name="options[]" value="'.$opt->id.'"'.(isset($autoOptions[$opt->id]) ? ' checked="checked"' : '').' />';
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
            <div class="col-3 sell-left fl">{!!$optionsCol1!!}</div>
            <div class="col-3 sell-middle fl">{!!$optionsCol2!!}</div>
            <div class="col-3 sell-right fl">{!!$optionsCol3!!}</div>
            <div class="cb"></div>

            <div class="separator"></div>
            <?php } ?>

            <div class="col-1">
                <div>
                    <a href="#" id="upload-image" class="btn dib">{{trans('www.sell_car.upload_image')}}</a>
                    <p class="img-help">{{trans('www.sell_car.img.help')}}</p>
                    <div class="dib dpn upload-load"></div>
                    <div id="form-error-images" class="form-error"></div>
                </div>
                <div id="sell-images"></div>
                <div class="cb"></div>
            </div>

            {{csrf_field()}}
            <div class="submit-box">
                <input type="submit" class="btn" value="{{trans('www.sell_car.submit')}}" />
            </div>

        </form>
    </div>
</div>

@stop