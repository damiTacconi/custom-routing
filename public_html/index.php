<?php

require_once('../config/Autoload.php');
require_once('../config/Route.php');
require_once('../config/Config.php');
require_once('../config/Router.php');
require_once('../config/Request.php');

use config\Router;
use controller\HomeController;
use config\Autoload;
use config\Request;

Autoload::autoload();
require_once('../config/routes.php');
Router::connect(new Request());
