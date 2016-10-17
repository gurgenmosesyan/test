<?php

namespace App\Http\Controllers;

use App\Models\Currency\CurrencyManager;
use App\Models\UrgentCar\UrgentCar;

class UrgentCarController extends Controller
{
    public function index()
    {
        $urgentCars = UrgentCar::active()->inDate()->with(['auto' => function($query) {
            $query->term()->with('mark', 'model', 'country_ml', 'region_ml');
        }])->latest()->get();

        foreach ($urgentCars as $key => $car) {
            if (!$car->auto) {
                unset($urgentCars[$key]);
            }
        }

        $currencyManager = new CurrencyManager();
        $currencies = $currencyManager->all();
        $defCurrency = $currencyManager->defaultCurrency();
        $cCurrency = $currencyManager->currentCurrency();

        return view('urgent_car.index')->with([
            'urgentCars' => $urgentCars,
            'currencies' => $currencies,
            'defCurrency' => $defCurrency,
            'cCurrency' => $cCurrency,
        ]);
    }
}