<?php

/**
 * Handles common name data
 */
class CommonNameModel
{
    private $db;

    public function __construct()
    {
        $this->db = new Database(Site::getInstance()->getDbConf());
    }

    private function get($criteria = NULL, $sort = NULL, $limit = NULL)
    {
        $query = <<<EOF
select id, name
from common_names
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
        $names = array();
        if (!$rs) {// no results
            return $names;
        }
        foreach ($rs as $row) {
            $names[] = new CommonName($row["id"], $row["name"]);
        }
        return $names;
    }

    public function getAll()
    {
        return $this->get(null, "name asc");
    }
}
