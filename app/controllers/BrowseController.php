<?php

/**
 *
 *
 * @author Jon-Michael Deldin <dev@jmdeldin.com>
 */
class BrowseController implements Controller
{
    public function index()
    {
        return $this->view();
    }

    public function view($params = NULL)
    {
        // valid categories to search
        $categories = array(
            "common_name_id" => "Common Name",
            "breed"          => "Breed",
            "sex"            => "Sex",
            "shelter_id"     => "Shelter"
        );

        $v = new View("animal_index");
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
