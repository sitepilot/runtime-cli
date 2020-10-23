<?php

return [
    'default' => 'local',
    'disks' => [
        'local' => [
            'driver' => 'local',
            'root' => base_path('storage/config'),
        ],
        'runtime' => [
            'driver' => 'local',
            'root' => '/opt/sitepilot/etc'
        ],
        'templates' => [
            'driver' => 'local',
            'root' => base_path('templates')
        ]
    ],
];