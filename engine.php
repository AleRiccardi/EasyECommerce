<?php

// Define CONSTANTS
define('PLUGIN_PATH', dirname(__FILE__));

// Require once the Composer Autoload
if (file_exists(PLUGIN_PATH . '/vendor/autoload.php')) {
    require_once PLUGIN_PATH . '/vendor/autoload.php';
}

/**
 * Initialize all the core classes of the plugin
 *
 * @since 1.0.0
 */
if (class_exists(Inc\Init::class)) {
    Inc\Init::registerServices();
}


$baseController = new \Inc\Base\BaseController();
