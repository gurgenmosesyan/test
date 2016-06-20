<?php
use App\Models\Body\Body;
use App\Core\Helpers\ImgUploader;

$head->appendScript('/admin/body/body.js');
$pageTitle = trans('admin.body.form.title');
$pageMenu = 'body';
if ($saveMode == 'add') {
    $pageSubTitle = trans('admin.body.form.add.sub_title');
    $url = route('admin_body_store');
} else {
    $pageSubTitle = trans('admin.body.form.edit.sub_title', ['id' => $body->id]);
    $url = route('admin_body_update', $body->id);
}
$mls = $body->ml->keyBy('lng_id');
?>
@extends('core.layout')
@section('content')
<form id="edit-form" class="form-horizontal" method="post" action="{{$url}}">
    <div class="box-body">
        <div class="form-group">
            <label class="col-sm-3 control-label data-req">{{trans('admin.base.label.name')}}</label>
            <div class="col-sm-9">
                @foreach($languages as $lng)
                    <div class="form-group form-group-inner">
                        <input type="text" name="ml[{{$lng->id}}][name]" class="form-control" value="{{isset($mls[$lng->id]) ? $mls[$lng->id]->name : ''}}" placeholder="{{$lng->name}}">
                        <div id="form-error-ml_{{$lng->id}}_name" class="form-error"></div>
                    </div>
                @endforeach
                <div id="form-error-ml" class="form-error"></div>
            </div>
        </div>
        <div class="form-group">
            <label for="show-in-search" class="col-sm-3 control-label">{{trans('admin.base.label.show_in_search')}}</label>
            <div class="col-sm-9">
                <input type="checkbox" id="show-in-search" name="show_in_search" class="minimal-checkbox" value="{{Body::SHOW_IN_SEARCH}}" {{$body->show_in_search == Body::SHOW_IN_SEARCH ? ' checked="checked"' : ''}}>
                <div id="form-error-show_in_search" class="form-error"></div>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label img-label">{{trans('admin.base.label.image')}}</label>
            <div class="col-sm-9">
                <?php ImgUploader::uploader('body', 'image', 'image', $body->image); ?>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label">{{trans('admin.base.label.sort_order')}}</label>
            <div class="col-sm-9">
                <input type="text" name="sort_order" class="form-control" value="{{$body->sort_order or ''}}">
                <div id="form-error-sort_order" class="form-error"></div>
            </div>
        </div>
        {{csrf_field()}}
    </div>
    <div class="box-footer">
        <input type="submit" class="nav-btn nav-btn-save btn btn-primary" value="{{trans('admin.base.label.save')}}">
        <a href="{{route('admin_body_table')}}" class="nav-btn nav-btn-cancel btn btn-default">{{trans('admin.base.label.cancel')}}</a>
    </div>
</form>
@stop