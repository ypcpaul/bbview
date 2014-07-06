<?php
namespace tunalaruan\bbview;
/**
 * Bare bones View.
 *
 * Implements views with php templates.
 */
class BBView
{
    private $filePath;
    private $data;

    /**
     * Creates a new BBView from file given.
     * @param string $filePath full path to the file
     * @param array $data [optional] data to be sent to the view
     * @throws \Exception if the file doesn't exist
     */
    public function __construct($filePath, array $data = array())
    {
        if(file_exists($filePath)) {
            $this->filePath = $filePath;
            $this->data = $data;
        } else {
            throw new \Exception("File doesn't exist");
        }
    }

    /**
     * Generates the view
     * @param boolean $returnString pass true if you don't want to get
     * the contents of the view generated instead of printing it. Default false
     * @return mixed returns string if $returnAsString paramater is set to true,
     * void otherwise 
     */
    public function generate($returnAsString = false)
    {
        ob_start();
        extract($this->data);
        include $this->filePath;

        if($returnAsString) {
            $content = ob_get_contents();
            ob_end_clean();
            return $content;
        } else {
            ob_end_flush();
        }
    }

    /**
     * Inserts a view to this view.
     * @param string $name The variable name representing the contents of
     * the view to be inserted.
     */
    public function insert(BBView $view, $name)
    {
        $this->data[$name] = $view->generate(true);
        return $this;
    }
}
