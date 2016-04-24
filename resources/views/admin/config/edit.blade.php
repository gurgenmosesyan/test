<?php
use App\Core\Helpers\ImgUploader;

$head->appendScript('/admin/config/config.js');
$pageTitle = $pageSubTitle = trans('admin.config.form.title');
$pageMenu = 'config';
?>
@extends('core.layout')
@section('content')
<form id="edit-form" class="form-horizontal" method="post" action="{{route('admin_config_update')}}">
    <div class="box-body">
        <div class="form-group">
            <label class="col-sm-3 control-label">{{trans('admin.base.label.watermark')}}</label>
            <div class="col-sm-9">
                <?php ImgUploader::uploader('config', 'watermark', 'watermark', $watermark); ?>
            </div>
        </div>

        {{csrf_field()}}
    </div>
    <div class="box-footer">
        <input type="submit" class="nav-btn nav-btn-save btn btn-primary" value="{{trans('admin.base.label.save')}}">
    </div>
</form>
@stop