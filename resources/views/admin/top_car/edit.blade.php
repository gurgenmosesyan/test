<?php
use App\Core\Helpers\Calendar;

$head->appendScript('/admin/top_car/top_car.js');
$pageTitle = trans('admin.top_car.form.title');
$pageMenu = 'top_car';
if ($saveMode == 'add') {
    $pageSubTitle = trans('admin.top_car.form.add.sub_title');
    $url = route('admin_top_car_store');
} else {
    $pageSubTitle = trans('admin.top_car.form.edit.sub_title', ['id' => $topCar->id]);
    $url = route('admin_top_car_update', $topCar->id);
}
?>
@extends('core.layout')
@section('content')
<form id="edit-form" class="form-horizontal" method="post" action="{{$url}}">
    <div class="box-body">

        <div class="form-group">
            <label class="col-sm-3 control-label data-req">{{trans('admin.base.label.auto')}}</label>
            <div class="col-sm-9">
                <input type="text" id="auto-search" name="auto_id" class="form-control"  data-value="{{$topCar->auto_id}}" value="{{$autoName}}">
                <div id="form-error-auto_id" class="form-error"></div>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-3 control-label data-req">{{trans('admin.base.label.deadline')}}</label>
            <div class="col-sm-3">
                <?php Calendar::render('deadline', $topCar->deadline); ?>
                <div id="form-error-deadline" class="form-error"></div>
            </div>
        </div>

        {{csrf_field()}}
    </div>
    <div class="box-footer">
        <input type="submit" class="nav-btn nav-btn-save btn btn-primary" value="{{trans('admin.base.label.save')}}">
        <a href="{{route('admin_top_car_table')}}" class="nav-btn nav-btn-cancel btn btn-default">{{trans('admin.base.label.cancel')}}</a>
    </div>
</form>
@stop