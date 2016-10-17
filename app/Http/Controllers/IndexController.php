<?php

namespace App\Http\Controllers;

use App\Models\Auto\Auto;
use App\Models\Engine\EngineMl;
use App\Models\TopCar\TopCar;
use App\Models\Country\CountryMl;
use App\Models\Mark\Mark;
use App\Models\Body\Body;
use App\Models\Currency\CurrencyManager;
use App\Models\UrgentCar\UrgentCar;
use Auth;
use DB;

class IndexController extends Controller
{
    public function index()
    {
        $topCars = TopCar::active()->inDate()->with(['auto' => function($query) {
            $query->term()->with('mark', 'model', 'country_ml', 'region_ml');
        }])->get();
        $urgentCars = UrgentCar::active()->inDate()->with(['auto' => function($query) {
            $query->term()->with('mark', 'model', 'country_ml', 'region_ml');
        }])->get();
        foreach ($topCars as $key => $car) {
            if (!$car->auto) {
                unset($topCars[$key]);
            }
        }
        foreach ($urgentCars as $key => $car) {
            if (!$car->auto) {
                unset($urgentCars[$key]);
            }
        }
        $recentCars = Auto::active()->term()->with('mark', 'model', 'country_ml', 'region_ml')->take(12)->latest()->get();

        $countries = CountryMl::active()->current()->get();
        $marks = Mark::active()->orderBy('name', 'asc')->get();
        $bodies = Body::active()->inSearch()->ordered()->take(3)->get();
        $engines = EngineMl::active()->current()->get();

        $currencyManager = new CurrencyManager();
        $currencies = $currencyManager->all();
        $defCurrency = $currencyManager->defaultCurrency();
        $cCurrency = $currencyManager->currentCurrency();

        $favorites = [];
        if (Auth::guard('user')->check()) {
            $user = Auth::guard('user')->user();
            $favorites = $user->favorites->keyBy('auto_id');
        }

        return view('index.index')->with([
            'topCars' => $topCars,
            'urgentCars' => $urgentCars,
            'recentCars' => $recentCars,
            'countries' => $countries,
            'marks' => $marks,
            'bodies' => $bodies,
            'engines' => $engines,
            'currencies' => $currencies,
            'defCurrency' => $defCurrency,
            'cCurrency' => $cCurrency,
            'favorites' => $favorites
        ]);
    }
}