<?php

use App\Controllers\ShorteningController;
use Psr\Container\ContainerInterface;

$app = new \Slim\App();

$container = $app->getContainer();

// Register Application Dependencies.
require __DIR__ . '/dependencies.php';

// Update Container Settings.
$container->get('settings')->replace($container->get('config')->get('app'));

// Register Routes.
require __DIR__ . '/../app/routes.php';

// Register Controllers.
$container[ShorteningController::class] = function (ContainerInterface $container) {
    return new ShorteningController($container->get('shortener'));
};

return $app;