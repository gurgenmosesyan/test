<?php

namespace App\Http\Controllers;

use App\Models\Country\CountryMl;
use App\Models\Mark\Mark;
use App\Models\Body\Body;
use App\Models\Currency\CurrencyManager;

class IndexController extends Controller
{
    public function index()
    {
        $countries = CountryMl::active()->current()->get();
        $marks = Mark::active()->orderBy('name', 'asc')->get();
        $bodies = Body::active()->inSearch()->ordered()->take(3)->get();

        $currencyManager = new CurrencyManager();
        $currencies = $currencyManager->all();
        $defCurrency = $currencyManager->defaultCurrency();
        $cCurrency = $currencyManager->currentCurrency();

        return view('index.index')->with([
            'countries' => $countries,
            'marks' => $marks,
            'bodies' => $bodies,
            'currencies' => $currencies,
            'defCurrency' => $defCurrency,
            'cCurrency' => $cCurrency
        ]);
    }
}