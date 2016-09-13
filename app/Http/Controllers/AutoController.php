<?php

namespace App\Http\Controllers;

use App\Models\Auto\Auto;
use App\Models\Option\Option;
use App\Models\Currency\CurrencyManager;
use Auth;

class AutoController extends Controller
{
    public function index($lngCode, $autoId)
    {
        $query = Auto::active()->where('auto_id', $autoId);
        if (Auth::guard('user')->check()) {
            $user = Auth::guard('user')->user();
            $query->where(function($query) use($user) {
                $query->where('user_id', $user->id)->orWhere(function($query) {
                    $query->notBlocked()->term();
                });
            });
        } else {
            $query->notBlocked()->term();
        }
        $auto = $query->firstOrFail();

        $options = Option::joinMl()->active()->get();

        $currencyManager = new CurrencyManager();
        $currencies = $currencyManager->all();
        $defCurrency = $currencyManager->defaultCurrency();
        $cCurrency = $currencyManager->currentCurrency();

        return view('auto.index')->with([
            'auto' => $auto,
            'options' => $options,
            'currencies' => $currencies,
            'defCurrency' => $defCurrency,
            'cCurrency' => $cCurrency,
        ]);
    }
}