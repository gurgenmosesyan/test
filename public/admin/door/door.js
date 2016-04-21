var $door = $.extend(true, {}, $main);
$door.listPath = '/management/cms/door';

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