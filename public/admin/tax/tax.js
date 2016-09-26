var $tax = $.extend(true, {}, $main);
$tax.listPath = '/management/cms/tax';

$tax.initSearchPage = function() {
    $tax.listColumns = [
        {data: 'id'},
        {data: 'mark_name'},
        {data: 'model_name'},
        {data: 'year'},
        {data: 'engine_name'},
        {data: 'volume'},
        {data: 'price'}
    ];
    $tax.initSearch();
};

$tax.generateModels = function(data) {
    var html = '';
    for (var i in data) {
        html += '<option value="'+ data[i].id +'">'+ data[i].name +'</option>';
    }
    $('#model-select').append(html).change();
};

$tax.getModels = function(markId) {
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
                $tax.generateModels(result.data);
            }
        }
    });
};

$tax.initModel = function() {
    $('#mark-select').change(function() {
        $('#model-select').html('<option value="">'+ $trans.get('admin.base.label.select') +'</option>').change();
        if ($(this).val()) {
            $tax.getModels($(this).val());
        }
    });
};

$tax.initEditPage = function() {

    $tax.initForm();

    $tax.initModel();

};

$tax.init();
