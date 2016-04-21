var $rudder = $.extend(true, {}, $main);
$rudder.listPath = '/management/cms/rudder';

$rudder.initSearchPage = function() {
    $rudder.listColumns = [
        {data: 'id'},
        {data: 'name'}
    ];
    $rudder.initSearch();
};

$rudder.initEditPage = function() {
    $rudder.initForm();
};

$rudder.init();
