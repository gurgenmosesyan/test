var $transmission = $.extend(true, {}, $main);
$transmission.listPath = '/management/cms/transmission';

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
