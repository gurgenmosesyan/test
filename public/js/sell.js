var $sell = {};
$sell.imgIndex = 0;

$sell.initCountrySelect = function() {
    var sell = $('#sell'),
        regionSelectBox = sell.find('.region-select'),
        regionSelect = regionSelectBox.find('select');
    sell.find('.country-select select').change(function() {
        var self = $(this),
            html = '';
        if (self.val()) {
            regionSelectBox.addClass('loading');
            $.ajax({
                type: 'post',
                url: $main.basePath('/api/region'),
                data: {
                    country_id: self.val(),
                    _token: $main.token
                },
                dataType: 'json',
                success: function(result) {
                    if (result.status == 'OK') {
                        for (var i in result.data) {
                            html += '<option class="opt" value="'+result.data[i].id+'">'+result.data[i].name+'</option>';
                        }
                        regionSelectBox.removeClass('disabled');
                        regionSelect.find('.opt').remove();
                        regionSelect.append(html).attr('disabled', false).change();
                    }
                    regionSelectBox.removeClass('loading');
                }
            });
        } else {
            regionSelectBox.addClass('disabled');
            regionSelect.find('.opt').remove();
            regionSelect.append(html).attr('disabled', 'disabled').change();
        }
    });
};

$sell.initUploaderForm = function() {
    var html =  '<div id="iframe-img-uploader" style="display: none">'+
                    '<form target="iframe-uploader" action="'+$main.basePath('/api/image/upload', false)+'" method="post" enctype="multipart/form-data">'+
                        '<input type="file" name="image" />'+
                        '<input type="text" name="module" value="auto.images.images" />'+
                        '<input type="hidden" name="_token" value="'+ $main.token +'" />'+
                    '</form>'+
                    '<iframe src="#" id="iframe-uploader" name="iframe-uploader" style="display: none;"></iframe>'+
                '</div>';
    html = $(html);
    var loader = $('#sell').find('.upload-load');
    $('input[type="file"]', html).change(function() {
        loader.removeClass('dpn');
        $('form', html).submit();
    });
    $('form', html).submit(function() {
        $('iframe', html).load(function() {
            var result = $.parseJSON($(this.contentDocument).find('body').html()),
                errorObj = $('#form-error-images'),
                groupObj = $('#image-group');
            errorObj.text('');
            groupObj.removeClass('has-error');

            if (result.status == 'OK') {
                $sell.addImage(result.data.img_path, result.data.id);
            } else {
                errorObj.text(result.data.error);
                groupObj.addClass('has-error');
            }
            loader.addClass('dpn');
        });
    });
    $('body').append(html);
    $('input[type="file"]', html).trigger('click');
};

$sell.addImage = function(imgPath, imgVal, id) {
    var idStr = id ? '<input type="hidden" name="images['+$sell.imgIndex+'][id]" value="'+id+'" />' : '';
    var labelClass = '',
        checked = '';
    if (imgPath.indexOf($sell.defImgSrc) != -1) {
        labelClass = ' active';
        checked = ' checked="checked"';
    }
    var html =  '<div class="img-box fl">'+
                    '<div class="img-item tc">'+
                        '<img class="uploaded-image" src="'+imgPath+'" />'+
                    '</div>'+
                    '<input type="hidden" name="images['+$sell.imgIndex+'][image]" value="'+imgVal+'" />'+
                    '<input type="hidden" class="rotate-input" name="images['+$sell.imgIndex+'][rotate]" value="0" />'+
                    idStr+
                    '<label class="default dib'+labelClass+'">'+
                        '<input type="radio" name="images['+$sell.imgIndex+'][default]" value="1"'+checked+' />'+
                    '</label>'+
                    '<div class="img-tools">'+
                        '<a href="#" class="rotate-left dib"></a>'+
                        '<a href="#" class="rotate-right dib"></a>'+
                        '<a href="#" class="delete-img dib"></a>'+
                    '</div>'+
                    '<div id="form-error-images_'+$sell.imgIndex+'_image" class="form-error"></div>'+
                '</div>';
    html = $(html);
    $sell.initImageTools(html);
    var sellImages = $('#sell-images');
    sellImages.append(html);
    $sell.initDefaultRadio(sellImages);
    $sell.imgIndex++;
};

$sell.initImageTools = function(html) {
    $('.delete-img', html).on('click', function() {
        html.remove();
        return false;
    });
    $('.rotate-left', html).on('click', function() {
        $sell.imgRotate(90, html);
        return false;
    });
    $('.rotate-right', html).on('click', function() {
        $sell.imgRotate(-90, html);
        return false;
    });
};

$sell.initDefaultRadio = function(obj) {
    var checked = false;
    $('input:radio', obj).on('change', function() {
        if ($(this).prop('checked')) {
            checked = true;
        }
        $('input:radio', obj).prop('checked', false);
        $('.default', obj).removeClass('active');
        if (checked) {
            $(this).prop('checked', true);
            $(this).parent('label').addClass('active');
        }
    });
};

$sell.imgRotate = function(size, html) {
    var rotate = parseInt($('.rotate-input', html).val()) + size;
    if (rotate > 270) {
        rotate = 0;
    } else if (rotate < 0) {
        rotate = 270;
    }
    $('.uploaded-image', html).removeClass('rotate90 rotate180 rotate270').addClass('rotate' + rotate);
    $('.rotate-input', html).val(rotate);
};

$sell.generateImages = function() {
    if (!$.isEmptyObject($sell.images)) {
        for (var i in $sell.images) {
            var imgPath = '/images/auto/'+$sell.images[i].image;
            $sell.addImage(imgPath, 'same', $sell.images[i].id);
        }
    }
};

$sell.initImageUpload = function() {
    $('#upload-image').on('click', function() {
        if ($('#sell-images').find('.img-box').length > 9) {
            $('#popup').popup({
                alert: true,
                title: $trans.get('www.base.label.attention'),
                text: $trans.get('www.auto.images.limit.text')
            });
            return false;
        }
        $('#iframe-img-uploader').remove();
        $sell.initUploaderForm();
        return false;
    });
    $sell.generateImages();
};

$sell.resetForm = function(form) {
    $('.has-error', form).removeClass('has-error');
    $('.form-error', form).text('');
};

$sell.showErrors = function(form, errors) {
    for (var i in errors) {
        $('#form-error-'+i.replace(/\./g, '_'), form).text(errors[i][0]).closest('.form-box').addClass('has-error');
    }
    if (!$sell.pages) {
        $('html, body').animate({
            scrollTop: $('.has-error:first').offset().top-20
        }, 500);
    }
};

$sell.initPrice = function() {
    var contract = $('#contract'),
        auction = $('#auction'),
        priceBox = $('#price-box');
    contract.on('change', function() {
        if ($(this).prop('checked')) {
            priceBox.find('input, select').attr('disabled', 'disabled');
            priceBox.find('input').val('');
            priceBox.find('.select-box').addClass('disabled');
            priceBox.find('label').removeClass('required');
            auction.prop('checked', false).trigger('change');
            $('#auction-group').find('.icheckbox_minimal-blue').removeClass('checked');
        } else if (!auction.prop('checked')) {
            priceBox.find('input, select').attr('disabled', false);
            priceBox.find('.select-box').removeClass('disabled');
            priceBox.find('label').addClass('required');
        }
    }).trigger('change');
    auction.on('change', function() {
        if ($(this).prop('checked')) {
            priceBox.find('input, select').attr('disabled', 'disabled');
            priceBox.find('input').val('');
            priceBox.find('.select-box').addClass('disabled');
            priceBox.find('label').removeClass('required');
            contract.prop('checked', false).trigger('change');
            $('#contract-group').find('.icheckbox_minimal-blue').removeClass('checked');
        } else if (!contract.prop('checked')) {
            priceBox.find('input, select').attr('disabled', false);
            priceBox.find('.select-box').removeClass('disabled');
            priceBox.find('label').addClass('required');
        }
    }).trigger('change');
};

$sell.initPages = function() {
    $sell.pages = true;
    $sell.page1 = $('#page1');
    $sell.page2 = $('#page2');
    $sell.page3 = $('#page3');
    $sell.page4 = $('#page4');
    $sell.page5 = $('#page5');
    $sell.page6 = $('#page6');
    $sell.page7 = $('#page7');
    $sell.backBox = $('#back-box');
    $sell.submit = $('#submit');
    $sell.action = $('#action');
    $('#back').on('click', function() {
        if ($sell.page2.hasClass('opened')) {
            $sell.page2.removeClass('opened').stop().fadeOut(400, function() {
                $sell.page1.addClass('opened').stop().fadeIn(400);
                $sell.backBox.stop().fadeOut(400);
            });
        } else if ($sell.page3.hasClass('opened')) {
            $sell.page3.removeClass('opened').stop().fadeOut(400, function() {
                $sell.page2.addClass('opened').stop().fadeIn(400);
            });
        } else if ($sell.page4.hasClass('opened')) {
            $sell.page4.removeClass('opened').stop().fadeOut(400, function() {
                $sell.page3.addClass('opened').stop().fadeIn(400);
            });
        } else if ($sell.page5.hasClass('opened')) {
            $sell.page5.removeClass('opened').stop().fadeOut(400, function() {
                $sell.page4.addClass('opened').stop().fadeIn(400);
            });
        } else if ($sell.page6.hasClass('opened')) {
            $sell.page6.removeClass('opened').stop().fadeOut(400, function() {
                $sell.page5.addClass('opened').stop().fadeIn(400);
            });
        } else if ($sell.page7.hasClass('opened')) {
            $sell.submit.val($trans.get('www.sell_car.next'));
            $sell.action.val('next');
            $sell.page7.removeClass('opened').stop().fadeOut(400, function () {
                $sell.page6.addClass('opened').stop().fadeIn(400);
            });
        }
        return false;
    });
};

$sell.checkPages = function(form, result) {
    var errors = result.errors;
    if ($sell.page1.hasClass('opened')) {
        if (!errors || (!errors.mark_id && !errors.model_id && !errors.year)) {
            $sell.resetForm(form);
            $sell.page1.removeClass('opened').stop().fadeOut(400, function() {
                $sell.page2.addClass('opened').stop().fadeIn(400);
                $sell.backBox.stop().fadeIn(400);
            });
        }
    } else if ($sell.page2.hasClass('opened')) {
        if (!errors || (!errors.transmission_id && !errors.rudder_id && !errors.body_id && !errors.tuning && !errors.color_id && !errors.interior_color_id)) {
            $sell.resetForm(form);
            $sell.page2.removeClass('opened').stop().fadeOut(400, function() {
                $sell.page3.addClass('opened').stop().fadeIn(400);
            });
        }
    } else if ($sell.page3.hasClass('opened')) {
        if (!errors || (!errors.engine_id && !errors.volume && !errors.horsepower && !errors.train_id && !errors.cylinders && !errors.vin && !errors.mileage && !errors.mileage_measurement)) {
            $sell.resetForm(form);
            $sell.page3.removeClass('opened').stop().fadeOut(400, function() {
                $sell.page4.addClass('opened').stop().fadeIn(400);
            });
        }
    } else if ($sell.page4.hasClass('opened')) {
        if (!errors.country_id && !errors.region_id && !errors.place) {
            $sell.resetForm(form);
            $sell.page4.removeClass('opened').stop().fadeOut(400, function() {
                $sell.page5.addClass('opened').stop().fadeIn(400);
            });
        }
    } else if ($sell.page5.hasClass('opened')) {
        if (!errors || (!errors.term && !errors.price && !errors.currency_id && !errors.additional_phone && !errors.contract && !errors.exchange && !errors.damaged && !errors.auction && !errors.partial_pay && !errors.bank && !errors.custom_cleared)) {
            $sell.resetForm(form);
            $sell.page5.removeClass('opened').stop().fadeOut(400, function() {
                $sell.page6.addClass('opened').stop().fadeIn(400);
            });
        }
    } else if ($sell.page6.hasClass('opened')) {
        if (!errors) {
            $sell.resetForm(form);
            $sell.submit.val($trans.get('www.sell_car.submit'));
            $sell.action.val('submit');
            $sell.page6.removeClass('opened').stop().fadeOut(400, function() {
                $sell.page7.addClass('opened').stop().fadeIn(400);
            });
        }
    }  else if ($sell.page7.hasClass('opened')) {
        if (result.status == 'OK') {
            document.location.href = result.data.link;
        } else if (result.status == 'AUTO_LIMIT') {
            $('#popup').popup({
                alert: true,
                title: $trans.get('www.base.label.attention'),
                text: result.errors.limit
            });
        }
    }
};

$sell.initForm = function() {
    $('#sell-form').submit(function() {
        var form = $(this);
        if (form.hasClass('loading')) {
            return false;
        }
        form.addClass('loading');
        $.ajax({
            type: 'post',
            url: form.attr('action'),
            data: form.serializeArray(),
            dataType: 'json',
            success: function(result) {
                $sell.resetForm(form);
                if (result.status != 'OK') {
                    $sell.showErrors(form, result.errors);
                }
                $sell.checkPages(form, result);
                form.removeClass('loading');
            }
        });
        return false;
    });
};

$sell.initNumber = function() {
    $('.number').on('keypress', function(e) {
        if (e.charCode < 48 || e.charCode > 57) {
            return false;
        }
    });
};

$sell.initMainPhone = function() {
    var additionalPhone = $('#additional-phone');
    $('#hide-main-phone').change(function() {
        if ($(this).prop('checked')) {
            additionalPhone.addClass('required');
        } else {
            additionalPhone.removeClass('required');
        }
    });
};

$sell.init = function() {

    $sell.initCountrySelect();

    $sell.initImageUpload();

    $sell.initPrice();

    $sell.initForm();

    $sell.initNumber();

    $sell.initMainPhone();
};

$(document).ready(function() {
    $sell.init();
});
