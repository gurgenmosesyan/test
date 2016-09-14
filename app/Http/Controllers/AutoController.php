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

        $this->setAutoHistory($auto->id);

        return view('auto.index')->with([
            'auto' => $auto,
            'options' => $options,
            'currencies' => $currencies,
            'defCurrency' => $defCurrency,
            'cCurrency' => $cCurrency,
        ]);
    }

    protected function setAutoHistory($id)
    {
        if (isset($_COOKIE['history'])) {
            $data = json_decode($_COOKIE['history'], true);
            $data = [$id => $id] + $data;
        } else {
            $data = [$id => $id];
        }
        $data = json_encode(array_slice($data, 0, 50, true));
        setcookie('history', $data, time()+60*60*24*30, '/');
    }
}