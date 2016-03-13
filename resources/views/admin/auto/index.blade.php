<?php
$head->appendStyle('/admin/auto/auto.css');
$head->appendScript('/admin/auto/auto.js');
$pageTitle = $pageSubTitle = trans('admin.auto.form.title');
$pageMenu = 'auto';

$jsTrans->addTrans([
    'admin.base.label.attention',
    'admin.base.label.ok',
    'admin.auto.modal.status.text'
]);
?>
@extends('core.layout')
@section('navButtons')
    <a href="{{route('admin_auto_create')}}" class="btn btn-primary pull-right">{{trans('admin.base.label.add')}}</a>
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
            <th width="150">{{trans('admin.base.label.status')}}</th>
            <th class="th-actions"></th>
        </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>
@stop