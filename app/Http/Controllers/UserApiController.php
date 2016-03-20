<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\RegRequest;
use App\Http\Requests\User\LoginRequest;
use App\Http\Requests\User\ForgotRequest;
use App\Http\Requests\User\ResetRequest;
use App\Models\User\User;
use App\Models\User\UserManager;

class UserApiController extends Controller
{
    protected $manager = null;

    public function __construct(UserManager $manager)
    {
        $this->manager = $manager;
    }

    public function login(LoginRequest $request)
    {
        $data = $request->all();
        $rememberMe = isset($data['remember_me']) && $data['remember_me'] == User::REMEMBER_ME ? true : false;
        $auth = auth()->guard('user');
        $result = $auth->attempt(['email' => $data['email'], 'password' => $data['password']], false, false);
        if ($result) {
            $user = User::active()->where('email', $data['email'])->first();
            if ($user->status == User::STATUS_REGISTERED) {
                $error = trans('www.user.login.not_confirmed');
            } else if ($user->status == User::STATUS_BLOCKED) {
                $error = trans('www.user.login.blocked');
            } else {
                $auth->login($user, $rememberMe);
                return $this->api('OK', ['link' => route('user_profile', cLng('code'))]);
            }
        } else {
            $error = trans('www.user.login.invalid_credentials');
        }
        return $this->api('INVALID_DATA', null, ['email' => [$error]]);
    }

    public function registration(RegRequest $request)
    {
        return $this->api('OK', $this->manager->registration($request->all()));
    }

    public function forgot(ForgotRequest $request)
    {
        return $this->api('OK', $this->manager->forgot($request->all()));
    }

    public function reset(ResetRequest $request)
    {
        return $this->api('OK', $this->manager->reset($request->all()));
    }
}
