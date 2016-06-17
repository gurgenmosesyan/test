<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CurrencyController extends Controller
{
    public function index(Request $request)
    {
        $currencyId = $request->input('id');
        setcookie('currency', $currencyId, time()+60*60*24*30, '/');
        $_COOKIE['currency'] = $currencyId;
        return redirect()->back();
    }
}