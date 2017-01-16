var $urgentCar = $.extend(true, {}, $main);
$urgentCar.listPath = '/management/cms/urgentCar';

$urgentCar.initSearchPage = function() {
    $urgentCar.listColumns = [
        {data: 'id'},
        {data: 'auto'},
        {data: 'user'},
        {data: 'deadline'}
    ];
    $urgentCar.initSearch();
};

$urgentCar.initSelectBox = function() {
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

$urgentCar.initEditPage = function() {

    $urgentCar.initForm();

    $urgentCar.initSelectBox();
};

$urgentCar.init();
