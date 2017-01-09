<?php

return array(
    'default-connection' => 'wercker',
    'connections' => array(
        'wercker' => array(
            'driver' => 'c5_pdo_mysql',
            'server' => getenv('MARIADB_PORT_3306_TCP_ADDR'),
            'database' => 'wercker_documentation',
            'username' => 'root',
            'password' => 'wercker',
            'charset' => 'utf8',
        ),
    ),
);
