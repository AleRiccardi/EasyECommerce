<?php

namespace Inc\Base;

/**
 * The BaseController class permit to retrieve information
 * about the plugin path, plugin url and plugin initial
 * function.
 *
 * @author      Alessandro RICCARDI
 * @since       1.0.0
 *
 * @package     OpenBadgesFramework
 */
class BaseController {
    public $website_path;
    public $website_url;

    /**
     * Here are initialized main variables.
     *
     * @author      Alessandro RICCARDI
     * @since       1.0.0
     */
    public function __construct() {
        //Path
        $this->website_path = $this->dirname_r(__FILE__, 3);
        //Url
        $url = $_SERVER['REQUEST_URI']; //returns the current URL
        $parts = explode('/',$url);
        $this->website_url = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]/$parts[1]";
    }

    /**
     * Returns a parent directory's path, implemented
     * because in php minor of 7 return a warming about
     * the second parameter that is not necessary.
     *
     * @param     $path     A path.
     * @param int $levels   The number of parent directories to go up.
     *
     * @return string
     */
    public static function dirname_r($path, $levels = 1) {
        if ($levels > 1) {
            return dirname(self::dirname_r($path, --$levels));
        } else {
            return dirname($path);
        }
    }
}