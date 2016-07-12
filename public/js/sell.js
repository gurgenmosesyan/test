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
    $('input[type="file"]', html).change(function() {
        $('form', html).submit();
    });
    $('form', html).submit(function() {
        $('iframe', html).load(function() {
            var result = $.parseJSON($(this.contentDocument).find('body').html());
            var errorObj = $('#form-error-images');
            var groupObj = $('#image-group');
            errorObj.text('');
            groupObj.removeClass('has-error');

            if (result.status == 'OK') {
                $sell.addImage(result.data.img_path, result.data.id);
            } else {
                errorObj.text(result.data.error);
                groupObj.addClass('has-error');
            }
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

$sell.init = function() {

    $sell.initCountrySelect();

    $sell.initImageUpload();
};

$(document).ready(function() {
    $sell.init();
});
