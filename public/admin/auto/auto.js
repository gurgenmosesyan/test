var $auto = $.extend(true, {}, $main);
$auto.listPath = '/admpanel/auto';
$auto.imgIndex = 0;

$auto.initSearchPage = function() {
    /*$auto.listColumns = [
        {data: 'id'},
        {data: 'mark_name'},
        {data: 'model_name'},
        {data: 'year'}
    ];
    $auto.initSearch();*/

    var self = this;
    $main.table = $('#data-table').DataTable({
        "autoWidth": false,
        "processing": true,
        "oLanguage": {
            "sProcessing": $trans.get('admin.base.label.loading')
        },
        "serverSide": true,
        "ajax": {
            "url": self.listPath,
            "type": "post",
            "data": {
                '_token': $main.token
            }
        },
        "columns": [
            {data: 'id'},
            {data: 'mark_name'},
            {data: 'model_name'},
            {data: 'year'},
            {
                data: 'status',
                render: function(status) {
                    var html = '<span>'+ status + '</span> ';
                    if (status == 'pending' || status == 'approved') {
                        html += '<a href="#" class="btn btn-xs btn-danger status-btn" data-status="blocked">Block</a>';
                    }
                    if (status == 'pending' || status == 'blocked') {
                        html += '<a href="#" class="btn btn-xs btn-success status-btn" data-status="approved">Approve</a> ';
                    }
                    return html;
                }
            },
            {
                data: null,
                render: function(data) {
                    return '<div class="text-center"><a href="'+ self.listPath +'/edit/'+data.id+'"><i class="fa fa-pencil"></i></a>'+
                        '<a class="action-remove" href="#"><i class="fa fa-trash"></i></a></div>';
                },
                "orderable": false
            }
        ],
        "order": [[4, "asc"]],
        "fnRowCallback": function(row, data) {
            console.log(row);
            console.log(data);
            if (data.status == 'pending') {
                $('td', row).addClass('pending');
            }
        }
    });
    $('#data-table tbody').on('click', '.action-remove', function() {
        var data = $main.table.row($(this).parents('tr')).data();
        $main.confirmModal = $main.getConfirmModal();
        $main.confirmModal.modal();
        $('.delete', $main.confirmModal).on('click', function() {
            self.deleteObj(data.id);
            return false;
        });
        return false;
    });
    $('#data-table tbody').on('click', '.status-btn', function() {
        var status = $(this).data('status');
        var data = $main.table.row($(this).parents('tr')).data();
        $auto.confirmModal = $auto.getStatusConfirmModal();
        $auto.confirmModal.modal();
        $('.change', $auto.confirmModal).on('click', function() {
            $auto.changeStatus(data.id, status);
            return false;
        });
        return false;
    });
};

$auto.changeStatus = function(id, status) {
    $.ajax({
        type: 'post',
        url: '/admpanel/auto/changeStatus',
        data: {
            id: id,
            status: status,
            _token: $main.token
        },
        dataType: 'json',
        success: function(result) {
            $auto.confirmModal.modal('hide');
            if (result.status == 'OK') {
                $main.table.ajax.reload();
            } else {
                alert('Error! Don\'t change');
            }
        }
    });
};

$auto.getStatusConfirmModal = function() {
    return $('<div id="delete-confirm" class="modal fade" tabindex="-1" role="dialog">'+
                '<div class="modal-dialog">'+
                    '<div class="modal-content">'+
                        '<div class="modal-header">'+
                            '<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                            '<h4 class="modal-title">'+ $trans.get('admin.base.label.attention') +'</h4>'+
                        '</div>'+
                        '<div class="modal-body">'+$trans.get('admin.auto.modal.status.text')+
                        '</div>'+
                        '<div class="modal-footer">'+
                            '<button type="button" class="btn btn-default" data-dismiss="modal">'+ $trans.get('admin.base.label.close') +'</button>'+
                            '<button type="button" class="btn btn-primary change">'+ $trans.get('admin.base.label.ok') +'</button>'+
                        '</div>'+
                    '</div>'+
                '</div>'+
            '</div>');
};

$auto.generateModels = function(data) {
    var html = '';
    for (var i in data) {
        html += '<option value="'+ data[i].id +'">'+ data[i].name +'</option>';
    }
    $('#model-select').append(html).change();
};

$auto.getModels = function(markId) {
    $.ajax({
        type: 'post',
        url: '/admpanel/api/model/get',
        data: {
            mark_id: markId,
            _token: $main.token
        },
        dataType: 'json',
        success: function(result) {
            if (result.status == 'OK') {
                $auto.generateModels(result.data);
            }
        }
    });
};

$auto.initModel = function() {
    $('#mark-select').change(function() {
        $('#model-select').html('<option value="">'+ $trans.get('admin.base.label.select') +'</option>').change();
        if ($(this).val()) {
            $auto.getModels($(this).val());
        }
    });
};

$auto.generateRegions = function(data) {
    var html = '';
    for (var i in data) {
        html += '<option value="'+ data[i].id +'">'+ data[i].name +'</option>';
    }
    $('#region-select').append(html).change();
};

$auto.getRegions = function(countryId) {
    $.ajax({
        type: 'post',
        url: '/admpanel/api/region/get',
        data: {
            country_id: countryId,
            _token: $main.token
        },
        dataType: 'json',
        success: function(result) {
            if (result.status == 'OK') {
                $auto.generateRegions(result.data);
            }
        }
    });
};

$auto.initRegion = function() {
    $('#country-select').change(function() {
        $('#region-select').html('<option value="">'+ $trans.get('admin.base.label.select') +'</option>').change();
        if ($(this).val()) {
            $auto.getRegions($(this).val());
        }
    }).change();
};

$auto.initUploaderForm = function() {
    var html =  '<div id="iframe-img-uploader" style="display: none">'+
                    '<form target="iframe-uploader" action="/admpanel/core/image/upload" method="post" enctype="multipart/form-data">'+
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
                $auto.addImage(result.data.img_path, result.data.id);
            } else {
                errorObj.text(result.data.error);
                groupObj.addClass('has-error');
            }
        });
    });
    $('body').append(html);
    $('input[type="file"]', html).trigger('click');
};

$auto.addImage = function(imgPath, imgVal, id) {
    var idStr = id ? '<input type="hidden" name="images['+ $auto.imgIndex +'][id]" value="'+ id +'" />' : '';
    var html =  '<div class="img-thumbnail img-block">'+
                    '<div class="img-item">'+
                        '<img class="uploaded-image" src="'+ imgPath +'" />'+
                    '</div>'+
                    '<input type="hidden" name="images['+ $auto.imgIndex +'][image]" value="'+ imgVal +'" />'+
                    '<input type="hidden" class="rotate-input" name="images['+ $auto.imgIndex +'][rotate]" value="0" />'+
                    idStr+
                    '<div class="img-tools text-center">'+
                        '<a href="#" class="btn btn-xs btn-default rotate-left"><i class="fa fa-undo"></i></a>'+
                        '<a href="#" class="btn btn-xs btn-default rotate-right"><i class="fa fa-repeat"></i></a>'+
                        '<a href="#" class="btn btn-xs btn-danger delete-img"><i class="fa fa-remove"></i></a>'+
                    '</div>'+
                '</div>';
    html = $(html);
    $auto.initImageTools(html);
    $('#images-block').append(html);
    $auto.imgIndex++;
};

$auto.initImageTools = function(html) {
    $('.delete-img', html).on('click', function() {
        html.remove();
        return false;
    });
    $('.rotate-left', html).on('click', function() {
        $auto.imgRotate(90, html);
        return false;
    });
    $('.rotate-right', html).on('click', function() {
        $auto.imgRotate(-90, html);
        return false;
    });
};

$auto.imgRotate = function(size, html) {
    var rotate = parseInt($('.rotate-input', html).val()) + size;
    if (rotate > 270) {
        rotate = 0;
    } else if (rotate < 0) {
        rotate = 270;
    }
    $('.uploaded-image', html).removeClass('rotate90 rotate180 rotate270').addClass('rotate' + rotate);
    $('.rotate-input', html).val(rotate);
};

$auto.generateImages = function() {
    if (!$.isEmptyObject($auto.images)) {
        for (var i in $auto.images) {
            var imgPath = '/images/auto/'+$auto.images[i].image;
            $auto.addImage(imgPath, 'same', $auto.images[i].id);
        }
    }
};

$auto.initImageUpload = function() {
    $('#upload-image').on('click', function() {
        if ($('#images-block').find('.img-block').length > 9) {
            $('#auto-modal').modal();
            return false;
        }
        $('#iframe-img-uploader').remove();
        $auto.initUploaderForm();
        return false;
    });

    $auto.generateImages();
};

$auto.initPrice = function() {
    var contract = $('#contract'),
        auction = $('#auction'),
        priceGroup = $('#price-group');
    contract.on('ifChanged', function() {
        if ($(this).prop('checked')) {
            priceGroup.find('input').val('').attr('disabled', 'disabled');
            auction.prop('checked', false).trigger('ifChanged');
            $('#auction-group').find('.icheckbox_minimal-blue').removeClass('checked');
        } else if (!auction.prop('checked')) {
            priceGroup.find('input').attr('disabled', false);
        }
    }).trigger('ifChanged');

    auction.on('ifChanged', function() {
        if ($(this).prop('checked')) {
            priceGroup.find('input').val('').attr('disabled', 'disabled');
            contract.prop('checked', false).trigger('ifChanged');
            $('#contract-group').find('.icheckbox_minimal-blue').removeClass('checked');
        } else if (!contract.prop('checked')) {
            priceGroup.find('input').attr('disabled', false);
        }
    }).trigger('ifChanged');
};

$auto.initEditPage = function() {
    $auto.initForm();

    $auto.initModel();

    $auto.initRegion();

    $auto.initImageUpload();

    $auto.initPrice();
};

$auto.init();
