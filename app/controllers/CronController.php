<?php

/**
 * Actions that are run
 */
class CronController {
    /**
     * Ensure the controller is called from the command line.
     */
    public function __construct()
    {
        if (php_sapi_name() !== 'cli' || !empty($_SERVER['REMOTE_ADDR'])) {
            $err = new NotFoundError("Must be run from the command line.");
            return $err->serve();
        }

    }

    /**
     * @todo This could run various scripts.
     */
    public function index()
    {
    }
}
