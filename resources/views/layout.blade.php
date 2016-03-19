<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>Autotrade.am</title>
    <?php
    $head->appendMainScript('/assets/plugins/jQuery/jQuery-2.1.4.min.js');

    $head->renderStyles();
    $head->renderScripts();
    ?>
</head>
<body>

<div id="content">
@yield('content')
</div>

</body>
</html>