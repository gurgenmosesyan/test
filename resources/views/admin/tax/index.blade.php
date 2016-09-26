<?php
$head->appendScript('/admin/tax/tax.js');
$pageTitle = $pageSubTitle = trans('admin.tax.form.title');
$pageMenu = 'tax';
?>
@extends('core.layout')
@section('navButtons')
    <a href="{{route('admin_tax_create')}}" class="btn btn-primary pull-right">{{trans('admin.base.label.add')}}</a>
@stop
@section('content')
    <div class="box-body">
        <table id="data-table" class="table table-bordered table-striped table-hover">
            <thead>
            <tr>
                <th>{{trans('admin.base.label.id')}}</th>
                <th>{{trans('admin.base.label.mark')}}</th>
                <th>{{trans('admin.base.label.model')}}</th>
                <th>{{trans('admin.base.label.year')}}</th>
                <th>{{trans('admin.base.label.engine')}}</th>
                <th>{{trans('admin.base.label.engine_volume')}}</th>
                <th>{{trans('admin.base.label.price')}}</th>
                <th class="th-actions"></th>
            </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
@stop