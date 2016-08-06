var $wheel = $.extend(true, {}, $main);
$wheel.listPath = '/management/cms/wheel';

$wheel.initSearchPage = function() {
    $wheel.listColumns = [
        {data: 'id'},
        {data: 'count'}
    ];
    $wheel.initSearch();
};

$wheel.initEditPage = function() {
    $wheel.initForm();
};

$wheel.init();