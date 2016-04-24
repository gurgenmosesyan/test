var $config = $.extend(true, {}, $main);
$config.listPath = '/management/cms/config/edit';

$config.initEditPage = function() {
    $config.initForm();
};

$config.init();
