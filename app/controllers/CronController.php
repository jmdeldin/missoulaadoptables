<?php

/**
 * Actions that are run by cron or from the command line
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
        // TODO: This should be read from the ``shelter_pages'' table
        $mhsDog = new MhsDogScraper("http://montanapets.org/mhs/residentdog.html");
        $mhsCat = new MhsCatScraper("http://montanapets.org/mhs/residentcat.html");

        $packer = new Packer();
        $packer->pack($mhsDog->scrape());
        $packer->pack($mhsCat->scrape());

        $loader = new Loader($packer->getPackedPets());
        $loader->checkActive();
        $loader->load();

        // temporary fix for the slashes in some breeds
        // @todo: this should be done in the scraper
        $db = new Database(Site::getInstance()->getDbConf());
        $db->execute("update animals set breed = replace(breed, '/', '-')");
    }
}
