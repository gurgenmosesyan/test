<?php

namespace App\Http\Controllers;

use App\Models\Auto\Auto;
use App\Models\Currency\CurrencyManager;
use Illuminate\Http\Request;
use Auth;
use DB;

class FavoriteController extends Controller
{
    public function index()
    {
        $user = Auth::guard('user')->user();

        $autos = Auto::join('user_favorites as fav', function($query) use($user) {
                $query->on('fav.auto_id', '=', 'autos.id')->where('fav.user_id', '=', $user->id);
            })
            ->active()
            ->where(function($query) use($user) {
                $query->where('autos.user_id', $user->id)->orWhere(function($query) {
                    $query->notBlocked()->term();
                });
            })->get();

        $currencyManager = new CurrencyManager();
        $currencies = $currencyManager->all();
        $defCurrency = $currencyManager->defaultCurrency();
        $cCurrency = $currencyManager->currentCurrency();

        return view('favorite.index')->with([
            'autos' => $autos,
            'currencies' => $currencies,
            'defCurrency' => $defCurrency,
            'cCurrency' => $cCurrency
        ]);
    }

    public function api(Request $request)
    {
        $user = Auth::guard('user')->user();
        $autoId = $request->input('id');
        $action = $request->input('action');
        if ($action != 'add' && $action != 'delete') {
            return $this->api('INVALID_DATA');
        }
        $auto = Auto::active()->notBlocked()->term()->where('id', $autoId)->firstOrFail();
        DB::table('user_favorites')->insert(['user_id' => $user->id, 'auto_id' => $auto->id]);
        return $this->api('OK');
    }
}