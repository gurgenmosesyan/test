<?php

$head->appendScript('/admin/part/part.js');
$pageTitle = $pageSubTitle = trans('admin.part.form.title');
$pageMenu = 'part';

$jsTrans->addTrans(['admin.base.label.select']);
?>
@extends('core.layout')
@section('navButtons')
    <a href="{{route('admin_part_create')}}" class="btn btn-primary pull-right">{{trans('admin.base.label.add')}}</a>
@stop
@section('content')
<div class="box-body">
    <table id="data-table" class="table table-bordered table-striped table-hover">
        <thead>
        <tr>
            <th>{{trans('admin.base.label.id')}}</th>
            <th>{{trans('admin.base.label.mark')}}</th>
            <th>{{trans('admin.base.label.model')}}</th>
            <th class="th-actions"></th>
        </tr>
        </thead>
        <tbody></tbody>
    </table>

    <div id="filters">
        <div class="col-sm-3 no-padding"></div>
        <div id="search-box" class="col-sm-9">
            <form id="search-form" class="form-horizontal">
                <table class="table-condensed">
                    <tr>
                        <td align="right"><label>{{trans('admin.base.label.mark')}}</label></td>
                        <td>
                            <select id="mark-select" data-column="1" class="form-control">
                                <option value="">{{trans('admin.base.label.select')}}</option>
                                @foreach($marks as $mark)
                                    <option value="{{$mark->id}}">{{$mark->name}}</option>
                                @endforeach
                            </select>
                        </td>

                        <td align="right"><label>{{trans('admin.base.label.model')}}</label></td>
                        <td>
                            <select id="model-select" data-column="2" class="form-control">
                                <option value="">{{trans('admin.base.label.select')}}</option>
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
<style>
    #data-table_filter {
        display: none;
    }
</style>
@stop