var $door = $.extend(true, {}, $main);
$door.listPath = '/admpanel/door';

$door.initSearchPage = function() {
    $door.listColumns = [
        {data: 'id'},
        {data: 'name'}
    ];
    $door.initSearch();
};

$door.initEditPage = function() {
    $door.initForm();
};

$door.init();