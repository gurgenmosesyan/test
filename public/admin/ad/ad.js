var $ad = $.extend(true, {}, $main);
$ad.listPath = '/management/cms/ad';
$ad.firstInit = true;

$ad.initSearchPage = function() {
    var self = this;
    $main.table = $('#data-table').DataTable({
        "pageLength": 25,
        "autoWidth": false,
        "processing": true,
        "oLanguage": {
            "sProcessing": $trans.get('admin.base.label.loading')
        },
        "serverSide": true,
        "ajax": {
            "url": self.getListPath(),
            "type": "post",
            "data": {
                '_token': $main.token
            },
            error: function (xhr) {
                if (xhr.status === 401) {
                    document.location.href = xhr.responseJSON.path;
                }
            }
        },
        "columns": [
            {data: 'id'},
            {data: 'key'},
            {data: 'user'},
            {
                data: 'image',
                sortable: false
            },
            {data: 'deadline'},
            {
                data: 'status',
                render: function(status) {
                    var html = '<span>'+ status + '</span> ';
                    if (status == 'pending' || status == 'confirmed') {
                        html += '<a href="#" class="btn btn-xs btn-danger status-btn" data-status="declined">Decline</a>';
                    }
                    if (status == 'pending' || status == 'declined') {
                        html += '<a href="#" class="btn btn-xs btn-success status-btn" data-status="confirmed">Confirm</a> ';
                    }
                    return html;
                }
            },
            {
                "data": null,
                "render": function(data) {
                    return '<div class="text-center"><a href="'+ self.getListPath() +'/edit/'+data.id+'"><i class="fa fa-pencil"></i></a>'+
                        '<a class="action-remove" href="#"><i class="fa fa-trash"></i></a></div>';
                },
                "orderable": false
            }
        ],
        "order": [[5, "asc"]],
        "fnRowCallback": function(row, data) {
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
        $ad.confirmModal = $ad.getStatusConfirmModal();
        $ad.confirmModal.modal();
        $('.change', $ad.confirmModal).on('click', function() {
            $ad.changeStatus(data.id, status);
            return false;
        });
        return false;
    });
};

$ad.changeStatus = function(id, status) {
    $.ajax({
        type: 'post',
        url: '/management/cms/ad/changeStatus',
        data: {
            id: id,
            status: status,
            _token: $main.token
        },
        dataType: 'json',
        success: function(result) {
            $ad.confirmModal.modal('hide');
            if (result.status == 'OK') {
                $main.table.ajax.reload();
            } else {
                alert('Error! Don\'t change');
            }
        }
    });
};

$ad.getStatusConfirmModal = function() {
    return $('<div id="delete-confirm" class="modal fade" tabindex="-1" role="dialog">'+
                '<div class="modal-dialog">'+
                    '<div class="modal-content">'+
                        '<div class="modal-header">'+
                            '<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                            '<h4 class="modal-title">'+ $trans.get('admin.base.label.attention') +'</h4>'+
                        '</div>'+
                        '<div class="modal-body">'+$trans.get('admin.auto.modal.status.text')+'</div>'+
                        '<div class="modal-footer">'+
                            '<button type="button" class="btn btn-default" data-dismiss="modal">'+ $trans.get('admin.base.label.close') +'</button>'+
                            '<button type="button" class="btn btn-primary change">'+ $trans.get('admin.base.label.ok') +'</button>'+
                        '</div>'+
                    '</div>'+
                '</div>'+
            '</div>');
};

$ad.initKey = function() {
    var imgBox = $('#img-box'),
        helpTxt, module;
    $('#key-select').change(function() {
        var self = $(this);
        if (!$ad.firstInit) {
            imgBox.find('img').attr('src', '/core/images/img-default.png');
            imgBox.find('.img-uploader-id').val('');
        }
        $ad.firstInit = false;
        if (self.val() == 'top') {
            helpTxt = $ad.topHelpTxt;
        } else if (self.val() == 'thin') {
            helpTxt = $ad.thinHelpTxt;
        } else if (self.val() == 'right') {
            helpTxt = $ad.rightHelpTxt;
        } else if (self.val() == 'bottom') {
            helpTxt = $ad.bottomHelpTxt;
        }
        imgBox.find('.img-uploader-box').data('module', 'ad.images.'+self.val());
        imgBox.find('.img-uploader-help').text(helpTxt);
        imgBox.removeClass('dn');
    }).change();
};

$ad.initEditPage = function() {

    $ad.initForm();

    $ad.initKey();
};

$ad.init();
