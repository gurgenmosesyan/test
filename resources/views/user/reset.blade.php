<?php
$head->appendScript('/js/user.js');
?>

@extends('layout')

@section('content')

    @if($data['wrong_hash'])
        <p>Hash is wrong</p>
    @else
        <form id="reset-form" action="{{url_with_lng('/api/reset', false)}}" method="post">
            <div>
                <input type="password" name="password" /> Password
                <div id="form-error-password" class="form-error"></div>
            </div>
            <div>
                <input type="password" name="re_password" /> Re password
                <div id="form-error-re_password" class="form-error"></div>
            </div>
            <input type="hidden" name="hash" value="{{$data['hash']}}" />
            {{csrf_field()}}
            <input type="submit" />
        </form>
    @endif

    <style>
        div { margin-bottom: 10px; }
    </style>

@stop