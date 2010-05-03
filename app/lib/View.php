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
        $this->file = Site::getInstance()->getAppRoot() . "/views/{$name}.php";
    }

    public function render()
    {
        if (!file_exists($this->file))
        {
            $e = new NotFoundError("View unavailable.");
            $e->serve();
        die('foo');
        }
        // make any object vars available as globals to the view
        extract(get_object_vars($this));
        require $this->file;
    }
}

