<?php
require_once __DIR__ .'/vendor/autoload.php';

use NNV\RestCountries;

$restCountries = new RestCountries;

$paises = $restCountries->all();

echo json_encode($paises);
/*
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

// create a log channel
$log = new Logger('name');
$log->pushHandler(new StreamHandler('name.log', Logger::WARNING));

// add records to the log
$log->warning('Foo');
$log->error('Bar');*/