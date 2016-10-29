<?php

namespace App\Http\Controllers;

use App\Models\Auto\Auto;
use App\Models\Auto\Manager;
use App\Http\Requests\SellRequest;
use Auth;

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

        $user = Auth::guard('user')->user();
        $autosCount = Auto::active()->where('user_id', $user->id)->count();
        if ($autosCount >= 10) {
            return $this->api('AUTO_LIMIT', null, ['limit' => trans('www.auto.add.limit.text')]);
        }

        $autoId = $this->manager->add($data);

        return $this->api('OK', [
            'link' => url_with_lng('/auto/'.$autoId)
        ]);
    }
}