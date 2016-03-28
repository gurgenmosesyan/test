<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>Autotrade.am</title>
    <?php
    $head->appendMainScript('/assets/plugins/jQuery/jQuery-2.1.4.min.js');
    $head->appendMainScript('/js/main.js');

    $head->renderStyles();
    $head->renderScripts();
    ?>
    <script type="text/javascript">
        $main.baseUrl = '{{url('')}}';
        $main.baseUrlWithLng = '{{url_with_lng('', false)}}';
        $main.token = '{{csrf_token()}}';
    </script>
</head>
<body>
<script>
    window.fbAsyncInit = function() {
        FB.init({
            appId: '{{config('social.fb.app_id')}}',
            cookie: true,
            xfbml: true,
            version: 'v2.5'
        });
    };
    (function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = "//connect.facebook.net/en_US/sdk.js";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));
</script>

<div id="content">
@yield('content')
</div>

</body>
</html>