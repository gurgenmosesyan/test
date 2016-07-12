<?php
use App\Models\User\User;

$title = trans('www.user.profile.title');
?>
@extends('layout')

@section('content')

<div class="page">

    <div id="profile">
        <div class="links tc">
            <div class="link profile-link fl">
                <span class="item db fb">
                    <span class="icon dib"></span>
                    <span class="text dib">{{trans('www.profile.link.my_profile')}}</span>
                </span>
            </div>
            <div class="link cars-link fl">
                <a href="#" class="item db fb">
                    <span class="icon dib"></span>
                    <span class="text dib">{{trans('www.profile.link.my_cars')}}</span>
                </a>
            </div>
            <div class="link ads-link fl">
                <a href="#" class="item db fb">
                    <span class="icon dib"></span>
                    <span class="text dib">{{trans('www.profile.link.my_ads')}}</span>
                </a>
            </div>
            <div class="cb"></div>
        </div>

        <div id="profile-box">
            <div class="profile-left fl">
                <div class="profile-info fl">
                    <h2 class="fb">{{$user->first_name.' '.$user->last_name}}</h2>
                    <p>{{trans('www.profile.email').' '.$user->email}}</p>
                    <p>{{trans('www.profile.mobile').' '.$user->phone}}</p>
                    @if(!empty($user->birthday) && $user->birthday != '0000-00-00')
                        <p>{{trans('www.profile.birthday').' '.date('d.m.Y', strtotime($user->birthday))}}</p>
                    @endif
                    @if(!empty($user->gender))
                        <p>{{trans('www.profile.gender').' '.trans('www.profile.gender.'.$user->gender)}}</p>
                    @endif
                    <p class="edit-link">
                        <a href="{{url_with_lng('/profile/edit', false)}}" class="orange">{{trans('www.profile.edit_profile')}}</a>
                    </p>
                    <p class="edit-link">
                        <a href="{{url_with_lng('/logout', false)}}" class="orange">{{trans('www.profile.logout')}}</a>
                    </p>
                </div>
            </div>
            <div class="profile-right fl">
                <div class="balance">
                    <div class="balance-icon fl"></div>
                    <div class="balance-text fl">
                        <p class="fb">{{trans('www.profile.balance').' '.$user->balance}}</p>
                        <p class="fb">{{trans('www.profile.id').' '.$user->id}}</p>
                    </div>
                    <div class="cb"></div>
                </div>
                <p class="recharge orange">{{trans('www.profile.recharge_balance')}}</p>
                <div class="payments">
                    <a href="#"><img src="{{url('/images/paypal.png')}}" /></a>
                    <a href="#"><img src="{{url('/images/telcell.png')}}" /></a>
                    <a href="#"><img src="{{url('/images/arca.png')}}" /></a>
                </div>
            </div>
            <div class="cb"></div>

        </div>
    </div>

</div>

@stop