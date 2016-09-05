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
        $data = $request->all();
        if ($data['action'] == 'next') {
            return $this->api('OK');
        }

        $this->manager->add($data);

        $request->session()->flash('add_car', true);

        return $this->api('OK', [
            'link' => route('sell_success', cLng('code'))
        ]);
    }
}