<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\RegRequest;
use App\Http\Requests\User\LoginRequest;
use App\Http\Requests\User\ForgotRequest;
use App\Http\Requests\User\ResetRequest;
use Illuminate\Http\Request;
use App\Models\User\User;
use App\Models\User\UserManager;
use Facebook\Facebook;
use Facebook\Exceptions\FacebookResponseException;
use Facebook\Exceptions\FacebookSDKException;

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

    public function fbLogin(Request $request)
    {
        $accessToken = $request->input('access_token');
        $fb = new Facebook([
            'app_id' => config('social.fb.app_id'),
            'app_secret' => config('social.fb.app_secret'),
            'default_graph_version' => 'v2.5',
        ]);
        $status = 'OK';
        $error = null;
        try {
            $oAuth2Client = $fb->getOAuth2Client();
            $longLivedAccessToken = $oAuth2Client->getLongLivedAccessToken($accessToken);

            $fb->setDefaultAccessToken($longLivedAccessToken);
            $response = $fb->get('/me');
            $userNode = $response->getGraphUser();

            $userManager = new UserManager();
            $user = $userManager->getFBUser($userNode);

            $auth = auth()->guard('user');
            $auth->login($user);

        } catch (FacebookResponseException $e) {
            //echo 'Graph returned an error: ' . $e->getMessage();
            $status = 'INVALID_DATA';
            $error = $e->getMessage();
        } catch(FacebookSDKException $e) {
            //echo 'Facebook SDK returned an error: ' . $e->getMessage();
            $status = 'INVALID_DATA';
            $error = $e->getMessage();
        }
        return $this->api($status, null, $error);
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
