<?php

class Loader
{
  /*
  Loader.php
  Evan Cummings
  CS 346
  4.16.10

  Loads and updates database with new pets.
  */

  private $newPets;
  private $connection;
  private $currentPets;
  private $newKeys;
  private $keys;
  private $totalNew;
  private $totalCurrent;
  private $log;

  // Constructor.
  function Loader($newPets)
  {
    $db = Site::getInstance()->getDbConf();
    $this->log = Site::getInstance()->getLogFile();
    $this->newPets = $newPets;
    $this->connection = mysql_connect($db["host"], $db["user"], $db["pass"]);
    $this->currentPets = array( "id"            => array(),
                                "scrape_date"   => array(),
                                "name"          => array(),
                                "breed"         => array(),
                                "color"         => array(),
                                "entry_date"    => array(),
                                "impound_num"   => array(),
                                "sex"           => array(),
                                "fixed"         => array(),
                                "age"           => array(),
                                "description"   => array(),
                                "common_name_id"=> array(),
                                "shelter_id"    => array(),
                                "active"        => array());
    $this->keys = array_keys($this->currentPets);
    $this->newKeys = array_keys($this->newPets);
    mysql_select_db($db["dbname"], $this->connection);

    $query = "SELECT * FROM animals";
    $result = mysql_query($query, $this->connection);

    // Load up array of current pets from DB.
    while ($row = mysql_fetch_array($result, MYSQL_ASSOC))
    {
      for($i = 0; $i < count($row); $i++)
      {
        array_push($this->currentPets[$this->keys[$i]],
          $row[$this->keys[$i]]);
      }

    }

    $this->totalNew = count($this->newPets["name"]);
    $this->totalCurrent = count($this->currentPets["name"]);

  }

  // Check to see if a pet is gone.
  function checkActive()
  {
    // For each current pet,
    for ($c = 0; $c < count($this->currentPets["name"]); $c++)
    {
      $match = false;

      file_put_contents($this->log,
          "\n\n::CHECK ACTIVE::",
          FILE_APPEND);
      file_put_contents($this->log,
          "\n\n{$this->currentPets["name"][$c]}: {$c}",
          FILE_APPEND);

      // Compare to each new pet,
      for ($n = 0; $n < count($this->newPets["name"]); $n++)
      {
        $date = date("Y.n.d-H:i:s - ");

        file_put_contents($this->log,
          "\n{$date}c." . $n . ".{$this->newPets["name"][$n]}: ",
          FILE_APPEND);

        // If the numbers match, move to next current animal.
        if (strcmp($this->currentPets["impound_num"][$c],
            $this->newPets["impound_num"][$n]) == 0)
        {
          file_put_contents($this->log,
            "Impound #'s Match: ",
            FILE_APPEND);
          $match = true;
          $this->updateActive($c, 1);
        }

        // If the impound numbers don't match, keep going.
        // If it reaches the end of the current animal list
        // without a match, update active flag to false.
        else
        {
          file_put_contents($this->log,
            "Not the same ",
            FILE_APPEND);
          if (($n == count($this->newPets["name"]) - 1) &&
              ($match == false))
          {
            $this->updateActive($c, 0);
          }

        }

      }

    }

  }

  // Update active flag.
  function updateActive($c, $b)
  {
    $date = date("Y.n.d-H:i:s - ");
    $animal = $this->currentPets["impound_num"][$c];

    mysql_query(
      "UPDATE animals SET active = {$b} WHERE impound_num = '{$animal}';",
      $this->connection);

    file_put_contents(
      $this->log,
      "\n{$date}UPDATE animals SET active = {$b} WHERE impound_num = '{$animal}';",
      FILE_APPEND);
  }

  // Starts the database loading process.
  function load()
  {
    // For each new pet,
    for ($n = 0; $n < count($this->newPets["name"]); $n++)
    {
      $match = false;

      file_put_contents(
        $this->log,
        "\n\n::UPDATE DATABASE::",
         FILE_APPEND);
      file_put_contents(
        $this->log,
        "\n\n{$this->newPets["name"][$n]}: {$n}",
        FILE_APPEND);

      // Compare to each current pet,
      for ($c = 0; $c < count($this->currentPets["name"]); $c++)
      {
        $date = date("Y.n.d-H:i:s - ");

        file_put_contents(
          $this->log,
          "\n{$date}c." . $c . ".{$this->currentPets["name"][$c]}: ",
          FILE_APPEND);

        // If the impound numbers match, check each field.
        if (strcmp($this->newPets["impound_num"][$n],
            $this->currentPets["impound_num"][$c]) == 0)
        {
          $match = true;

          file_put_contents(
            $this->log,
            "Impound #'s Match: ",
            FILE_APPEND);
          $this->checkField($n, $c);
        }

        // If the impound numbers don't match, keep going.
        // If it reaches the end of the new animal list
        // without a match, insert the animal into the DB.
        else
        {
          file_put_contents(
            $this->log,
            "Not the same ",
            FILE_APPEND);

          if (($c == count($this->currentPets["name"]) - 1) &&
              ($match == false))
          {
            $this->insertAnimal($n);
            // TODO: verify mysql_insert_id is consistently returning an ID
            $this->saveImage($this->newPets["impound_num"][$n],
                             mysql_insert_id($this->connection));
          }

        }

      }

    }

  }

  // Compare individual fields of matching current and new pet
  // and determine if update is needed.
  function checkField($n, $c)
  {
    for ($k = 2; $k < count($this->keys) - 2; $k++)
    {
      $date = date("Y.n.d-H:i:s - ");

      file_put_contents(
        $this->log,
        "\n{$date}\t\t\t{$this->keys[$k]} - ",
        FILE_APPEND);

      if (strcmp($this->newPets[$this->keys[$k]][$n],
          $this->currentPets[$this->keys[$k]][$c]) == 0)
      {
        file_put_contents(
          $this->log,
          "match",
          FILE_APPEND);
      }

      else
      {
        file_put_contents(
          $this->log,
          "different",
          FILE_APPEND);

        $this->alterAnimal($n, $k);
      }

    }

  }

  // Query DB with updated pet field.
  function alterAnimal($n, $k)
  {
    $date = date("Y.n.d-H:i:s - ");
    $column = $this->keys[$k];
    $entry = $this->newPets[$this->keys[$k]][$n];
    $pet = $this->newPets["impound_num"][$n];

    mysql_query("UPDATE animals SET {$column} = '{$entry}' WHERE impound_num = '{$pet}';",
      $this->connection);

    file_put_contents(
      $this->log,
      "\n{$date}\t\t\t\tUPDATE animals SET {$column} = '{$entry}' WHERE impound_num = '{$pet}';",
      FILE_APPEND);
  }

  // Query DB with new animal.
  function insertAnimal($n)
  {
    $date = date("Y.n.d-H:i:s - ");

    mysql_query("INSERT INTO animals SET
      id = NULL,
      scrape_date = NULL,
      name = '{$this->newPets["name"][$n]}',
      breed = '{$this->newPets["breed"][$n]}',
      color = '{$this->newPets["color"][$n]}',
      entry_date = '{$this->newPets["entry_date"][$n]}',
      impound_num = '{$this->newPets["impound_num"][$n]}',
      sex = '{$this->newPets["sex"][$n]}',
      fixed = '{$this->newPets["fixed"][$n]}',
      age = '{$this->newPets["age"][$n]}',
      description = \"{$this->newPets["description"][$n]}\",
      common_name_id = {$this->newPets["common_name_id"][$n]},
      shelter_id = 2;", $this->connection);

    file_put_contents(
      $this->log,
      "\n{$date}INSERT INTO animals SET
      id = NULL,
      scrape_date = NULL,
      name = '{$this->newPets["name"][$n]}',
      breed = '{$this->newPets["breed"][$n]}',
      color = '{$this->newPets["color"][$n]}',
      entry_date = '{$this->newPets["entry_date"][$n]}',
      impound_num = '{$this->newPets["impound_num"][$n]}',
      sex = '{$this->newPets["sex"][$n]}',
      fixed = '{$this->newPets["fixed"][$n]}',
      age = '{$this->newPets["age"][$n]}',
      description = \"{$this->newPets["description"][$n]}\",
      common_name_id = {$this->newPets["common_name_id"][$n]},
      shelter_id = 2;\n",
      FILE_APPEND);
  }

  /**
   * Saves a remote image to the local disk.
   *
   * @param string $impoundNum Impound # for finding the image
   * @param int    $id         Animal ID from the animals table
   */
  private function saveImage($impoundNum, $id)
  {
    $url = "http://montanapets.org/mhs/pictures/{$impoundNum}.jpg";
    $jpg = file_get_contents($url);
    if ($jpg) {
      file_put_contents(Site::getInstance()->getUploadPath() . "/{$id}.jpg",
                        $jpg);
    }
  }

  // Recursive loading function.
  function loadRecursive($n = 0, $c = 0)
  {
    $check = strcmp($this->newPets["impound_num"][$n],
            $this->currentPets["impound_num"][$c]);

    print "<b><br/>{$this->newPets["name"][$n]}: {$n}</b> compared to <b>{$this->currentPets["name"][$c]}: {$c} - </b>";

    if (($n == $this->totalNew - 1) && ($c == $this->totalCurrent - 1))
    {
      if ($check == 0)
      {
        print "Impound #'s Match: <br/>";
        $this->checkFieldRecursive($n, $c);
      }

      elseif ($check != 0)
      {
        print "Not the same ";
      }

      print "<br/><br/><b>Finished</b>";
    }

    elseif (($n == $this->totalNew - 1) && ($c < $this->totalCurrent - 1))
    {
      if ($check == 0)
      {
        print "Impound #'s Match: <br/>";
        $this->checkFieldRecursive($n, $c);
      }

      elseif ($check != 0)
      {
        print "Not the same ";
      }

      $this->loadRecursive($n, $c + 1);
    }

    elseif (($n < $this->totalNew - 1) && ($c == $this->totalCurrent - 1))
    {
      if ($check == 0)
      {
        print "Impound #'s Match: <br/>";
        $this->checkFieldRecursive($n, $c);
      }

      elseif ($check != 0)
      {
        print "Not the same ";
      }

      print "<br/><b>Finished with {$this->newPets["name"][$n]}: {$n}</b><br/>";
      $this->loadRecursive($n + 1, 0);
    }

    elseif (($n < $this->totalNew - 1) && ($c < $this->totalCurrent - 1))
    {
      if ($check == 0)
      {
        print "Impound #'s Match: <br/>";
        $this->checkFieldRecursive($n, $c);
      }

      elseif ($check != 0)
      {
        print "Not the same ";
      }

      $this->loadRecursive($n, $c + 1);
    }

  }

  // Recursive checkField function.
  function checkFieldRecursive($n, $c, $k = 0)
  {
    $check = strcmp($this->newPets[$this->newKeys[$k]][$n],
          $this->currentPets[$this->newKeys[$k]][$c]);

    print "<br/><b>{$this->newKeys[$k]} - </b>";

    if ($k == count($this->newKeys) - 1)
    {
      if ($check == 0)
      {
        print "match";
      }

      else
      {
        print "different - ";
        $this->alterAnimal($n, $k);
      }
      print "<br/>";
      $this->loadRecursive($n, $c + 1);
    }

    elseif ($k < count($this->newKeys) - 1)
    {
      if ($check == 0)
      {
        print "match";
      }

      else
      {
        print "different - ";
        $this->alterAnimal($n, $k);
      }

      $this->checkFieldRecursive($n, $c, $k + 1);
    }

  }

}//End

?>