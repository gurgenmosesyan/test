<?php

$admin = Auth::guard('admin')->user();
$permissions = $admin->permissions;

$menu = require resource_path('admin_menu/app.php');
$coreMenu = require resource_path('admin_menu/core.php');

$menu = array_merge($menu, $coreMenu);

echo '<ul class="sidebar-menu">';

foreach($menu as $value) {
    if (empty($value['sub_menu'])) {
        if ($admin->isSuperAdmin() || isset($permissions[$value['key']])) {
            $class = $pageMenu == $value['key'] ? ' class="active"' : '';
            echo '<li'.$class.'><a href="'.$value['path'].'"><i class="fa '.$value['icon'].'"></i> <span>'.trans('admin.'.$value['key'].'.form.title').'</span></a></li>';
        }
    } else {
        $class = '';
        $show = false;
        foreach ($value['sub_menu'] as $sub) {
            if ($pageMenu == $sub['key']) {
                $class = ' active';
            }
            if ($admin->isSuperAdmin() || isset($permissions[$sub['key']])) {
                $show = true;
            }
        }
        if ($show) {
            echo '<li class="treeview'.$class.'">';
            echo '<a href="#"><i class="fa '.$value['icon'].'"></i> <span>'.trans('admin.'.$value['key'].'.form.title').'</span> <i class="fa fa-angle-left pull-right"></i></a>';
            echo '<ul class="treeview-menu">';
            foreach ($value['sub_menu'] as $sub) {
                if ($admin->isSuperAdmin() || isset($permissions[$sub['key']])) {
                    $class = $pageMenu == $sub['key'] ? ' class="active"' : '';
                    echo '<li'.$class.'><a href="'.$sub['path'].'"><i class="fa '.$sub['icon'].'"></i> '.trans('admin.'.$sub['key'].'.form.title').'</a></li>';
                }
            }
            echo '</ul>';
            echo '</li>';
        }
    }
}

echo '</ul>';