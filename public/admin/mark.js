var $mark = $.extend(true, {}, $main);
$mark.listPath = '/admpanel/mark';

$mark.initSearchPage = function() {
    $mark.listColumns = [
        {data: 'id'},
        {data: 'name'}
    ];
    $mark.initSearch();
};

$mark.initEditPage = function() {
    $mark.initForm();
};

$mark.init();
