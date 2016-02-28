<?php
$head->appendScript('/admin/body.js');
$pageTitle = $pageSubTitle = trans('admin.body.form.title');
$pageMenu = 'body';
?>
@extends('admin.layout')
@section('navButtons')
    <a href="{{url('admin_body_create')}}" class="btn btn-primary pull-right">{{trans('admin.base.label.add')}}</a>
@stop
@section('content')
<div class="box-body">
    <table id="data-table" class="table table-bordered table-striped table-hover">
        <thead>
        <tr>
            <th>{{trans('admin.base.label.id')}}</th>
            <th>{{trans('admin.base.label.name')}}</th>
            <th class="th-actions"></th>
        </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>
@stop