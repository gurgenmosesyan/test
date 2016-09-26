var $ad = $.extend(true, {}, $main);
$ad.listPath = '/management/cms/ad';
$ad.firstInit = true;

$ad.initSearchPage = function() {
    $ad.listColumns = [
        {data: 'id'},
        {data: 'key'},
        {data: 'user'},
        {
            data: 'image',
            sortable: false
        },
        {data: 'deadline'}
    ];
    $ad.initSearch();
};

$ad.initKey = function() {
    var imgBox = $('#img-box'),
        helpTxt, module;
    $('#key-select').change(function() {
        var self = $(this);
        if (!$ad.firstInit) {
            imgBox.find('img').attr('src', '/core/images/img-default.png');
            imgBox.find('.img-uploader-id').val('');
        }
        $ad.firstInit = false;
        if (self.val() == 'top') {
            helpTxt = $ad.topHelpTxt;
        } else if (self.val() == 'thin') {
            helpTxt = $ad.thinHelpTxt;
        } else if (self.val() == 'right') {
            helpTxt = $ad.rightHelpTxt;
        } else if (self.val() == 'bottom') {
            helpTxt = $ad.bottomHelpTxt;
        }
        imgBox.find('.img-uploader-box').data('module', 'ad.images.'+self.val());
        imgBox.find('.img-uploader-help').text(helpTxt);
        imgBox.removeClass('dn');
    }).change();
};

$ad.initEditPage = function() {

    $ad.initForm();

    $ad.initKey();
};

$ad.init();
