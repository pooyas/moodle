<?php

/**
 * @package    tool
 * @subpackage xmldb
 * @copyright  2015 Pooya Saeedi
 * 
 */

/**
 * This class will display one XML file
 *
 */
class view_xml extends XMLDBAction {

    /**
     * Init method, every subclass will have its own
     */
    function init() {
        parent::init();
        // Set own core attributes
        $this->can_subaction = ACTION_NONE;
        //$this->can_subaction = ACTION_HAVE_SUBACTIONS;

        // Set own custom attributes
        $this->sesskey_protected = false; // This action doesn't need sesskey protection

        // Get needed strings
        $this->loadStrings(array(
            // 'key' => 'module',
        ));
    }

    /**
     * Invoke method, every class will have its own
     * returns true/false on completion, setting both
     * errormsg and output as necessary
     * @return mixed
     */
    function invoke() {
        parent::invoke();

        $result = true;

        // Set own core attributes
        $this->does_generate = ACTION_GENERATE_XML;

        // These are always here
        global $CFG, $XMLDB;

        // Do the job, setting result as needed

        // Get the file parameter
        $file = required_param('file', PARAM_PATH);
        $file = $CFG->dirroot . $file;
        // File must be under $CFG->wwwroot and
        // under one db directory (simple protection)
        if (substr($file, 0, strlen($CFG->dirroot)) == $CFG->dirroot &&
            substr(dirname($file), -2, 2) == 'db') {
            // Everything is ok. Load the file to memory
            $this->output = file_get_contents($file);
        } else {
            // Switch to HTML and error
            $this->does_generate = ACTION_GENERATE_HTML;
            $this->errormsg = 'File not viewable (' . $file .')';
            $result = false;
        }

        // Return ok if arrived here
        return $result;
    }
}

