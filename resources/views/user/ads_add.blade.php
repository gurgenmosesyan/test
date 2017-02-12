<?php
use App\Models\Ad\Ad;
use App\Models\Config\Manager;

$head->appendScript('/js/ads.js');

$title = trans('www.user.ads.title');

$meta->title($title);
$meta->ogTitle($title);
$meta->ogImage(url('/images/fb-logo.png'));

$priceAdPerDay = Manager::getPriceAdPerDay();

$jsTrans->addTrans([
    'www.base.label.attention',
    'www.ads.select_size.required'
]);

?>
@extends('layout')

@section('content')

<script type="text/javascript">
    $ad.priceAdPerDay = {{$priceAdPerDay->value}};
</script>
<div class="page">

    <div id="profile">
        <div class="links tc">
            <div class="link profile-link fl">
                <a href="{{url_with_lng('/profile', false)}}" class="item db fb">
                    <span class="icon dib"></span>
                    <span class="text dib">{{trans('www.profile.link.my_profile')}}</span>
                </a>
            </div>
            <div class="link cars-link fl">
                <a href="{{url_with_lng('/profile/autos', false)}}" class="item db fb">
                    <span class="icon dib"></span>
                    <span class="text dib">{{trans('www.profile.link.my_cars')}}</span>
                </a>
            </div>
            <div class="link ads-link fl">
                <span class="item db fb active">
                    <span class="icon dib"></span>
                    <span class="text dib">{{trans('www.profile.link.my_ads')}}</span>
                </span>
            </div>
            <div class="cb"></div>
        </div>

        <div id="profile-govs">
            <div class="back-gov-btn tc">
                <a href="{{url_with_lng('/profile/ads', false)}}" class="underline dib fb">{{trans('www.ads.back.btn')}}</a>
            </div>

            <form id="gov-form" action="{{url_with_lng('/api/ad', false)}}" method="post">

                <div class="form-box">
                    <label class="required fl"><span>{{trans('www.ads.label.size')}}</span></label>
                    <div class="mark-select inp fl">
                        <div class="select-box">
                            <div class="select-arrow"></div>
                            <div class="select-title">{{trans('www.base.label.select')}}</div>
                            <select id="size-select" name="key">
                                <option value="">{{trans('www.base.label.select')}}</option>
                                <option value="{{Ad::KEY_THIN}}">{{trans('www.ads.label.size.thin')}} (520x95)px</option>
                                <option value="{{Ad::KEY_RIGHT}}">{{trans('www.ads.label.size.right')}} (303x254)px</option>
                                <option value="{{Ad::KEY_BOTTOM}}">{{trans('www.ads.label.size.bottom')}} (290x250)px</option>
                            </select>
                        </div>
                        <div id="form-error-key" class="form-error"></div>
                    </div>
                    <div class="cb"></div>
                </div>
                <div class="form-box" id="image-group">
                    <label class="fl required"><span>{{trans('www.ads.label.image')}}</span></label>
                    <div class="inp fl">
                        <a href="#" id="upload-gov-img" class="btn dib">{{trans('www.ads.label.image.upload')}}</a>
                        <div class="dib upload-load dpn"></div>
                        <div id="form-error-image" class="form-error"></div>
                        <div class="image-box"></div>
                        <input type="hidden" class="image-input" name="image" value="" />
                    </div>
                    <div class="cb"></div>
                </div>
                <div class="form-box">
                    <label class="fl"><span>{{trans('www.ads.label.link')}}</span></label>
                    <div class="inp fl">
                        <input type="text" name="link" value="">
                        <div id="form-error-link" class="form-error"></div>
                    </div>
                    <div class="cb"></div>
                </div>
                <div class="form-box">
                    <label class="required fl"><span>{{trans('www.ads.label.day_count')}}</span></label>
                    <div class="mark-select inp fl">
                        <div class="select-box">
                            <div class="select-arrow"></div>
                            <div class="select-title">{{trans('www.base.label.select')}}</div>
                            <select id="day-select" name="day">
                                <option value="">{{trans('www.base.label.select')}}</option>
                                @for($i = 1; $i < 31; $i++)
                                    <option value="{{$i}}">{{$i}}</option>
                                @endfor
                            </select>
                        </div>
                        <div id="form-error-day" class="form-error"></div>
                    </div>
                    <div class="cb"></div>
                </div>
                <div class="form-box">
                    <label class="fl">&nbsp;</label>
                    <div class="inp fl">
                        <span class="price">0</span> {{trans('www.ads.price.dram')}}
                    </div>
                    <div class="cb"></div>
                </div>
                {!! csrf_field() !!}
                <div class="form-box">
                    <label class="fl">&nbsp;</label>
                    <div class="inp fl">
                        <input type="submit" class="btn" value="{{trans('www.ads.form.add.btn')}}" />
                    </div>
                    <div class="cb"></div>
                </div>
            </form>

        </div>
    </div>

</div>

@stop