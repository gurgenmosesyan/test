var $color = $.extend(true, {}, $main);
$color.listPath = '/management/cms/interiorColor';

$color.initSearchPage = function() {
    $color.listColumns = [
        {data: 'id'},
        {data: 'name'}
    ];
    $color.initSearch();
};

$color.initEditPage = function() {
    $color.initForm();
};

$color.init();
