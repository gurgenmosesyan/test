var $category = $.extend(true, {}, $main);
$category.listPath = '/admpanel/modelCategory';

$category.initSearchPage = function() {
    $category.listColumns = [
        {data: 'id'},
        {data: 'mark_name'},
        {data: 'name'}
    ];
    $category.initSearch();
};

$category.initEditPage = function() {
    $category.initForm();
};

$category.init();
