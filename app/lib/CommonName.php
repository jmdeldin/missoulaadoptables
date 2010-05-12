<?php

/**
 * Value class for common names
 */
class CommonName
{
    private $id;
    private $name; // display title
    private $slug; // url-safe name

    function __construct($id, $name)
    {
        $this->setId($id);
        $this->setName($name);
        $this->setSlug($name);
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

    /**
     * Uppercases words for each name.
     *
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = ucwords($name);
    }

    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Creates a URL-safe slug from a common name.
     *
     * @param string $name
     */
    public function setSlug($name)
    {
        $this->slug = strtolower(urlencode($name));
    }

    public function __toString()
    {
        return $this->name;
    }

}
