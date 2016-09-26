<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Core\BaseController;
use Auth;

class IndexController extends BaseController
{
    public function index()
    {
        $admin = Auth::guard('admin')->user();
        return redirect(url('management/cms/'.ltrim($admin->homepage, '/')));
    }
}