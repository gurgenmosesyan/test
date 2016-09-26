<?php

$head->appendScript('/admin/tax/tax.js');

$pageTitle = trans('admin.tax.form.title');
$pageMenu = 'tax';
if ($saveMode == 'add') {
    $pageSubTitle = trans('admin.tax.form.add.sub_title');
    $url = route('admin_tax_store');
} else {
    $pageSubTitle = trans('admin.tax.form.edit.sub_title', ['id' => $tax->id]);
    $url = route('admin_tax_update', $tax->id);
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
                        <option value="{{$value->id}}"{{$value->id == $tax->mark_id ? ' selected="selected"' : ''}}>{{$value->name}}</option>
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
                        <option value="{{$value->id}}"{{$value->id == $tax->model_id ? ' selected="selected"' : ''}}>{{$value->name}}</option>
                    @endforeach
                </select>
                <div id="form-error-model_id" class="form-error"></div>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-3 control-label data-req">{{trans('admin.base.label.year')}}</label>
            <div class="col-sm-9">
                <select name="year" class="form-control">
                    <option value="">{{trans('admin.base.label.select')}}</option>
                    @for($i = intval(date('Y'))+2; $i > 1909; $i--)
                        <option value="{{$i}}"{{$i == $tax->year ? ' selected="selected"' : ''}}>{{$i}}</option>
                    @endfor
                </select>
                <div id="form-error-year" class="form-error"></div>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-3 control-label data-req">{{trans('admin.base.label.engine')}}</label>
            <div class="col-sm-9">
                <select name="engine_id" class="form-control">
                    <option value="">{{trans('admin.base.label.select')}}</option>
                    @foreach($engines as $value)
                        <option value="{{$value->id}}"{{$value->id == $tax->engine_id ? ' selected="selected"' : ''}}>{{$value->current->name}}</option>
                    @endforeach
                </select>
                <div id="form-error-engine_id" class="form-error"></div>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-3 control-label">{{trans('admin.base.label.engine_volume')}}</label>
            <div class="col-sm-3">
                <select name="volume" class="form-control">
                    <option value="">{{trans('admin.base.label.select')}}</option>
                    <?php $i = 0.1; ?>
                    @while($i < 10.1)
                        <?php $i = number_format($i, 1, '.', '.'); ?>
                        <option value="{{$i}}"{{$i == $tax->volume ? ' selected="selected"' : ''}}>{{$i}}</option>
                        <?php $i += 0.1; ?>
                    @endwhile
                </select>
                <div id="form-error-volume" class="form-error"></div>
            </div>
        </div>

        <div id="price-group" class="form-group">
            <label class="col-sm-3 control-label data-req">{{trans('admin.base.label.price')}}</label>
            <div class="col-sm-3">
                <input type="text" name="price" class="form-control" value="{{$tax->price or ''}}">
                <div id="form-error-price" class="form-error"></div>
            </div>
            <div class="col-sm-3">
                <select name="currency_id" class="form-control text-uppercase">
                    @foreach($currencies as $currency)
                        <option value="{{$currency->id}}"{{$currency->id == $tax->currency_id ? ' selected="selected"' : ''}}>{{$currency->code}}</option>
                    @endforeach
                </select>
                <div id="form-error-currency_id" class="form-error"></div>
            </div>
        </div>

    </div>
    <input type="hidden" name="save_mode" value="{{$saveMode}}">
    {{csrf_field()}}
    <div class="box-footer">
        <input type="submit" class="nav-btn nav-btn-save btn btn-primary" value="{{trans('admin.base.label.save')}}">
        <a href="{{route('admin_tax_table')}}" class="nav-btn nav-btn-cancel btn btn-default">{{trans('admin.base.label.cancel')}}</a>
    </div>
</form>

@stop