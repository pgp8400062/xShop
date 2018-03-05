<?php

use Phalcon\Loader;

$loader = new Loader();

/**
 * Register Namespaces
 */
$loader->registerNamespaces([
    'XShop\Models'  => APP_PATH . '/common/models/',
    'XShop\Library' => APP_PATH . '/common/library/',
]);

/**
 * Register module classes
 */
$loader->registerClasses([
    'XShop\Modules\Frontend\Module' => APP_PATH . '/modules/frontend/Module.php',
    'XShop\Modules\Cli\Module'      => APP_PATH . '/modules/cli/Module.php'
]);

$loader->register();
