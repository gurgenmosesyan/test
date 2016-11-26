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

$main.preloadImages = function(images) {
    var img;
    for (var i in images) {
        img = new Image();
        img.src = images[i];
    }
};

$main.initPreloadImages = function() {
    var images = ['/images/checkbox-active.png', '/images/radio-active.png', '/images/overlay.png'];
    $main.preloadImages(images);
};

$main.initHeaderBlocks = function(html) {
    html = html || $('#header');
    html.find('#currency-link').on('click', function() {
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
    html.find('#lng-link').on('click', function() {
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
        autoPlay: 5000,
        navigation: true,
        navigationText: ['',''],
        //pagination: true,
        paginationSpeed: 1300,
        slideSpeed: 1300,
        rewindSpeed: 1500
    });
};

$main.initUrgentCars = function() {
    $('#urgent-cars').find('.car-block').owlCarousel({
        singleItem: true,
        //autoPlay: 8000,
        navigation: true,
        navigationText: ['',''],
        paginationSpeed: 1500,
        slideSpeed: 1500,
        rewindSpeed: 1700
    });
};

$main.initRecentlyCars = function() {
    $('#recently-cars').find('.car-block').owlCarousel({
        singleItem: true,
        stopOnHover: true,
        autoPlay: 5000,
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
    var quickSearch = $('#quick-search'),
        partsCalc = $('#parts-calculator'),
        taxCalc = $('#tax-calculator'),
        sell = $('#sell'),
        search = $('#search');
    $main.markSelect(quickSearch.find('.mark-select select'), quickSearch.find('.model-select .select-box'));
    $main.markSelect(partsCalc.find('.mark-select select'), partsCalc.find('.model-select .select-box'));
    $main.markSelect(taxCalc.find('.mark-select select'), taxCalc.find('.model-select .select-box'));
    $main.markSelect(sell.find('.mark-select select'), sell.find('.model-select .select-box'));
    $main.markSelect(search.find('.mark-select select'), search.find('.model-select.select-box'));
};

$main.markSelect = function(markSelect, modelSelBox) {
    var modelSelect = modelSelBox.find('select');
    markSelect.change(function() {
        var self = $(this),
            html = '';
        if (self.val()) {
            modelSelBox.addClass('loading');
            $.ajax({
                type: 'post',
                url: '/api/model',
                data: {
                    mark_id: self.val(),
                    only_model: self.data('only_model'),
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

$main.initCheckbox = function(obj) {
    obj = obj || $('.checkbox-label');
    $('input', obj).on('change', function() {
        $('input', obj).each(function() {
            if ($(this).prop('checked')) {
                $(this).parent('.checkbox-label').addClass('active');
            } else {
                $(this).parent('.checkbox-label').removeClass('active');
            }
        });
    }).change();
};

$main.initRadio = function(obj) {
    obj = obj || $('.radio-label');
    $('input', obj).on('change', function() {
        $('input', obj).each(function() {
            if ($(this).prop('checked')) {
                $(this).parent('.radio-label').addClass('active');
            } else {
                $(this).parent('.radio-label').removeClass('active');
            }
        });
    }).change();
};

$main.numberFormat = function(number, decimals, decPoint, thousandsSep) {
    number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
    var n = !isFinite(+number) ? 0 : +number;
    var prec = !isFinite(+decimals) ? 0 : Math.abs(decimals);
    var sep = (typeof thousandsSep === 'undefined') ? ',' : thousandsSep;
    var dec = (typeof decPoint === 'undefined') ? '.' : decPoint;
    var s;
    var toFixedFix = function (n, prec) {
        var k = Math.pow(10, prec);
        return '' + (Math.round(n * k) / k)
                .toFixed(prec)
    };
    // @todo: for IE parseFloat(0.55).toFixed(0) = 0;
    s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
    if (s[0].length > 3) {
        s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
    }
    if ((s[1] || '').length < prec) {
        s[1] = s[1] || '';
        s[1] += new Array(prec - s[1].length + 1).join('0');
    }
    return s.join(dec);
};

$main.initPartsCheckbox = function(html, partsBlock) {
    var partsPriceObj = $('.parts-price', partsBlock),
        servicePriceObj = $('.service-price', partsBlock),
        totalPriceObj = $('.total-price', partsBlock),
        partsPrice = partsPriceObj.data('price') ? parseInt(partsPriceObj.text()) : 0,
        servicePrice = servicePriceObj.data('price') ? parseInt(servicePriceObj.text()) : 0,
        totalPrice = totalPriceObj.data('price') ? parseInt(totalPriceObj.text()) : 0;
    $('input', html).on('change', function() {
        var self = $(this);
        if (self.prop('checked')) {
            self.parent('.checkbox-label').addClass('active');
            partsPrice += self.data('price');
            servicePrice += self.data('service_price');
            totalPrice = totalPrice + self.data('price') + self.data('service_price');
        } else {
            self.parent('.checkbox-label').removeClass('active');
            partsPrice -= self.data('price');
            servicePrice -= self.data('service_price');
            totalPrice = totalPrice - self.data('price') - self.data('service_price');
        }
        partsPriceObj.data('price', partsPrice).text($main.numberFormat(partsPrice, 0, '', '.'));
        servicePriceObj.data('price', servicePrice).text($main.numberFormat(servicePrice, 0, '', '.'));
        totalPriceObj.data('price', totalPrice).text($main.numberFormat(totalPrice, 0, '', '.'));
    });
};

$main.resetParts = function(partsBlock) {
    $('.price-info', partsBlock).remove();
    $('input:checkbox', partsBlock).attr('disabled', 'disabled').prop('checked', false).change();
    $('.checkbox-label', partsBlock).addClass('disabled');
    $('.parts-price', partsBlock).data('price', false).text('--');
    $('.service-price', partsBlock).data('price', false).text('--');
    $('.total-price', partsBlock).data('price', false).text('--');
};

$main.initParts = function() {
    var partsBlock = $('#parts-calculator'),
        markSelect = $('.mark-select select', partsBlock),
        modelSelect = $('.model-select select', partsBlock);
    markSelect.change(function() {
        $main.resetParts(partsBlock);
    });
    modelSelect.change(function() {
        var self = $(this);
        $main.resetParts(partsBlock);
        if (self.val()) {
            $('.parts-loader', partsBlock).removeClass('dpn');
            $.ajax({
                type: 'post',
                url: $main.basePath('/api/part', false),
                data: {
                    mark_id: markSelect.val(),
                    model_id: self.val(),
                    _token: $main.token
                },
                dataType: 'json',
                success: function(result) {
                    if (result.status == 'OK') {
                        result.data = $(result.data);
                        $main.initPartsCheckbox(result.data, partsBlock);
                        $('.parts-checkboxes', partsBlock).html(result.data);
                    }
                    $('.parts-loader', partsBlock).addClass('dpn');
                }
            });
        }
    });
};

$main.initTaxCalc = function() {
    var taxBox = $('#tax-calculator'),
        form = taxBox.find('form');
    taxBox.find('select').change(function() {
        taxBox.find('.service-price').text('--');
    });
    form.submit(function() {
        $.ajax({
            type: 'post',
            url: $main.basePath('/api/tax', false),
            data: form.serializeArray(),
            dataType: 'json',
            success: function(result) {
                form.find('.form-error').text('');
                taxBox.find('.service-price').text('--');
                if (result.status == 'OK') {
                    for (var i in result.data) {
                        taxBox.find('.'+i).text(result.data[i]);
                    }
                } else if (result.status == 'NOT_FOUND') {
                    form.find('.form-error').text(result.data.message);
                } else {
                    form.find('.form-error').text($trans.get('www.tax.error'));
                }
            }
        });
        return false;
    });
};

$main.initQuickSearch = function() {
    var bodies = $('#quick-search').find('.search-bodies input'),
        isChecked;
    bodies.change(function() {
        isChecked = $(this).prop('checked') ? true : false;
        bodies.each(function() {
            $(this).prop('checked', false).parent('label').removeClass('active');
        });
        if (isChecked) {
            $(this).prop('checked', true).parent('label').addClass('active');
        } else {
            $(this).prop('checked', false).parent('label').removeClass('active');
        }
    });
    bodies.each(function() {
        $(this).change();
    });
};

$main.initSearch = function() {
    var search = $('#search'),
        hiddenBox = search.find('.hidden'),
        self;
    search.find('.show-all').on('click', function() {
        self = $(this);
        if (hiddenBox.hasClass('dpn')) {
            hiddenBox.stop().slideDown(400, function() {
                self.text($trans.get('www.search.all_params.hide'));
                $(this).removeClass('dpn')
            });
        } else {
            hiddenBox.stop().slideUp(400, function() {
                self.text($trans.get('www.search.all_params'));
                $(this).addClass('dpn')
            });
        }
        return false;
    });
};

$main.initAutoImages = function() {
    var auto = $('#auto');
    auto.find('.img-thumb').on('mouseover', function() {
        auto.find('.main-img').attr('style', 'background-image: url(\''+$(this).attr('href')+'\');').attr('href', $(this).attr('href'));
        auto.find('.fancybox.dn').attr('rel', 'images-big');
        auto.find('.hidden-img'+$(this).data('id')).attr('rel', false);
        auto.find('.img-thumb.active').removeClass('active');
        $(this).addClass('active');
        return false;
    });
    auto.find('.fancybox').fancybox();
};

$main.initAutoDelete = function() {
    $('#auto-delete').on('click', function() {
        var popup = $('#popup');
        popup.popup({
            title: $trans.get('www.base.label.attention'),
            text: $trans.get('www.auto.delete.confirm.text')
        });
        var self = $(this);
        popup.find('.ok').on('click', function() {
            if (self.hasClass('deleting')) {
                return false;
            }
            self.addClass('deleting');
            $.ajax({
                type: 'post',
                url: $main.basePath('/auto/delete'),
                data: {
                    id: self.data('id'),
                    _token: $main.token
                },
                dataType: 'json',
                success: function(result) {
                    if (result.status == 'OK') {
                        document.location.href = result.data.link;
                    } else {
                        alert('Error!');
                    }
                    self.removeClass('deleting');
                }
            });
            return false;
        });
        return false;
    });
};

$main.initFavorite = function() {
    $('.favorite-icon').on('click', function() {
        var self = $(this);
        if (self.hasClass('sending')) {
            return false;
        }
        self.addClass('sending');
        var action = self.hasClass('active') ? 'delete' : 'add';
        $.ajax({
            type: 'post',
            url: $main.basePath('/api/favorite'),
            data: {
                auto_id: self.data('id'),
                action: action,
                _token: $main.token
            },
            dataType: 'json',
            success: function(result) {
                if (result.status == 'OK') {
                    self.removeClass('sending');
                    if (action == 'add') {
                        $('.fav-'+self.data('id')).addClass('active');
                    } else {
                        $('.fav-'+self.data('id')).removeClass('active');
                    }
                }
            },
            error: function(xhr) {
                if (xhr.status === 401) {
                    document.location.href = xhr.responseJSON.path;
                }
            }
        });
        return false;
    });
};

$main.initTooltip = function() {
    $('.help').tooltip({
        tooltipClass: 'tooltip-box',
        position: {
            my: "center bottom-5",
            at: "center top"
        },
        content: function() {
            var self = $(this),
                data = '<p class="t-txt">'+self.attr('title')+'</p>';
            if (self.data('url')) {
                data += '<p class="tc"><a href="'+self.data('url')+'" class="btn dib">'+$trans.get('www.tooltip.url.text')+'</a></p>';
            }
            return data;
        },
        close: function(event, ui) {
            ui.tooltip.on('mouseover', function() {
                $(this).stop(true).fadeIn(300);
            });
            ui.tooltip.on('mouseout', function() {
                $(this).fadeOut('300', function() {
                    $(this).remove();
                });
            });
        }
    });
};

$main.initPopup = function() {
    $.fn.popup = function(options) {
        var settings = $.extend({
            alert: false,
            title: '',
            text: ''
        }, options);

        $('body').addClass('lock');

        var popup = {};
        popup.self = $(this);
        popup.self.addClass('popup');

        popup.wrapper = $('<div>').addClass('popup-wrapper');
        popup.close = $('<div class="fb">X</div>').addClass('close');
        popup.content = $('<div>').addClass('popup-content');

        popup.title = $('<h3>').addClass('popup-title');
        popup.text = $('<p>').addClass('popup-text');

        popup.content.append(popup.title.text(settings.title));
        popup.content.append(popup.text.text(settings.text));

        var cancel = settings.alert ? '' : '<a href="#" class="btn dib cancel">'+$trans.get('www.base.label.cancel')+'</a>';
        var links = '<div class="popup-links">'+
                        '<a href="#" class="btn dib ok">'+$trans.get('www.base.label.ok')+'</a>'+
                        cancel+
                    '</div>';
        links = $(links);
        var closeClass = settings.alert ? '.ok' : '.cancel';
        links.find(closeClass).on('click', function() {
            popup.remove();
            return false;
        });
        popup.content.append(links);

        popup.wrapper.append(popup.close);
        popup.wrapper.append(popup.content);
        popup.self.append(popup.wrapper);
        popup.self.stop().fadeIn(200);

        popup.remove = function() {
            popup.self.stop().fadeOut(200, function() {
                $('body').removeClass('lock');
                popup.self.removeClass('popup').html('');
            });
        };

        popup.self.click(function (e) {
            if ($(this).has(e.target).length === 0) {
                popup.remove();
            }
        });
        popup.close.click(function(){
            popup.remove();
        });
        $(document).keydown(function(e){
            if (e.keyCode == 27) {
                popup.remove();
            }
        });
    };
};

$(document).ready(function() {

    $main.initHeaderBlocks();

    $main.initSelect();

    $main.initMarkSelect();

    $main.initCheckbox();

    $main.initRadio();

    $main.initQuickSearch();

    $main.initPreloadImages();

    $main.initSearch();

    $main.initFavorite();

    $main.initPopup();
});
