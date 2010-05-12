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
        $v->showMission = true;
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

    /**
     * Handles search queries.
     *
     * @param string $_GET['q']
     */
    public function search()
    {
        // no query
        if (!isset($_GET['q']) || empty($_GET['q'])) {
            $v = new View("search_index");
            $v->content = "You must enter a query.";
            return $v->render();
        }

        // process their query
        $query = filter_var($_GET['q'], FILTER_SANITIZE_STRING);

        $m = new AnimalModel();
        $v = new View("animal_index");
        $v->title = "Search Results for &#8220;{$query}&#8221;";
        $v->animals = $m->find($query);
        if (empty($v->animals)) {
            $v->setFile("search_index");
            $v->content = "Sorry, no results were found for &#8220;{$query}&#8221;.";
        }
        $v->render();
    }

    /**
     * Handles the browse page.
     */
    public function browse($params = NULL)
    {
        // valid categories to search
        $categories = array(
            "common_name_id" => "Common Name",
            "breed"          => "Breed",
            "sex"            => "Sex",
            "shelter_id"     => "Shelter"
        );

        $v = new View("browse");
        $v->title = "Browse";
        $v->showBrowser = true;
        $animalModel = new AnimalModel();

        // common name browser
        $commonModel = new CommonNameModel();
        $v->commonNames = $commonModel->getAll();

        // breed browser
        $breedModel = new BreedModel();
        $v->breeds = $breedModel->getAll();

        // shelter browser
        $shelterModel = new ShelterModel();
        $v->shelters = $shelterModel->getAll();

        $v->animals = array();
        // default page
        if (!$params) {
            $v->animals = $animalModel->getLatestAnimals(Site::getInstance()->getNumAnimals());
            return $v->render();
        }

        // check params
        if (!isset($categories[$params[0]])) {
            $e = new NotFoundError("Invalid criteria");
            return $e->serve();
        }

        // sanitize the params
        for ($i = 0; $i < count($params); $i++) {
            $params[$i] = filter_var($params[$i], FILTER_SANITIZE_STRING);
        }

        $v->title = "Browsing by {$categories[$params[0]]}";
        $v->animals = $animalModel->getByCategory($params[0], $params[1]);
        $v->render();
    }
}
