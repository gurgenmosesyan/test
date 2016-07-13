<?php

namespace App\Http\Controllers;

use App\Models\Auto\Manager;
use App\Http\Requests\SellRequest;

class SellApiController extends Controller
{
    protected $manager = null;

    public function __construct(Manager $manager)
    {
        $this->manager = $manager;
    }

    public function add(SellRequest $request)
    {
        $this->manager->add($request->all());

        return $this->api('OK', [
            'text' => trans('www.sell_car.add.success_text'),
            'link' => route('user_profile', cLng('code'))
        ]);
    }
}