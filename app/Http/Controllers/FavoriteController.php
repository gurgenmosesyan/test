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

        $autos = Auto::select('autos.*')->join('user_favorites as fav', function($query) use($user) {
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

    public function favorite(Request $request)
    {
        $user = Auth::guard('user')->user();
        $autoId = $request->input('auto_id');
        $action = $request->input('action');
        if ($action != 'add' && $action != 'delete') {
            return $this->api('INVALID_DATA');
        }
        $auto = Auto::active()->where('id', $autoId)
            ->where(function($query) use($user) {
                $query->where('autos.user_id', $user->id)->orWhere(function($query) {
                    $query->notBlocked()->term();
                });
            })->firstOrFail();

        if ($action == 'add') {
            $userFav = DB::table('user_favorites')->where('user_id', $user->id)->where('auto_id', $autoId)->first();
            if ($userFav == null) {
                DB::table('user_favorites')->insert(['user_id' => $user->id, 'auto_id' => $auto->id]);
            }
        } else {
            DB::table('user_favorites')->where('user_id', $user->id)->where('auto_id', $autoId)->delete();
        }
        return $this->api('OK');
    }
}