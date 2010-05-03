<?php

/**
 * Represents an Animal object.
 *
 * @author Jon-Michael Deldin <dev@jmdeldin.com>
 */
class Animal
{
    private $id;
    private $entryDate;
    private $dateRecorded;
    private $name;
    private $description;
    private $breed;
    private $sex;
    private $fixed;
    private $age;
    private $color;
    private $commonName;
    private $shelter;

    public function __construct($id, $entryDate, $dateRecorded, $name,
        $description, $breed, $sex, $fixed, $age, $color, $commonName,
        $shelter)
    {
        $this->id           = $id;
        $this->entryDate    = $entryDate;
        $this->dateRecorded = $dateRecorded;
        $this->name         = $name;
        $this->description  = $description;
        $this->breed        = $breed;
        $this->sex          = $sex;
        $this->fixed        = $fixed;
        $this->age          = $age;
        $this->color        = $color;
        $this->commonName   = $commonName;
        $this->shelter      = $shelter;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getEntryDate()
    {
        return $this->entryDate;
        }

    public function setEntryDate($entryDate)
    {
        $this->entryDate = $entryDate;
    }

    public function getDateRecorded()
    {
        return $this->dateRecorded;
        }

    public function setDateRecorded($dateRecorded)
    {
        $this->dateRecorded = $dateRecorded;
    }

    public function getName()
    {
        return $this->name;
        }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getDescription()
    {
        return $this->description;
        }

    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function getBreed()
    {
        return $this->breed;
        }

    public function setBreed($breed)
    {
        $this->breed = $breed;
    }

    public function getSex()
    {
        return $this->sex;
        }

    public function setSex($sex)
    {
        $this->sex = $sex;
    }

    public function getFixed()
    {
        return $this->fixed;
        }

    public function setFixed($fixed)
    {
        $this->fixed = $fixed;
    }

    public function getColor()
    {
        return $this->color;
        }

    public function setColor($color)
    {
        $this->color = $color;
    }

    public function getCommonName()
    {
        return $this->commonName;
        }

    public function setCommonName($commonName)
    {
        $this->commonName = $commonName;
    }

    public function getShelter()
    {
        return $this->shelter;
        }

    public function setShelter($shelter)
    {
        $this->shelter = $shelter;
    }
}

