<?php

namespace App\Http\Controllers;

use App\Models\Auto\Auto;
use App\Models\Body\Body;
use App\Models\Country\Country;
use App\Models\Currency\Currency;
use App\Models\Cylinder\Cylinder;
use App\Models\Door\Door;
use App\Models\Engine\Engine;
use App\Models\Mark\Mark;
use App\Models\Option\Option;
use App\Models\Rudder\Rudder;
use App\Models\Train\Train;
use App\Models\Transmission\Transmission;
use App\Models\Color\Color;
use App\Models\InteriorColor\Color as InteriorColor;
use App\Models\Wheel\Wheel;
use Session;

class SellController extends Controller
{
    public function index()
    {
        $auto = new Auto();
        $marks = Mark::active()->get();
        $bodies = Body::joinMl()->active()->get();
        $transmissions = Transmission::joinMl()->active()->get();
        $rudders = Rudder::joinMl()->active()->get();
        $colors = Color::joinMl()->active()->get();
        $interiorColors = InteriorColor::joinMl()->active()->get();
        $engines = Engine::joinMl()->active()->get();
        $cylinders = Cylinder::active()->get();
        $trains = Train::joinMl()->active()->get();
        $doors = Door::active()->get();
        $wheels = Wheel::active()->get();
        $countries = Country::joinMl()->active()->get();
        $options = Option::joinMl()->active()->get();
        $currenciesData = Currency::active()->ordered()->get();

        return view('sell.index')->with([
            'auto' => $auto,
            'marks' => $marks,
            'models' => [],
            'bodies' => $bodies,
            'transmissions' => $transmissions,
            'rudders' => $rudders,
            'colors' => $colors,
            'interiorColors' => $interiorColors,
            'engines' => $engines,
            'cylinders' => $cylinders,
            'trains' => $trains,
            'doors' => $doors,
            'wheels' => $wheels,
            'countries' => $countries,
            'options' => $options,
            'currenciesData' => $currenciesData
        ]);
    }

    public function success()
    {
        if (!Session::get('add_car')) {
            return redirect()->route('sell', cLng('code'));
        }

        return view('sell.success');
    }
}