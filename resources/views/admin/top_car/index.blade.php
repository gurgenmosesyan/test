<?php
$head->appendScript('/admin/top_car/top_car.js');
$pageTitle = $pageSubTitle = trans('admin.top_car.form.title');
$pageMenu = 'top_car';
?>
@extends('core.layout')
@section('navButtons')
    <a href="{{route('admin_top_car_create')}}" class="btn btn-primary pull-right">{{trans('admin.base.label.add')}}</a>
@stop
@section('content')
<div class="box-body">
    <table id="data-table" class="table table-bordered table-striped table-hover">
        <thead>
        <tr>
            <th>{{trans('admin.base.label.id')}}</th>
            <th>{{trans('admin.base.label.auto')}}</th>
            <th>{{trans('admin.base.label.user')}}</th>
            <th>{{trans('admin.base.label.deadline')}}</th>
            <th class="th-actions"></th>
        </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>
@stop