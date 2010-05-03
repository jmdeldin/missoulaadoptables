<?php

/**
 * Represents a Shelter object.
 *
 * @author Jon-Michael Deldin <dev@jmdeldin.com>
 */
class Shelter
{
    private $id;
    private $name;
    private $uri;
    private $streetAddress;
    private $city;
    private $postalCode;
    private $phone;
    private $email;
    private $hours;
    private $state;

    function __construct($id, $name, $uri, $streetAddress, $city, $postalCode,
        $phone, $email, $hours, $state)
    {
        $this->id            = $id;
        $this->name          = $name;
        $this->uri           = $uri;
        $this->streetAddress = $streetAddress;
        $this->city          = $city;
        $this->postalCode    = $postalCode;
        $this->phone         = $phone;
        $this->email         = $email;
        $this->hours         = $hours;
        $this->state         = $state;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getUri()
    {
        return $this->uri;
    }

    public function setUri($uri)
    {
        $this->uri = $uri;
    }

    public function getStreetAddress()
    {
        return $this->streetAddress;
    }

    public function setStreetAddress($streetAddress)
    {
        $this->streetAddress = $streetAddress;
    }

    public function getCity()
    {
        return $this->city;
    }

    public function setCity($city)
    {
        $this->city = $city;
    }

    public function getPostalCode()
    {
        return $this->postalCode;
    }

    public function setPostalCode($postalCode)
    {
        $this->postalCode = $postalCode;
    }

    /**
     * @return string formatted phone number
     */
    public function getPhone()
    {
        return preg_replace("/(\d{3})(\d{3})(\d{4})/", "($1) $2-$3",
                            $this->phone);
    }

    public function setPhone($phone)
    {
        $this->phone = $phone;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getHours()
    {
        return $this->hours;
    }

    public function setHours($hours)
    {
        $this->hours = $hours;
    }

    public function getState()
    {
        return $this->state;
    }

    public function setState($state)
    {
        $this->state = $state;
    }

    public function __toString()
    {
        return $this->name;
    }
}

