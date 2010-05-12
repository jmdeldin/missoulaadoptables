<?php

/**
 * Handles the breed column.
 *
 * @todo Use a separate table for breeds
 * @author Jon-Michael Deldin <dev@jmdeldin.com>
 */
class BreedModel
{
    private $db;

    public function __construct()
    {
        $this->db = new Database(Site::getInstance()->getDbConf());
    }

    public function getAll()
    {
        $breeds = array();
        $rs = $this->db->retrieve("select distinct breed
                                   from animals
                                   order by breed asc");
        if (!$rs) {
            return $breeds;
        }
        foreach ($rs as $row) {
            $breeds[] = new Breed($row["breed"]);
        }
        return $breeds;
    }
}
