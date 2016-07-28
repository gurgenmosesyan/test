<?php

namespace App\Http\Controllers;

use App\Models\Body\Body;
use App\Models\Color\Color;
use App\Models\Cylinder\Cylinder;
use App\Models\Door\Door;
use App\Models\InteriorColor\Color as InteriorColor;
use App\Models\Country\CountryMl;
use App\Models\Engine\Engine;
use App\Models\Mark\Mark;
use App\Models\Rudder\Rudder;
use App\Models\Train\Train;
use App\Models\Transmission\Transmission;
use App\Models\Wheel\Wheel;
use App\Models\Currency\CurrencyManager;

class SearchController extends Controller
{
    public function index()
    {
        $countries = CountryMl::active()->current()->get();
        $marks = Mark::active()->orderBy('name', 'asc')->get();
        $bodies = Body::joinMl()->active()->get();
        $transmissions = Transmission::joinMl()->active()->get();
        $trains = Train::joinMl()->active()->get();
        $engines = Engine::joinMl()->active()->get();
        $rudders = Rudder::joinMl()->active()->get();
        $colors = Color::joinMl()->active()->get();
        $interiorColors = InteriorColor::joinMl()->active()->get();
        $cylindersCount = Cylinder::active()->get();
        $doorsCount = Door::active()->get();
        $wheels = Wheel::active()->get();

        $currencyManager = new CurrencyManager();
        $currencies = $currencyManager->all();
        $defCurrency = $currencyManager->defaultCurrency();
        $cCurrency = $currencyManager->currentCurrency();

        return view('search.index')->with([
            'marks' => $marks,
            'countries' => $countries,
            'bodies' => $bodies,
            'transmissions' => $transmissions,
            'trains' => $trains,
            'engines' => $engines,
            'rudders' => $rudders,
            'colors' => $colors,
            'interiorColors' => $interiorColors,
            'cylindersCount' => $cylindersCount,
            'doorsCount' => $doorsCount,
            'wheels' => $wheels,
            'currencies' => $currencies,
            'defCurrency' => $defCurrency,
            'cCurrency' => $cCurrency
        ]);
    }
}