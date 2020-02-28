<?php

return [
    '__name' => 'media-sizer',
    '__version' => '0.0.3',
    '__git' => 'git@github.com:getmim/media-sizer.git',
    '__license' => 'MIT',
    '__author' => [
        'name' => 'Iqbal Fauzi',
        'email' => 'iqbalfawz@gmail.com',
        'website' => 'http://iqbalfn.com/'
    ],
    '__files' => [
        'modules/media-sizer' => ['install','update','remove']
    ],
    '__dependencies' => [
        'required' => [
            [
                'lib-media' => NULL
            ],
            [
                'lib-upload' => NULL
            ],
            [
                'lib-image' => NULL
            ]
        ],
        'optional' => []
    ],
    'autoload' => [
        'classes' => [
            'MediaSizer\\Controller' => [
                'type' => 'file',
                'base' => 'modules/media-sizer/system/Controller.php',
                'children' => 'modules/media-sizer/controller'
            ]
        ],
        'files' => []
    ],
    'gates' => [
        'media' => [
            'priority' => 20000,
            'host' => [
                'value' => 'HOST'
            ],
            'path' => [
                'value' => '/media'
            ]
        ]
    ],
    'routes' => [
        'media' => [
            404 => [
                'handler' => 'MediaSizer\\Controller::show404'
            ],
            500 => [
                'handler' => 'MediaSizer\\Controller::show500'
            ],
            'mediaSizer' => [
                'path' => [
                    'value' => '/(:file)',
                    'params' => [
                        'file' => 'rest'
                    ]
                ],
                'handler' => 'MediaSizer\\Controller\\Sizer::resize'
            ]
        ]
    ]
];
