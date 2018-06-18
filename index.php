<?php
//ini_set('display_errors', 1);
session_start();
require_once 'Psr4Autoloader.php';
$loader = new Psr4Autoloader();

// register the autoloader
$loader->register();
$loader->addNamespace('radio\classes', __DIR__. '/source/classes');
$loader->addNamespace('radio\controllers', __DIR__. '/source/controllers');
$loader->addNamespace('radio\models', __DIR__. '/source/models');
$loader->addNamespace('radio\core', __DIR__. '/source/core');

require_once 'source/system/config.php';
require_once 'source/bootstrap.php';
