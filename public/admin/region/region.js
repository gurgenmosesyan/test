var $region = $.extend(true, {}, $main);
$region.listPath = '/management/cms/region';

$region.initSearchPage = function() {
    $region.listColumns = [
        {data: 'id'},
        {data: 'country_name'},
        {data: 'name'}
    ];
    $region.initSearch();
};

$region.initEditPage = function() {
    $region.initForm();
};

$region.init();
