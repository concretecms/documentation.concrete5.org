<?php

use Concrete\Core\Application\Application;

/**
 * Load in a .env if there is one
 */
try {
    $dotenv = new Dotenv\Dotenv(__DIR__ . "/../../", 'myconfig');
    $dotenv->load();
} catch (\Exception $e) {
    // Ignore exception
}

/**
 * ----------------------------------------------------------------------------
 * Instantiate concrete5
 * ----------------------------------------------------------------------------
 */
$app = new Application();

/**
 * ----------------------------------------------------------------------------
 * Detect the environment based on the hostname of the server
 * ----------------------------------------------------------------------------
 */
$app->detectEnvironment(
    array(
        'andrew' => array(
            'Andrews-MacBook-Pro.local'
        ),
        'live' => array(
            'documentation.concrete5.org'
        )
    ));

return $app;
