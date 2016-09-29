<?php

return [
    [
        'key' => 'detail',
        'icon' => 'fa-cog',
        'sub_menu' => [
            [
                'key' => 'mark',
                'path' => route('admin_mark_table'),
                'icon' => 'fa-circle-o',
            ],
            [
                'key' => 'model_category',
                'path' => route('admin_model_category_table'),
                'icon' => 'fa-circle-o',
            ],
            [
                'key' => 'model',
                'path' => route('admin_model_table'),
                'icon' => 'fa-circle-o',
            ],
            [
                'key' => 'body',
                'path' => route('admin_body_table'),
                'icon' => 'fa-circle-o',
            ],
            [
                'key' => 'transmission',
                'path' => route('admin_transmission_table'),
                'icon' => 'fa-circle-o',
            ],
            [
                'key' => 'rudder',
                'path' => route('admin_rudder_table'),
                'icon' => 'fa-circle-o',
            ],
            [
                'key' => 'color',
                'path' => route('admin_color_table'),
                'icon' => 'fa-circle-o',
            ],
            [
                'key' => 'interior_color',
                'path' => route('admin_interior_color_table'),
                'icon' => 'fa-circle-o',
            ],
            [
                'key' => 'engine',
                'path' => route('admin_engine_table'),
                'icon' => 'fa-circle-o',
            ],
            [
                'key' => 'cylinder',
                'path' => route('admin_cylinder_table'),
                'icon' => 'fa-circle-o',
            ],
            [
                'key' => 'train',
                'path' => route('admin_train_table'),
                'icon' => 'fa-circle-o',
            ],
            [
                'key' => 'door',
                'path' => route('admin_door_table'),
                'icon' => 'fa-circle-o',
            ],
            [
                'key' => 'wheel',
                'path' => route('admin_wheel_table'),
                'icon' => 'fa-circle-o',
            ]
        ]
    ],
    [
        'key' => 'option',
        'path' => route('admin_option_table'),
        'icon' => 'fa-bars',
    ],
    [
        'key' => 'country',
        'path' => route('admin_country_table'),
        'icon' => 'fa-globe',
    ],
    [
        'key' => 'region',
        'path' => route('admin_region_table'),
        'icon' => 'fa-globe',
    ],
    [
        'key' => 'auto',
        'path' => route('admin_auto_table'),
        'icon' => 'fa-car',
    ],
    [
        'key' => 'top_car',
        'path' => route('admin_top_car_table'),
        'icon' => 'fa-star',
    ],
    [
        'key' => 'urgent_car',
        'path' => route('admin_urgent_car_table'),
        'icon' => 'fa-exclamation-circle',
    ],
    [
        'key' => 'config',
        'path' => route('admin_config_edit'),
        'icon' => 'fa-edit',
    ],
    [
        'key' => 'currency',
        'path' => route('admin_currency_table'),
        'icon' => 'fa-usd',
    ],
    [
        'key' => 'part',
        'path' => route('admin_part_table'),
        'icon' => 'fa-cogs',
    ],
    [
        'key' => 'ad',
        'path' => route('admin_ad_table'),
        'icon' => 'fa-bullhorn',
    ],
    [
        'key' => 'tax',
        'path' => route('admin_tax_table'),
        'icon' => 'fa-calculator',
    ],
    [
        'key' => 'footer_menu',
        'path' => route('admin_footer_menu_table'),
        'icon' => 'fa-align-left',
    ]
];