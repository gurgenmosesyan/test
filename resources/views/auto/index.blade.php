<?php
use App\Models\Auto\Auto;
use App\Models\TopCar\TopCar;
use App\Models\UrgentCar\UrgentCar;
use App\Helpers\Base;
use App\Models\Config\Manager;

$head->appendStyle('/css/jquery.fancybox.css');
$head->appendScript('/js/jquery.fancybox.pack.js');
$head->appendScript('/js/auto.js');

$prices = Manager::getPaymentPrices();

if ($auto->isContract()) {
    $price = trans('www.auto.price.contract');
} else if ($auto->isAuction()) {
    $price = trans('www.auto.price.auction');
} else {
    $price = Base::price($auto, $currencies, $defCurrency, $cCurrency, 'code');
}

$autoEmpty = Manager::getAutoEmpty();
$autoImage = $auto->getImage($autoEmpty);

$title = $auto->mark->name.' '.$auto->model->name.' '.$auto->year.', '.strtoupper($price);
$details = $auto->country_ml->name.', '.$auto->year.', '.$auto->mileageInfo().', '.$auto->body_ml->name.', '.$auto->color_ml->name.', '.$auto->engine_ml->name.', '.$auto->transmission_ml->name.', '.$auto->rudder_ml->name;
$meta->title($title);
$meta->description($details);
$meta->keywords($details);
$meta->ogTitle($title);
$meta->ogDescription($details);
$meta->ogImage($autoImage);
$meta->ogUrl(url_with_lng('/auto/'.$auto->auto_id));

$autoOptions = $auto->options->keyBy('option_id');

$jsTrans->addTrans([
    'www.auto.delete.confirm.text',
    'www.auto.add_top.popup.title',
    'www.auto.add_top.popup.text',
    'www.auto.add_urgent.popup.title',
    'www.auto.add_urgent.popup.text',
    'www.auto.popup.select_day',
    'www.auto.popup.dram',
    'www.auto.popup.continue',
]);
?>
@extends('layout')

@section('content')

<div class="page">

    @include('blocks.top_banner')

    <div id="main-left" class="fl">

        <div id="auto">
            <div class="top-box fb">
                <h1 class="fl">{{$auto->mark->name.' '.$auto->model->name}}</h1>
                <p class="fr">
                    @if($auto->isContract())
                        {{trans('www.auto.price.contract')}}
                    @elseif($auto->isAuction())
                        {{trans('www.auto.price.auction')}}
                    @else
                        {{Base::price($auto, $currencies, $defCurrency, $cCurrency)}}
                    @endif
                    <?php
                    $priceInfo = '';
                    if ($auto->isBank()) {
                        $priceInfo .= trans('www.auto.price.bank').', ';
                    }
                    if ($auto->isExchange()) {
                        $priceInfo .= trans('www.auto.price.exchange').', ';
                    }
                    if ($auto->isPartialPay()) {
                        $priceInfo .= trans('www.auto.price.partial_pay');
                    }
                    if (!empty($priceInfo)) {
                        echo ' <span class="fs16 fbn">(' . rtrim($priceInfo, ', ') . ')</span>';
                    }
                    ?>
                </p>
                <div class="cb"></div>
                <div class="mt25">
                    <p class="fs14 fbn fl">
                        <?php
                        $countryInfo = $auto->country_ml->name.', ';
                        if (!empty($auto->region_id)) {
                            $countryInfo .= $auto->region_ml->name.', ';
                        }
                        if (!empty($auto->place)) {
                            $countryInfo .= $auto->place;
                        }
                        echo rtrim($countryInfo, ', ');
                        ?>
                    </p>
                    <div class="fr">
                        <?php
                        $topStr = $urgentStr = '';
                        if (Auth::guard('user')->check()) {
                            $user = Auth::guard('user')->user();
                            if ($user->id == $auto->user_id) {
                                if ($auto->isBlocked()) {
                                    echo '<p class="dib auto-status red fs16">'.trans('www.auto.status.blocked').'</p>';
                                }
                                if (!$auto->isInTerm()) {
                                    echo '<p class="dib auto-status red fs16 ml20">'.trans('www.auto.out_of_term').'</p>';
                                }
                                $topCar = TopCar::where('auto_id', $auto->id)->active()->inDate()->first();
                                if ($topCar != null) {
                                    $topStr = '<span>'.e(trans('www.auto.in_top', ['deadline' => date('d.m.Y', strtotime($topCar->deadline))])).'</span>, ';
                                    if (!$auto->isBlocked() && $auto->isInTerm()) {
                                        $topStr .= '<a href="#" id="add-top" class="underline">'.e(trans('www.base.label.add')).'</a>';
                                    }
                                }
                                $urgentCar = UrgentCar::where('auto_id', $auto->id)->active()->inDate()->first();
                                if ($urgentCar != null) {
                                    $urgentStr = '<span>'.e(trans('www.auto.in_urgent', ['deadline' => date('d.m.Y', strtotime($urgentCar->deadline))])).'</span>, ';
                                    if (!$auto->isBlocked() && $auto->isInTerm()) {
                                        $urgentStr .= '<a href="#" id="add-urgent" class="underline">'.e(trans('www.base.label.add')).'</a>';
                                    }
                                }
                                if (!$auto->isBlocked() && $auto->isInTerm()) {
                                    if ($topCar == null) {
                                        echo '<a href="#" id="add-top" class="dib btn">'.trans('www.base.label.add_top').'</a>';
                                    }
                                    if ($urgentCar == null) {
                                        echo '<a href="#" id="add-urgent" class="dib btn ml10">'.trans('www.base.label.add_urgent').'</a>';
                                    }
                                }
                                echo '<a href="'.route('auto_edit', [cLng('code'), $auto->id]).'" class="btn dib ml20">'.trans('www.base.label.edit').'</a>';
                                echo '<a href="#" id="auto-delete" class="dib btn btn-red ml10" data-id="'.$auto->id.'">'.trans('www.base.label.delete').'</a>';
                            }
                        }
                        ?>
                    </div>
                    <div class="cb"></div>
                    @if(!empty($topStr))
                        <p class="tr mt20 fs16">{!! $topStr !!}</p>
                    @endif
                    @if(!empty($urgentStr))
                        <p class="tr mt20 fs16">{!! $urgentStr !!}</p>
                    @endif
                </div>
                <div class="views-count fs14 mt10">{{$auto->views_count}}</div>
            </div>
            <div class="line"></div>
            <div class="main-box">
                <div class="main-left fl">
                    <p class="fl key">{{trans('www.auto.year')}}</p>
                    <p class="fl value fb">{{$auto->year}}</p>
                    <div class="cb"></div>
                    <p class="fl key">{{trans('www.auto.mileage')}}</p>
                    <p class="fl value fb">{{$auto->mileageInfo()}}</p>
                    <div class="cb"></div>
                    <p class="fl key">{{trans('www.auto.body')}}</p>
                    <p class="fl value">{{$auto->body_ml->name}}</p>
                    <div class="cb"></div>
                    <p class="fl key">{{trans('www.auto.color')}}</p>
                    <p class="fl value">{{$auto->color_ml->name}}</p>
                    <div class="cb"></div>
                    @if(!empty($auto->interior_color_id))
                        <p class="fl key">{{trans('www.auto.interior_color')}}</p>
                        <p class="fl value">{{$auto->interior_color_ml->name}}</p>
                        <div class="cb"></div>
                    @endif
                    <p class="fl key">{{trans('www.auto.engine')}}</p>
                    <p class="fl value">
                        @if(!empty($auto->volume)){{number_format($auto->volume, 1).' / '}}@endif
                        @if(!empty($auto->horsepower)){{$auto->horsepower.' '.trans('www.horsepower.short').' / '}}@endif
                        {{$auto->engine_ml->name}}
                    </p>
                    <div class="cb"></div>
                    <p class="fl key">{{trans('www.auto.transmission')}}</p>
                    <p class="fl value">{{$auto->transmission_ml->name}}</p>
                    <div class="cb"></div>
                    @if(!empty($auto->train_id))
                        <p class="fl key">{{trans('www.auto.train')}}</p>
                        <p class="fl value">{{$auto->train_ml->name}}</p>
                        <div class="cb"></div>
                    @endif
                    <p class="fl key">{{trans('www.auto.rudder')}}</p>
                    <p class="fl value">{{$auto->rudder_ml->name}}</p>
                    <div class="cb"></div>
                    @if(!empty($auto->tuning))
                        <p class="fl key">{{trans('www.auto.tuning')}}</p>
                        <p class="fl value">{{$auto->tuning}}</p>
                        <div class="cb"></div>
                    @endif
                    @if(!empty($auto->cylinders))
                        <p class="fl key">{{trans('www.auto.cylinders')}}</p>
                        <p class="fl value">{{$auto->cylinders}}</p>
                        <div class="cb"></div>
                    @endif
                    @if(!empty($auto->doors))
                        <p class="fl key">{{trans('www.auto.doors')}}</p>
                        <p class="fl value">{{$auto->doors}}</p>
                        <div class="cb"></div>
                    @endif
                    @if(!empty($auto->wheels))
                        <p class="fl key">{{trans('www.auto.wheels')}}</p>
                        <p class="fl value">{{$auto->wheels}}"</p>
                        <div class="cb"></div>
                    @endif
                    <p class="mt10">
                    @if($auto->isCustomCleared())
                        {{trans('www.auto.customs_cleared.yes')}}
                    @else
                        {{trans('www.auto.customs_cleared.no')}}
                    @endif
                    </p>
                    @if($auto->isDamaged())
                        <p>{{trans('www.auto.damaged')}}</p>
                    @endif
                    <br />
                    <?php $mainPhone = false; ?>
                    @if($auto->user && $auto->hide_main_phone == Auto::NOT_HIDE_MAIN_PHONE)
                        <?php $mainPhone = true; ?>
                        <p class="fl key">{{trans('www.auto.phone')}}</p>
                        <p class="fl value">{{$auto->user->phone}}</p>
                        <div class="cb"></div>
                    @endif
                    @if(!empty($auto->additional_phone) || !empty($auto->additional_phone2) || !empty($auto->additional_phone3))
                        <p class="fl key">{{$mainPhone ? trans('www.auto.additional_phone') : trans('www.auto.phone')}}</p>
                        <div class="fl value">
                            @if(!empty($auto->additional_phone))
                                <p>{{$auto->additional_phone}}</p>
                            @endif
                            @if(!empty($auto->additional_phone2))
                                <p>{{$auto->additional_phone2}}</p>
                            @endif
                            @if(!empty($auto->additional_phone3))
                                <p>{{$auto->additional_phone3}}</p>
                            @endif
                        </div>
                        <div class="cb"></div>
                    @endif
                    @if(!empty($auto->description))
                        <div class="desc mt25 lh22">{{$auto->description}}</div>
                    @endif
                </div>
                <div class="main-right fl">

                    <div class="images-box">
                        <span class="favorite-icon fav-{{$auto->id}} db{{$isFavorite ? ' active' : ''}}" data-id="{{$auto->id}}"></span>
                        <?php $autoImage = $auto->images->isEmpty() ? $autoImage : $auto->images[0]->getImage(); ?>
                        <a class="main-img db fancybox" href="{{$autoImage}}" rel="images-big" style="background-image: url('{{$autoImage}}');"></a>
                        @if(!empty($auto->images))
                            <div class="images">
                                <?php $images = []; ?>
                                @foreach($auto->images as $key => $image)
                                    <a href="{{$image->getImage()}}" class="fancybox dn hidden-img{{$image->id}}"{{$key != 0 ? 'rel=images-big' : ''}}></a>
                                    <a href="{{$image->getImage()}}" data-id="{{$image->id}}" class="db fl img-thumb fancybox{{$key%4 == 0 ? ' mln' : ''}}{{$key == 0 ? ' active' : ''}}" rel="images" style="background-image: url('{{$image->getThumb()}}');"></a>
                                    <?php $images[] = $image->getImage(); ?>
                                @endforeach
                                <div class="cb"></div>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="cb"></div>

                <div class="options mt5">
                    @foreach($options as $key => $option)
                        <div class="option fl{{$key%2 == 0 ? ' bg' : ''}}{{isset($autoOptions[$option->id]) ? ' active' : ''}}">
                            <div class="opt-item fs15">{{$option->name}}</div>
                        </div>
                    @endforeach
                    <div class="cb"></div>
                </div>
            </div>
        </div>

    </div>

    @include('blocks.right_banner')

    <div class="cb"></div>

</div>
<script type="text/javascript">
    $main.initAutoImages();
    $main.preloadImages(<?php echo json_encode($images); ?>);
    $main.initAutoDelete();
    $auto.id = '{{$auto->id}}';
    $auto.topPerDay = {{$prices['price_top_per_day']->value}};
    $auto.urgentPerDay = {{$prices['price_urgent_per_day']->value}};
    $auto.init();
</script>
@stop