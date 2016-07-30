<?php

namespace App\Http\Controllers;

use App\Models\Model\Manager;
use Illuminate\Http\Request;
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
use App\Models\Auto\Auto;

class SearchController extends Controller
{
    public function index(Request $request)
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
        $models = [];

        $currencyManager = new CurrencyManager();
        $currencies = $currencyManager->all();
        $defCurrency = $currencyManager->defaultCurrency();
        $cCurrency = $currencyManager->currentCurrency();

        list($autos, $reqData, $showAll) = $this->getAutos($request);

        if (!empty($reqData['mark_id']) && !empty($reqData['model_id'])) {
            $models = Manager::getModelsWithCat($reqData['mark_id']);
        }

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
            'cCurrency' => $cCurrency,
            'autos' => $autos,
            'reqData' => $reqData,
            'showAll' => $showAll,
            'models' => $models
        ]);
    }

    protected function getAutos(Request $request)
    {
        $reqData = [];
        $showAll = false;
        $reqData['mark_id'] = $request->input('mark_id');
        $reqData['model_id'] = $request->input('model_id');
        $reqData['country_id'] = $request->input('country_id');
        $reqData['transmission_id'] = $request->input('transmission_id');
        $reqData['rudder_id'] = $request->input('rudder_id');
        $reqData['engine_id'] = $request->input('engine_id');
        $reqData['volume_from'] = $request->input('volume_from');
        $reqData['volume_to'] = $request->input('volume_to');
        $reqData['year_from'] = $request->input('year_from');
        $reqData['year_to'] = $request->input('year_to');
        $reqData['mileage_from'] = $request->input('mileage_from');
        $reqData['mileage_to'] = $request->input('mileage_to');
        $reqData['mileage_measurement'] = $request->input('mileage_measurement');
        $reqData['price_from'] = $request->input('price_from');
        $reqData['price_to'] = $request->input('price_to');
        $reqData['body_id'] = $request->input('body_id');
        $reqData['train_id'] = $request->input('train_id');
        $reqData['horsepower_from'] = $request->input('horsepower_from');
        $reqData['horsepower_to'] = $request->input('horsepower_to');
        $reqData['color_id'] = $request->input('color_id');
        $reqData['interior_color_id'] = $request->input('interior_color_id');
        $reqData['cylinder_id'] = $request->input('cylinder_id');
        $reqData['door_id'] = $request->input('door_id');
        $reqData['wheel_id'] = $request->input('wheel_id');
        $reqData['custom_cleared'] = $request->input('custom_cleared');
        $reqData['damaged'] = $request->input('damaged');
        $reqData['partial_pay'] = $request->input('partial_pay');

        $query = Auto::active()->approved()->with('mark', 'model', 'images');
        if (!empty($reqData['mark_id'])) {
            $query->where('mark_id', $reqData['mark_id']);
        }
        if (!empty($reqData['model_id'])) {
            $query->where('model_id', $reqData['model_id']);
        }
        if (!empty($reqData['country_id'])) {
            $query->where('country_id', $reqData['country_id']);
        }
        if (!empty($reqData['transmission_id'])) {
            $query->where('transmission_id', $reqData['transmission_id']);
        }
        if (!empty($reqData['rudder_id'])) {
            $query->where('rudder_id', $reqData['rudder_id']);
        }
        if (!empty($reqData['engine_id'])) {
            $query->where('engine_id', $reqData['engine_id']);
        }
        if (!empty($reqData['volume_from'])) {
            $volumeParts = explode('.', $reqData['volume_from']);
            if (isset($volumeParts[0]) && isset($volumeParts[1])) {
                $query->where('volume_1', '>=', $volumeParts[0])->where('volume_2', '>=', $volumeParts[1]);
            }
        }
        if (!empty($reqData['volume_to'])) {
            $volumeParts = explode('.', $reqData['volume_to']);
            if (isset($volumeParts[0]) && isset($volumeParts[1])) {
                $query->where('volume_1', '<=', $volumeParts[0])->where('volume_2', '<=', $volumeParts[1]);
            }
        }
        if (!empty($reqData['year_from'])) {
            $query->where('year', '>=', $reqData['year_from']);
        }
        if (!empty($reqData['year_to'])) {
            $query->where('year', '>=', $reqData['year_to']);
        }
        if (!empty($reqData['mileage_from'])) {
            if ($reqData['mileage_measurement'] == Auto::MILEAGE_MEASUREMENT_KM) {
                $query->where('mileage_km', '>=', $reqData['mileage_from']);
            }  else if ($reqData['mileage_measurement'] == Auto::MILEAGE_MEASUREMENT_MILE) {
                $query->where('mileage_mile', '>=', $reqData['mileage_from']);
            }
        }
        if (!empty($reqData['mileage_to'])) {
            if ($reqData['mileage_measurement'] == Auto::MILEAGE_MEASUREMENT_KM) {
                $query->where('mileage_km', '<=', $reqData['mileage_to']);
            }  else if ($reqData['mileage_measurement'] == Auto::MILEAGE_MEASUREMENT_MILE) {
                $query->where('mileage_mile', '<=', $reqData['mileage_to']);
            }
        }
        if (!empty($reqData['price_from'])) {
            $query->where('price', '>=', $reqData['price_from']);
        }
        if (!empty($reqData['price_to'])) {
            $query->where('price', '<=', $reqData['price_to']);
        }
        if (!empty($reqData['body_id'])) {
            $query->where('body_id', $reqData['body_id']);
            $showAll = true;
        }
        if (!empty($reqData['train_id'])) {
            $query->where('train_id', $reqData['train_id']);
            $showAll = true;
        }
        if (!empty($reqData['horsepower_from'])) {
            $query->where('horsepower', '>=', $reqData['horsepower_from']);
            $showAll = true;
        }
        if (!empty($reqData['horsepower_to'])) {
            $query->where('horsepower', '<=', $reqData['horsepower_to']);
            $showAll = true;
        }
        if (!empty($reqData['color_id'])) {
            $query->where('color_id', $reqData['color_id']);
            $showAll = true;
        }
        if (!empty($reqData['interior_color_id'])) {
            $query->where('interior_color_id', $reqData['interior_color_id']);
            $showAll = true;
        }
        if (!empty($reqData['cylinder_id'])) {
            $query->where('cylinder_id', $reqData['cylinder_id']);
            $showAll = true;
        }
        if (!empty($reqData['door_id'])) {
            $query->where('door_id', $reqData['door_id']);
            $showAll = true;
        }
        if (!empty($reqData['wheel_id'])) {
            $query->where('wheel_id', $reqData['wheel_id']);
            $showAll = true;
        }
        if (!empty($reqData['custom_cleared'])) {
            $query->where('custom_cleared', $reqData['custom_cleared']);
            $showAll = true;
        }
        if (!empty($reqData['damaged'])) {
            $query->where('damaged', $reqData['damaged']);
            $showAll = true;
        }
        if (!empty($reqData['partial_pay'])) {
            $query->where('partial_pay', $reqData['partial_pay']);
            $showAll = true;
        }
        return [$query->get(), $reqData, $showAll];
    }
}