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

    public function getById($id)
    {
        $query = <<<EOF
select shelters.*, states.name as state
from shelters
    inner join states on shelters.state_id = states.id
where shelters.id = ?
EOF;

        $rs = $this->db->retrieve($query, array($id));
        if (!$rs)
            return null;
        $shelters = array();
        foreach ($rs as $row) {
            extract($row);
            // TODO: Consider using the builder pattern
            $shelters[] = new Shelter($id, $name, $uri, $street_address, $city,
                                      $postal_code, $phone, $email, $hours,
                                      $state);
        }
        return $shelters[0];
    }
}
