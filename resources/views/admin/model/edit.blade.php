<?php
use App\Models\Model\Model;

$head->appendScript('/admin/model.js');
$pageTitle = trans('admin.model.form.title');
$pageMenu = 'model';
if ($saveMode == 'add') {
    $pageSubTitle = trans('admin.model.form.add.sub_title');
    $url = route('admin_model_store');
} else {
    $pageSubTitle = trans('admin.model.form.edit.sub_title', ['id' => $model->id]);
    $url = route('admin_model_update', $model->id);
}
$jsTrans->addTrans(['admin.base.label.select']);
?>
@extends('admin.layout')
@section('content')
<form id="edit-form" class="form-horizontal" method="post" action="{{$url}}">
    <div class="box-body">
        <div class="form-group">
            <label class="col-sm-3 control-label data-req">{{trans('admin.base.label.mark')}}</label>
            <div class="col-sm-9">
                <select id="mark-select" name="mark_id" class="form-control">
                    <option value="">{{trans('admin.base.label.select')}}</option>
                    @foreach($marks as $mark)
                        <option value="{{$mark->id}}"{{$mark->id == $model->mark_id ? ' selected="selected"' : ''}}>{{$mark->name}}</option>
                    @endforeach
                </select>
                <div id="form-error-mark_id" class="form-error"></div>
            </div>
        </div>
        <div id="category-group" class="form-group{{$categories->isEmpty() ? ' dn' : ''}}">
            <label class="col-sm-3 control-label">{{trans('admin.base.label.category')}}</label>
            <div class="col-sm-9">
                <select id="category-select" name="category_id" class="form-control">
                    <option value="">{{trans('admin.base.label.select')}}</option>
                    @foreach($categories as $category)
                        <option value="{{$category->id}}"{{$category->id == $model->category_id ? ' selected="selected"' : ''}}>{{$category->name}}</option>
                    @endforeach
                </select>
                <div id="form-error-category_id" class="form-error"></div>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label data-req">{{trans('admin.base.label.name')}}</label>
            <div class="col-sm-9">
                <input type="text" name="name" class="form-control" value="{{$model->name or ''}}">
                <div id="form-error-name" class="form-error"></div>
            </div>
        </div>
        {{csrf_field()}}
    </div>
    <div class="box-footer">
        <input type="submit" class="nav-btn nav-btn-save btn btn-primary" value="{{trans('admin.base.label.save')}}">
        <a href="{{route('admin_model_table')}}" class="nav-btn nav-btn-cancel btn btn-default">{{trans('admin.base.label.cancel')}}</a>
    </div>
</form>
@stop