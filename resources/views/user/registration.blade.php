<?php
$head->appendScript('/js/user.js');
?>

@extends('layout')

@section('content')

<form id="registration-form" action="{{url_with_lng('/api/registration', false)}}" method="post">
    <div>
        <input type="text" name="email" /> Email
        <div id="form-error-email" class="form-error"></div>
    </div>
    <div>
        <input type="password" name="password" /> Password
        <div id="form-error-password" class="form-error"></div>
    </div>
    <div>
        <input type="password" name="re_password" /> Re password
        <div id="form-error-re_password" class="form-error"></div>
    </div>
    <div>
        <input type="text" name="first_name" /> First name
        <div id="form-error-first_name" class="form-error"></div>
    </div>
    <div>
        <input type="text" name="last_name" /> Last name
        <div id="form-error-last_name" class="form-error"></div>
    </div>
    <div>
        <input type="text" name="phone" /> Phone
        <div id="form-error-phone" class="form-error"></div>
    </div>
    {{csrf_field()}}
    <input type="submit" />
</form>

<br><br><br>

<a href="#" id="fb-login">FB login</a>
<br>
<br>
<a href="#" id="google-login">Google login</a>

<style>
    div { margin-bottom: 10px; }
</style>

@stop