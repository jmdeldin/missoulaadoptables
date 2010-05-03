<?php

/**
 * Represents the site's basic configuration.
 *
 * This class is a singleton, so it can only be accessed as
 *
 *      $site = Site::getInstance();
 *
 * @author Jon-Michael Deldin <dev@jmdeldin.com>
 */
class Site
{
    /**
     * Instance of itself.
     * @var Site
     */
    private static $instance;

    /**
     * Site name
     * @var string
     */
    private $name;

    /**
     * Location of the "app" directory.
     * @var string
     */
    private $appRoot;

    /**
     * Production status (false == debugging)
     * @var boolean
     */
    private $production;

    /**
     * Associative array of db configuration.
     * @var array
     */
    private $dbConf;

    /**
     * Number of animals to display on the homepage.
     */
    private $numAnimals;

    /**
     * Email address (footer and Atom feed)
     * @var string
     */
    private $email;

    /**
     * Cannot be instantiated outside of this class.
     */
    private function __construct()
    {
        $this->appRoot = dirname(dirname(__FILE__)); // "../../"
        $this->loadConf();
    }

    /**
     * Create and return this class.
     */
    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new self;
        }
        return self::$instance;
    }

    /**
     * Loads the "app/conf/conf.ini" config file.
     */
    private function loadConf()
    {
        $filename = "{$this->appRoot}/conf/conf.ini";
        if (file_exists($filename)) {
            $conf = parse_ini_file($filename, true);

            // site name
            $this->name = $conf["site"]["name"];

            // base url
            $this->url = rtrim($conf["site"]["url"], '/');

            // email
            $this->email = $conf["site"]["email"];

            // production status -- parse_ini_file sets "false" as ""
            $this->production = ($conf["site"]["production"]) ? true : false;

            // mod_rewrite or not
            $this->prettyUrls = ($conf["site"]["pretty_urls"]) ? true: false;

            // # animals for the homepage
            $this->numAnimals = (int) $conf["site"]["num_animals"];

            // database info
            $this->dbConf = $conf["database"];
        }
    }

    /**
     * This method should be fed to spl_autoload_register() (its only client).
     *
     * @param string $className
     */
    public function autoload($className)
    {
        // directories to scan
        $dirs = array(
            'controllers',
            'models',
            'lib'
        );

        $fname = "";
        foreach ($dirs as $d) {
            $filename = $this->appRoot . "/{$d}/{$className}.php";
            if (file_exists($filename)) {
                return require $filename;
            }
        }
    }

    public function getName()
    {
        return $this->name;
    }

    public function getAppRoot()
    {
        return $this->appRoot;
    }

    public function getProduction()
    {
        return $this->production;
    }

    public function getDbConf()
    {
        return $this->dbConf;
    }

    public function getUrl()
    {
        return $this->url;
    }

    public function hasPrettyUrls()
    {
        return $this->prettyUrls;
    }

    public function getNumAnimals()
    {
        return $this->numAnimals;
    }

    public function getEmail()
    {
        return $this->email;
    }
}
