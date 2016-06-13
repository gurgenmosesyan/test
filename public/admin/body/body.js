var $body = $.extend(true, {}, $main);
$body.listPath = '/management/cms/body';

$body.initSearchPage = function() {
    $body.listColumns = [
        {data: 'id'},
        {data: 'name'}
    ];
    $body.initSearch();
};

$body.initShowInSearch = function() {
    var imgLabel = $('.img-label');
    $('#show-in-search').on('ifChanged', function() {
        if ($(this).prop('checked')) {
            imgLabel.addClass('data-req');
        } else {
            imgLabel.removeClass('data-req');
        }
    }).trigger('ifChanged');
};

$body.initEditPage = function() {
    $body.initForm();

    $body.initShowInSearch();
};

$body.init();
