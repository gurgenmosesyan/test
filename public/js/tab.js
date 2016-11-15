var $tab = {};

$tab.initPrice = function() {
    var priceBox = $('#price-range-box'),
        html =  '<div class="price-from" style="margin-bottom: 27px;">'+
                    '<input type="text" name="price_from" value="" placeholder="'+$trans.get('www.price_from')+'">'+
                '</div>'+
                '<div>'+
                    '<input type="text" name="price_to" value="" placeholder="'+$trans.get('www.price_to')+'">'+
                '</div>';
    priceBox.html(html);
};

$tab.init = function() {
    $tab.initPrice();
};

$(document).ready(function() {
    $tab.init();
});
