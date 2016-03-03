<?php
use App\Models\Door\Door;

$head->appendScript('/admin/door.js');
$pageTitle = trans('admin.door.form.title');
$pageMenu = 'door';
if ($saveMode == 'add') {
    $pageSubTitle = trans('admin.door.form.add.sub_title');
    $url = route('admin_door_store');
} else {
    $pageSubTitle = trans('admin.door.form.edit.sub_title', ['id' => $door->id]);
    $url = route('admin_door_update', $door->id);
}
?>
@extends('core.layout')
@section('content')
<form id="edit-form" class="form-horizontal" method="post" action="{{$url}}">
    <div class="box-body">
        <div class="form-group">
            <label class="col-sm-3 control-label data-req">{{trans('admin.base.label.name')}}</label>
            <div class="col-sm-9">
                <input type="text" name="name" class="form-control" value="{{$door->name or ''}}">
                <div id="form-error-name" class="form-error"></div>
            </div>
        </div>
        {{csrf_field()}}
    </div>
    <div class="box-footer">
        <input type="submit" class="nav-btn nav-btn-save btn btn-primary" value="{{trans('admin.base.label.save')}}">
        <a href="{{route('admin_door_table')}}" class="nav-btn nav-btn-cancel btn btn-default">{{trans('admin.base.label.cancel')}}</a>
    </div>
</form>
@stop