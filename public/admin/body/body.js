var $body = $.extend(true, {}, $main);
$body.listPath = '/admpanel/body';

$body.initSearchPage = function() {
    $body.listColumns = [
        {data: 'id'},
        {data: 'name'}
    ];
    $body.initSearch();
};

$body.initEditPage = function() {
    $body.initForm();
};

$body.init();
