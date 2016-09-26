<?php
use App\Models\Ad\Manager;

$banners = Manager::get('top');
?>
<div id="top-banner" class="tc">
    @if(!$banners->isEmpty())
        @if(empty($banners[0]->link))
            <img src="{{$banners[0]->getImage()}}" />
        @else
            <a href="{{$banners[0]->link}}" target="_blank"><img src="{{$banners[0]->getImage()}}" /></a>
        @endif
    @endif
</div>