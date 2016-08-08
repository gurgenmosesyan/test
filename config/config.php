<?php

use App\Models\Config\Config;

return [
    'images' => [
        'path' => '/'.Config::IMAGES_PATH,
        'watermark' => [
            'extensions' => [
                'jpg', 'jpeg', 'png'
            ],
            //'width' => 700,
            //'height' => 500,
            //'min_width' => 500,
            //'max_width' => 200,
            //'min_height' => 500,
            //'max_height' => 200,
        ],
        'auto_empty' => [
            'extensions' => [
                'jpg', 'jpeg', 'png'
            ],
            'width' => 527,
            'height' => 380,
        ]
    ]
];