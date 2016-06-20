'use strict';

var $trans = function() {
    return $trans.get.apply(arguments);
};
$trans.transMap = null;

$trans.get = function (key, paramData) {
    try {
        if ($trans.transMap  == null) {
            var locSettings = $locSettings || {};
            $trans.transMap = locSettings.trans || {};
        }
        if (typeof $trans.transMap[key] != "undefined") {
            key = $trans.transMap[key];
            if (paramData) {
                for (var i in paramData) {
                    if (paramData.hasOwnProperty(i)) {
                        key = key.replace("{"+i+"}",paramData[i]);
                    }
                }
            }
            return key;
        }
    }
    catch(e){}
    return key;
};

var $main = {};

$main.basePath = function(path, lngCode) {
    var baseUrl;
    if (typeof lngCode == 'undefined') {
        baseUrl = $main.baseUrlWithLng;
    } else {
        baseUrl = lngCode ? $main.baseUrlWithLng : $main.baseUrl;
    }
    return baseUrl + path;
};

$main.preloadImages = function() {
    var images = ['/images/checkbox-active.png'],
        img;
    for (var i in images) {
        img = new Image();
        img.src = images[i];
    }
};

$main.initHeaderBlocks = function() {
    $('#currency-link').on('click', function() {
        var list = $('#currency-list');
        list.stop().slideToggle(300);
        $('#lng-list').slideUp(300);
        $(document).unbind('click').bind('click', function(e) {
            if (!$(e.target).parents().is('#currency-list')) {
                list.stop().slideToggle(300);
                $(document).unbind('click');
            }
        });
        return false;
    });
    $('#lng-link').on('click', function() {
        var list = $('#lng-list');
        list.stop().slideToggle(300);
        $('#currency-list').slideUp(300);
        $(document).unbind('click').bind('click', function(e) {
            if (!$(e.target).parents().is('#lng-list')) {
                list.stop().slideToggle(300);
                $(document).unbind('click');
            }
        });
        return false;
    });
};

$main.initTopCars = function() {
    $('#top-cars').find('.car-block').owlCarousel({
        singleItem: true,
        stopOnHover: true,
        autoPlay: 7000,
        navigation: true,
        navigationText: ['',''],
        //pagination: true,
        paginationSpeed: 1400,
        slideSpeed: 1400,
        rewindSpeed: 2500
    });
};

$main.initUrgentCars = function() {
    $('#urgent-cars').find('.car-block').owlCarousel({
        singleItem: true,
        //autoPlay: 8000,
        navigation: true,
        navigationText: ['',''],
        paginationSpeed: 1700,
        slideSpeed: 1700,
        rewindSpeed: 1700
    });
};

$main.initRecentlyCars = function() {
    $('#recently-cars').find('.car-block').owlCarousel({
        singleItem: true,
        stopOnHover: true,
        autoPlay: 7000,
        navigation: true,
        navigationText: ['',''],
        paginationSpeed: 1500,
        slideSpeed: 1500,
        rewindSpeed: 1500
    });
};

$main.initSelect = function() {
    $('select').change(function() {
        var self = $(this),
            text = self.find('option:selected').text();
        self.prev('.select-title').text($.trim(text));
    }).change();
};

$main.initMarkSelect = function() {
    $('.mark-select select').change(function() {
        var self = $(this),
            modelSelBox = self.parents('.mark-select').next('.model-select').find('.select-box'),
            modelSelect = modelSelBox.find('select'),
            html = '';
        if (self.val()) {
            modelSelBox.addClass('loading');
            $.ajax({
                type: 'post',
                url: '/api/model',
                data: {
                    mark_id: self.val(),
                    _token: $main.token
                },
                dataType: 'json',
                success: function(result) {
                    if (result.status == 'OK') {
                        for (var i in result.data) {
                            html += '<option class="opt" value="'+result.data[i].id+'">'+result.data[i].name+'</option>';
                        }
                        modelSelBox.removeClass('disabled');
                        modelSelect.find('.opt').remove();
                        modelSelect.append(html).attr('disabled', false).change();
                    }
                    modelSelBox.removeClass('loading');
                }
            });
        } else {
            modelSelBox.addClass('disabled');
            modelSelect.find('.opt').remove();
            modelSelect.append(html).attr('disabled', 'disabled').change();
        }
    });
};

$main.initPriceRange = function() {
    var priceRangeBox = $('#price-range-box');
    $('#price-range').slider({
        range: true,
        min: 0,
        max: $main.priceMax,
        values: [$main.priceFrom, $main.priceTo],
        step: $main.priceStep,
        slide: function(event, ui) {
            priceRangeBox.find('.price-from').val(ui.values[0]);
            priceRangeBox.find('.price-to').val(ui.values[1]);
            priceRangeBox.find('.price-from-text').text(ui.values[0]);
            priceRangeBox.find('.price-to-text').text(ui.values[1]);
        }
    });
};

$main.initCheckbox = function() {
    $('.checkbox-label input').on('change', function() {
        $('.checkbox-label input').each(function() {
            if ($(this).prop('checked')) {
                $(this).parent('.checkbox-label').addClass('active');
            } else {
                $(this).parent('.checkbox-label').removeClass('active');
            }
        });
    });
};

$(document).ready(function() {
    $main.initHeaderBlocks();

    $main.initTopCars();

    $main.initUrgentCars();

    $main.initRecentlyCars();

    $main.initSelect();

    $main.initMarkSelect();

    $main.initPriceRange();

    $main.initCheckbox();

    $main.preloadImages();
});
