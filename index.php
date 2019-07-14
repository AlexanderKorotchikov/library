<?php

// Общие настройки 
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Подключение файлов системы
session_start();

define('ROOT', dirname(__FILE__));
define('NUM_BOOKS', 5);
require_once(ROOT.'/components/Router.php');
require_once(ROOT.'/components/Db.php');

// Вызор Router
$router = new Router();
$router->run();
