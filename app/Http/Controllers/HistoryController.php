<?php

namespace App\Http\Controllers;

use App\Models\Auto\Auto;
use App\Models\Currency\CurrencyManager;
use Auth;

class HistoryController extends Controller
{
    public function index()
    {
        if (isset($_COOKIE['history'])) {
            $autoIds = json_decode($_COOKIE['history'], true);
            if (is_array($autoIds)) {
                $query = Auto::active()->whereIn('id', $autoIds);
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
                $autos = $query->get()->keyBy('id');
                $result = collect();
                foreach ($autoIds as $id) {
                    if (isset($autos[$id])) {
                        $result[] = $autos[$id];
                    }
                }

                $currencyManager = new CurrencyManager();

                $favorites = [];
                if (Auth::guard('user')->check()) {
                    $user = Auth::guard('user')->user();
                    $favorites = $user->favorites->keyBy('auto_id');
                }

                $data = [
                    'autos' => $result,
                    'currencies' => $currencyManager->all(),
                    'defCurrency' => $currencyManager->defaultCurrency(),
                    'cCurrency' => $currencyManager->currentCurrency(),
                    'favorites' => $favorites
                ];
            } else {
                $data = ['autos' => collect()];
            }
        } else {
            $data = ['autos' => collect()];
        }

        return view('history.index')->with($data);
    }
}
