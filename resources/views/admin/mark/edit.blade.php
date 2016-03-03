<?php
use App\Models\Mark\Mark;

$head->appendScript('/admin/mark.js');
$pageTitle = trans('admin.mark.form.title');
$pageMenu = 'mark';
if ($saveMode == 'add') {
    $pageSubTitle = trans('admin.mark.form.add.sub_title');
    $url = route('admin_mark_store');
} else {
    $pageSubTitle = trans('admin.mark.form.edit.sub_title', ['id' => $mark->id]);
    $url = route('admin_mark_update', $mark->id);
}
?>
@extends('core.layout')
@section('content')
<form id="edit-form" class="form-horizontal" method="post" action="{{$url}}">
    <div class="box-body">
        <div class="form-group">
            <label class="col-sm-3 control-label data-req">{{trans('admin.base.label.name')}}</label>
            <div class="col-sm-9">
                <input type="text" name="name" class="form-control" value="{{$mark->name or ''}}">
                <div id="form-error-name" class="form-error"></div>
            </div>
        </div>
        {{csrf_field()}}
    </div>
    <div class="box-footer">
        <input type="submit" class="nav-btn nav-btn-save btn btn-primary" value="{{trans('admin.base.label.save')}}">
        <a href="{{route('admin_mark_table')}}" class="nav-btn nav-btn-cancel btn btn-default">{{trans('admin.base.label.cancel')}}</a>
    </div>
</form>
@stop