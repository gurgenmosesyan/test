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
use App\Models\Rudder\Rudder;
use App\Models\Train\Train;
use App\Models\Transmission\Transmission;
use App\Models\Wheel\Wheel;
use App\Models\Option\Option;
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
        $options = Option::active()->with('current')->get();
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
            'options' => $options,
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
        $options = Option::active()->with('current')->get();
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
            'options' => $options,
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
}