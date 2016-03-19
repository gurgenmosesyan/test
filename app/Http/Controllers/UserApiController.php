<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;

class UserApiController extends Controller
{
    public function registration(UserRequest $request)
    {
        $data = $request->all();
        dd($data);
    }
}
