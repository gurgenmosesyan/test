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
                callback(result.data);
            } else {
                $user.showErrors(result.errors);
            }
            form.removeClass('sending');
        }
    });
};

$user.FBLogin = function(accessToken) {
    $.ajax({
        type: 'post',
        url: $main.basePath('/api/fb/login'),
        data: {
            access_token: accessToken,
            _token: $main.token
        },
        dataType: 'json',
        success: function(result) {
            console.log(result);
            if (result.status == 'OK') {
                document.location.reload();
            } else {
                alert(result.errors);
            }
        }
    });
};

$user.FBConnect = function() {
    if (typeof FB !== 'undefined') {
        var accessToken;
        FB.getLoginStatus(function(response) {
            if (response.status === 'connected') {
                accessToken = response.authResponse.accessToken;
                $user.FBLogin(accessToken);
            } else {
                FB.login(function(res){
                    if (res.authResponse !== null) {
                        accessToken = res.authResponse.accessToken;
                        $user.FBLogin(accessToken);
                    } else {
                        //
                    }
                }, {scope: 'public_profile, email, user_location'});
            }
        });
    }
};

$user.googleConnect = function() {
    var url = $main.basePath('/api/google/login', false),
        width = 600,
        height = 400,
        left = (screen.width/2)-(width/2),
        top = (screen.height/2)-(height/2);
    $user.googlePopup = window.open(url, 'VK', 'height='+height+',width='+width+',left='+left+',top='+top);
};

$user.googleCallback = function() {
    $user.googlePopup.close();
    document.location.reload();
};

$user.init = function() {
    $('#registration-form').submit(function() {
        $user.sendForm($(this), function(data) {
            document.location.href = data.link;
        });
        return false;
    });
    $('#login-form').submit(function() {
        $user.sendForm($(this), function(data) {
            document.location.href = data.link;
        });
        return false;
    });
    $('#forgot-form').submit(function() {
        $user.sendForm($(this), function(data) {
            document.location.href = data.link;
        });
        return false;
    });
    $('#reset-form').submit(function() {
        $user.sendForm($(this), function(data) {
            document.location.href = data.link;
        });
        return false;
    });
    $('#edit-form').submit(function() {
        $user.sendForm($(this), function(data) {
            document.location.href = data.link;
        });
        return false;
    });
    $('#auto-edit-form').submit(function() {
        $user.sendForm($(this), function(data) {
            document.location.href = data.link;
        });
        return false;
    });
    $('#fb-login').on('click', function() {
        $user.FBConnect();
        return false;
    });
    $('#google-login').on('click', function() {
        $user.googleConnect();
        return false;
    });

    $('#contact-form').submit(function() {
        var form = $(this);
        $user.sendForm(form, function(data) {
            var popup = $('#popup');
            popup.popup({
                alert: true,
                title: $trans.get('www.contact.success.title'),
                text: $trans.get('www.contact.success.text')
            });
            form.find('textarea').val('');
        });
        return false;
    });
};

$(document).ready(function() {
    $user.init();
});
