<?php

use App\Models\Auto\Auto;
use App\Models\Config\Config;

return [
    'auto' => [
        'path' => '/'.Auto::IMAGES_PATH,
        'thumb' => [
            'width' => '245',
            'height' => '177',
            'crop' => 'center'
        ]
    ],
    'config' => [
        'path' => '/'.Config::IMAGES_PATH,
        'auto_empty_thumb' => [
            'width' => '245',
            'height' => '177',
            'crop' => 'center'
        ]
    ]
];