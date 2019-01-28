<?php

use Zend\Session\Storage\SessionArrayStorage;
use Zend\Session\Validator\RemoteAddr;
use Zend\Session\Validator\HttpUserAgent;
use Zend\Cache\Storage\Adapter\Filesystem;

return [

    // Session configuration.
    'session_config' => [
        'cookie_lifetime'     => 60*60*24, // Session cookie will expire in 24 hours.
        'gc_maxlifetime'      => 60*60*24*30, // How long to store session data on server (for 1 month).
    ],

    // Session manager configuration.
    'session_manager' => [
        // Session validators (used for security).
        'validators' => [
            RemoteAddr::class,
            HttpUserAgent::class,
        ]
    ],

    // Session storage configuration.
    'session_storage' => [
        'type' => SessionArrayStorage::class
    ],

    // Cache configuration.
    'caches' => [

        'FilesystemCache' => [

            'adapter' => [
                'name'    => Filesystem::class,
                'options' => [

                    // Store cached data in this directory.
                    'cache_dir' => './data/cache',

                    // Store cached data for 1 hour.
                    'ttl' => 60*60*1
                ],
            ],

            'plugins' => [
                [
                    'name' => 'serializer',
                    'options' => [
                    ],
                ],
            ],

        ],

    ],
];
