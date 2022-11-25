<?php

include __DIR__ . '/vendor/autoload.php';

use challenge\Application;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\PhpFileLoader;
use Symfony\Component\Config\FileLocator;

const APP_PATH = __DIR__;
const DATA_PATH = APP_PATH . DIRECTORY_SEPARATOR . 'resource';

$di = new ContainerBuilder();
$loader = new PhpFileLoader($di, new FileLocator(APP_PATH));
$loader->load('dependencies.php');

/** @var Application $app */
$app = $di->get('app');
$app->execute();