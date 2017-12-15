<?php

// Register The Composer Auto Loader
require __DIR__ . '/../vendor/autoload.php';

// Bootstrap The Framework.
$app = require_once __DIR__ . '/../bootstrap/app.php';

$app->run();

