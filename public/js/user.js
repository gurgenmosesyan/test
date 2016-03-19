var $user = {};

$user.resetErrors = function() {
    $('.form-error').text('');
};

$user.showErrors = function(errors) {
    for (var i in errors) {
        $('#form-error-'+i.replace(/\./g, '_')).text(errors[i][0]);
    }
};

$user.initRegistration = function() {
    $('#registration-form').submit(function() {
        var form = $(this);
        if (form.hasClass('sending')) {
            return false;
        }
        form.addClass('sening');
        $.ajax({
            type: 'post',
            url: form.attr('action'),
            data: form.serializeArray(),
            dataType: 'json',
            success: function(result) {
                $user.resetErrors();
                if (result.status == 'OK') {
                    alert('You have successfully registered!');
                } else {
                    $user.showErrors(result.errors);
                }
                form.removeClass('sending');
            }
        });
        return false;
    });
};

$(document).ready(function() {
    $user.initRegistration();
});
