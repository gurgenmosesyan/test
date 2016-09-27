<?php
use App\Core\Language\Language;
use App\Models\Currency\CurrencyManager;
use App\Models\Config\Manager;

$logo = Manager::getLogo();

$user = Auth::guard('user')->user();
$languages = Language::all();
if (!isset($currencies)) {
    $currencyManager = new CurrencyManager();
    $currencies = $currencyManager->all();
    $defCurrency = $currencyManager->defaultCurrency();
    $cCurrency = $currencyManager->currentCurrency();
}

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>{{$title.' - autotrade.am'}}</title>
    <link rel="icon" href="{{url('/favicon.png')}}" />
    <link rel="shortcut icon" href="{{url('/favicon.ico')}}" />
    <?php
    $head->appendMainStyle('/css/main.css');

    $head->appendMainScript('/js/jquery-2.1.4.min.js');
    $head->appendMainScript('/js/main.js');

    $head->renderStyles();
    $head->renderScripts();

    $jsTrans->addTrans([
        'www.base.label.ok',
        'www.base.label.cancel',
        'www.base.label.attention'
    ]);
    ?>
</head>
<body>
<script type="text/javascript">
    $main.baseUrl = '{{url('')}}';
    $main.baseUrlWithLng = '{{url_with_lng('', false)}}';
    $main.cCurrency = <?php echo json_encode($cCurrency); ?>;
    $main.token = '{{csrf_token()}}';
    var $locSettings = {"trans": <?php echo json_encode($jsTrans->getTrans()); ?>};
</script>
<script>
    window.fbAsyncInit = function() {
        FB.init({
            appId: '{{config('social.fb.app_id')}}',
            cookie: true,
            xfbml: true,
            version: 'v2.5'
        });
    };
    (function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = "//connect.facebook.net/en_US/sdk.js";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));
</script>

<div id="page">

    <div id="header">
        <div class="page">
            <div class="header-left fl">
                <div id="logo" style="background-image: url('{{$logo}}');">
                    <a href="{{url_with_lng('')}}" class="db"></a>
                </div>
            </div>
            <div class="header-right fr">
                <div class="sell-car fl">
                    <a href="{{url_with_lng('/sell', false)}}" class="db fb">{{trans('www.header.sell_car.btn')}}</a>
                </div>
                <div class="right-box currency-lng fl">
                    <div class="right-inner-box currency fl">
                        <a id="currency-link" href="#" class="box-link tu db" style="background-image: url('{{url($cCurrency->getIcon())}}');">{{$cCurrency->code}}</a>
                        <ul id="currency-list" class="dpn">
                            @foreach($currencies as $currency)
                                @if($currency->id != $cCurrency->id)
                                    <li><a href="{{url_with_lng('/currency?id='.$currency->id, false)}}" class="db tu tc">{{$currency->code}}</a></li>
                                @endif
                            @endforeach
                        </ul>
                    </div>
                    <div class="right-inner-box lng fl">
                        <a id="lng-link" href="#" class="box-link tu db" style="background-image: url('/images/language/{{cLng('icon')}}');">
                            {{trans('www.lng.switcher.'.cLng('code'))}}
                        </a>
                        <ul id="lng-list" class="dpn">
                            @foreach($languages as $lng)
                                @if($lng->id != cLng('id'))
                                    <li><a href="{{url('/'.$lng->code.'/')}}" class="db tu tc">{{trans('www.lng.switcher.'.$lng->code)}}</a></li>
                                @endif
                            @endforeach
                        </ul>
                    </div>
                    <div class="cb"></div>
                </div>
                <div class="right-box fav-history fl">
                    <div class="right-inner-box favorite fl">
                        <a href="{{url_with_lng('/favorite', false)}}" class="box-link db">{{trans('www.header.favorites')}}</a>
                    </div>
                    <div class="right-inner-box history fl">
                        <a href="{{url_with_lng('/history', false)}}" class="box-link db">{{trans('www.header.history')}}</a>
                    </div>
                    <div class="cb"></div>
                </div>
                <div class="right-box profile fl">
                    @if(Auth::guard('user')->guest())
                        <div class="right-inner-box login fl">
                            <a href="{{url_with_lng('/login')}}" class="box-link db">{{trans('www.header.sign_in')}}</a>
                        </div>
                        <div class="right-inner-box registration fl">
                            <a href="{{url_with_lng('/registration')}}" class="box-link db">{{trans('www.header.sign_up')}}</a>
                        </div>
                        <div class="cb"></div>
                    @else
                        <div class="right-inner-box username fl">
                            <a href="{{url_with_lng('/profile')}}" class="box-link db">{{$user->first_name}}</a>
                        </div>
                    @endif
                </div>
                <div class="cb"></div>
            </div>
            <div class="cb"></div>
        </div>
    </div>

    <div id="content">
    @yield('content')
    </div>

    <div id="footer-block">
        <div class="page">
            <div id="footer">
                <div class="footer-left fl">
                    <ul class="footer-menu">
                        <li class="fl"><a href="#">{{trans('www.footer.menu.contact')}}</a></li>
                        <li class="fl"><a href="#">{{trans('www.footer.menu.faq')}}</a></li>
                        <li class="fl"><a href="#">{{trans('www.footer.menu.privacy_policy')}}</a></li>
                        <li class="fl"><a href="#">{{trans('www.footer.menu.terms')}}</a></li>
                        <li class="fl"><a href="#">{{trans('www.footer.menu.advertisement')}}</a></li>
                        <li class="fl last"><a href="#">{{trans('www.footer.menu.sell_car')}}</a></li>
                        <li class="cb"></li>
                    </ul>
                    <div class="footer-contacts fl">
                        <p class="footer-contact">{!!trans('www.footer.contact.phone')!!}</p>
                        <p class="footer-contact">{!!trans('www.footer.contact.email')!!}</p>
                        <p class="footer-contact">{!!trans('www.footer.contact.copyright')!!}</p>
                    </div>
                    <div class="footer-join fl">
                        <p class="tc">{{trans('www.footer.join.title')}}</p>
                        <ul>
                            <li class="fl">
                                <a href="{{trans('www.footer.social.fb.link')}}" class="facebook db" target="_blank"></a>
                            </li>
                            <li class="fl">
                                <a href="{{trans('www.footer.social.intagram.link')}}" class="instagram db" target="_blank"></a>
                            </li>
                            <li class="cb"></li>
                        </ul>
                    </div>
                    <div class="footer-payments fl">
                        <p class="tc">{{trans('www.footer.payments.title')}}</p>
                        <ul>
                            <li class="fl">
                                <a href="{{trans('www.footer.payment.paypal.link')}}" class="paypal db" target="_blank"></a>
                            </li>
                            <li class="fl">
                                <a href="{{trans('www.footer.payment.telcell.link')}}" class="telcell db" target="_blank"></a>
                            </li>
                            <li class="fl">
                                <a href="{{trans('www.footer.payment.arca.link')}}" class="arca db" target="_blank"></a>
                            </li>
                            <li class="cb"></li>
                        </ul>
                    </div>
                    <div class="cb"></div>
                </div>
                <div class="footer-right fr">
                    <p>{{trans('www.footer.right.text')}}</p>
                    <div><span class="dib"></span> Autotrade.am</div>
                </div>
                <div class="cb"></div>
                <div class="website-by tc">
                    <div class="dib">
                        {!!trans('www.footer.website_by.text')!!}
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<div id="popup"></div>

</body>
</html>