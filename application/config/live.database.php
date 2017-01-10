<?php

/**
 * dotenv based db configuration
 */
return array(
    'default-connection' => 'live',
    'connections' => array(
        'live' => array(
            'driver' => 'c5_pdo_mysql',
            'server' => getenv('DB_SERVER'),
            'database' => getenv('DB_DATABASE'),
            'username' => getenv('DB_USER'),
            'password' => getenv('DB_PASSWORD'),
            'charset' => 'utf8mb4',
        ),
    ),
);
