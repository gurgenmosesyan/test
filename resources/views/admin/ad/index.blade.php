<?php
$head->appendStyle('/admin/ad/ad.css');
$head->appendScript('/admin/ad/ad.js');

$pageTitle = $pageSubTitle = trans('admin.ad.form.title');
$pageMenu = 'ad';

$jsTrans->addTrans([
    'admin.base.label.attention',
    'admin.base.label.ok',
    'admin.auto.modal.status.text'
]);

?>
@extends('core.layout')
@section('navButtons')
    <a href="{{route('admin_ad_create')}}" class="btn btn-primary pull-right">{{trans('admin.base.label.add')}}</a>
@stop
@section('content')
<div class="box-body">
    <table id="data-table" class="table table-bordered table-striped table-hover">
        <thead>
        <tr>
            <th>{{trans('admin.base.label.id')}}</th>
            <th>{{trans('admin.base.label.key')}}</th>
            <th>{{trans('admin.base.label.user')}}</th>
            <th>{{trans('admin.base.label.image')}}</th>
            <th>{{trans('admin.base.label.deadline')}}</th>
            <th>{{trans('admin.base.label.status')}}</th>
            <th class="th-actions"></th>
        </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>
@stop