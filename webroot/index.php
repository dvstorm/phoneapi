<?php
ini_set('display_startup_errors', 1);
ini_set('display_errors', 1);
ini_set('html_errors', true);
error_reporting(E_ALL);

define('DS', DIRECTORY_SEPARATOR);
define('ROOT', dirname(dirname(__FILE__)));

require_once(ROOT.DS.'lib'.DS.'init.php');

// $router = new Router($_SERVER['REQUEST_URI']);

App::run($_SERVER['REQUEST_URI']);
