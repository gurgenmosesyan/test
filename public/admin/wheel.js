var $wheel = $.extend(true, {}, $main);
$wheel.listPath = '/admpanel/wheel';

$wheel.initSearchPage = function() {
    $wheel.listColumns = [
        {data: 'id'},
        {data: 'name'}
    ];
    $wheel.initSearch();
};

$wheel.initEditPage = function() {
    $wheel.initForm();
};

$wheel.init();