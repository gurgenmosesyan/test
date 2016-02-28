var $transmission = $.extend(true, {}, $main);
$transmission.listPath = '/admpanel/transmission';

$transmission.initSearchPage = function() {
    $transmission.listColumns = [
        {data: 'id'},
        {data: 'name'}
    ];
    $transmission.initSearch();
};

$transmission.initEditPage = function() {
    $transmission.initForm();
};

$transmission.init();
