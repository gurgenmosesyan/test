<?php
use App\Models\Currency\CurrencyManager;
use App\Helpers\Base;

if ($part == null) {
    for($i = 1; $i < 11; $i++) {
?>
        <div class="part-checkbox">
            <label class="checkbox-label no-select disabled">
                {{trans('www.part.form.part'.$i)}}
                <input type="checkbox" value="1" disabled="disabled" />
            </label>
        </div>
<?php
    }
    return;
}

$currencyManager = new CurrencyManager();
$currencies = $currencyManager->all();
$defCurrency = $currencyManager->defaultCurrency();
$cCurrency = $currencyManager->currentCurrency();

for($i = 1; $i < 11; $i++) {
    $priceProp = 'part'.$i.'_price';
    $servicePriceProp = 'part'.$i.'_service_price';
    $price = $part->$priceProp;
    $servicePrice = $part->$servicePriceProp;

    $title = trans('www.part.form.part'.$i);
    if (empty($price)) {
        $class = ' disabled';
        $attr = ' disabled="disabled"';
    } else {
        $class = $attr = '';
        $title .= '<span class="price-info"> '.Base::partPrice($part, $price, $currencies, $defCurrency, $cCurrency);
        if (!empty($servicePrice)) {
            $title .= ', '.trans('www.part.form.service_price_text').' '.Base::partPrice($part, $servicePrice, $currencies, $defCurrency, $cCurrency);;
        }
        $title .= '</span>';
    }
?>
    <div class="part-checkbox">
        <label class="checkbox-label no-select{{$class}}">
            {!!$title!!}
            <input type="checkbox" value="1" data-price="{{$price}}" data-service_price="{{$servicePrice}}"{{$attr}} />
        </label>
    </div>
<?php
}
?>