<?php

/**
 * Handles user interactions for the animal module.
 *
 * @author Jon-Michael Deldin <dev@jmdeldin.com>
 */
class AnimalController implements Controller
{
    private $model;

    public function  __construct()
    {
        $this->model = new AnimalModel();
    }

    /**
     * Display the latest animals.
     */
    public function index()
    {
        $v = new View("animal_index");
        $v->title = "Latest Animals";
        $v->animals = $this->model->getLatestAnimals(Site::getInstance()->getNumAnimals());
        $v->render();
    }

    /**
     * Display a single animal.
     *
     * @param array $id
     */
    public function view($id = null)
    {
        // someone trying to view "view/" should be redirected to the index
        if (!$id) {
            Url::redirect301(Url::route2url("animal"));
        }

        $v = new View('animal');
        $v->animal = $this->model->getAnimalById($id[0]);
        $v->shelter = $v->animal->getShelter();
        $v->title = "Details for {$v->animal->getName()}";
        $v->render();
    }

    /**
     * Render the Atom feed.
     */
    public function feed()
    {
        $v = new View("atom");
        $v->title = "Latest Animals";
        $v->animals = $this->model->getLatestAnimals(20);
        $v->render();
    }
}

