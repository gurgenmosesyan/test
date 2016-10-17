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

        $autoId = $this->manager->add($data);

        return $this->api('OK', [
            'link' => url_with_lng('/auto/'.$autoId)
        ]);
    }
}