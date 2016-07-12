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
        $wrong = false;

        if ($user == null) {
            $wrong = true;
        } else {
            $user->status = User::STATUS_CONFIRMED;
            $manager = new UserManager();
            $user->hash = $manager->generateRandomUniqueHash();
            $user->save();
        }
        return view('user.activation')->with([
            'wrong' => $wrong
        ]);
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

    public function profile()
    {
        return view('user.profile')->with([
            'user' => Auth::guard('user')->user()
        ]);
    }

    public function profileEdit()
    {
        $user = Auth::guard('user')->user();
        $day = $month = $year = null;
        if (!empty($user->birthday) && $user->birthday != '0000-00-00') {
            $day = date('j', strtotime($user->birthday));
            $month = date('n', strtotime($user->birthday));
            $year = date('Y', strtotime($user->birthday));
        }
        return view('user.profile_edit')->with([
            'user' => $user,
            'day' => $day,
            'month' => $month,
            'year' => $year
        ]);
    }

    public function logout()
    {
        Auth::guard('user')->logout();
        return redirect()->route('homepage', cLng('code'));
    }
}