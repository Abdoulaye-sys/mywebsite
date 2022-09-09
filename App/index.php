<?php

require_once 'Core/Autoloader.php';

use Core\Autoloader;
use Core\Router;
use Core\Session;


Autoloader::register();
Session::start();
Router::dispatch();