<?php
use Doctrine\DBAL\Driver\PDOMySql\Driver as PDOMySqlDriver;

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
];
