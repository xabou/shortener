<?php

use App\Middlewares\ValidationMiddleware;

$app->post('/shorten', \App\Controllers\ShorteningController::class . ':show')
    ->add(new ValidationMiddleware($app->getContainer()->get('validator')));