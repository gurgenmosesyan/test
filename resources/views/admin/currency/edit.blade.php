<?php
use App\Models\Currency\Currency;
use App\Core\Helpers\ImgUploader;

$head->appendScript('/admin/currency/currency.js');
$pageTitle = trans('admin.currency.form.title');
$pageMenu = 'currency';
if ($saveMode == 'add') {
    $pageSubTitle = trans('admin.currency.form.add.sub_title');
    $url = route('admin_currency_store');
} else {
    $pageSubTitle = trans('admin.currency.form.edit.sub_title', ['id' => $currency->id]);
    $url = route('admin_currency_update', $currency->id);
}
?>
@extends('core.layout')
@section('content')
<form id="edit-form" class="form-horizontal" method="post" action="{{$url}}">
    <div class="box-body">
        <div class="form-group">
            <label class="col-sm-2 control-label data-req">{{trans('admin.base.label.code')}}</label>
            <div class="col-sm-4">
                <input type="text" name="code" class="form-control" value="{{$currency->code or ''}}">
                <div id="form-error-code" class="form-error"></div>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">{{trans('admin.base.label.default')}}</label>
            <div class="col-sm-4">
                <input type="checkbox" id="default" name="default" class="minimal-checkbox" value="{{Currency::IS_DEFAULT}}" {{$currency->default == Currency::IS_DEFAULT ? ' checked="checked"' : ''}}>
                <div id="form-error-default" class="form-error"></div>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label data-req rate-label">{{trans('admin.base.label.rate')}}</label>
            <div class="col-sm-4">
                <input type="text" name="rate" class="form-control" value="{{$currency->rate or ''}}">
                <div id="form-error-rate" class="form-error"></div>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label data-req">{{trans('admin.base.label.icon')}}</label>
            <div class="col-sm-10">
                <?php ImgUploader::uploader('currency', 'icon', 'icon', $currency->icon); ?>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">{{trans('admin.base.label.sort_order')}}</label>
            <div class="col-sm-4">
                <input type="text" name="sort_order" class="form-control" value="{{$currency->sort_order or ''}}">
                <div id="form-error-sort_order" class="form-error"></div>
            </div>
        </div>
        {{csrf_field()}}
    </div>
    <div class="box-footer">
        <input type="submit" class="nav-btn nav-btn-save btn btn-primary" value="{{trans('admin.base.label.save')}}">
        <a href="{{route('admin_currency_table')}}" class="nav-btn nav-btn-cancel btn btn-default">{{trans('admin.base.label.cancel')}}</a>
    </div>
</form>
@stop