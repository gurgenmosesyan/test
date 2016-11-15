<?php

namespace App\Http\Requests\User;

use App\Http\Requests\Request;
use App\Models\User\User;
use Auth;
use Illuminate\Http\Request as HttpRequest;

class EditRequest extends Request
{
    public function __construct(HttpRequest $request)
    {
        $day = $request->input('day');
        $month = $request->input('month');
        $year = $request->input('year');
        $birthday = '';
        if (!empty($year) && !empty($month) && !empty($day)) {
            $birthday = $year.'-'.$month.'-'.$day;
        }
        $request->request->add(['birthday' => $birthday]);
    }

    public function rules()
    {
        //$user = Auth::guard('user')->user();

        return [
            //'email' => 'required|email|unique:users,email,'.$user->id.',id,show_status,1',
            'password' => 'required_with:re_password|min:6|max:255|regex:/[a-z]{1,}[0-9]{1,}/i',
            're_password' => 'required_with:password|same:password',
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'phone' => [
                'required',
                'regex:/^\s*\+\s*?[0-9\s*]{1,}\s*$/',
                'max:30'
            ],
            'birthday' => 'required|date',
            'gender' => 'required|in:'.User::GENDER_MALE.','.User::GENDER_FEMALE
        ];
    }
}