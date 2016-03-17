<?php
use App\Models\Auto\Auto;

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

    <div id="filters">
        <div class="col-sm-3 no-padding">
            <a href="#" id="init-search" class="btn btn-default">{{trans('admin.base.label.search')}}</a>
        </div>
        <div id="search-box" class="col-sm-9 dn">
            <form id="search-form" class="form-horizontal">
                <table class="table-condensed">
                    <tr>
                        <td align="right"><label>{{trans('admin.base.label.id')}}</label></td>
                        <td><input type="text" class="form-control" data-column="0" value=""></td>

                        <td align="right"><label>{{trans('admin.base.label.status')}}</label></td>
                        <td>
                            <select data-column="4" class="form-control">
                                <option value="">{{trans('admin.base.label.select')}}</option>
                                <option value="{{Auto::STATUS_PENDING}}">{{trans('admin.auto.status.pending')}}</option>
                                <option value="{{Auto::STATUS_APPROVED}}">{{trans('admin.auto.status.approved')}}</option>
                                <option value="{{Auto::STATUS_BLOCKED}}">{{trans('admin.auto.status.blocked')}}</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4" align="right">
                            <input type="submit" class="btn btn-default" value="{{trans('admin.base.label.search')}}">
                        </td>
                    </tr>
                </table>
            </form>
        </div>
        <div class="cb"></div>
    </div>

</div>
@stop