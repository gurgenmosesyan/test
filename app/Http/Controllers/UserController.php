<?php

namespace App\Http\Controllers;

use App\Http\Requests\SellRequest;
use App\Models\Auto\Auto;
use App\Models\Region\Region;
use App\Models\User\User;
use App\Models\User\UserManager;
use App\Models\Currency\CurrencyManager;
use App\Models\Body\Body;
use App\Models\Country\Country;
use App\Models\Currency\Currency;
use App\Models\Cylinder\Cylinder;
use App\Models\Door\Door;
use App\Models\Engine\Engine;
use App\Models\Mark\Mark;
use App\Models\Model\Model;
use App\Models\Option\Option;
use App\Models\Rudder\Rudder;
use App\Models\Train\Train;
use App\Models\Transmission\Transmission;
use App\Models\Color\Color;
use App\Models\InteriorColor\Color as InteriorColor;
use App\Models\Wheel\Wheel;
use Session;
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

    public function registrationSuccess()
    {
        if (!Session::get('success_reg')) {
            return redirect()->route('homepage', cLng('code'));
        }
        return view('user.registration_success');
    }

    public function forgot()
    {
        return view('user.forgot');
    }

    public function forgotSuccess()
    {
        if (!Session::get('forgot_success')) {
            return redirect()->route('homepage', cLng('code'));
        }
        return view('user.forgot_success');
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

    public function resetSuccess()
    {
        if (!Session::get('reset_success')) {
            return redirect()->route('user_login', cLng('code'));
        }
        return view('user.reset_success');
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

    public function profileChanged()
    {
        if (!Session::get('profile_changed')) {
            return redirect()->route('user_profile', cLng('code'));
        }
        return view('user.profile_changed');
    }

    public function autos()
    {
        $count = config('auto.paging.count');
        $user = Auth::guard('user')->user();
        $autos = Auto::active()->where('user_id', $user->id)->with('mark', 'model', 'engine_ml', 'train_ml', 'body_ml', 'color_ml', 'country_ml')->latest()->paginate($count);

        $currencyManager = new CurrencyManager();
        $currencies = $currencyManager->all();
        $defCurrency = $currencyManager->defaultCurrency();
        $cCurrency = $currencyManager->currentCurrency();

        return view('user.autos')->with([
            'autos' => $autos,
            'currencies' => $currencies,
            'defCurrency' => $defCurrency,
            'cCurrency' => $cCurrency
        ]);
    }

    public function autoEdit($lngCode, $id)
    {
        $user = Auth::guard('user')->user();
        $auto = Auto::active()->where('id', $id)->where('user_id', $user->id)->firstOrFail();

        $marks = Mark::active()->get();
        $models = Model::active()->where('mark_id', $auto->mark_id)->get();
        $bodies = Body::joinMl()->active()->get();
        $transmissions = Transmission::joinMl()->active()->get();
        $rudders = Rudder::joinMl()->active()->get();
        $colors = Color::joinMl()->active()->get();
        $interiorColors = InteriorColor::joinMl()->active()->get();
        $engines = Engine::joinMl()->active()->get();
        $cylinders = Cylinder::active()->get();
        $trains = Train::joinMl()->active()->get();
        $doors = Door::active()->get();
        $wheels = Wheel::active()->get();
        $countries = Country::joinMl()->active()->get();
        $regions = collect();
        if (!empty($auto->region_id)) {
            $regions = Region::joinMl()->active()->get();
        }
        $options = Option::joinMl()->active()->get();
        $currenciesData = Currency::active()->ordered()->get();

        return view('user.auto_edit')->with([
            'auto' => $auto,
            'marks' => $marks,
            'models' => $models,
            'bodies' => $bodies,
            'transmissions' => $transmissions,
            'rudders' => $rudders,
            'colors' => $colors,
            'interiorColors' => $interiorColors,
            'engines' => $engines,
            'cylinders' => $cylinders,
            'trains' => $trains,
            'doors' => $doors,
            'wheels' => $wheels,
            'countries' => $countries,
            'regions' => $regions,
            'options' => $options,
            'currenciesData' => $currenciesData
        ]);
    }

    public function autoUpdated()
    {
        if (!Session::get('auto_updated')) {
            return redirect()->route('profile_autos', cLng('code'));
        }
        return view('user.auto_updated');
    }

    public function logout()
    {
        Auth::guard('user')->logout();
        return redirect()->route('homepage', cLng('code'));
    }
}