<?php

/**
 * Breed value class.
 *
 */
class Breed {
    private $name;
    private $slug;

    function __construct($name)
    {
        $this->setName($name);
        $this->setSlug($name);
    }

    public function getName()
    {
        return $this->name;
    }

    /**
     * Some listings are inconsistent, so we need to try to standardize the
     * breed display.
     *
     * Lab/Hound X should be Lab-Hound X.
     *
     * @todo This won't be needed if the scrapers are modified to insert into
     *       a ``breeds'' table.
     * @param string $name
     * @return void
     */
    public function setName($name)
    {
        $this->name = str_replace('/', '-', $name);
    }

    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Creates a URL-friendly slug.
     *
     * @param string $slug
     */
    public function setSlug($slug)
    {
        $this->slug = urlencode(strtolower($this->name));
    }

    public function  __toString()
    {
        return $this->name;
    }
}
