var $cylinder = $.extend(true, {}, $main);
$cylinder.listPath = '/management/cms/cylinder';

$cylinder.initSearchPage = function() {
    $cylinder.listColumns = [
        {data: 'id'},
        {data: 'count'}
    ];
    $cylinder.initSearch();
};

$cylinder.initEditPage = function() {
    $cylinder.initForm();
};

$cylinder.init();