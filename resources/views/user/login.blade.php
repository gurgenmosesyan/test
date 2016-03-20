<?php
use App\Models\User\User;
$head->appendScript('/js/user.js');
?>

@extends('layout')

@section('content')

    <form id="login-form" action="{{url_with_lng('/api/login', false)}}" method="post">
        <div>
            <input type="text" name="email" /> Email
            <div id="form-error-email" class="form-error"></div>
        </div>
        <div>
            <input type="password" name="password" /> Password
            <div id="form-error-password" class="form-error"></div>
        </div>
        <div>
            <input type="checkbox" name="remember_me" value="{{User::REMEMBER_ME}}" /> Remember me
            <div id="form-error-remember_me" class="form-error"></div>
        </div>
        {{csrf_field()}}
        <input type="submit" />
    </form>

    <style>
        div { margin-bottom: 10px; }
    </style>

@stop