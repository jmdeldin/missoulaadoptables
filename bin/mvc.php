#!/usr/bin/env php

<?php

/**
 * Loads controllers from the command line.
 *
 * Usage:
 *  $ php mvc.php -c Cron -m index
 *
 * @author Jon-Michael Deldin <dev@jmdeldin.com>
 */

require dirname(dirname(__FILE__)) . "/app/lib/Site.php";
Site::getInstance(); // bootstrap

// required parameters
$opts = array("c:", "m:");

// get any arguments to the required options
$args = getopt(implode('', $opts));

if (!isset($args['c']) || !isset($args['m'])) {
    echo "You must supply -c and -m arguments.\n";
    exit(1);
}

// fake the HTTP request for Router
$_GET["route"] = "{$args['c']}/{$args['m']}";

// TODO: Perhaps <index.php> could move to a common file
$router = new Router();
$router->delegate();
