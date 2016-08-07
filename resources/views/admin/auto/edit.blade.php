<?php
use App\Models\Auto\Auto;

$head->appendStyle('/admin/auto/auto.css');
$head->appendScript('/admin/auto/auto.js');

$pageTitle = trans('admin.auto.form.title');
$pageMenu = 'auto';
$volume1 = $volume2 = null;
if ($saveMode == 'add') {
    $pageSubTitle = trans('admin.auto.form.add.sub_title');
    $url = route('admin_auto_store');
    $autoOptions = [];
    $autoImages = [];
} else {
    $pageSubTitle = trans('admin.auto.form.edit.sub_title', ['id' => $auto->id]);
    $url = route('admin_auto_update', $auto->id);
    $autoOptions = $auto->options->keyBy('option_id');
    $autoImages = $auto->images;
    if (!empty($auto->volume)) {
        $volumes = explode('.', $auto->volume);
        $volume1 = $volumes[0];
        $volume2 = $volumes[1];
    }

}
$jsTrans->addTrans(['admin.base.label.select']);
?>
@extends('core.layout')
@section('content')
<script type="text/javascript">
    $auto.images = {!!json_encode($autoImages)!!};
</script>
<form id="edit-form" class="form-horizontal" method="post" action="{{$url}}">
    <div class="box-body">
        <div class="form-group">
            <label class="col-sm-3 control-label data-req">{{trans('admin.base.label.mark')}}</label>
            <div class="col-sm-9">
                <select id="mark-select" name="mark_id" class="form-control">
                    <option value="">{{trans('admin.base.label.select')}}</option>
                    @foreach($marks as $value)
                        <option value="{{$value->id}}"{{$value->id == $auto->mark_id ? ' selected="selected"' : ''}}>{{$value->name}}</option>
                    @endforeach
                </select>
                <div id="form-error-mark_id" class="form-error"></div>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label data-req">{{trans('admin.base.label.model')}}</label>
            <div class="col-sm-9">
                <select id="model-select" name="model_id" class="form-control">
                    <option value="">{{trans('admin.base.label.select')}}</option>
                    @foreach($models as $value)
                        <option value="{{$value->id}}"{{$value->id == $auto->model_id ? ' selected="selected"' : ''}}>{{$value->name}}</option>
                    @endforeach
                </select>
                <div id="form-error-model_id" class="form-error"></div>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label">{{trans('admin.base.label.tuning')}}</label>
            <div class="col-sm-9">
                <input type="text" name="tuning" class="form-control" value="{{$auto->tuning or ''}}">
                <div id="form-error-tuning" class="form-error"></div>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label data-req">{{trans('admin.base.label.body')}}</label>
            <div class="col-sm-9">
                <select name="body_id" class="form-control">
                    <option value="">{{trans('admin.base.label.select')}}</option>
                    @foreach($bodies as $value)
                        <option value="{{$value->id}}"{{$value->id == $auto->body_id ? ' selected="selected"' : ''}}>{{$value->current->name}}</option>
                    @endforeach
                </select>
                <div id="form-error-body_id" class="form-error"></div>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label data-req">{{trans('admin.base.label.year')}}</label>
            <div class="col-sm-9">
                <select name="year" class="form-control">
                    <option value="">{{trans('admin.base.label.select')}}</option>
                    @for($i = intval(date('Y'))+2; $i > 1909; $i--)
                        <option value="{{$i}}"{{$i == $auto->year ? ' selected="selected"' : ''}}>{{$i}}</option>
                    @endfor
                </select>
                <div id="form-error-year" class="form-error"></div>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label data-req">{{trans('admin.base.label.mileage')}}</label>
            <div class="col-sm-3">
                <input type="text" name="mileage" class="form-control" value="{{$auto->mileage_measurement == Auto::MILEAGE_MEASUREMENT_KM ? $auto->mileage_km : $auto->mileage_mile}}">
                <div id="form-error-mileage" class="form-error"></div>
            </div>
            <div class="col-sm-3">
                <select name="mileage_measurement" class="form-control">
                    <option value="{{Auto::MILEAGE_MEASUREMENT_KM}}"{{$auto->mileage_measurement == Auto::MILEAGE_MEASUREMENT_KM ? ' selected="selected"' : ''}}>{{trans('admin.base.measurement.km')}}</option>
                    <option value="{{Auto::MILEAGE_MEASUREMENT_MILE}}"{{$auto->mileage_measurement == Auto::MILEAGE_MEASUREMENT_MILE ? ' selected="selected"' : ''}}>{{trans('admin.base.measurement.mile')}}</option>
                </select>
                <div id="form-error-mileage_measurement" class="form-error"></div>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label data-req">{{trans('admin.base.label.transmission')}}</label>
            <div class="col-sm-9">
                <select name="transmission_id" class="form-control">
                    <option value="">{{trans('admin.base.label.select')}}</option>
                    @foreach($transmissions as $value)
                        <option value="{{$value->id}}"{{$value->id == $auto->transmission_id ? ' selected="selected"' : ''}}>{{$value->current->name}}</option>
                    @endforeach
                </select>
                <div id="form-error-transmission_id" class="form-error"></div>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label data-req">{{trans('admin.base.label.rudder')}}</label>
            <div class="col-sm-9">
                <select name="rudder_id" class="form-control">
                    <option value="">{{trans('admin.base.label.select')}}</option>
                    @foreach($rudders as $value)
                        <option value="{{$value->id}}"{{$value->id == $auto->rudder_id ? ' selected="selected"' : ''}}>{{$value->current->name}}</option>
                    @endforeach
                </select>
                <div id="form-error-rudder_id" class="form-error"></div>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label data-req">{{trans('admin.base.label.color')}}</label>
            <div class="col-sm-9">
                <select name="color_id" class="form-control">
                    <option value="">{{trans('admin.base.label.select')}}</option>
                    @foreach($colors as $value)
                        <option value="{{$value->id}}"{{$value->id == $auto->color_id ? ' selected="selected"' : ''}}>{{$value->current->name}}</option>
                    @endforeach
                </select>
                <div id="form-error-color_id" class="form-error"></div>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label">{{trans('admin.base.label.interior_color')}}</label>
            <div class="col-sm-9">
                <select name="interior_color_id" class="form-control">
                    <option value="">{{trans('admin.base.label.select')}}</option>
                    @foreach($interiorColors as $value)
                        <option value="{{$value->id}}"{{$value->id == $auto->interior_color_id ? ' selected="selected"' : ''}}>{{$value->current->name}}</option>
                    @endforeach
                </select>
                <div id="form-error-interior_color_id" class="form-error"></div>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label data-req">{{trans('admin.base.label.engine')}}</label>
            <div class="col-sm-9">
                <select name="engine_id" class="form-control">
                    <option value="">{{trans('admin.base.label.select')}}</option>
                    @foreach($engines as $value)
                        <option value="{{$value->id}}"{{$value->id == $auto->engine_id ? ' selected="selected"' : ''}}>{{$value->current->name}}</option>
                    @endforeach
                </select>
                <div id="form-error-engine_id" class="form-error"></div>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label">{{trans('admin.base.label.engine_volume')}}</label>
            <div class="col-sm-3">
                <select name="volume_1" class="form-control">
                    <option value="">{{trans('admin.base.label.select')}}</option>
                    @for($i = 0; $i < 16; $i++)
                        <option value="{{$i}}"{{($volume1 != 0 || $volume2 != 0) && $i == $volume1 ? ' selected="selected"' : ''}}>{{$i}}</option>
                    @endfor
                </select>
                <div id="form-error-volume_1" class="form-error"></div>
            </div>
            <div class="col-sm-3">
                <select name="volume_2" class="form-control">
                    <option value="">{{trans('admin.base.label.select')}}</option>
                    @for($i = 0; $i < 10; $i++)
                        <option value="{{$i}}"{{($volume2 != 0 || $volume2 != 0) && $i == $volume2 ? ' selected="selected"' : ''}}>{{$i}}</option>
                    @endfor
                </select>
                <div id="form-error-volume_2" class="form-error"></div>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label">{{trans('admin.base.label.horsepower')}}</label>
            <div class="col-sm-3">
                <input type="text" name="horsepower" class="form-control" maxlength="4" value="{{$auto->horsepower or ''}}">
                <div id="form-error-horsepower" class="form-error"></div>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label">{{trans('admin.base.label.cylinders_count')}}</label>
            <div class="col-sm-9">
                <select name="cylinders" class="form-control">
                    <option value="">{{trans('admin.base.label.select')}}</option>
                    @foreach($cylinders as $value)
                        <option value="{{$value->count}}"{{$value->count == $auto->cylinders ? ' selected="selected"' : ''}}>{{$value->count}}</option>
                    @endforeach
                </select>
                <div id="form-error-cylinders" class="form-error"></div>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label">{{trans('admin.base.label.train')}}</label>
            <div class="col-sm-9">
                <select name="train_id" class="form-control">
                    <option value="">{{trans('admin.base.label.select')}}</option>
                    @foreach($trains as $value)
                        <option value="{{$value->id}}"{{$value->id == $auto->train_id ? ' selected="selected"' : ''}}>{{$value->current->name}}</option>
                    @endforeach
                </select>
                <div id="form-error-train_id" class="form-error"></div>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label">{{trans('admin.base.label.doors_count')}}</label>
            <div class="col-sm-9">
                <select name="doors" class="form-control">
                    <option value="">{{trans('admin.base.label.select')}}</option>
                    @foreach($doors as $value)
                        <option value="{{$value->count}}"{{$value->count == $auto->doors ? ' selected="selected"' : ''}}>{{$value->count}}</option>
                    @endforeach
                </select>
                <div id="form-error-doors" class="form-error"></div>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label">{{trans('admin.base.label.wheel')}}</label>
            <div class="col-sm-9">
                <select name="wheels" class="form-control">
                    <option value="">{{trans('admin.base.label.select')}}</option>
                    @foreach($wheels as $value)
                        <option value="{{$value->count}}"{{$value->count == $auto->wheels ? ' selected="selected"' : ''}}>{{$value->count}}</option>
                    @endforeach
                </select>
                <div id="form-error-wheels" class="form-error"></div>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label data-req">{{trans('admin.base.label.country')}}</label>
            <div class="col-sm-9">
                <select id="country-select" name="country_id" class="form-control">
                    @foreach($countries as $value)
                        <option value="{{$value->id}}"{{$value->id == $auto->country_id ? ' selected="selected"' : ''}}>{{$value->current->name}}</option>
                    @endforeach
                </select>
                <div id="form-error-country_id" class="form-error"></div>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label">{{trans('admin.base.label.region')}}</label>
            <div class="col-sm-9">
                <select id="region-select" name="region_id" class="form-control"></select>
                <div id="form-error-region_id" class="form-error"></div>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label">{{trans('admin.base.label.place')}}</label>
            <div class="col-sm-9">
                <input type="text" name="place" class="form-control" value="{{$auto->place or ''}}">
                <div id="form-error-place" class="form-error"></div>
            </div>
        </div>
        <div id="price-group" class="form-group">
            <label class="col-sm-3 control-label data-req">{{trans('admin.base.label.price')}}</label>
            <div class="col-sm-3">
                <input type="text" name="price" class="form-control" value="{{$auto->price or ''}}">
                <div id="form-error-price" class="form-error"></div>
            </div>
            <div class="col-sm-3">
                <select name="currency_id" class="form-control text-uppercase">
                    @foreach($currencies as $currency)
                        <option value="{{$currency->id}}"{{$currency->id == $auto->currency_id ? ' selected="selected"' : ''}}>{{$currency->code}}</option>
                    @endforeach
                </select>
                <div id="form-error-currency_id" class="form-error"></div>
            </div>
        </div>
        <div id="contract-group" class="form-group">
            <label class="col-sm-3 control-label">{{trans('admin.base.label.contract')}}</label>
            <div class="col-sm-9">
                <input type="checkbox" id="contract" name="contract" class="form-control minimal-checkbox" value="{{Auto::CONTRACT}}"{{$auto->contract == Auto::CONTRACT ? ' checked="checked"' : ''}}>
                <div id="form-error-contract" class="form-error"></div>
            </div>
        </div>
        <div id="auction-group" class="form-group">
            <label class="col-sm-3 control-label">{{trans('admin.base.label.auction')}}</label>
            <div class="col-sm-9">
                <input type="checkbox" id="auction" name="auction" class="form-control minimal-checkbox" value="{{Auto::AUCTION}}"{{$auto->auction == Auto::AUCTION ? ' checked="checked"' : ''}}>
                <div id="form-error-auction" class="form-error"></div>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label">{{trans('admin.base.label.bank')}}</label>
            <div class="col-sm-9">
                <input type="checkbox" name="bank" class="form-control minimal-checkbox" value="{{Auto::BANK}}"{{$auto->bank == Auto::BANK ? ' checked="checked"' : ''}}>
                <div id="form-error-bank" class="form-error"></div>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label">{{trans('admin.base.label.exchange')}}</label>
            <div class="col-sm-9">
                <input type="checkbox" name="exchange" class="form-control minimal-checkbox" value="{{Auto::EXCHANGE}}"{{$auto->exchange == Auto::EXCHANGE ? ' checked="checked"' : ''}}>
                <div id="form-error-exchange" class="form-error"></div>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label">{{trans('admin.base.label.partial_pay')}}</label>
            <div class="col-sm-9">
                <input type="checkbox" name="partial_pay" class="form-control minimal-checkbox" value="{{Auto::PARTIAL_PAY}}"{{$auto->partial_pay == Auto::PARTIAL_PAY ? ' checked="checked"' : ''}}>
                <div id="form-error-partial_pay" class="form-error"></div>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label">{{trans('admin.base.label.custom_cleared')}}</label>
            <div class="col-sm-9">
                <input type="checkbox" name="custom_cleared" class="form-control minimal-checkbox" value="{{Auto::CUSTOM_CLEARED}}"{{$auto->custom_cleared == Auto::CUSTOM_CLEARED ? ' checked="checked"' : ''}}>
                <div id="form-error-custom_cleared" class="form-error"></div>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label">{{trans('admin.base.label.damaged')}}</label>
            <div class="col-sm-9">
                <input type="checkbox" name="damaged" class="form-control minimal-checkbox" value="{{Auto::DAMAGED}}"{{$auto->damaged == Auto::DAMAGED ? ' checked="checked"' : ''}}>
                <div id="form-error-damaged" class="form-error"></div>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label">{{trans('admin.base.label.vin')}}</label>
            <div class="col-sm-9">
                <input type="text" name="vin" class="form-control" value="{{$auto->vin or ''}}">
                <div id="form-error-vin" class="form-error"></div>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label">{{trans('admin.base.label.description')}}</label>
            <div class="col-sm-9">
                <textarea name="description" class="form-control" rows="3">{{$auto->description}}</textarea>
                <div id="form-error-description" class="form-error"></div>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label">{{trans('admin.base.label.additional_phone')}}</label>
            <div class="col-sm-9">
                <input type="text" name="additional_phone" class="form-control" value="{{$auto->additional_phone or ''}}">
                <div id="form-error-additional_phone" class="form-error"></div>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label{{$saveMode == 'add' ? ' data-req' : ''}}">{{trans('admin.base.label.term')}}</label>
            @if($saveMode == 'edit')
                <div class="col-sm-2" style="padding-top: 7px;">
                    <label>{{date('d-m-Y', strtotime($auto->term))}}</label>
                </div>
            @endif
            <div class="col-sm-3">
                <select name="term" class="form-control">
                    <option value="">{{trans('admin.base.label.select')}}</option>
                    @for($i = 10; $i > 0; $i--)
                        <option value="{{$i}}">{{trans('admin.auto.term.week', ['week' => $i])}}</option>
                    @endfor
                </select>
                <div id="form-error-term" class="form-error"></div>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-3 control-label">{{trans('admin.base.label.options')}}</label>
            <div class="col-sm-9">
                @foreach($options as $key => $option)
                    <div class="form-group col-sm-4" style="margin-bottom: 0;">
                        <input type="checkbox" id="{{$key}}" class="minimal-checkbox" name="options[]" value="{{$option->id}}"{{isset($autoOptions[$option->id]) ? ' checked="checked"' : ''}}>
                        <label class="control-label" for="{{$key}}" style="margin-left: 3px;">{{$option->current->name}}</label>
                        <div id="form-error-options_{{$key}}" class="form-error"></div>
                    </div>
                @endforeach
            </div>
        </div>

        <div id="image-group" class="form-group">
            <label class="col-sm-3 control-label">{{trans('admin.base.label.images')}}</label>
            <div class="col-sm-9">
                <a href="#" id="upload-image" class="btn btn-default">{{trans('admin.base.label.upload')}}</a>
                <div id="form-error-images" class="form-error"></div>
                <div id="images-block"></div>
            </div>
        </div>

    </div>
    <input type="hidden" name="save_mode" value="{{$saveMode}}">
    {{csrf_field()}}
    <div class="box-footer">
        <input type="submit" class="nav-btn nav-btn-save btn btn-primary" value="{{trans('admin.base.label.save')}}">
        <a href="{{route('admin_auto_table')}}" class="nav-btn nav-btn-cancel btn btn-default">{{trans('admin.base.label.cancel')}}</a>
    </div>
</form>
<div id="auto-modal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">{{trans('admin.base.label.attention')}}</h4>
            </div>
            <div class="modal-body">{{trans('admin.auto.max_images.text')}}</div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">{{trans('admin.base.label.close')}}</button>
            </div>
        </div>
    </div>
</div>
@stop