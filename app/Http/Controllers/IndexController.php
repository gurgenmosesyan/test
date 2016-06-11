<?php

namespace App\Http\Controllers;

use App\Models\Country\CountryMl;
use App\Models\Mark\Mark;

class IndexController extends Controller
{
    public function index()
    {
        $countries = CountryMl::active()->current()->get();
        $marks = Mark::active()->get();

        return view('index.index')->with([
            'countries' => $countries,
            'marks' => $marks
        ]);
    }
}