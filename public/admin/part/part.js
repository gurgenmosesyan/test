var $part = $.extend(true, {}, $main);
$part.listPath = '/management/cms/part';

$part.initSearchPage = function() {
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
            },
            error: function (xhr) {
                if (xhr.status === 401) {
                    document.location.href = xhr.responseJSON.path;
                }
            }
        },
        "columns": [
            {data: 'id'},
            {data: 'mark_name'},
            {data: 'model_name'},
            {
                data: null,
                render: function(data) {
                    return '<div class="text-center"><a href="'+ self.listPath +'/edit/'+data.id+'"><i class="fa fa-pencil"></i></a>'+
                        '<a class="action-remove" href="#"><i class="fa fa-trash"></i></a></div>';
                },
                "orderable": false
            }
        ],
        "order": [[0, "desc"]]
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

    $part.initFilters();

    $part.initModel();
};

$part.initFilters = function() {
    $('#filters').appendTo($('#data-table_length').parent('div').prev('div'));
    $('#filters input, #filters select').change(function() {
        var self = $(this);
        $main.table.column(self.data('column')).search(self.val());
    });
    $('#search-form').submit(function() {
        $main.table.draw();
        return false;
    });
};

$part.generateModels = function(data) {
    var html = '';
    for (var i in data) {
        html += '<option value="'+ data[i].id +'">'+ data[i].name +'</option>';
    }
    $('#model-select').append(html).change();
};

$part.getModels = function(markId) {
    $.ajax({
        type: 'post',
        url: '/management/cms/api/model/get',
        data: {
            mark_id: markId,
            _token: $main.token
        },
        dataType: 'json',
        success: function(result) {
            if (result.status == 'OK') {
                $part.generateModels(result.data);
            }
        }
    });
};

$part.initModel = function() {
    $('#mark-select').change(function() {
        $('#model-select').html('<option value="">'+ $trans.get('admin.base.label.select') +'</option>').change();
        if ($(this).val()) {
            $part.getModels($(this).val());
        }
    });
};

$part.initEditPage = function() {
    $part.initForm();

    $part.initModel();
};

$part.init();
