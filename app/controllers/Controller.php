<?php

/**
 * Base interface for Controllers to implement.
 *
 * @author Jon-Michael Deldin <dev@jmdeldin.com>
 */
interface Controller {
    /**
     * This method is automatically called when the Route is "$controller/".
     */
    public function index();
}
