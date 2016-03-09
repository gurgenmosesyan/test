<?php
use App\Models\ModelCategory\Category;

$head->appendScript('/admin/model_category/model_category.js');
$pageTitle = trans('admin.model_category.form.title');
$pageMenu = 'model_category';
if ($saveMode == 'add') {
    $pageSubTitle = trans('admin.model_category.form.add.sub_title');
    $url = route('admin_model_category_store');
} else {
    $pageSubTitle = trans('admin.model_category.form.edit.sub_title', ['id' => $category->id]);
    $url = route('admin_model_category_update', $category->id);
}
?>
@extends('core.layout')
@section('content')
<form id="edit-form" class="form-horizontal" method="post" action="{{$url}}">
    <div class="box-body">
        <div class="form-group">
            <label class="col-sm-3 control-label data-req">{{trans('admin.base.label.mark')}}</label>
            <div class="col-sm-9">
                <select name="mark_id" class="form-control">
                    <option value="">{{trans('admin.base.label.select')}}</option>
                    @foreach($marks as $mark)
                        <option value="{{$mark->id}}"{{$mark->id == $category->mark_id ? ' selected="selected"' : ''}}>{{$mark->name}}</option>
                    @endforeach
                </select>
                <div id="form-error-mark_id" class="form-error"></div>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label data-req">{{trans('admin.base.label.name')}}</label>
            <div class="col-sm-9">
                <input type="text" name="name" class="form-control" value="{{$category->name or ''}}">
                <div id="form-error-name" class="form-error"></div>
            </div>
        </div>
        {{csrf_field()}}
    </div>
    <div class="box-footer">
        <input type="submit" class="nav-btn nav-btn-save btn btn-primary" value="{{trans('admin.base.label.save')}}">
        <a href="{{route('admin_model_category_table')}}" class="nav-btn nav-btn-cancel btn btn-default">{{trans('admin.base.label.cancel')}}</a>
    </div>
</form>
@stop