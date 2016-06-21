<?php

$head->appendScript('/admin/part/part.js');

$pageTitle = trans('admin.part.form.title');
$pageMenu = 'part';
if ($saveMode == 'add') {
    $pageSubTitle = trans('admin.part.form.add.sub_title');
    $url = route('admin_part_store');
} else {
    $pageSubTitle = trans('admin.part.form.edit.sub_title', ['id' => $part->id]);
    $url = route('admin_part_update', $part->id);
}
$jsTrans->addTrans(['admin.base.label.select']);
?>
@extends('core.layout')
@section('content')
<form id="edit-form" class="form-horizontal" method="post" action="{{$url}}">
    <div class="box-body">
        <div class="form-group">
            <label class="col-sm-3 control-label data-req">{{trans('admin.base.label.mark')}}</label>
            <div class="col-sm-9">
                <select id="mark-select" name="mark_id" class="form-control">
                    <option value="">{{trans('admin.base.label.select')}}</option>
                    @foreach($marks as $value)
                        <option value="{{$value->id}}"{{$value->id == $part->mark_id ? ' selected="selected"' : ''}}>{{$value->name}}</option>
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
                        <option value="{{$value->id}}"{{$value->id == $part->model_id ? ' selected="selected"' : ''}}>{{$value->name}}</option>
                    @endforeach
                </select>
                <div id="form-error-model_id" class="form-error"></div>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label data-req">{{trans('admin.base.label.currency')}}</label>
            <div class="col-sm-9">
                <select name="currency_id" class="form-control text-uppercase">
                    @foreach($currencies as $currency)
                        <option value="{{$currency->id}}"{{$currency->id == $part->currency_id ? ' selected="selected"' : ''}}>{{$currency->code}}</option>
                    @endforeach
                </select>
                <div id="form-error-currency_id" class="form-error"></div>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label">{{trans('admin.part.form.part1')}}</label>
            <div class="col-sm-3">
                <input type="text" name="part1_price" class="form-control" value="{{empty($part->part1_price) ? '' : $part->part1_price}}" placeholder="{{trans('admin.base.label.price')}}">
                <div id="form-error-part1_price" class="form-error"></div>
            </div>
            <div class="col-sm-3">
                <input type="text" name="part1_service_price" class="form-control" value="{{empty($part->part1_service_price) ? '' : $part->part1_service_price}}" placeholder="{{trans('admin.base.label.service_price')}}">
                <div id="form-error-part1_service_price" class="form-error"></div>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label">{{trans('admin.part.form.part2')}}</label>
            <div class="col-sm-3">
                <input type="text" name="part2_price" class="form-control" value="{{empty($part->part2_price) ? '' : $part->part2_price}}" placeholder="{{trans('admin.base.label.price')}}">
                <div id="form-error-part2_price" class="form-error"></div>
            </div>
            <div class="col-sm-3">
                <input type="text" name="part2_service_price" class="form-control" value="{{empty($part->part2_service_price) ? '' : $part->part2_service_price}}" placeholder="{{trans('admin.base.label.service_price')}}">
                <div id="form-error-part2_service_price" class="form-error"></div>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label">{{trans('admin.part.form.part3')}}</label>
            <div class="col-sm-3">
                <input type="text" name="part3_price" class="form-control" value="{{empty($part->part3_price) ? '' : $part->part3_price}}" placeholder="{{trans('admin.base.label.price')}}">
                <div id="form-error-part3_price" class="form-error"></div>
            </div>
            <div class="col-sm-3">
                <input type="text" name="part3_service_price" class="form-control" value="{{empty($part->part3_service_price) ? '' : $part->part3_service_price}}" placeholder="{{trans('admin.base.label.service_price')}}">
                <div id="form-error-part3_service_price" class="form-error"></div>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label">{{trans('admin.part.form.part4')}}</label>
            <div class="col-sm-3">
                <input type="text" name="part4_price" class="form-control" value="{{empty($part->part4_price) ? '' : $part->part4_price}}" placeholder="{{trans('admin.base.label.price')}}">
                <div id="form-error-part4_price" class="form-error"></div>
            </div>
            <div class="col-sm-3">
                <input type="text" name="part4_service_price" class="form-control" value="{{empty($part->part4_service_price) ? '' : $part->part4_service_price}}" placeholder="{{trans('admin.base.label.service_price')}}">
                <div id="form-error-part4_service_price" class="form-error"></div>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label">{{trans('admin.part.form.part5')}}</label>
            <div class="col-sm-3">
                <input type="text" name="part5_price" class="form-control" value="{{empty($part->part5_price) ? '' : $part->part5_price}}" placeholder="{{trans('admin.base.label.price')}}">
                <div id="form-error-part5_price" class="form-error"></div>
            </div>
            <div class="col-sm-3">
                <input type="text" name="part5_service_price" class="form-control" value="{{empty($part->part5_service_price) ? '' : $part->part5_service_price}}" placeholder="{{trans('admin.base.label.service_price')}}">
                <div id="form-error-part5_service_price" class="form-error"></div>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label">{{trans('admin.part.form.part6')}}</label>
            <div class="col-sm-3">
                <input type="text" name="part6_price" class="form-control" value="{{empty($part->part6_price) ? '' : $part->part6_price}}" placeholder="{{trans('admin.base.label.price')}}">
                <div id="form-error-part6_price" class="form-error"></div>
            </div>
            <div class="col-sm-3">
                <input type="text" name="part6_service_price" class="form-control" value="{{empty($part->part6_service_price) ? '' : $part->part6_service_price}}" placeholder="{{trans('admin.base.label.service_price')}}">
                <div id="form-error-part6_service_price" class="form-error"></div>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label">{{trans('admin.part.form.part7')}}</label>
            <div class="col-sm-3">
                <input type="text" name="part7_price" class="form-control" value="{{empty($part->part7_price) ? '' : $part->part7_price}}" placeholder="{{trans('admin.base.label.price')}}">
                <div id="form-error-part7_price" class="form-error"></div>
            </div>
            <div class="col-sm-3">
                <input type="text" name="part7_service_price" class="form-control" value="{{empty($part->part7_service_price) ? '' : $part->part7_service_price}}" placeholder="{{trans('admin.base.label.service_price')}}">
                <div id="form-error-part7_service_price" class="form-error"></div>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label">{{trans('admin.part.form.part8')}}</label>
            <div class="col-sm-3">
                <input type="text" name="part8_price" class="form-control" value="{{empty($part->part8_price) ? '' : $part->part8_price}}" placeholder="{{trans('admin.base.label.price')}}">
                <div id="form-error-part8_price" class="form-error"></div>
            </div>
            <div class="col-sm-3">
                <input type="text" name="part8_service_price" class="form-control" value="{{empty($part->part8_service_price) ? '' : $part->part8_service_price}}" placeholder="{{trans('admin.base.label.service_price')}}">
                <div id="form-error-part8_service_price" class="form-error"></div>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label">{{trans('admin.part.form.part9')}}</label>
            <div class="col-sm-3">
                <input type="text" name="part9_price" class="form-control" value="{{empty($part->part9_price) ? '' : $part->part9_price}}" placeholder="{{trans('admin.base.label.price')}}">
                <div id="form-error-part9_price" class="form-error"></div>
            </div>
            <div class="col-sm-3">
                <input type="text" name="part9_service_price" class="form-control" value="{{empty($part->part9_service_price) ? '' : $part->part9_service_price}}" placeholder="{{trans('admin.base.label.service_price')}}">
                <div id="form-error-part9_service_price" class="form-error"></div>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label">{{trans('admin.part.form.part10')}}</label>
            <div class="col-sm-3">
                <input type="text" name="part10_price" class="form-control" value="{{empty($part->part10_price) ? '' : $part->part10_price}}" placeholder="{{trans('admin.base.label.price')}}">
                <div id="form-error-part10_price" class="form-error"></div>
            </div>
            <div class="col-sm-3">
                <input type="text" name="part10_service_price" class="form-control" value="{{empty($part->part10_service_price) ? '' : $part->part10_service_price}}" placeholder="{{trans('admin.base.label.service_price')}}">
                <div id="form-error-part10_service_price" class="form-error"></div>
            </div>
        </div>
    </div>
    {{csrf_field()}}
    <div class="box-footer">
        <input type="submit" class="nav-btn nav-btn-save btn btn-primary" value="{{trans('admin.base.label.save')}}">
        <a href="{{route('admin_part_table')}}" class="nav-btn nav-btn-cancel btn btn-default">{{trans('admin.base.label.cancel')}}</a>
    </div>
</form>
@stop