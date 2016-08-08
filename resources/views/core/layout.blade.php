<?php
$appName = config('app.name');
$jsTrans->addTrans([
    'admin.delete.modal.text',
    'admin.base.label.delete',
    'admin.base.label.close',
    'admin.base.label.loading',
    'admin.base.label.saved',
    'admin.base.label.invalid_data'
]);
?><!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{isset($pageTitle) ? $appName.' - '.$pageTitle : $appName}}</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <!-- Ionicons -->
    {{--<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">--}}
    <!-- Date Picker -->
    {{--<link rel="stylesheet" href="/assets/plugins/datepicker/datepicker3.css">
    <link rel="stylesheet" href="/assets/plugins/timepicker/bootstrap-timepicker.min.css">--}}

    <?php
    $head->appendMainStyle('https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css');
    $head->appendMainStyle('/assets/bootstrap/css/bootstrap.min.css');
    $head->appendMainStyle('/assets/plugins/datatables/dataTables.bootstrap.css');
    $head->appendMainStyle('/assets/dist/css/main.css');
    $head->appendMainStyle('/assets/dist/css/skins/skin-blue.min.css');
    $head->appendMainStyle('/assets/plugins/iCheck/minimal/blue.css');
    $head->appendMainStyle('/assets/plugins/jQueryUI/jquery-ui.min.css');

    $head->appendMainScript('/assets/plugins/jQuery/jQuery-2.1.4.min.js');
    $head->appendMainScript('/assets/plugins/jQueryUI/jquery-ui.min.js');
    $head->appendMainScript('/assets/bootstrap/js/bootstrap.min.js');
    $head->appendMainScript('/assets/plugins/datatables/jquery.dataTables.min.js');
    $head->appendMainScript('/assets/plugins/datatables/dataTables.bootstrap.min.js');
    $head->appendMainScript('/assets/plugins/iCheck/icheck.min.js');
    $head->appendMainScript('/assets/plugins/datepicker/bootstrap-datepicker.js');
    $head->appendMainScript('/assets/dist/js/app.js');
    $head->appendMainScript('/core/js/searchSelectBox.js');
    $head->appendMainScript('/core/js/main.js');

    //$head->appendMainScript('/assets/plugins/timepicker/bootstrap-timepicker.min.js');

    $head->renderStyles();
    $head->renderScripts();

    $admin = Auth::guard('admin')->user();
    ?>
</head>
<body class="hold-transition skin-blue sidebar-mini">
<script type="text/javascript">
    var $locSettings = {"trans":<?php echo json_encode($jsTrans->getTrans())?>};
    $main.path = '{{url('')}}';
    $main.token = '{{csrf_token()}}';
</script>
<div class="wrapper">

    <header class="main-header">
        <a href="{{url('/')}}" class="logo">
            <span class="logo-mini">{{config('app.short_name')}}</span>
            <span class="logo-lg">{{$appName}}</span>
        </a>
        <nav class="navbar navbar-static-top" role="navigation">
            <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                <span class="sr-only">Toggle navigation</span>
            </a>
            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    <li class="dropdown user user-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <span class="hidden-xs">{{$admin->email}}</span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="user-footer">
                                <div class="pull-left">
                                    <a href="{{route('core_admin_edit', $admin->id)}}" class="btn btn-default btn-flat">{{trans('admin.profile.title')}}</a>
                                </div>
                                <div class="pull-right">
                                    <a href="{{route('core_admin_logout')}}" class="btn btn-default btn-flat">{{trans('admin.logout.title')}}</a>
                                </div>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>
    </header>

    <aside class="main-sidebar">
        <section class="sidebar">
            <ul class="sidebar-menu">
                <li class="treeview{{$pageMenu == 'mark' || $pageMenu == 'model_category' || $pageMenu == 'model' || $pageMenu == 'body' || $pageMenu == 'rudder' || $pageMenu == 'color' || $pageMenu == 'interior_color' || $pageMenu == 'transmission' || $pageMenu == 'engine' || $pageMenu == 'cylinder' || $pageMenu == 'train' || $pageMenu == 'door' || $pageMenu == 'wheel' ? ' active' : ''}}">
                    <a href="#">
                        <i class="fa fa-cog"></i> <span>{{trans('admin.admin_menu.detail')}}</span> <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <li{{$pageMenu == 'mark' ? ' class=active' : ''}}><a href="{{route('admin_mark_table')}}"><i class="fa fa-circle-o"></i> {{trans('admin.mark.form.title')}}</a></li>
                        <li{{$pageMenu == 'model_category' ? ' class=active' : ''}}><a href="{{route('admin_model_category_table')}}"><i class="fa fa-circle-o"></i> {{trans('admin.model_category.form.title')}}</a></li>
                        <li{{$pageMenu == 'model' ? ' class=active' : ''}}><a href="{{route('admin_model_table')}}"><i class="fa fa-circle-o"></i> {{trans('admin.model.form.title')}}</a></li>
                        <li{{$pageMenu == 'body' ? ' class=active' : ''}}><a href="{{route('admin_body_table')}}"><i class="fa fa-circle-o"></i> {{trans('admin.body.form.title')}}</a></li>
                        <li{{$pageMenu == 'transmission' ? ' class=active' : ''}}><a href="{{route('admin_transmission_table')}}"><i class="fa fa-circle-o"></i> {{trans('admin.transmission.form.title')}}</a></li>
                        <li{{$pageMenu == 'rudder' ? ' class=active' : ''}}><a href="{{route('admin_rudder_table')}}"><i class="fa fa-circle-o"></i> {{trans('admin.rudder.form.title')}}</a></li>
                        <li{{$pageMenu == 'color' ? ' class=active' : ''}}><a href="{{route('admin_color_table')}}"><i class="fa fa-circle-o"></i> {{trans('admin.color.form.title')}}</a></li>
                        <li{{$pageMenu == 'interior_color' ? ' class=active' : ''}}><a href="{{route('admin_interior_color_table')}}"><i class="fa fa-circle-o"></i> {{trans('admin.interior_color.form.title')}}</a></li>
                        <li{{$pageMenu == 'engine' ? ' class=active' : ''}}><a href="{{route('admin_engine_table')}}"><i class="fa fa-circle-o"></i> {{trans('admin.engine.form.title')}}</a></li>
                        <li{{$pageMenu == 'cylinder' ? ' class=active' : ''}}><a href="{{route('admin_cylinder_table')}}"><i class="fa fa-circle-o"></i> {{trans('admin.cylinder.form.title')}}</a></li>
                        <li{{$pageMenu == 'train' ? ' class=active' : ''}}><a href="{{route('admin_train_table')}}"><i class="fa fa-circle-o"></i> {{trans('admin.train.form.title')}}</a></li>
                        <li{{$pageMenu == 'door' ? ' class=active' : ''}}><a href="{{route('admin_door_table')}}"><i class="fa fa-circle-o"></i> {{trans('admin.door.form.title')}}</a></li>
                        <li{{$pageMenu == 'wheel' ? ' class=active' : ''}}><a href="{{route('admin_wheel_table')}}"><i class="fa fa-circle-o"></i> {{trans('admin.wheel.form.title')}}</a></li>
                    </ul>
                </li>
                <li{{$pageMenu == 'option' ? ' class=active' : ''}}><a href="{{route('admin_option_table')}}"><i class="fa fa-bars"></i> <span>{{trans('admin.option.form.title')}}</span></a></li>
                <li{{$pageMenu == 'country' ? ' class=active' : ''}}><a href="{{route('admin_country_table')}}"><i class="fa fa-globe"></i> <span>{{trans('admin.country.form.title')}}</span></a></li>
                <li{{$pageMenu == 'region' ? ' class=active' : ''}}><a href="{{route('admin_region_table')}}"><i class="fa fa-globe"></i> <span>{{trans('admin.region.form.title')}}</span></a></li>
                <li{{$pageMenu == 'auto' ? ' class=active' : ''}}><a href="{{route('admin_auto_table')}}"><i class="fa fa-car"></i> <span>{{trans('admin.auto.form.title')}}</span></a></li>
                <li{{$pageMenu == 'top_car' ? ' class=active' : ''}}><a href="{{route('admin_top_car_table')}}"><i class="fa fa-star"></i> <span>{{trans('admin.top_car.form.title')}}</span></a></li>
                <li{{$pageMenu == 'urgent_car' ? ' class=active' : ''}}><a href="{{route('admin_urgent_car_table')}}"><i class="fa fa-exclamation-circle"></i> <span>{{trans('admin.urgent_car.form.title')}}</span></a></li>
                <li{{$pageMenu == 'config' ? ' class=active' : ''}}><a href="{{route('admin_config_edit')}}"><i class="fa fa-edit"></i> <span>{{trans('admin.config.form.title')}}</span></a></li>
                <li{{$pageMenu == 'currency' ? ' class=active' : ''}}><a href="{{route('admin_currency_table')}}"><i class="fa fa-usd"></i> <span>{{trans('admin.currency.form.title')}}</span></a></li>
                <li{{$pageMenu == 'part' ? ' class=active' : ''}}><a href="{{route('admin_part_table')}}"><i class="fa fa-cogs"></i> <span>{{trans('admin.part.form.title')}}</span></a></li>
                <li class="treeview{{$pageMenu == 'admin' || $pageMenu == 'language' || $pageMenu == 'dictionary' ? ' active' : ''}}">
                    <a href="#">
                        <i class="fa fa-wrench"></i> <span>{{trans('admin.admin_menu.system')}}</span> <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <li{{$pageMenu == 'admin' ? ' class=active' : ''}}><a href="{{route('core_admin_table')}}"><i class="fa fa-user"></i> {{trans('admin.admin.form.title')}}</a></li>
                        <li{{$pageMenu == 'language' ? ' class=active' : ''}}><a href="{{route('core_language_table')}}"><i class="fa fa-flag"></i> {{trans('admin.language.form.title')}}</a></li>
                        <li{{$pageMenu == 'dictionary' ? ' class=active' : ''}}><a href="{{route('core_dictionary_table')}}"><i class="fa fa-book"></i> {{trans('admin.dictionary.form.title')}}</a></li>
                    </ul>
                </li>
            </ul>
        </section>
    </aside>

    <div class="content-wrapper">
        <section class="content-header">
            <h1>{{$pageTitle}}</h1>
            {{--<ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">Dashboard</li>
            </ol>--}}
        </section>

        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title">{{$pageSubTitle}}</h3>
                            @yield('navButtons')
                        </div>
                        @yield('content')
                    </div>
                </div>
            </div>
        </section>
    </div>
    <div class="control-sidebar-bg"></div>
</div>
<div id="win-status"></div>
</body>
</html>
