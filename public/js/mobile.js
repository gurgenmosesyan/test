'use strict';

var $mobile = {};

$mobile.initBurger = function() {
    var header = $('#header'),
        mobileMenu = '<ul id="mobile-menu" class="dn">',
        profile = header.find('.username');

    mobileMenu += '<li class="sell-car">'+header.find('.sell-car').html()+'</li>';
    mobileMenu += '<li class="currency">'+header.find('.currency').html()+'</li>';
    mobileMenu += '<li class="lng">'+header.find('.lng').html()+'</li>';
    mobileMenu += '<li class="favorite">'+header.find('.favorite').html()+'</li>';
    mobileMenu += '<li class="history">'+header.find('.history').html()+'</li>';
    if (profile.length > 0) {
        mobileMenu += '<li class="username">'+profile.html()+'</li>';
    } else {
        mobileMenu += '<li class="login">'+header.find('.login').html()+'</li>';
        mobileMenu += '<li class="registration">'+header.find('.registration').html()+'</li>';
    }

    mobileMenu += '</ul>';
    mobileMenu = $(mobileMenu);
    header.append(mobileMenu);
    $main.initHeaderBlocks(mobileMenu);

    var burger = '<a href="#" id="burger" class="db">'+
                     '<span class="burger1 db"></span>'+
                     '<span class="burger2 db"></span>'+
                     '<span class="burger3 db"></span>'+
                 '</a>';
    burger = $(burger);

    burger.on('click', function() {
        $(this).toggleClass('open');
        mobileMenu.stop().slideToggle();
        return false;
    });
    header.prepend(burger);

    header.find('.header-right').remove();
};

$mobile.initPrice = function() {
    var priceBox = $('#price-range-box'),
        html =  '<div class="price-from">'+
                    '<input type="text" name="price_from" value="" placeholder="'+$trans.get('www.price_from')+'">'+
                '</div>'+
                '<div>'+
                    '<input type="text" name="price_to" value="" placeholder="'+$trans.get('www.price_to')+'">'+
                '</div>';
    priceBox.html(html);
};

$mobile.init = function() {

    $mobile.initBurger();

    $mobile.initPrice();

    $('#top-cars').insertAfter('#quick-search').show();
};

$(document).ready(function() {
    $mobile.init();
});
