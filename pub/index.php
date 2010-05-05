<?php

require dirname(dirname(__FILE__)) . "/app/lib/Site.php";

Site::getInstance(); // bootstrap the application
$router = new Router();
$router->delegate();
