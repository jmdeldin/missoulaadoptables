<?php

/**
 * URL utilitiy class.
 *
 * @author Jon-Michael Deldin <dev@jmdeldin.com>
 */
class Url
{
    /**
     * This static class cannot be instantiated.
     */
    private function __construct() {}

    /**
     * Redirects the user to a given URL.
     *
     * @param string $url
     */
    public static function redirect301($url)
    {
        header($_SERVER["SERVER_PROTOCOL"] . " 301 Redirect");
        header("Location: {$url}");
    }

    /**
     * Converts a route (controller/method/arg) to an absolute URL.
     *
     * This method handles pretty (example.com/controller/method/arg) and
     * ugly URLS (example.com/index.php?route=...) depending on the conf.ini
     * settings.
     *
     * @param string $route
     * @return string URL
     */
    public static function route2url($route)
    {
        $s = Site::getInstance();
        $url = $s->getUrl();
        $url .= ($s->hasPrettyUrls()) ? "/{$route}" :
                                        "/index.php?route={$route}";
        return $url;
    }

    /**
     * Returns the URL of the site.
     *
     *
     * This is an alias of Site::getInstance()->getUrl() to provide a
     * consistent and shorter interface to clients. The config file wouldn't
     * need the URL entry if there was a reliable way to determine the site's
     * base URL,
     *
     * @return string
     */
    public static function getBase()
    {
        return Site::getInstance()->getUrl();
    }
}
