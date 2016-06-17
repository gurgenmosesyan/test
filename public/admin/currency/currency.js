var $currency = $.extend(true, {}, $main);
$currency.listPath = '/management/cms/currency';

$currency.initSearchPage = function() {
    $currency.listColumns = [
        {data: 'id'},
        {data: 'code'},
        {data: 'rate'}
    ];
    $currency.initSearch();
};

$currency.initEditPage = function() {
    $currency.initForm();

    $('#default').on('ifChanged', function() {
        var self = $(this);
        if (self.prop('checked')) {
            $('.rate-label').removeClass('data-req');
        } else {
            $('.rate-label').addClass('data-req');
        }
    }).trigger('ifChanged');
};

$currency.init();
