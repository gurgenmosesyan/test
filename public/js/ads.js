var $ad = {};

$ad.initUploaderForm = function() {
    var html =  '<div id="iframe-img-uploader" style="display: none">'+
                    '<form target="iframe-uploader" action="'+$main.basePath('/api/image/upload', false)+'" method="post" enctype="multipart/form-data">'+
                        '<input type="file" name="image" />'+
                        '<input type="text" name="module" value="ad.images.'+ $('#size-select').val() +'" />'+
                        '<input type="hidden" name="_token" value="'+ $main.token +'" />'+
                    '</form>'+
                    '<iframe src="#" id="iframe-uploader" name="iframe-uploader" style="display: none;"></iframe>'+
                '</div>';
    html = $(html);
    var loader = $('#gov-form').find('.upload-load');
    $('input[type="file"]', html).change(function() {
        loader.removeClass('dpn');
        $('form', html).submit();
    });
    $('form', html).submit(function() {
        $('iframe', html).load(function() {
            var result = $.parseJSON($(this.contentDocument).find('body').html()),
                errorObj = $('#form-error-image'),
                groupObj = $('#image-group');
            errorObj.text('');
            groupObj.removeClass('has-error');

            if (result.status == 'OK') {
                groupObj.find('.image-box').html('<img src="'+result.data.img_path+'" />');
                groupObj.find('.image-input').val(result.data.id);
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

$ad.addImage = function(imgPath, imgVal, id) {
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

$ad.initImageUpload = function() {
    var sizeSelect = $('#size-select');
    $('#upload-gov-img').on('click', function() {
        if (sizeSelect.val()) {
            $('#iframe-img-uploader').remove();
            $ad.initUploaderForm();
        } else {
            $('#popup').popup({
                title: $trans.get('www.base.label.attention'),
                text: $trans.get('www.ads.select_size.required'),
                alert: true
            });
        }
        return false;
    });
};

$ad.resetErrors = function(form) {
    form.find('.form-error').text('');
};

$ad.showErrors = function(errors, form) {
    for (var i in errors) {
        form.find('#form-error-'+i.replace(/\./g, '_')).text(errors[i][0]);
    }
};

$ad.initForm = function() {
    $('#gov-form').submit(function() {
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
                $ad.resetErrors(form);
                if (result.status == 'OK') {
                    document.location.href = result.data.url;
                } else {
                    $ad.showErrors(result.errors, form);
                }
                form.removeClass('loading');
            }
        });
        return false;
    });
};

$ad.initPrice = function() {
    $('#day-select').change(function() {
        var self = $(this),
            value = self.val() ? self.val() : 0,
            price = parseInt(value) * $ad.priceAdPerDay;
        $('#gov-form').find('.price').text(price);
    });
};

$ad.initSize = function() {
    $('#size-select').change(function() {
        var uploaderForm = $('#iframe-img-uploader');
        if ($(this).val() && uploaderForm.length > 0) {
            uploaderForm.find('input[name="module"]').val('ad.images'+$(this).val());
        }
    });
};

$ad.init = function() {

    $ad.initImageUpload();

    $ad.initSize();

    $ad.initPrice();

    $ad.initForm();
};

$(document).ready(function() {
    $ad.init();
});
