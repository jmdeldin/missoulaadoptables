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

    /**
     * Run the scrapers.
     */
    public function scrape()
    {
        $url = "http://montanapets.org/mhs/residentdog.html";
        // DOMDocument complains about malformed HTML
        // TODO: See if there's a better library for parsing HTML
        error_reporting(E_ERROR);
        $scraper = new Scraper($url);
        $loader = new Loader($scraper->scrape());
        $loader->checkActive();
        $loader->load();
    }
}
