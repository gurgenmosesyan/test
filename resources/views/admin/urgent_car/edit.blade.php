<?php
use App\Core\Helpers\Calendar;

$head->appendScript('/admin/urgent_car/urgent_car.js');
$pageTitle = trans('admin.urgent_car.form.title');
$pageMenu = 'urgent_car';
if ($saveMode == 'add') {
    $pageSubTitle = trans('admin.urgent_car.form.add.sub_title');
    $url = route('admin_urgent_car_store');
} else {
    $pageSubTitle = trans('admin.urgent_car.form.edit.sub_title', ['id' => $urgentCar->id]);
    $url = route('admin_urgent_car_update', $urgentCar->id);
}
?>
@extends('core.layout')
@section('content')
<form id="edit-form" class="form-horizontal" method="post" action="{{$url}}">
    <div class="box-body">

        <div class="form-group">
            <label class="col-sm-3 control-label data-req">{{trans('admin.base.label.auto')}}</label>
            <div class="col-sm-9">
                <input type="text" id="auto-search" name="auto_id" class="form-control"  data-value="{{$urgentCar->auto_id}}" value="{{$autoName}}">
                <div id="form-error-auto_id" class="form-error"></div>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-3 control-label data-req">{{trans('admin.base.label.deadline')}}</label>
            <div class="col-sm-3">
                <?php Calendar::render('deadline', $urgentCar->deadline); ?>
                <div id="form-error-deadline" class="form-error"></div>
            </div>
        </div>

        {{csrf_field()}}
    </div>
    <div class="box-footer">
        <input type="submit" class="nav-btn nav-btn-save btn btn-primary" value="{{trans('admin.base.label.save')}}">
        <a href="{{route('admin_urgent_car_table')}}" class="nav-btn nav-btn-cancel btn btn-default">{{trans('admin.base.label.cancel')}}</a>
    </div>
</form>
@stop