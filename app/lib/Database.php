<?php

/**
 * Database access layer that uses PHP's PDO as a database abstraction layer.
 *
 * @author Jon-Michael Deldin <dev@jmdeldin.com>
 */
class Database
{
    private $dbh; // PDO instance

    /**
     * @param array $config Associative array of configuration.
     *                      Keys: {driver, host, dbname, user, pass}
     */
    public function __construct($config)
    {
        $dsn = "{$config['driver']}:host={$config['host']};
                dbname={$config['dbname']}";
        try {
            $this->dbh = new PDO($dsn, $config['user'], $config['pass']);
        } catch (PDOException $e) {
            echo "Database unavailable.";
            // TODO: Log $e->getMessage()
            exit(1);
        }
    }

    /**
     * Binds and executes a prepared statement.
     *
     * @param string $query SQL query to execute.
     * @param array  $vals  Key-value array for the prepared statement.
     *                      {key => {value, type}}
     * @return PDOStatement
     */
    private function executePreparedStatement($query, $vals = array())
    {
        $stmt = $this->dbh->prepare($query);
        $stmt->execute($vals);

        return $stmt;
    }

    /**
     * Returns a result set as an associative array.
     *
     * The query must use prepared statements and pass a hash of keys and
     * values for the statement as an array ($vals).
     *
     * @param string $query SQL query to execute.
     * @param array  $vals  Key-value pair for the prepared statement.
     */
    public function retrieve($query, $vals = NULL)
    {
        $stmt = $this->executePreparedStatement($query, $vals);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Insert into the database.
     *
     * @param string $query SQL query to execute.
     * @param array  $vals  Key-value pair for the prepared statement.
     */
    public function insert($query, $vals)
    {
        $this->executePreparedStatement($query, $vals);
    }

    /**
     * Delete records from the database.
     *
     * @param string $query SQL query to execute.
     * @param array  $vals  Key-value pair for the prepared statement.
     */
    public function delete($query, $vals)
    {
        $this->executePreparedStatement($query, $vals);
    }
}
