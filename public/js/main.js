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
    $('#top-cars').find('.top-block').owlCarousel({
        singleItem: true,
        autoPlay: 7000,
        navigation: true,
        navigationText: ['',''],
        //pagination: true,
        paginationSpeed: 1400,
        slideSpeed: 1400,
        rewindSpeed: 2500
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
            modelSelBox = $('.model-select .select-box'),
            modelSelect = modelSelBox.find('select'),
            html = '<option value="">'+$trans.get('www.model.select.default')+'</option>';
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
                            html += '<option value="'+result.data[i].id+'">'+result.data[i].name+'</option>';
                        }
                        modelSelBox.removeClass('disabled');
                        modelSelect.html(html).attr('disabled', false).change();
                    }
                    modelSelBox.removeClass('loading');
                }
            });
        } else {
            modelSelBox.addClass('disabled');
            modelSelect.html(html).attr('disabled', 'disabled').change();
        }
    });
};

$(document).ready(function() {
    $main.initHeaderBlocks();

    $main.initTopCars();

    $main.initSelect();

    $main.initMarkSelect();
});
