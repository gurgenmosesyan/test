<?php

namespace App\Http\Controllers;

use App\Models\Currency\CurrencyManager;
use App\Models\TopCar\TopCar;

class TopCarController extends Controller
{
    public function index()
    {
        $topCars = TopCar::active()->inDate()->with(['auto' => function($query) {
            $query->term()->with('mark', 'model', 'country_ml', 'region_ml');
        }])->latest()->get();

        foreach ($topCars as $key => $car) {
            if (!$car->auto) {
                unset($topCars[$key]);
            }
        }

        $currencyManager = new CurrencyManager();
        $currencies = $currencyManager->all();
        $defCurrency = $currencyManager->defaultCurrency();
        $cCurrency = $currencyManager->currentCurrency();

        return view('top_car.index')->with([
            'topCars' => $topCars,
            'currencies' => $currencies,
            'defCurrency' => $defCurrency,
            'cCurrency' => $cCurrency,
        ]);
    }
}