<?php

namespace App\Http\Controllers;

use App\Models\Auto\Auto;
use App\Models\Currency\CurrencyManager;

class AutoController extends Controller
{
    public function index($lngCode, $autoId)
    {
        $auto = Auto::active()->approved()->term()->where('auto_id', $autoId)->firstOrFail();

        $currencyManager = new CurrencyManager();
        $currencies = $currencyManager->all();
        $defCurrency = $currencyManager->defaultCurrency();
        $cCurrency = $currencyManager->currentCurrency();

        return view('auto.index')->with([
            'auto' => $auto,
            'currencies' => $currencies,
            'defCurrency' => $defCurrency,
            'cCurrency' => $cCurrency,
        ]);
    }
}