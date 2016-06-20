<?php

namespace App\Http\Controllers;

use App\Models\Country\CountryMl;
use App\Models\Mark\Mark;
use App\Models\Body\Body;

class IndexController extends Controller
{
    public function index()
    {
        $countries = CountryMl::active()->current()->get();
        $marks = Mark::active()->orderBy('name', 'asc')->get();
        $bodies = Body::active()->inSearch()->ordered()->take(3)->get();

        return view('index.index')->with([
            'countries' => $countries,
            'marks' => $marks,
            'bodies' => $bodies
        ]);
    }
}