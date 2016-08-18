<?php

namespace App\Http\Controllers;

use App\Models\Model\Model;
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

        list($autos, $reqData, $showAll) = $this->getAutos($request, $currencies, $defCurrency, $cCurrency);

        if (!empty($reqData['mark_id'])) {
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

    protected function getAutos(Request $request, $currencies, $defCurrency, $cCurrency)
    {
        $reqData = $this->getReqData($request);
        $showAll = false;
        if (!empty($reqData['body_id']) || !empty($reqData['train_id']) || !empty($reqData['horsepower_from']) ||
            !empty($reqData['horsepower_to']) || !empty($reqData['color_id']) || !empty($reqData['interior_color_id']) ||
            !empty($reqData['cylinders']) || !empty($reqData['doors']) || !empty($reqData['wheels']) ||
            !empty($reqData['custom_cleared']) || !empty($reqData['damaged']) || !empty($reqData['partial_pay'])) {
            $showAll = true;
        }

        $query = Auto::active()->approved()->term()->with('mark', 'model', 'engine_ml', 'train_ml', 'body_ml', 'color_ml', 'country_ml')->latest();

        $this->setWhere($query, 'mark_id', $reqData['mark_id']);
        if (!empty($reqData['model_id'])) {
            if (strpos($reqData['model_id'], 'c_') === 0) {
                $categoryId = str_replace('c_', '', $reqData['model_id']);
                $modelIds = Model::active()->where('category_id', $categoryId)->lists('id')->toArray();
                $query->whereIn('model_id', $modelIds);
            } else {
                $query->where('model_id', $reqData['model_id']);
            }
        }
        $this->setWhere($query, 'country_id', $reqData['country_id']);
        $this->setWhere($query, 'transmission_id', $reqData['transmission_id']);
        $this->setWhere($query, 'rudder_id', $reqData['rudder_id']);
        $this->setWhere($query, 'engine_id', $reqData['engine_id']);
        $this->setWhere($query, 'volume', $reqData['volume_from'], '>=');
        $this->setWhere($query, 'volume', $reqData['volume_to'], '<=');
        $this->setWhere($query, 'year', $reqData['year_from'], '>=');
        $this->setWhere($query, 'year', $reqData['year_to'], '<=');
        $this->setWhere($query, 'train_id', $reqData['train_id']);
        $this->setWhere($query, 'horsepower', $reqData['horsepower_from'], '>=');
        $this->setWhere($query, 'horsepower', $reqData['horsepower_to'], '<=');
        $this->setWhere($query, 'color_id', $reqData['color_id']);
        $this->setWhere($query, 'interior_color_id', $reqData['interior_color_id']);
        $this->setWhere($query, 'cylinders', $reqData['cylinders']);
        $this->setWhere($query, 'doors', $reqData['doors']);
        $this->setWhere($query, 'wheels', $reqData['wheels']);
        $this->setWhere($query, 'custom_cleared', $reqData['custom_cleared']);
        $this->setWhere($query, 'damaged', $reqData['damaged']);
        $this->setWhere($query, 'partial_pay', $reqData['partial_pay']);

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
        $this->setPriceWhere($query, $reqData['price_from'], '>=', $currencies, $defCurrency, $cCurrency);
        $this->setPriceWhere($query, $reqData['price_to'], '<=', $currencies, $defCurrency, $cCurrency);

        $count = config('auto.paging.count');
        $autos = $query->paginate($count);
        return [$autos, $reqData, $showAll];
    }

    protected function getReqData(Request $request)
    {
        $reqData = [];
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
        $reqData['cylinders'] = $request->input('cylinders');
        $reqData['doors'] = $request->input('doors');
        $reqData['wheels'] = $request->input('wheels');
        $reqData['custom_cleared'] = $request->input('custom_cleared');
        $reqData['damaged'] = $request->input('damaged');
        $reqData['partial_pay'] = $request->input('partial_pay');
        return $reqData;
    }

    protected function setWhere($query, $key, $value, $equation = '=')
    {
        if (!empty($value)) {
            $query->where($key, $equation, $value);
        }
    }

    protected function setPriceWhere($query, $value, $equation, $currencies, $defCurrency, $cCurrency)
    {
        if (!empty($value)) {
            $prices = [];
            foreach ($currencies as $currency) {
                if ($currency->id == $cCurrency->id) {
                    $price = $value;
                } else if ($currency->id == $defCurrency->id) {
                    $price = round($value / $cCurrency->rate);
                } else if ($defCurrency->id == $cCurrency->id) {
                    $price = round($value * $currency->rate);
                } else {
                    $price = $value / $cCurrency->rate;
                    $price = round($price * $currency->rate);
                }
                $prices[] = [
                    'currency_id' => $currency->id,
                    'price' => intval($price)
                ];
            }
            $query->where(function($query) use($prices, $equation) {
                foreach ($prices as $price) {
                    $query->orWhere(function($query) use($price, $equation) {
                        $query->where('currency_id', $price['currency_id'])->where('price', $equation, $price['price']);
                    });
                }
            });
        }
    }

}