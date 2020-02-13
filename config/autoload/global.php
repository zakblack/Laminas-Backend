<?php
use Doctrine\DBAL\Driver\PDOMySql\Driver as PDOMySqlDriver;
use Laminas\Session\Storage\SessionArrayStorage;
use Laminas\Session\Validator\HttpUserAgent;
use Laminas\Session\Validator\RemoteAddr;

return [
    'doctrine' => [
        'connection' => [
            'orm_default' => [
                'driverClass' => PDOMySqlDriver::class,
                'params' => [
                    'host'     => 'b54kr7o4sssj7dm1qdld-mysql.services.clever-cloud.com',
                    'user'     => 'uaqruimhcy6k4jnk',
                    'password' => 'mbsIaOPQovWMmiR06kFR',
                    'dbname'   => 'b54kr7o4sssj7dm1qdld',
                ]
            ],
        ],
    ],

    'session_config' => [
        'cookie_lifetime' => 60*60*1,
        'gc_maxlifetime'     => 60*60*24*30,
    ],
    'session_manager' => [

        'validators' => [
            RemoteAddr::class,
            HttpUserAgent::class,
        ]
    ],
    // Session storage configuration.
    'session_storage' => [
        'type' => SessionArrayStorage::class
    ],
];
