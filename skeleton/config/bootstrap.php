<?php

require __DIR__ . '/../vendor/autoload.php';

use SlimFactory\AppFactory;

$app = AppFactory::create();
$app->setBasePath("/skeleton/public");

return $app;
   