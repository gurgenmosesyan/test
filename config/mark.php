<?php

use App\Models\Mark\Mark;

return [
    'images' => [
        'path' => '/'.Mark::IMAGES_PATH,
        'image' => [
            'extensions' => [
                'jpg', 'jpeg', 'png'
            ],
            //'width' => 700,
            //'height' => 500,
            //'min_width' => 500,
            //'max_width' => 200,
            //'min_height' => 500,
            //'max_height' => 200,
        ]
    ]
];