<?php
use App\Models\Cylinder\Cylinder;

$head->appendScript('/admin/cylinder.js');
$pageTitle = trans('admin.cylinder.form.title');
$pageMenu = 'cylinder';
if ($saveMode == 'add') {
    $pageSubTitle = trans('admin.cylinder.form.add.sub_title');
    $url = route('admin_cylinder_store');
} else {
    $pageSubTitle = trans('admin.cylinder.form.edit.sub_title', ['id' => $cylinder->id]);
    $url = route('admin_cylinder_update', $cylinder->id);
}
?>
@extends('admin.layout')
@section('content')
<form id="edit-form" class="form-horizontal" method="post" action="{{$url}}">
    <div class="box-body">
        <div class="form-group">
            <label class="col-sm-3 control-label data-req">{{trans('admin.base.label.name')}}</label>
            <div class="col-sm-9">
                <input type="text" name="name" class="form-control" value="{{$cylinder->name or ''}}">
                <div id="form-error-name" class="form-error"></div>
            </div>
        </div>
        {{csrf_field()}}
    </div>
    <div class="box-footer">
        <input type="submit" class="nav-btn nav-btn-save btn btn-primary" value="{{trans('admin.base.label.save')}}">
        <a href="{{route('admin_cylinder_table')}}" class="nav-btn nav-btn-cancel btn btn-default">{{trans('admin.base.label.cancel')}}</a>
    </div>
</form>
@stop