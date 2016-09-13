<?php

namespace App\Http\Controllers;

use App\Http\Requests\SellRequest;
use App\Http\Requests\User\RegRequest;
use App\Http\Requests\User\LoginRequest;
use App\Http\Requests\User\ForgotRequest;
use App\Http\Requests\User\ResetRequest;
use App\Http\Requests\User\EditRequest;
use App\Models\Auto\Auto;
use Illuminate\Http\Request;
use App\Models\User\User;
use App\Models\User\UserManager;
use App\Models\Auto\Manager;
use Facebook\Facebook;
use Facebook\Exceptions\FacebookResponseException;
use Facebook\Exceptions\FacebookSDKException;
use Google_Client;
use Google_Service_Plus;
use Session;
use Auth;

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
            $status = 'INVALID_DATA';
            $error = $e->getMessage();
        } catch(FacebookSDKException $e) {
            $status = 'INVALID_DATA';
            $error = $e->getMessage();
        }
        return $this->api($status, null, $error);
    }

    public function googleLogin(Request $request)
    {
        $code = $request->input('code');
        $client = new Google_Client();
        $client->setClientId(config('social.google.client_id'));
        $client->setClientSecret(config('social.google.client_secret'));
        $client->setRedirectUri(route('google_login'));

        //$client->addScope(\Google_Service_Urlshortener::URLSHORTENER);
        $client->setScopes(['https://www.googleapis.com/auth/userinfo.email', 'https://www.googleapis.com/auth/userinfo.profile']);

        if (empty($code)) {
            $authUrl = $client->createAuthUrl();
            return redirect($authUrl);
        } else {
            $client->authenticate($code);
            $plus = new Google_Service_Plus($client);
            $person = $plus->people->get('me');

            $userManager = new UserManager();
            $user = $userManager->getGoogleUser($person);

            $auth = auth()->guard('user');
            $auth->login($user);

            return '<script>opener.window.$user.googleCallback();</script>';
        }
    }

    public function registration(RegRequest $request)
    {
        $this->manager->registration($request->all());
        $request->session()->flash('success_reg', true);
        return $this->api('OK', ['link' => route('success_reg', cLng('code'))]);
    }

    public function forgot(ForgotRequest $request)
    {
        $this->manager->forgot($request->all());
        $request->session()->flash('forgot_success', true);
        return $this->api('OK', ['link' => route('forgot_success', cLng('code'))]);
    }

    public function reset(ResetRequest $request)
    {
        $this->manager->reset($request->all());
        $request->session()->flash('reset_success', true);
        return $this->api('OK', ['link' => route('reset_success', cLng('code'))]);
    }

    public function profileEdit(EditRequest $request)
    {
        $this->manager->editProfile($request->all());
        $request->session()->flash('profile_changed', true);
        return $this->api('OK', ['link' => route('profile_changed', cLng('code'))]);
    }

    public function autoUpdate(SellRequest $request, $lngCode, $id)
    {
        $autoManager = new Manager();
        $autoManager->updateAuto($request->all(), $id);
        $request->session()->flash('auto_updated', true);
        return $this->api('OK', ['link' => route('auto_updated', cLng('code'))]);
    }

    public function deleteAuto(Request $request)
    {
        $user = Auth::guard('user')->user();
        $id = $request->input('id');
        $auto = Auto::active()->where('id', $id)->firstOrFail();
        if ($auto->user_id != $user->id) {
            return $this->api('INVALID_DATA');
        }
        $auto->show_status = Auto::STATUS_DELETED;
        $auto->save();
        $request->session()->flash('auto_deleted', true);
        return $this->api('OK', ['link' => route('auto_deleted', cLng('code'))]);
    }
}
