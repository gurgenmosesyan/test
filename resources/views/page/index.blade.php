<?php

$description = mb_substr(trim(strip_tags($page->text)), 0, 250);

$meta->title($page->title);
$meta->description($description);
$meta->ogTitle($page->title);
$meta->ogDescription($description);
$meta->ogImage(url('/images/fb-logo.png'));
$meta->ogUrl(url_with_lng('/page/'.$page->alias));

?>
@extends('layout')

@section('content')

<div class="page">

    @include('blocks.top_banner')

    <div id="main-left" class="fl">

        <div id="static">
            <h1 class="fb fs20 tc">{{$page->title}}</h1>
            <div class="html">{!!$page->text!!}</div>

            @if(request()->segment(3) == 'contact-us')
                <?php
                $head->appendScript('/js/user.js');
                $jsTrans->addTrans([
                    'www.contact.success.title',
                    'www.contact.success.text'
                ]);
                ?>
                <form id="contact-form" action="{{url_with_lng('/api/contacts', false)}}" method="post">
                    <div class="form-box">
                        <input type="text" name="name" placeholder="{{trans('www.base.label.name')}}" />
                        <div id="form-error-name" class="form-error fs14"></div>
                    </div>
                    <div class="form-box">
                        <input type="text" name="email" placeholder="{{trans('www.base.label.email')}}" />
                        <div id="form-error-email" class="form-error fs14"></div>
                    </div>
                    <div class="form-box">
                        <textarea name="message" placeholder="{{trans('www.base.label.message')}}"></textarea>
                        <div id="form-error-message" class="form-error fs14"></div>
                    </div>
                    {!! csrf_field() !!}
                    <input type="submit" class="orange-bg fb" value="{{trans('www.base.label.send')}}" />
                </form>
            @endif

        </div>

    </div>

    @include('blocks.right_banner')

    <div class="cb"></div>

</div>

@stop