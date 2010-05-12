<?php

class Packer
{
  /*
  Packer.php
  Evan Cummings
  CS 346
  5.8.10
  
  Packs all scraped pets into an array to be sent to loader.
  */
  
  private $pets;
  private $keys;

  // Constructor.
  function Packer()
  {
    $this->pets = array(  "name"          => array(), 
                          "breed"         => array(),
                          "color"         => array(),
                          "entry_date"    => array(),
                          "impound_num"   => array(),
                          "sex"           => array(),
                          "fixed"         => array(),
                          "age"           => array(),
                          "description"   => array(),
                          "common_name_id"=> array());

    $this->keys = array_keys($this->pets);
  }
  
  // Pack the array of new pets into the main pets array.
  function pack($newPets)
  {
    for ($o = 0; $o < count($this->keys); $o++)
    {
      $this->pets[$this->keys[$o]] = array_merge(
                $this->pets[$this->keys[$o]],
                $newPets[$this->keys[$o]]);
      /*
      for ($i = 0; $i < count($newPets["name"]); $i++)
      {
        array_push($this->pets[$this->keys[$o]], 
          $newPets[$this->keys[$o]][$i]);
      }
      */
    }
    
  }
  
  // Return the fully-packed array of pets.
  function getPackedPets()
  {
    return $this->pets;
  }
}

?>