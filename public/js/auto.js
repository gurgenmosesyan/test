var $auto = {};

$auto.init = function() {
    $('#add-top').on('click', function() {
        $auto.popup('top');
        return false;
    });
    $('#add-urgent').on('click', function() {
        $auto.popup('urgent');
        return false;
    });
};

$auto.popup = function(type) {
    var popup, url, title, text, pricePerDay, html;
    if (type == 'top') {
        url = $main.basePath('/api/topCar');
        title = $trans.get('www.auto.add_top.popup.title');
        text = $trans.get('www.auto.add_top.popup.text');
        pricePerDay = $auto.topPerDay;
    } else {
        url = $main.basePath('/api/urgentCar');
        title = $trans.get('www.auto.add_urgent.popup.title');
        text = $trans.get('www.auto.add_urgent.popup.text');
        pricePerDay = $auto.urgentPerDay;
    }

    $('body').addClass('lock');
    popup = $('#popup');
    html =  '<div class="popup-wrapper auto-popup">'+
                '<div class="fb close">X</div>'+
                '<div class="popup-content">'+
                    '<h3 class="popup-title">'+title+'</h3>'+
                    '<p class="popup-text">'+text+'</p>'+
                    '<form action="" method="post">'+
                        '<div class="select-box">'+
                            '<div class="select-arrow"></div>'+
                            '<div class="select-title"></div>'+
                            '<select name="day">'+
                                '<option value="">'+$trans.get('www.auto.popup.select_day')+'</option>';
    for (var i = 1; i < 31; i++) {
        html += '<option value="'+i+'">'+i+'</option>';
    }
    html +=                 '</select>'+
                        '</div>'+
                        '<div id="form-error-day" class="form-error"></div>'+
                        '<div class="price"><span>0</span> '+$trans.get('www.auto.popup.dram')+'</div>'+
                        '<input type="hidden" name="auto_id" value="'+$auto.id+'" />'+
                        '<input type="hidden" name="_token" value="'+$main.token+'" />'+
                        '<input type="submit" class="btn dib" value="'+$trans.get('www.auto.popup.continue')+'" />'+
                    '</form>'+
                '</div>'+
            '</div>';
    html = $(html);

    $auto.initSelect(html, pricePerDay);
    $auto.initForm(html, url);

    popup.html(html).addClass('popup').stop().fadeIn(200);

    function remove() {
        popup.stop().fadeOut(200, function() {
            $('body').removeClass('lock');
            popup.removeClass('popup').html('');
        });
    }

    popup.click(function (e) {
        if ($(this).has(e.target).length === 0) {
            remove();
        }
    });
    popup.find('.close').click(function() {
        remove();
    });
    $(document).keydown(function(e) {
        if (e.keyCode == 27) {
            remove();
        }
    });
};

$auto.initSelect = function(html, pricePerDay) {
    html.find('select').change(function() {
        var self = $(this),
            text = self.find('option:selected').text();
        self.prev('.select-title').text($.trim(text));
        var value = self.val() ? self.val() : 0;
        var price = parseInt(value) * pricePerDay;
        html.find('.price span').text(price);
    }).change();
};

$auto.initForm = function(html, url) {
    html.find('form').submit(function() {
        var form = $(this);
        if (form.hasClass('loading')) {
            return false;
        }
        form.addClass('loading');
        $.ajax({
            type: 'post',
            url: url,
            data: form.serializeArray(),
            dataType: 'json',
            success: function(result) {
                html.find('.form-error').text('');
                if (result.status == 'OK') {
                    document.location.href = result.data.url;
                } else if (result.errors) {
                    for (var i in result.errors) {
                        html.find('#form-error-'+i).text(result.errors[i][0]);
                    }
                }
                form.removeClass('loading');
            }
        });
        return false;
    });
};