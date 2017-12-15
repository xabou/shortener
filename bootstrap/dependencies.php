<?php

use App\Providers\BitlyProvider;
use App\Providers\GoogleProvider;
use App\Services\CachingService;
use App\Services\ConfigurationService;
use App\Services\ErrorHandlingService;
use App\Services\HttpClientService;
use App\Services\LoggingService;
use App\Services\ShorteningService;
use App\Services\ValidationService;
use Psr\Container\ContainerInterface;

$container['config'] = function () {
    return (new ConfigurationService())->register();
};

$container['logger'] = function () {
    return (new LoggingService())->register();
};

$container['shortener'] = function (ContainerInterface $container) {
    return (new ShorteningService($container->get('request'), $container, $container->get('config')))
        ->register();
};

$container['googleProvider'] = function (ContainerInterface $container) {
    return new GoogleProvider($container->get('httpClient'), $container->get('config'), $container->get('cache'));
};

$container['bitlyProvider'] = function (ContainerInterface $container) {
    return new BitlyProvider($container->get('httpClient'), $container->get('config'), $container->get('cache'));
};

$container['validator'] = function () {
    return (new ValidationService())->register();
};

$container['httpClient'] = function () {
    return (new HttpClientService())->register();
};

$container['errorHandler'] = function (ContainerInterface $container) {
    return (new ErrorHandlingService($container->get('logger')))->register();
};

$container['cache'] = function (ContainerInterface $container) {
    return (new CachingService($container->get('config')))->register();
};

