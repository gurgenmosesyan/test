<?php
$head->appendScript('/admin/admin.js');
$pageTitle = trans('admin.admin_form.title');
$pageMenu = 'admin';
if ($saveMode == 'add') {
    $pageSubTitle = trans('admin.admin_form.add.sub_title');
    $url = 'store';
} else {
    $pageSubTitle = trans('admin.admin_form.edit.sub_title', ['id' => $admin->id]);
    $url = 'update/'.$admin->id;
}
?>
@extends('admin.layout')
@section('content')
<form id="edit-form" class="form-horizontal" method="post" action="{{url('/admpanel/admin/'.$url)}}">
    <div class="box-body">
        <div class="form-group">
            <label for="email" class="col-sm-3 control-label data-req">{{trans('admin.base.label.email')}}</label>
            <div class="col-sm-9">
                <input type="text" name="email" class="form-control" id="username" value="{{$admin->email or ''}}">
                <div id="form-error-email" class="form-error"></div>
            </div>
        </div>
        <div class="form-group">
            <label for="password" class="col-sm-3 control-label data-req">{{trans('admin.base.label.password')}}</label>
            <div class="col-sm-9">
                <input type="password" name="password" class="form-control" id="password">
                <div id="form-error-password" class="form-error"></div>
            </div>
        </div>
        <div class="form-group">
            <label for="re_password" class="col-sm-3 control-label data-req">{{trans('admin.base.label.re_password')}}</label>
            <div class="col-sm-9">
                <input type="password" name="re_password" class="form-control" id="re_password">
                <div id="form-error-re_password" class="form-error"></div>
            </div>
        </div>
        {{csrf_field()}}
    </div>
    <div class="box-footer">
        <input type="submit" class="nav-btn nav-btn-save btn btn-primary" value="{{trans('admin.base.label.save')}}">
        <a href="{{route('admin_table')}}" class="nav-btn nav-btn-cancel btn btn-default">{{trans('admin.base.label.cancel')}}</a>
    </div>
</form>
@stop