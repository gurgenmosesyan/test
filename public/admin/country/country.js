var $country = $.extend(true, {}, $main);
$country.listPath = '/management/cms/country';

$country.initSearchPage = function() {
    $country.listColumns = [
        {data: 'id'},
        {data: 'name'}
    ];
    $country.initSearch();
};

$country.initEditPage = function() {
    $country.initForm();
};

$country.init();
