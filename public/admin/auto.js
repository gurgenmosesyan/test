var $auto = $.extend(true, {}, $main);
$auto.listPath = '/admpanel/auto';

$auto.initSearchPage = function() {
    $auto.listColumns = [
        {data: 'id'},
        {data: 'year'}
    ];
    $auto.initSearch();
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

$auto.initEditPage = function() {
    $auto.initForm();

    $auto.initModel();

    $auto.initRegion();
};

$auto.init();
