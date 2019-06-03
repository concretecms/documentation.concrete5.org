<?php

/**
 * dotenv based db configuration
 */
return array(
    'default-connection' => 'live',
    'connections' => array(
        'live' => array(
            'driver' => 'c5_pdo_mysql',
            'server' => getenv('DB_HOSTNAME'),
            'database' => getenv('DB_DATABASE'),
            'username' => getenv('DB_USERNAME'),
            'password' => getenv('DB_PASSWORD'),
            'charset' => 'utf8mb4',
        ),
    ),
);
