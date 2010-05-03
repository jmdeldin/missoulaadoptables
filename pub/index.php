<?php
$appRoot = dirname(dirname(__FILE__)) . "/app";
require "{$appRoot}/lib/Site.php";

$site = Site::getInstance();
spl_autoload_register(array($site, "autoload"));

$router = new Router();
$router->delegate();
