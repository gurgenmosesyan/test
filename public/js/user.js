var $user = {};

$user.resetErrors = function() {
    $('.form-error').text('');
};

$user.showErrors = function(errors) {
    for (var i in errors) {
        $('#form-error-'+i.replace(/\./g, '_')).text(errors[i][0]);
    }
};

$user.sendForm = function(form, callback) {
    if (form.hasClass('sending')) {
        return false;
    }
    form.addClass('sending');
    $.ajax({
        type: 'post',
        url: form.attr('action'),
        data: form.serializeArray(),
        dataType: 'json',
        success: function(result) {
            $user.resetErrors();
            if (result.status == 'OK') {
                callback(result.data.link);
            } else {
                $user.showErrors(result.errors);
            }
            form.removeClass('sending');
        }
    });
};

$user.init = function() {
    $('#registration-form').submit(function() {
        $user.sendForm($(this), function() {
            alert('You have successfully registered');
        });
        return false;
    });
    $('#login-form').submit(function() {
        $user.sendForm($(this), function(path) {
            document.location.href = path;
        });
        return false;
    });
    $('#forgot-form').submit(function() {
        $user.sendForm($(this), function() {
            alert('Check your email');
        });
        return false;
    });
    $('#reset-form').submit(function() {
        $user.sendForm($(this), function() {
            alert('Password successfully changed');
        });
        return false;
    });
};

$(document).ready(function() {
    $user.init();
});
