<?php

namespace App\Http\Controllers;

class UserController extends Controller
{
    public function registration()
    {
        return view('user.registration');
    }
}