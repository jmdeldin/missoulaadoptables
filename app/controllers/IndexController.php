<?php

/**
 * Handles requests to / and /index.
 *
 * @author Jon-Michael Deldin <dev@jmdeldin.com>
 */
class IndexController implements Controller
{
    public function index()
    {
        // for now, just pass control over to AnimalController->index()
        $c = new AnimalController();
        $c->index();
    }
}
