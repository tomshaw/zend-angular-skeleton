<?php

use Zend\Mvc\Application;
use Zend\Stdlib\ArrayUtils;

/**
 * This makes our life easier when dealing with paths. Everything is relative
 * to the application root now.
 */
chdir(dirname(__DIR__));

// Decline static file requests back to the PHP built-in webserver
if (php_sapi_name() === 'cli-server') {
    $path = realpath(__DIR__ . parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
    if (__FILE__ !== $path && is_file($path)) {
        return false;
    }
    unset($path);
}

defined('DS') || define('DS', DIRECTORY_SEPARATOR);
defined('APPLICATION_PATH') || define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/../..'));

// 1 hour  3600;
// 1 day   86400;
// 1 week  604800;
// 1 month 2600640;
// 1 year  31207680;

//define("SESSION_LIFETIME", 60 *60 * 24); // one day
define("SESSION_LIFETIME", 31207680 * 5); // five years

ini_set('session.gc_maxlifetime', SESSION_LIFETIME); // for server
ini_set('session.cookie_lifetime', SESSION_LIFETIME); // for browser

// Composer autoloading
include __DIR__ . '/../../vendor/autoload.php';

if (! class_exists(Application::class)) {
    throw new RuntimeException(
        "Unable to load application.\n"
        . "- Type `composer install` if you are developing locally.\n"
        . "- Type `vagrant ssh -c 'composer install'` if you are using Vagrant.\n"
        . "- Type `docker-compose run zf composer install` if you are using Docker.\n"
    );
}

// Retrieve configuration
$appConfig = require __DIR__ . '/../../config/application.config.php';
if (file_exists(__DIR__ . '/../../config/development.config.php')) {
    $appConfig = ArrayUtils::merge($appConfig, require __DIR__ . '/../../config/development.config.php');
}

// Run the application!
Application::init($appConfig)->run();
