var $body = $.extend(true, {}, $main);
$body.listPath = '/management/cms/body';

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
