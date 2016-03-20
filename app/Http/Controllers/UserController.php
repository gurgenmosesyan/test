<?php

namespace App\Http\Controllers;

use App\Models\User\User;
use App\Models\User\UserManager;
use Auth;

class UserController extends Controller
{
    public function login()
    {
        return view('user.login');
    }

    public function registration()
    {
        return view('user.registration');
    }

    public function forgot()
    {
        return view('user.forgot');
    }

    public function activation($lngCode, $hash)
    {
        $user = User::active()->where('hash', $hash)->where('status', User::STATUS_REGISTERED)->first();

        if ($user == null) {
            $message = trans('www.user.activation.wrong_hash');
        } else {
            $user->status = User::STATUS_CONFIRMED;
            $manager = new UserManager();
            $user->hash = $manager->generateRandomUniqueHash();
            $user->save();
            $message = trans('www.user.activation.success_message');
        }
        return view('user.activation')->with(['message' => $message]);
    }

    public function reset($lngCode, $hash)
    {
        $user = User::active()->where('hash', $hash)->first();
        if ($user == null) {
            $data = [
                'wrong_hash' => true,
                'message' => trans('www.user.reset.wrong_hash')
            ];
        } else {
            $data = [
                'wrong_hash' => false,
                'hash' => $hash
            ];
        }
        return view('user.reset')->with(['data' => $data]);
    }

    public function logout()
    {
        Auth::guard('user')->logout();
        return redirect()->route('homepage', cLng('code'));
    }
}