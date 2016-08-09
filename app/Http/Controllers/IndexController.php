<?php

namespace App\Http\Controllers;

use App\Models\Auto\Auto;
use App\Models\TopCar\TopCar;
use App\Models\Country\CountryMl;
use App\Models\Mark\Mark;
use App\Models\Body\Body;
use App\Models\Currency\CurrencyManager;

class IndexController extends Controller
{
    public function index()
    {
        $topCars = TopCar::active()->inDate()->with(['auto' => function($query) {
            $query->approved()->term()->with('mark', 'model', 'country_ml', 'region_ml');
        }])->get();
        $urgentCars = TopCar::active()->inDate()->with(['auto' => function($query) {
            $query->approved()->term()->with('mark', 'model', 'country_ml', 'region_ml');
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
        $recentCars = Auto::active()->approved()->term()->with('mark', 'model', 'country_ml', 'region_ml')->take(12)->latest()->get();

        $countries = CountryMl::active()->current()->get();
        $marks = Mark::active()->orderBy('name', 'asc')->get();
        $bodies = Body::active()->inSearch()->ordered()->take(3)->get();

        $currencyManager = new CurrencyManager();
        $currencies = $currencyManager->all();
        $defCurrency = $currencyManager->defaultCurrency();
        $cCurrency = $currencyManager->currentCurrency();

        return view('index.index')->with([
            'topCars' => $topCars,
            'urgentCars' => $urgentCars,
            'recentCars' => $recentCars,
            'countries' => $countries,
            'marks' => $marks,
            'bodies' => $bodies,
            'currencies' => $currencies,
            'defCurrency' => $defCurrency,
            'cCurrency' => $cCurrency
        ]);
    }
}