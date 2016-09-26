<?php
use App\Models\Ad\Manager;

$banners = Manager::get('right');
?>
@if(!$banners->isEmpty())
    <div class="right-gov">
        @if(empty($banners[0]->link))
            <img src="{{$banners[0]->getImage()}}">
        @else
            <a href="{{$banners[0]->link}}" target="_blank"><img src="{{$banners[0]->getImage()}}"></a>
        @endif
    </div>
@endif