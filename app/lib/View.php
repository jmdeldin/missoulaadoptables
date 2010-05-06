<?php
/**
 * Responsible for rendering templates.
 *
 * @author Jon-Michael Deldin <dev@jmdeldin.com>
 */
class View
{
    protected $name; // view name
    protected $file; // view file

    /**
     * @param string $name view name (.php is automatically appended)
     */
    public function __construct($name)
    {
        $this->setFile($name);
    }

    public function render()
    {
        if (!file_exists($this->file))
        {
            $e = new NotFoundError("View unavailable.");
            $e->serve();
        }
        // make any object vars available as globals to the view
        extract(get_object_vars($this));
        require $this->file;
    }

    public function setFile($name)
    {
        $this->file = Site::getInstance()->getAppRoot() . "/views/{$name}.php";
    }
}
