<?php

use App\Models\Ad\Ad;

return [
    'images' => [
        'path' => '/'.Ad::IMAGES_PATH,
        'top' => [
            'extensions' => [
                'jpg', 'jpeg', 'png', 'gif'
            ],
            'width' => 660,
            'height' => 88,
        ],
        'thin' => [
            'extensions' => [
                'jpg', 'jpeg', 'png', 'gif'
            ],
            'width' => 520,
            'height' => 95,
        ],
        'right' => [
            'extensions' => [
                'jpg', 'jpeg', 'png', 'gif'
            ],
            'width' => 303,
            'height' => 254,
        ],
        'bottom' => [
            'extensions' => [
                'jpg', 'jpeg', 'png', 'gif'
            ],
            'width' => 290,
            'height' => 250,
        ]
    ]
];