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
    var html =  '<div class="img-box fl">'+
                    '<div class="img-item tc">'+
                        '<img class="uploaded-image" src="'+imgPath+'" />'+
                    '</div>'+
                    '<input type="hidden" name="images['+$sell.imgIndex+'][image]" value="'+imgVal+'" />'+
                    '<input type="hidden" class="rotate-input" name="images['+$sell.imgIndex+'][rotate]" value="0" />'+
                    idStr+
                    '<div class="img-tools">'+
                        '<a href="#" class="rotate-left dib"></a>'+
                        '<a href="#" class="rotate-right dib"></a>'+
                        '<a href="#" class="delete-img dib"></a>'+
                    '</div>'+
                    '<div id="form-error-images_'+$sell.imgIndex+'_image" class="form-error"></div>'+
                '</div>';
    html = $(html);
    $sell.initImageTools(html);
    $('#sell-images').append(html);
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
            alert('Max images count 10');
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
    $('html, body').animate({
        scrollTop: $('.has-error:first').offset().top-20
    }, 500);
};

$sell.initPrice = function() {
    var contract = $('#contract'),
        auction = $('#auction'),
        priceLabel = $('#price-label');
    contract.on('change', function() {
        if ($(this).prop('checked')) {
            priceLabel.removeClass('required');
            auction.prop('checked', false).trigger('change');
            $('#auction-group').find('.icheckbox_minimal-blue').removeClass('checked');
        } else if (!auction.prop('checked')) {
            priceLabel.addClass('required');
        }
    }).trigger('change');
    auction.on('change', function() {
        if ($(this).prop('checked')) {
            priceLabel.removeClass('required');
            contract.prop('checked', false).trigger('change');
            $('#contract-group').find('.icheckbox_minimal-blue').removeClass('checked');
        } else if (!contract.prop('checked')) {
            priceLabel.addClass('required');
        }
    }).trigger('change');
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
                if (result.status == 'OK') {
                    document.location.href = result.data.link;
                } else {
                    $sell.showErrors(form, result.errors);
                }
                form.removeClass('loading');
            }
        });
        return false;
    });
};

$sell.init = function() {

    $sell.initCountrySelect();

    $sell.initImageUpload();

    $sell.initPrice();

    $sell.initForm();
};

$(document).ready(function() {
    $sell.init();
});
