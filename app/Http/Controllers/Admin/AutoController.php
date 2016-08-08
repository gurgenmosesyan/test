<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Core\BaseController;
use App\Models\Auto\Auto;
use App\Models\Auto\Manager;
use App\Models\Auto\Search;
use App\Http\Requests\Admin\AutoRequest;
use App\Models\Body\Body;
use App\Models\Color\Color;
use App\Models\Country\Country;
use App\Models\Cylinder\Cylinder;
use App\Models\Door\Door;
use App\Models\Engine\Engine;
use App\Models\InteriorColor\Color as InteriorColor;
use App\Models\Mark\Mark;
use App\Models\Model\Model;
use App\Models\Region\Region;
use App\Models\Rudder\Rudder;
use App\Models\Train\Train;
use App\Models\Transmission\Transmission;
use App\Models\Wheel\Wheel;
use App\Models\Option\Option;
use App\Models\Currency\Currency;
use Illuminate\Http\Request;

class AutoController extends BaseController
{
    protected $manager = null;

    public function __construct(Manager $manager)
    {
        $this->manager = $manager;
    }

    public function table()
    {
        return view('admin.auto.index');
    }

    public function index(Search $search)
    {
        $result = $this->processDataTable($search);
        return $this->toDataTable($result);
    }

    public function create()
    {
        $auto = new Auto();
        $marks = Mark::active()->get();
        $bodies = Body::active()->with('current')->get();
        $transmissions = Transmission::active()->with('current')->get();
        $rudders = Rudder::active()->with('current')->get();
        $colors = Color::active()->with('current')->get();
        $interiorColors = InteriorColor::active()->with('current')->get();
        $engines = Engine::active()->with('current')->get();
        $cylinders = Cylinder::active()->get();
        $trains = Train::active()->with('current')->get();
        $doors = Door::active()->get();
        $wheels = Wheel::active()->get();
        $countries = Country::active()->with('current')->get();
        $regions = [];
        if (!$countries->isEmpty()) {
            $regions = Region::joinMl()->active()->where('country_id', $countries[0]->id)->get();
        }
        $options = Option::active()->with('current')->get();
        $currencies = Currency::active()->ordered()->get();
        return view('admin.auto.edit')->with([
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
            'regions' => $regions,
            'options' => $options,
            'currencies' => $currencies,
            'saveMode' => 'add'
        ]);
    }

    public function store(AutoRequest $request)
    {
        return $this->api('OK', $this->manager->store($request->all()));
    }

    public function edit($id)
    {
        $auto = Auto::findOrFail($id);
        $marks = Mark::active()->get();
        $models = Model::active()->where('mark_id', $auto->mark_id)->get();
        $bodies = Body::active()->with('current')->get();
        $transmissions = Transmission::active()->with('current')->get();
        $rudders = Rudder::active()->with('current')->get();
        $colors = Color::active()->with('current')->get();
        $interiorColors = InteriorColor::active()->with('current')->get();
        $engines = Engine::active()->with('current')->get();
        $cylinders = Cylinder::active()->get();
        $trains = Train::active()->with('current')->get();
        $doors = Door::active()->get();
        $wheels = Wheel::active()->get();
        $countries = Country::active()->with('current')->get();
        $regions = Region::joinMl()->where('country_id', $auto->country_id)->get();
        $options = Option::active()->with('current')->get();
        $currencies = Currency::active()->ordered()->get();
        return view('admin.auto.edit')->with([
            'auto' => $auto,
            'marks' => $marks,
            'models' => $models,
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
            'regions' => $regions,
            'options' => $options,
            'currencies' => $currencies,
            'saveMode' => 'edit'
        ]);
    }

    public function update(AutoRequest $request, $id)
    {
        return $this->api('OK', $this->manager->update($id, $request->all()));
    }

    public function delete($id)
    {
        return $this->api('OK', $this->manager->delete($id));
    }

    public function changeStatus(Request $request)
    {
        $id = $request->input('id');
        $status = $request->input('status');
        if ($status != Auto::STATUS_APPROVED && $status != Auto::STATUS_BLOCKED) {
            return $this->api('INVALID_DATA');
        }
        Auto::active()->where('id', $id)->update(['status' => $status]);
        return $this->api('OK');
    }

    public function get(Request $request)
    {
        $title = $request->input('title');
        $parts = explode(' ', $title);
        foreach ($parts as $key => $part) {
            if (empty($part)) {
                unset($parts[$key]);
            }
        }
        $parts = array_values($parts);

        $autos = Auto::select('autos.id', 'autos.year', 'marks.name as mark_name', 'models.name as model_name')
        ->join('marks', function($query) {
            $query->on('marks.id', '=', 'autos.mark_id')->where('marks.show_status', '=', Mark::STATUS_ACTIVE);
        })
        ->join('models', function($query) {
            $query->on('models.id', '=', 'autos.model_id')->where('models.show_status', '=', Model::STATUS_ACTIVE);
        })
        ->active()
        ->where(function($query) use($parts) {
            if (count($parts) == 1) {
                $query->where('marks.name', 'LIKE', '%'.$parts[0].'%')
                    ->orWhere('models.name', 'LIKE', '%'.$parts[0].'%');
            } else if (count($parts) == 2) {
                $query->where(function($query) use($parts) {
                    $query->where('marks.name', 'LIKE', '%'.$parts[0].'%')
                          ->where('models.name', 'LIKE', '%'.$parts[1].'%');
                })->orWhere(function($query) use($parts) {
                    $query->where('marks.name', 'LIKE', '%'.$parts[1].'%')
                          ->where('models.name', 'LIKE', '%'.$parts[0].'%');
                });
            } else if (count($parts) == 3) {
                $query->where(function($query) use($parts) {
                    $query->where('marks.name', 'LIKE', '%'.$parts[0].'%')
                          ->where('models.name', 'LIKE', '%'.$parts[1].'%')
                          ->where('autos.year', 'LIKE', '%'.$parts[2].'%');
                })->orWhere(function($query) use($parts) {
                    $query->where('marks.name', 'LIKE', '%'.$parts[1].'%')
                          ->where('models.name', 'LIKE', '%'.$parts[0].'%')
                          ->where('autos.year', 'LIKE', '%'.$parts[2].'%');
                });
            }
        })
        ->get();

        return $this->api('OK', $autos);
    }
}