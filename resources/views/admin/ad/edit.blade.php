<?php
use App\Models\Ad\Ad;
use App\Core\Helpers\ImgUploader;
use App\Core\Helpers\Calendar;

$head->appendScript('/admin/ad/ad.js');
$pageTitle = trans('admin.ad.form.title');
$pageMenu = 'ad';
if ($saveMode == 'add') {
    $pageSubTitle = trans('admin.ad.form.add.sub_title');
    $url = route('admin_ad_store');
} else {
    $pageSubTitle = trans('admin.ad.form.edit.sub_title', ['id' => $ad->id]);
    $url = route('admin_ad_update', $ad->id);
}
?>
@extends('core.layout')
@section('content')
<script type="text/javascript">
    $ad.topHelpTxt = '<?php echo ImgUploader::getHelpTexts('ad', 'top'); ?>';
    $ad.thinHelpTxt = '<?php echo ImgUploader::getHelpTexts('ad', 'thin'); ?>';
    $ad.rightHelpTxt = '<?php echo ImgUploader::getHelpTexts('ad', 'right'); ?>';
    $ad.bottomHelpTxt = '<?php echo ImgUploader::getHelpTexts('ad', 'bottom'); ?>';
</script>
<form id="edit-form" class="form-horizontal" method="post" action="{{$url}}">
    <div class="box-body">

        <div class="form-group">
            <label class="col-sm-3 control-label data-req">{{trans('admin.base.label.key')}}</label>
            <div class="col-sm-3">
                <select name="key" id="key-select" class="form-control">
                    <option value="{{Ad::KEY_TOP}}"{{$ad->key == Ad::KEY_TOP ? ' selected="selected"' : ''}}>{{trans('admin.ad.key.'.Ad::KEY_TOP)}}</option>
                    <option value="{{Ad::KEY_THIN}}"{{$ad->key == Ad::KEY_THIN ? ' selected="selected"' : ''}}>{{trans('admin.ad.key.'.Ad::KEY_THIN)}}</option>
                    <option value="{{Ad::KEY_RIGHT}}"{{$ad->key == Ad::KEY_RIGHT ? ' selected="selected"' : ''}}>{{trans('admin.ad.key.'.Ad::KEY_RIGHT)}}</option>
                    <option value="{{Ad::KEY_BOTTOM}}"{{$ad->key == Ad::KEY_BOTTOM ? ' selected="selected"' : ''}}>{{trans('admin.ad.key.'.Ad::KEY_BOTTOM)}}</option>
                </select>
                <div id="form-error-key" class="form-error"></div>
            </div>
        </div>

        <div id="img-box" class="form-group">
            <label class="col-sm-3 control-label data-req">{{trans('admin.base.label.image')}}</label>
            <div class="col-sm-9">
                <?php ImgUploader::uploader('ad', 'top', 'image', $ad->image, 'image'); ?>
            </div>
        </div>

        <div id="img-box" class="form-group">
            <label class="col-sm-3 control-label">{{trans('admin.base.label.link')}}</label>
            <div class="col-sm-9">
                <input type="text" name="link" class="form-control" value="{{$ad->link or ''}}">
                <div id="form-error-link" class="form-error"></div>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-3 control-label data-req">{{trans('admin.base.label.deadline')}}</label>
            <div class="col-sm-3">
                <?php Calendar::render('deadline', $ad->deadline); ?>
                <div id="form-error-deadline" class="form-error"></div>
            </div>
        </div>

        {{csrf_field()}}
    </div>
    <div class="box-footer">
        <input type="submit" class="nav-btn nav-btn-save btn btn-primary" value="{{trans('admin.base.label.save')}}">
        <a href="{{route('admin_ad_table')}}" class="nav-btn nav-btn-cancel btn btn-default">{{trans('admin.base.label.cancel')}}</a>
    </div>
</form>
@stop