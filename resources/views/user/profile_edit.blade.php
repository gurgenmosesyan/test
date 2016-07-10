<?php
use App\Models\User\User;

$head->appendScript('/js/user.js');

$title = trans('www.profile.edit.title');

?>
@extends('layout')

@section('content')

    <div class="page">

        <div id="login-block" class="profile-edit">
            <div id="login-inner">
                <h1 class="tc">{{$title}}</h1>
                <form id="registration-form" action="{{url_with_lng('/api/registration', false)}}" method="post">
                    <div class="form-box">
                        <input type="text" name="email" value="{{$user->email}}" placeholder="{{trans('www.base.label.email')}}" />
                        <div id="form-error-email" class="form-error"></div>
                    </div>
                    <div class="form-box">
                        <input type="password" name="password" placeholder="{{trans('www.base.label.password')}}" />
                        <div id="form-error-password" class="form-error"></div>
                    </div>
                    <div class="form-box">
                        <input type="password" name="re_password" placeholder="{{trans('www.base.label.re_password')}}" />
                        <div id="form-error-re_password" class="form-error"></div>
                    </div>
                    <div class="form-box">
                        <input type="text" name="first_name" value="{{$user->first_name}}" placeholder="{{trans('www.base.label.first_name')}}" />
                        <div id="form-error-first_name" class="form-error"></div>
                    </div>
                    <div class="form-box">
                        <input type="text" name="last_name" value="{{$user->last_name}}" placeholder="{{trans('www.base.label.last_name')}}" />
                        <div id="form-error-last_name" class="form-error"></div>
                    </div>
                    <div class="form-box">
                        <input type="text" name="phone" value="{{$user->phone}}" placeholder="{{trans('www.base.label.phone')}}" />
                        <div id="form-error-phone" class="form-error"></div>
                    </div>
                    <div class="form-box">
                        <div class="day fl">
                            <div class="select-box">
                                <div class="select-arrow"></div>
                                <div class="select-title"></div>
                                <select name="day">
                                    <option value="">{{trans('www.base.label.day')}}</option>
                                    @for($i = 1; $i < 32; $i++)
                                        <option value="{{$i}}">{{$i}}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                        <div class="month fl">
                            <div class="select-box">
                                <div class="select-arrow"></div>
                                <div class="select-title"></div>
                                <select name="month">
                                    <option value="">{{trans('www.base.label.month')}}</option>
                                    @for($i = 1; $i < 13; $i++)
                                        <option value="{{$i}}">{{strftime('%b', strtotime('2015-'.$i.'-01'))}}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                        <div class="year fl">
                            <div class="select-box">
                                <div class="select-arrow"></div>
                                <div class="select-title"></div>
                                <select name="year_to">
                                    <option value="">{{trans('www.base.label.year')}}</option>
                                    @for($i = date('Y'); $i > 1904; $i--)
                                        <option value="{{$i}}">{{$i}}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                        <div class="cb"></div>
                        <div id="form-error-birthday" class="form-error"></div>
                    </div>
                    <div class="form-box">
                        <div class="male fl">
                            <label class="checkbox-label no-select">
                                {{trans('www.gender.male')}}
                                <input type="radio" name="gender" value="{{User::GENDER_MALE}}">
                            </label>
                        </div>
                        <div class="female fl">
                            <label class="checkbox-label no-select">
                                {{trans('www.gender.female')}}
                                <input type="radio" name="gender" value="{{User::GENDER_FEMALE}}">
                            </label>
                        </div>
                    </div>
                    {{csrf_field()}}
                    <input type="submit" class="orange-bg fb" value="{{$title}}" />
                </form>
            </div>
        </div>

    </div>

@stop