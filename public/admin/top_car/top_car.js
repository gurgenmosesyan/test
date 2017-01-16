var $topCar = $.extend(true, {}, $main);
$topCar.listPath = '/management/cms/topCar';

$topCar.initSearchPage = function() {
    $topCar.listColumns = [
        {data: 'id'},
        {data: 'auto'},
        {data: 'user'},
        {data: 'deadline'}
    ];
    $topCar.initSearch();
};

$topCar.initSelectBox = function() {
    var autoSearch = $('#auto-search');
    autoSearch.searchSelectBox({
        source : function (request, response) {
            autoSearch.loading();
            $.ajax({
                type :'post',
                url	 : '/management/cms/auto/get',
                data : {
                    title : request.term,
                    _token : $main.token
                },
                dataType :'json',
                success	 : function (json) {
                    autoSearch.removeLoading();
                    if (json.status == 'OK') {
                        response($.map(json.data , function(item) {
                            item.label = item.mark_name+' '+item.model_name+' - '+item.year+' - '+item.auto_id;
                            return item;
                        }));
                    }
                }
            });
        }
    });
};

$topCar.initEditPage = function() {

    $topCar.initForm();

    $topCar.initSelectBox();
};

$topCar.init();
