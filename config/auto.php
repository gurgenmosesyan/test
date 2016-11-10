<?php

use App\Models\Auto\AutoImage;

return [
    'paging' => [
        'count' => 25
    ],

    'images' => [
        'path' => '/'.AutoImage::IMAGES_PATH,
        'images' => [
            'extensions' => [
                'jpg', 'jpeg', 'png'
            ],
            //'width' => 700,
            //'height' => 500,
            //'min_width' => 500,
            //'min_height' => 500,
            //'max_width' => 1500,
            //'max_height' => 1500,
        ]
    ],

    'engine_volumes' => [
        '0.2', '0.4', '0.6', '0.8', '1.0', '1.2', '1.4', '1.6', '1.8', '2.0', '2.2', '2.4', '2.6', '2.8',
        '3.0', '3.5', '4.0', '4.5', '5.0', '5.5', '6.0', '7.0', '8.0', '9.0', '10.0'
    ]
];