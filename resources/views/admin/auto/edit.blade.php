<?php
use App\Models\Auto\Auto;

$head->appendScript('/admin/auto.js');
$pageTitle = trans('admin.auto.form.title');
$pageMenu = 'auto';
if ($saveMode == 'add') {
    $pageSubTitle = trans('admin.auto.form.add.sub_title');
    $url = route('admin_auto_store');
} else {
    $pageSubTitle = trans('admin.auto.form.edit.sub_title', ['id' => $auto->id]);
    $url = route('admin_auto_update', $auto->id);
}
$jsTrans->addTrans(['admin.base.label.select']);
?>
@extends('admin.layout')
@section('content')
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
                    @for($i = date('Y'); $i > 1909; $i--)
                        <option value="{{$i}}"{{$i == $auto->year ? ' selected="selected"' : ''}}>{{$i}}</option>
                    @endfor
                </select>
                <div id="form-error-body_id" class="form-error"></div>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label data-req">{{trans('admin.base.label.mileage')}}</label>
            <div class="col-sm-9">
                <select name="mileage_measurement" class="form-control">
                    <option value="">{{trans('admin.base.label.select')}}</option>
                    @for($i = date('Y'); $i > 1909; $i--)
                        <option value="{{$i}}"{{$i == $auto->year ? ' selected="selected"' : ''}}>{{$i}}</option>
                    @endfor
                </select>
                <div id="form-error-body_id" class="form-error"></div>
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
            <label class="col-sm-3 control-label">{{trans('admin.base.label.cylinders_count')}}</label>
            <div class="col-sm-9">
                <select name="cylinder_id" class="form-control">
                    <option value="">{{trans('admin.base.label.select')}}</option>
                    @foreach($cylinders as $value)
                        <option value="{{$value->id}}"{{$value->id == $auto->cylinder_id ? ' selected="selected"' : ''}}>{{$value->name}}</option>
                    @endforeach
                </select>
                <div id="form-error-cylinder_id" class="form-error"></div>
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
                <select name="door_id" class="form-control">
                    <option value="">{{trans('admin.base.label.select')}}</option>
                    @foreach($doors as $value)
                        <option value="{{$value->id}}"{{$value->id == $auto->door_id ? ' selected="selected"' : ''}}>{{$value->name}}</option>
                    @endforeach
                </select>
                <div id="form-error-door_id" class="form-error"></div>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label">{{trans('admin.base.label.wheel')}}</label>
            <div class="col-sm-9">
                <select name="wheel_id" class="form-control">
                    <option value="">{{trans('admin.base.label.select')}}</option>
                    @foreach($wheels as $value)
                        <option value="{{$value->id}}"{{$value->id == $auto->wheel_id ? ' selected="selected"' : ''}}>{{$value->name}}</option>
                    @endforeach
                </select>
                <div id="form-error-wheel_id" class="form-error"></div>
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
            <label class="col-sm-3 control-label data-req">{{trans('admin.base.label.year')}}</label>
            <div class="col-sm-9">
                <input type="text" name="year" class="form-control" value="{{$auto->year or ''}}">
                <div id="form-error-year" class="form-error"></div>
            </div>
        </div>
    </div>
    {{csrf_field()}}
    <div class="box-footer">
        <input type="submit" class="nav-btn nav-btn-save btn btn-primary" value="{{trans('admin.base.label.save')}}">
        <a href="{{route('admin_auto_table')}}" class="nav-btn nav-btn-cancel btn btn-default">{{trans('admin.base.label.cancel')}}</a>
    </div>
</form>
@stop