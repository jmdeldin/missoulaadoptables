<?php

/**
 * Communicates with the data abstraction layer.
 *
 * @author Jon-Michael Deldin <dev@jmdeldin.com>
 */
class AnimalModel
{
    private $db;

    public function __construct()
    {
        $this->db = new Database(Site::getInstance()->getDbConf());
    }

    /**
     * Internal method used to retrieve Animals from the database.
     *
     * @param array  $criteria {key => {value, datatype}}
     * @param int    $limit
     * @param string $sort Sort the results by a column (e.g., "name asc").
     */
    private function get($criteria = NULL, $sort = NULL, $limit = NULL)
    {
        $query = <<<EOF
select animals.*, common_names.name as common_name
from animals
    inner join common_names on
        animals.common_name_id = common_names.id
EOF;
        if (isset($criteria)) {
            // where column = ?
            $query .= " where " . $criteria[0];
            // reset criteria to just the input value
            $criteria = array($criteria[1]);
        }
        if (isset($sort)) {
            $query .= " order by $sort";
        }
        if (isset($limit)) {
            $query .= " limit $limit";
        }

        $rs = $this->db->retrieve($query, $criteria);
        if (!$rs) {// no results
            return array();
        }

        $animals = array();
        $shelterModel = new ShelterModel();
        foreach ($rs as $row) {
            extract($row);
            // get the shelter obj
            $shelter = $shelterModel->getById($shelter_id);
            $animals[] = new Animal($id, $entry_date, $scrape_date, $name,
                $description, $breed, $sex, $fixed, $age, $color,
                $common_name, $shelter);
        }

        return $animals;
    }

    /**
     * Returns an array of animals.
     *
     * @param int $limit
     */
    public function getLatestAnimals($limit)
    {
        return $this->get(NULL, 'scrape_date desc', $limit);
    }

    /**
     * Returns a single animal that matches an ID.
     *
     * @param int $id Animal ID.
     */
    public function getAnimalById($id)
    {
        $arr = $this->get(array("animals.id = ?", $id));
        // we just need the first result
        if (isset($arr[0]))
            return $arr[0];
        else
            return null;
    }

    /**
     * Returns all animals in the database.
     *
     * Thus far, this is only used by the cron script.
     */
    public function getAll()
    {
        return $this->get();
    }

    /**
     * Search the search_index view for matching terms.
     *
     * @todo  switch to Zend_Search_Lucene or some other less naive solution
     * @param string $query Term to search for
     */
    public function find($query)
    {
        $query = "%$query%";
        $sql = <<<EOF
select id
from search_index
where common_name like ?
    or breed like ?
    or description like ?
    or name like ?
EOF;
        $animals = array();
        $rs = $this->db->retrieve($sql, array($query, $query, $query, $query));
        if (!$rs) {
            return $animals;
        }
        foreach ($rs as $row) {
            $animals[] = $this->getAnimalById((int) $row['id']);
        }
        return $animals;
    }

    public function getByCategory($category, $value)
    {
        $rs = $this->get(array("{$category} = ?", $value), "scrape_date desc");
        return $rs;
    }
}
