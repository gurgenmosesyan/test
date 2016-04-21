var $model = $.extend(true, {}, $main);
$model.listPath = '/management/cms/model';

$model.initSearchPage = function() {
    $model.listColumns = [
        {data: 'id'},
        {data: 'mark_name'},
        {data: 'category_name'},
        {data: 'name'}
    ];
    $model.initSearch();
};

$model.generateCategories = function(data) {
    if ($.isEmptyObject(data)) {
        $('#category-group').addClass('dn');
        return;
    }
    var html = '<option value="">'+ $trans.get('admin.base.label.select') +'</option>';
    for (var i in data) {
        html += '<option value="'+ data[i].id +'">'+ data[i].name +'</option>';
    }
    $('#category-select').html('').append(html).change();
    $('#category-group').removeClass('dn');
};

$model.getCategories = function (markId) {
    $.ajax({
        type: 'post',
        url: '/management/cms/api/modelCategory/get',
        data: {
            mark_id: markId,
            _token: $main.token
        },
        dataType: 'json',
        success: function(result) {
            if (result.status == 'OK') {
                $model.generateCategories(result.data);
            }
        }
    });
};

$model.initCategory = function() {
    $('#mark-select').change(function() {
        if ($(this).val()) {
            $model.getCategories($(this).val());
        } else {
            $('#category-group').addClass('dn');
        }
    });
};

$model.initEditPage = function() {
    $model.initForm();

    $model.initCategory();
};

$model.init();
