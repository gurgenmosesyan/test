var $train = $.extend(true, {}, $main);
$train.listPath = '/management/cms/train';

$train.initSearchPage = function() {
    $train.listColumns = [
        {data: 'id'},
        {data: 'name'}
    ];
    $train.initSearch();
};

$train.initEditPage = function() {
    $train.initForm();
};

$train.init();
