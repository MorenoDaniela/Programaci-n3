<?php

require_once '/../vendor/autoload.php';
use Slim\Factory\AppFactory;//mirar barras
$app = AppFactory::Create();
$app->setBasePath("api/public");
return $app;
