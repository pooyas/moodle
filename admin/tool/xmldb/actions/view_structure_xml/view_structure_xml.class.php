<?php

/**
 * @package    tool_xmldb
 * @copyright  2003 onwards Eloy Lafuente (stronk7) {@link http://stronk7.com}
 * 
 */

/**
 * This class will display the XML for one structure
 *
 * @package    tool_xmldb
 * @copyright  2003 onwards Eloy Lafuente (stronk7) {@link http://stronk7.com}
 * 
 */
class view_structure_xml extends XMLDBAction {

    /**
     * Init method, every subclass will have its own
     */
    function init() {
        parent::init();

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
        $select = required_param('select', PARAM_ALPHA); //original/edited
        // Get the dir containing the file
        $dirpath = required_param('dir', PARAM_PATH);
        $dirpath = $CFG->dirroot . $dirpath;

        // Get the correct dir
        if ($select == 'original') {
            if (!empty($XMLDB->dbdirs)) {
                $base = $XMLDB->dbdirs[$dirpath];
            }
        } else if ($select == 'edited') {
            if (!empty($XMLDB->editeddirs)) {
                $base = $XMLDB->editeddirs[$dirpath];
            }
        } else {
            $this->errormsg = 'Cannot access to ' . $select . ' info';
            $result = false;
        }
        if ($base) {
            // Only if the directory exists and it has been loaded
            if (!$base->path_exists || !$base->xml_loaded) {
                $this->errormsg = 'Directory ' . $dirpath . ' not loaded';
                return false;
            }
        } else {
            $this->errormsg = 'Problem handling ' . $select . ' files';
            return false;
        }

        // Get the structure
        if ($result) {
            if (!$structure = $base->xml_file->getStructure()) {
                $this->errormsg = 'Error retrieving ' . $select . ' structure';
                $result = false;
            }
        }

        if ($result) {
            // Everything is ok. Generate the XML output
            $this->output = $structure->xmlOutput();
        } else {
            // Switch to HTML and error
            $this->does_generate = ACTION_GENERATE_HTML;
        }

        // Return ok if arrived here
        return $result;
    }
}

