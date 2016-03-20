<?php
$head->appendScript('/js/user.js');
?>

@extends('layout')

@section('content')

    <form id="forgot-form" action="{{url_with_lng('/api/forgot', false)}}" method="post">
        <div>
            <input type="text" name="email" /> Email
            <div id="form-error-email" class="form-error"></div>
        </div>
        {{csrf_field()}}
        <input type="submit" />
    </form>

    <style>
        div { margin-bottom: 10px; }
    </style>

@stop