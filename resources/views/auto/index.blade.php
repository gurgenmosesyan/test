<?php
use App\Models\Auto\Auto;
use App\Helpers\Base;
use App\Models\Config\Manager;

$head->appendStyle('/css/jquery.fancybox.css');
$head->appendScript('/js/jquery.fancybox.pack.js');

$price = Base::price($auto, $currencies, $defCurrency, $cCurrency, 'code');
$title = $auto->mark->name.' '.$auto->model->name.' '.$auto->year.', '.strtoupper($price);

$autoEmpty = Manager::getAutoEmpty();

$autoOptions = $auto->options->keyBy('option_id');
?>
@extends('layout')

@section('content')

<div class="page">

    <div id="top-banner" class="tc">
        <a href="#">
            <img src="/images/temp/top-banner.jpg" />
        </a>
    </div>

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
                <p class="fs14 fbn mt25">
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
                        @if(!empty($auto->volume_1)){{$auto->volume_1.'.'.$auto->volume_2.' / '}}@endif
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
                        <p class="fl value">{{$auto->wheels}}</p>
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
                    <p class="fl key mt20">{{trans('www.auto.phone')}}</p>
                    <p class="fl value mt20">{{$auto->user->phone}}</p>
                    <div class="cb"></div>
                    @if(!empty($auto->additional_phone))
                        <p class="fl key">{{trans('www.auto.additional_phone')}}</p>
                        <p class="fl value">{{$auto->additional_phone}}</p>
                        <div class="cb"></div>
                    @endif
                    @if(!empty($auto->description))
                        <div class="desc mt25">{{$auto->description}}</div>
                    @endif
                </div>
                <div class="main-right fl">

                    <div class="images-box">
                        <div class="main-img" style="background-image: url('{{$auto->getImage($autoEmpty)}}');"></div>
                        @if(!empty($auto->images))
                            <div class="images">
                                <?php $images = []; ?>
                                @foreach($auto->images as $key => $image)
                                    <a href="{{$image->getImage()}}" class="db fl img-thumb{{$key%4 == 0 ? ' mln' : ''}}{{$key == 0 ? ' active' : ''}}" rel="images" style="background-image: url('{{$image->getThumb()}}');"></a>
                                    <?php $images[] = $image->getImage(); ?>
                                @endforeach
                                <div class="cb"></div>
                            </div>
                        @endif
                    </div>

                    <div class="options">
                        <?php $i = 1; ?>
                        @foreach($options as $option)
                            <?php
                            $class = '';
                            if ($i == 0 || $i == 1) {
                                $class = ' bg';
                            } else if ($i == 3) {
                                $i = -1;
                            }
                            $i++;
                            ?>
                            <div class="option fl{{$class}}{{isset($autoOptions[$option->id]) ? ' active' : ''}}">
                                <div class="opt-item fs15">
                                    {{$option->name}}
                                </div>
                            </div>
                        @endforeach
                        <div class="cb"></div>
                    </div>

                </div>
                <div class="cb"></div>
            </div>
        </div>

    </div>

    <div id="main-right" class="fl">
        <img src="/images/temp/r-ad-1.jpg">
    </div>
    <div class="cb"></div>

</div>
<script type="text/javascript">
    $main.initAutoImages();
    $main.preloadImages(<?php echo json_encode($images); ?>);
</script>
@stop