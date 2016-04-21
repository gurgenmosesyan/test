var $option = $.extend(true, {}, $main);
$option.listPath = '/management/cms/option';

$option.initSearchPage = function() {
    $option.listColumns = [
        {data: 'id'},
        {data: 'name'}
    ];
    $option.initSearch();
};

$option.initEditPage = function() {
    $option.initForm();
};

$option.init();
