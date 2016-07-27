<?php

namespace App\Http\Controllers;

use App\Models\Body\Body;
use App\Models\Country\CountryMl;
use App\Models\Engine\Engine;
use App\Models\Mark\Mark;
use App\Models\Train\Train;
use App\Models\Transmission\Transmission;

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

        return view('search.index')->with([
            'marks' => $marks,
            'countries' => $countries,
            'bodies' => $bodies,
            'transmissions' => $transmissions,
            'trains' => $trains,
            'engines' => $engines
        ]);
    }
}