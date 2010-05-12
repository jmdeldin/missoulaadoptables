<?php

/**
 * Handles Shelter data.
 *
 * @author Jon-Michael Deldin <dev@jmdeldin.com>
 */
class ShelterModel
{
    private $db;

    public function __construct()
    {
        $this->db = new Database(Site::getInstance()->getDbConf());
    }

    private function get($criteria = NULL, $sort = NULL, $limit = NULL)
    {
        $query = <<<EOF
select shelters.*, states.name as state
from shelters
    inner join states on shelters.state_id = states.id
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
        $shelters = array();
        if (!$rs) {
            return $shelters;
        }
        foreach ($rs as $row) {
            extract($row);
            // TODO: Consider using the builder pattern
            $shelters[] = new Shelter($id, $name, $uri, $street_address, $city,
                                      $postal_code, $phone, $email, $hours,
                                      $state);
        }
        return $shelters;
    }

    public function getById($id)
    {
        $rs = $this->get(array("shelters.id = ?", $id));
        if (!$rs) {
            return null;
        }
        return $rs[0];
    }

    public function getAll()
    {
        $rs = $this->get(null, "shelters.name asc");
        if (!$rs) {
            return null;
        }
        return $rs;
    }
}
