<?php

use Slim\Container;

$container = $app->getContainer();

$container['db'] = function (Container $container) {
	$setting = $container->get('settings');

	$config = new \Doctrine\DBAL\Configuration();

	$connect = \Doctrine\DBAL\DriverManager::getConnection($setting['db'],
		$config);

	return $connect;
};

$container['logger'] = function(Container $container) {
    $logger = new \Monolog\Logger('my_logger');

    return $logger;
};